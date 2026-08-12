@twillBlockTitle('제목 + 설명')
@twillBlockIcon('text')
@twillBlockGroup('app')

<x-twill::input
    name="heading"
    label="Heading"
    :maxlength="150"
/>

<x-twill::wysiwyg
    name="description"
    label="Description"
    :toolbar-options="[
        ['header' => [2, 3, 4]],
        'bold',
        'italic',
        'underline',
        ['list' => 'bullet'],
        ['list' => 'ordered'],
        'blockquote',
        'link',
        'clean',
    ]"
    :browser="false"
    limit-height
/>
