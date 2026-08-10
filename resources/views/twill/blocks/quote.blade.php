@twillBlockTitle('Quote')
@twillBlockIcon('text')
@twillBlockGroup('프로젝트 본문')

<x-twill::wysiwyg
    name="quote"
    label="Quote"
    :toolbar-options="['bold', 'italic', 'link', 'clean']"
/>
<x-twill::input name="attribution" label="Attribution (optional)" />
