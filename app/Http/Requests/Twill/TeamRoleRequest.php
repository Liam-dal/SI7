<?php

namespace App\Http\Requests\Twill;

use A17\Twill\Http\Requests\Admin\Request;

class TeamRoleRequest extends Request
{
    public function rulesForCreate(): array { return []; }
    public function rulesForUpdate(): array { return []; }
}
