<?php

namespace App\Http\Requests\Twill;

use A17\Twill\Http\Requests\Admin\Request;
use Closure;
use Illuminate\Support\Str;

class GuideRequest extends Request
{
    public function rulesForCreate(): array
    {
        return $this->permalinkRules();
    }

    public function rulesForUpdate(): array
    {
        return $this->permalinkRules();
    }

    // Title 은 화면 표시용이 아니라 permalink(URL) 전용 필드다(표시 제목은 headline).
    // Str::slug 는 한글을 전부 버리기 때문에 제목을 한글로 넣으면 URL 이 망가진다:
    //   "브랜드 아이덴티티를 만드는 법" -> ""  → 슬러그가 아예 안 생겨 /guides/1 처럼 ID 로 노출
    //   "좋은 로고가 갖춰야 할 7가지 조건" -> "7" → /guides/7 이 ID 7 인 글을 가려서 그 글이 안 열림
    // 폼의 note 로만 안내하던 걸 저장 단계에서 실제로 막는다.
    private function permalinkRules(): array
    {
        return [
            'title' => [
                'required',
                function (string $attribute, mixed $value, Closure $fail): void {
                    $slug = Str::slug((string) $value);

                    if ($slug === '') {
                        $fail('Title is used only for the URL, so it must contain characters that survive slugging (Korean is dropped entirely). Please enter it in English.');

                        return;
                    }

                    if (ctype_digit($slug)) {
                        $fail('Title would produce the URL /guides/' . $slug . ', which collides with numeric guide IDs and would hide another article. Please include English words in the title.');
                    }
                },
            ],
        ];
    }
}
