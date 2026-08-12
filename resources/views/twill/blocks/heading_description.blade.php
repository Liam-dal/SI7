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
    :toolbar-options="['bold', 'italic', 'link']"
    :browser="false"
    limit-height
/>
