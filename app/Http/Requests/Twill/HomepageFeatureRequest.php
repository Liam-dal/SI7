<?php

namespace App\Http\Requests\Twill;

use A17\Twill\Http\Requests\Admin\Request;

class HomepageFeatureRequest extends Request
{
    public function rulesForCreate(): array { return $this->featureRules(); }
    public function rulesForUpdate(): array { return $this->featureRules(); }

    private function featureRules(): array
    {
        return [
            'project_id' => ['required', 'exists:projects,id'],
            'section' => ['required', 'in:main,secondary,additional'],
            'title' => ['nullable', 'string', 'max:180'],
            'description' => ['nullable', 'string', 'max:500'],
        ];
    }
}
