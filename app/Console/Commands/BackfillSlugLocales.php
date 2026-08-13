<?php

namespace App\Console\Commands;

use App\Models\Person;
use App\Models\Project;
use Illuminate\Console\Command;

/**
 * 번역하지 않는 slug 모델(Project, Person)의 기존 레코드에 빠진 로케일 slug를 채운다.
 *
 * 배경: i18n(ko/en) 도입 전에 만든 레코드는 'en' 로케일 slug만 있어서, ko 로케일에선
 * $model->slug 가 비어 링크가 숫자 ID로 폴백됨(/projects/11). 새로 저장되는 레코드는
 * Twill이 모든 로케일 slug를 자동 생성하므로, 기존 데이터만 1회 보정하면 된다. (idempotent)
 */
class BackfillSlugLocales extends Command
{
    protected $signature = 'slugs:backfill-locales {--dry-run : 변경 없이 무엇을 채울지만 출력}';

    protected $description = '기존 프로젝트/피플에 빠진 로케일 slug를 채움(ko 링크가 ID로 폴백되는 문제 해결)';

    public function handle(): int
    {
        $locales = getLocales();
        $dry = (bool) $this->option('dry-run');
        $created = 0;

        foreach ([Project::class, Person::class] as $class) {
            foreach ($class::with('slugs')->get() as $model) {
                $active = $model->slugs->where('active', true);

                if ($active->isEmpty()) {
                    continue; // slug 자체가 없으면 건너뜀(저장 시 생성됨)
                }

                // 대표 slug 문자열: en 우선, 없으면 첫 번째 활성 slug.
                $canonical = ($active->firstWhere('locale', 'en') ?? $active->first())->slug;

                foreach ($locales as $locale) {
                    if ($active->contains(fn ($s) => $s->locale === $locale)) {
                        continue; // 이미 이 로케일 활성 slug 있음
                    }

                    $label = class_basename($class) . " #{$model->id} [{$locale}] = {$canonical}";

                    if ($dry) {
                        $this->line("would create: {$label}");
                        continue;
                    }

                    $model->slugs()->create([
                        'slug' => $canonical,
                        'locale' => $locale,
                        'active' => true,
                    ]);
                    $this->line("created: {$label}");
                    $created++;
                }
            }
        }

        $this->info($dry ? '드라이런 완료.' : "완료: {$created}개 로케일 slug 생성.");

        return self::SUCCESS;
    }
}
