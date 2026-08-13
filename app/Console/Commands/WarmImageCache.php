<?php

namespace App\Console\Commands;

use App\Models\Guide;
use App\Models\Person;
use App\Models\Project;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

/**
 * 사이트 모든 페이지의 이미지 변형(Glide)을 미리 요청해 캐시를 생성한다.
 * 콜드 변환(첫 방문 시 1~5초)을 방문자 대신 배포/관리자가 미리 처리하는 목적.
 * Glide 캐시는 배포(optimize:clear)로 지워지지 않으므로, 이미 데워진 변형은
 * 즉시 통과(~50ms)하고 새 변형만 생성된다.
 */
class WarmImageCache extends Command
{
    protected $signature = 'images:warm {--timeout=90}';

    protected $description = '사이트 이미지 변형을 미리 요청해 Glide 캐시를 생성(콜드 변환 방지)';

    public function handle(): int
    {
        $base = rtrim((string) config('app.url'), '/');
        $timeout = (int) $this->option('timeout');

        $paths = ['/', '/about', '/guides', '/contact', '/download', '/projects'];

        foreach (Project::query()->where('published', true)->get() as $p) {
            $paths[] = '/projects/' . ($p->slug ?: $p->id);
        }
        foreach (Guide::query()->where('published', true)->get() as $g) {
            $paths[] = '/guides/' . ($g->slug ?: $g->id);
        }
        foreach (Person::query()->where('published', true)->get() as $person) {
            $paths[] = '/people/' . ($person->slug ?: $person->id);
        }

        $paths = array_values(array_unique($paths));
        $seen = [];
        $warmed = 0;
        $fresh = 0;

        foreach ($paths as $path) {
            try {
                $html = Http::timeout($timeout)->get($base . $path)->body();
            } catch (\Throwable $e) {
                $this->warn("페이지 건너뜀 {$path}: {$e->getMessage()}");
                continue;
            }

            preg_match_all('/(?:src|data-lightbox-src)="([^"]*\/img\/[^"]*)"/', $html, $m);
            $imgs = array_values(array_unique(array_map('html_entity_decode', $m[1])));

            foreach ($imgs as $img) {
                $url = str_starts_with($img, 'http') ? $img : $base . $img;
                if (isset($seen[$url])) {
                    continue;
                }
                $seen[$url] = true;

                $t0 = microtime(true);
                try {
                    Http::timeout($timeout)->get($url);
                } catch (\Throwable $e) {
                    continue;
                }
                $warmed++;
                if ((microtime(true) - $t0) * 1000 > 800) {
                    $fresh++;
                }
            }

            $this->line("• {$path} — " . count($imgs) . ' imgs');
        }

        $this->info("워밍 완료: {$warmed}개 이미지 (새로 생성 {$fresh}, 나머지 캐시됨).");

        return self::SUCCESS;
    }
}
