@twillBlockTitle('텍스트')
@twillBlockIcon('text')
@twillBlockGroup('프로젝트 본문')

<x-twill::input
    name="title"
    label="소제목 (선택)"
    :translated="true"
/>

<x-twill::wysiwyg
    name="text"
    label="본문"
    placeholder="내용을 입력하세요"
    :toolbar-options="[
        'bold',
        'italic',
        ['list' => 'bullet'],
        ['list' => 'ordered'],
        [ 'script' => 'super' ],
        [ 'script' => 'sub' ],
        'link',
        'clean'
    ]"
    :translated="true"
/>
