<?php

namespace App\Http\Requests\Twill;

use A17\Twill\Http\Requests\Admin\Request;

class OfficeRequest extends Request
{
    public function rulesForCreate(): array { return $this->officeRules(); }
    public function rulesForUpdate(): array { return $this->officeRules(); }

    private function officeRules(): array
    {
        return [
            'title' => ['required', 'string', 'max:200'],
            'email' => ['nullable', 'email', 'max:255'],
            'directions_url' => ['nullable', 'url', 'max:2048'],
            'timezone' => ['nullable', 'timezone'],
        ];
    }
}
