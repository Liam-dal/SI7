@twillBlockTitle('제목')
@twillBlockIcon('text')
@twillBlockGroup('프로젝트 본문')

<x-twill::input
    name="heading"
    label="제목"
    :required="true"
/>

<x-twill::input
    name="eyebrow"
    label="작은 제목 (선택)"
    note="제목 위에 표시할 짧은 문구입니다."
/>
