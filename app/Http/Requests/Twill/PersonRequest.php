<?php

namespace App\Http\Requests\Twill;

use A17\Twill\Http\Requests\Admin\Request;

class PersonRequest extends Request
{
    public function rulesForCreate(): array { return $this->personRules(); }
    public function rulesForUpdate(): array { return $this->personRules(); }

    private function personRules(): array
    {
        return [
            'title' => ['required', 'string', 'max:200'],
            'team_role_id' => ['nullable', 'exists:team_roles,id'],
            'start_year' => ['nullable', 'integer', 'min:1900', 'max:2100'],
        ];
    }
}
