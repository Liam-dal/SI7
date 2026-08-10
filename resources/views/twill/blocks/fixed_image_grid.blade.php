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

<x-twill::medias
    name="images"
    label="Images"
    :max="20"
    note="여러 장의 이미지를 정렬해 표시합니다."
/>
