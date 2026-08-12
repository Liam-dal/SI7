<?php

use A17\Twill\Models\Block;
use App\Models\Homepage;
use App\Models\HomepageFeatureSection;
use App\Models\Project;
use Illuminate\Database\Migrations\Migration;

/**
 * 고정 3섹션(main/secondary/additional)에 흩어져 있던 Featured 데이터를
 * Homepage 블록 에디터의 'featured_section' 블록으로 이관합니다.
 *
 * - 섹션 설정(제목/설명/표시 스타일)은 homepage_feature_sections 에서 가져옵니다.
 * - 연결된 프로젝트는 Homepage 싱글톤 브라우저(*_features)에서 각 블록으로 옮깁니다.
 *
 * 원본 데이터(homepage_feature_sections, Homepage의 *_features related)는 그대로 두어
 * 되돌리기가 가능하도록 합니다.
 */
return new class extends Migration
{
    /**
     * @var array<int, array{key: string, browser: string, fallbackLayout: string}>
     */
    private array $sections = [
        ['key' => 'main', 'browser' => 'main_features', 'fallbackLayout' => 'carousel'],
        ['key' => 'secondary', 'browser' => 'secondary_features', 'fallbackLayout' => 'grid_3'],
        ['key' => 'additional', 'browser' => 'additional_features', 'fallbackLayout' => 'grid_editorial'],
    ];

    public function up(): void
    {
        $homepage = Homepage::query()->first();

        if (! $homepage) {
            return;
        }

        // 이미 이관된 경우(블록 존재) 중복 생성을 막습니다.
        if ($homepage->blocks()->where('type', 'featured_section')->exists()) {
            return;
        }

        $position = 1;

        foreach ($this->sections as $section) {
            $config = HomepageFeatureSection::query()
                ->where('section_key', $section['key'])
                ->first();

            $projects = $homepage->getRelated($section['browser'])
                ->filter(fn (Project $project) => $project->exists)
                ->values();

            // 프로젝트도 설정도 없으면 빈 블록을 만들지 않습니다.
            if ($projects->isEmpty() && ! $config) {
                continue;
            }

            $content = [
                'title' => $config?->title ?? '',
                'description' => $config?->description ?? '',
                'layout_style' => $config?->layout_style ?: $section['fallbackLayout'],
            ];

            // 블록 폼(관리자)이 프로젝트 브라우저를 렌더링하려면 content['browsers']에
            // 선택 항목 id가 있어야 합니다. 실제 항목/라벨은 twill_related(getRelated)에서
            // 불러오므로 saveRelated 도 함께 호출합니다.
            if ($projects->isNotEmpty()) {
                $content['browsers'] = ['projects' => $projects->pluck('id')->values()->all()];
            }

            $block = new Block();
            $block->blockable_id = $homepage->getKey();
            $block->blockable_type = $homepage->getMorphClass();
            $block->editor_name = 'default';
            $block->type = 'featured_section';
            $block->position = $position++;
            $block->content = $content;
            $block->save();

            if ($projects->isNotEmpty()) {
                $block->saveRelated($projects->all(), 'projects');
            }
        }
    }

    public function down(): void
    {
        $homepage = Homepage::query()->first();

        if (! $homepage) {
            return;
        }

        $homepage->blocks()->where('type', 'featured_section')->get()->each(function (Block $block): void {
            $block->clearAllRelated();
            $block->delete();
        });
    }
};
