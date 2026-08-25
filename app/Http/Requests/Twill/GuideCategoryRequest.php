<?php

namespace App\Http\Requests\Twill;

use A17\Twill\Http\Requests\Admin\Request;

class GuideCategoryRequest extends Request
{
    public function rulesForCreate(): array
    {
        return [
            'title' => 'required|max:60',
        ];
    }

    public function rulesForUpdate(): array
    {
        return [
            'title' => 'required|max:60',
        ];
    }
}
