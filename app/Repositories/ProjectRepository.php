<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\Behaviors\HandleBrowsers;
use A17\Twill\Repositories\ModuleRepository;
use A17\Twill\Models\Contracts\TwillModelContract;
use App\Models\Project;

class ProjectRepository extends ModuleRepository
{
    use HandleBlocks, HandleSlugs, HandleMedias, HandleRevisions, HandleBrowsers;

    public function __construct(Project $model)
    {
        $this->model = $model;
        $this->browsers = ['people', 'offices'];
    }

    public function afterSave(TwillModelContract $model, array $fields): void
    {
        parent::afterSave($model, $fields);

        if (array_key_exists('sector_ids', $fields)) {
            $model->sectors()->sync(array_filter($fields['sector_ids'] ?? []));
        }

        if (array_key_exists('category_ids', $fields)) {
            $model->categories()->sync(array_filter($fields['category_ids'] ?? []));
        }
    }

    public function getFormFields(TwillModelContract $object): array
    {
        $fields = parent::getFormFields($object);

        // 프로젝트는 단일 언어 구조이지만 Twill 제목 영역은 locale별 slug 값을 사용합니다.
        // 이를 명시해 제목 아래 공개 주소가 항상 표시되도록 합니다.
        $fields['slug'] = [app()->getLocale() => $object->getSlug()];

        return $fields;
    }
}
