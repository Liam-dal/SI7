<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Behaviors\Sortable;
use A17\Twill\Models\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GuideCategory extends Model implements Sortable
{
    use HasPosition, HasRevisions, HasSlug;

    protected $fillable = [
        'published',
        'title',
        'position',
    ];

    public $slugAttributes = [
        'title',
    ];

    // 가이드는 카테고리를 하나만 가진다(Sector 와 달리 피벗 없음) — 표시가 제목 위
    // eyebrow 한 줄이라 다중일 때 무엇을 보일지가 애매해서 단일 관계로 뒀다.
    public function guides(): HasMany
    {
        return $this->hasMany(Guide::class);
    }
}
