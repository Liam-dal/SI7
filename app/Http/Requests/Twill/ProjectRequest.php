<?php

namespace App\Http\Requests\Twill;

use A17\Twill\Http\Requests\Admin\Request;

class ProjectRequest extends Request
{
    public function rulesForCreate(): array
    {
        return $this->projectRules();
    }

    public function rulesForUpdate(): array
    {
        return $this->projectRules();
    }

    private function projectRules(): array
    {
        return [
            'title' => ['required', 'string', 'max:200'],
            'description' => ['nullable', 'string', 'max:500'],
            'external_url' => ['nullable', 'url', 'max:2048'],
            'project_started_at' => ['nullable', 'date'],
            'project_completed_at' => ['nullable', 'date', 'after_or_equal:project_started_at'],
        ];
    }
}
