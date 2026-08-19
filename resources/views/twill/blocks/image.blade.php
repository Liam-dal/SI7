@twillBlockTitle('Image')
@twillBlockIcon('image')
@twillBlockGroup('Content')

<x-twill::medias
    name="image"
    label="Images"
    :max="20"
    note="Selecting several images shows them as one group in the body."
/>

<x-twill::input
    name="caption"
    label="Caption (optional)"
/>
