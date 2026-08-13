@twillBlockTitle('Full width image')
@twillBlockIcon('image')
@twillBlockGroup('프로젝트 본문')

<x-twill::medias name="image" label="Image" :max="1" />

<x-twill::select
    name="ratio"
    label="비율"
    default="default"
    :options="[
        ['value' => 'default', 'label' => '원본 비율'],
        ['value' => 'square', 'label' => '정사각 (1:1)'],
        ['value' => 'wide', 'label' => '와이드 (1.72:1)'],
        ['value' => 'hero', 'label' => '히어로 (1.85:1)'],
    ]"
    note="위 이미지의 크롭 탭에서 같은 비율을 잘라주세요. 화면에는 여기서 고른 비율이 출력됩니다."
/>

<x-twill::input name="caption" label="Caption (optional)" :translated="true" />
