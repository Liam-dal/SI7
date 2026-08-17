@twillBlockTitle('Fixed image grid')
@twillBlockIcon('image')
@twillBlockGroup('프로젝트 본문')

<x-twill::select
    name="columns"
    label="Grid columns"
    :options="[
        ['value' => '2', 'label' => '2 columns'],
        ['value' => '3', 'label' => '3 columns'],
    ]"
    default="3"
/>

<x-twill::select
    name="ratio"
    label="비율"
    default="square"
    :options="[
        ['value' => 'default', 'label' => '원본 비율'],
        ['value' => 'square', 'label' => '정사각 (1:1)'],
        ['value' => 'landscape', 'label' => '가로 (3:2)'],
        ['value' => 'portrait', 'label' => '세로 (3:4)'],
    ]"
    note="아래 이미지들의 크롭 탭에서 같은 비율로 잘라주세요. 그리드는 여기서 고른 비율로 통일됩니다."
/>

<x-twill::select
    name="fit_mode"
    label="이미지 표시"
    default="crop"
    :options="[
        ['value' => 'crop', 'label' => 'Crop (박스를 꽉 채움)'],
        ['value' => 'fit', 'label' => 'Fit (전체가 보이게 축소)'],
    ]"
    note="Fit은 세로로 긴 이미지도 잘리지 않고 전체가 보이게 넣고, 남는 여백은 아래 배경색으로 채웁니다."
/>

<x-twill::input
    name="bg_color"
    label="배경색 (Fit일 때 여백)"
    placeholder="#F2F0EB"
    note="헥사코드로 입력하세요 (예: #FFFFFF, #000000). 비우면 여백은 투명."
/>

<x-twill::medias
    name="images"
    label="Images"
    :max="20"
    note="여러 장의 이미지를 정렬해 표시합니다."
/>
