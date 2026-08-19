@twillBlockTitle('Flexible image grid')
@twillBlockIcon('image')
@twillBlockGroup('Content')

<x-twill::select
    name="columns"
    label="칼럼"
    default="auto"
    :options="[
        ['value' => 'auto', 'label' => '자동 (너비에 맞춰 흐름)'],
        ['value' => '2', 'label' => '2 columns'],
        ['value' => '3', 'label' => '3 columns'],
    ]"
    note="'자동'은 이미지 크기에 맞춰 유연하게 배열합니다."
/>

<x-twill::select
    name="ratio"
    label="비율"
    default="default"
    :options="[
        ['value' => 'default', 'label' => '원본 비율 (유연)'],
        ['value' => 'square', 'label' => '정사각 (1:1)'],
        ['value' => 'landscape', 'label' => '가로 (3:2)'],
        ['value' => 'portrait', 'label' => '세로 (3:4)'],
    ]"
    note="원본 비율(유연)이면 각 이미지 원래 비율을 유지합니다. 특정 비율을 고르면 이미지 크롭 탭에서 같은 비율로 잘라주세요."
/>

<x-twill::select
    name="fit_mode"
    label="이미지 표시"
    default="crop"
    :options="[
        ['value' => 'crop', 'label' => 'Crop (박스를 꽉 채움)'],
        ['value' => 'fit', 'label' => 'Fit (전체가 보이게 축소)'],
    ]"
    note="Fit은 세로로 긴 이미지도 잘리지 않고 전체가 보이게 넣고, 남는 여백은 아래 배경색으로 채웁니다. (비율을 고른 경우에 효과가 있어요)"
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
    note="원본 이미지 비율을 유지하며 유연하게 배열합니다."
/>
