@twillBlockTitle('Text')
@twillBlockIcon('text')
@twillBlockGroup('Content')

<x-twill::input
    name="title"
    label="Subheading (optional)"
    :translated="true"
/>

<x-twill::wysiwyg
    name="text"
    label="Body"
    placeholder="Enter your text"
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
