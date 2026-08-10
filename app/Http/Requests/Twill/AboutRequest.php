<?php

namespace App\Http\Requests\Twill;

use A17\Twill\Http\Requests\Admin\Request;

class AboutRequest extends Request
{
    public function rulesForCreate(): array
    {
        return $this->aboutRules();
    }

    public function rulesForUpdate(): array
    {
        return $this->aboutRules();
    }

    private function aboutRules(): array
    {
        return [
            'page_tagline' => ['nullable', 'string', 'max:255'],
        ];
    }
}
