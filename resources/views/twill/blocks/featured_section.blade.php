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

<x-twill::select
    name="cards_per_view"
    label="한 화면에 보이는 카드 수 (캐러셀)"
    default="4"
    :options="[
        ['value' => '2', 'label' => '2개'],
        ['value' => '3', 'label' => '3개'],
        ['value' => '4', 'label' => '4개'],
        ['value' => 'slide', 'label' => '슬라이드 (1개 + 다음 살짝)'],
    ]"
/>

<x-twill::select
    name="card_ratio"
    label="카드 이미지 비율"
    default="wide"
    :options="[
        ['value' => 'wide', 'label' => '와이드 (1.65:1)'],
        ['value' => 'square', 'label' => '정사각 (1:1)'],
        ['value' => 'tall', 'label' => '세로 (4:5)'],
    ]"
/>

<x-twill::input
    name="bg_color"
    label="배경색 (다크 스타일, 선택)"
    placeholder="#000000"
    note="다크 캐러셀에서 검정 대신 쓸 배경색(헥사). 비우면 검정. 아래 Neat를 넣으면 Neat가 우선."
/>

<x-twill::input
    name="neat_config"
    label="Neat 그라디언트 설정 (JSON, 선택)"
    type="textarea"
    :rows="6"
    note="neat.firecms.co의 설정 객체 { ... }를 붙여넣으면 다크 캐러셀 배경에 애니메이션 그라디언트가 깔립니다."
/>

<x-twill::browser
    name="projects"
    module-name="projects"
    label="프로젝트"
    :max="24"
    note="이 섹션에 표시할 프로젝트를 선택하고 드래그하여 순서를 바꿉니다."
/>
