@twillBlockTitle('Neat gradient')
@twillBlockIcon('image')
@twillBlockGroup('Content')

<x-twill::input
    name="config"
    label="Neat config (JSON)"
    type="textarea"
    :rows="12"
    note="Design it on neat.firecms.co, then paste only the config object { ... } — leave out the import, new NeatGradient and scroll lines."
/>

<x-twill::input
    name="height"
    label="Height (px, optional)"
    type="number"
    note="Leave empty for the responsive default (about 50vh, max 560px)."
/>
