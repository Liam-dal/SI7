@twillBlockTitle('Title')
@twillBlockIcon('text')
@twillBlockGroup('Content')

<x-twill::input
    name="heading"
    label="Heading"
    :required="true"
/>

<x-twill::input
    name="eyebrow"
    label="Eyebrow (optional)"
    note="Short line shown above the heading."
/>
