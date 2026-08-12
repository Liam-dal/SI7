@twillBlockTitle('Featured 섹션')
@twillBlockIcon('text')
@twillBlockGroup('app')

<x-twill::input
    name="title"
    label="섹션 제목"
    :maxlength="120"
    note="비워두면 'Featured work'로 표시됩니다."
/>

<x-twill::input
    name="description"
    label="섹션 설명 (선택)"
    type="textarea"
    :rows="3"
    :maxlength="500"
/>

<x-twill::select
    name="layout_style"
    label="표시 스타일 (템플릿)"
    :options="[
        ['value' => 'carousel', 'label' => '캐러셀 (밝게) — 가로 슬라이드'],
        ['value' => 'carousel_dark', 'label' => '캐러셀 (다크) — 검정 배경·흰 글씨 슬라이드'],
        ['value' => 'grid_3', 'label' => '3열 그리드 — 균일한 3단'],
        ['value' => 'grid_editorial', 'label' => '에디토리얼 그리드 — 첫 카드 크게'],
    ]"
    default="carousel"
/>

<x-twill::browser
    name="projects"
    module-name="projects"
    label="프로젝트"
    :max="24"
    note="이 섹션에 표시할 프로젝트를 선택하고 드래그하여 순서를 바꿉니다."
/>
