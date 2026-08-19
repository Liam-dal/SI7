@twillBlockTitle('Heading + description')
@twillBlockIcon('text')
@twillBlockGroup('Content')

<x-twill::input
    name="heading"
    label="Heading"
    :maxlength="150"
    :translated="true"
/>

<x-twill::wysiwyg
    name="description"
    label="Description"
    :translated="true"
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
