<?php

namespace App\Http\Requests\Twill;

use A17\Twill\Http\Requests\Admin\Request;

class HomepageFeatureSectionRequest extends Request
{
    public function rulesForCreate(): array { return $this->rules(); }
    public function rulesForUpdate(): array { return $this->rules(); }

    private function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:120'],
            'description' => ['nullable', 'string', 'max:500'],
        ];
    }
}
