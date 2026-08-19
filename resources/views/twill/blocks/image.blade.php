@twillBlockTitle('Image')
@twillBlockIcon('image')
@twillBlockGroup('Content')

<x-twill::medias
    name="image"
    label="이미지"
    :max="20"
    note="여러 장을 선택하면 본문에서 한 묶음으로 표시됩니다."
/>

<x-twill::input
    name="caption"
    label="이미지 설명 (선택)"
/>
