@twillBlockTitle('Full width image')
@twillBlockIcon('image')
@twillBlockGroup('Content')

<x-twill::medias name="image" label="Image" :max="1" />

<x-twill::select
    name="ratio"
    label="Ratio"
    default="default"
    :options="[
        ['value' => 'default', 'label' => 'Original ratio'],
        ['value' => 'square', 'label' => 'Square (1:1)'],
        ['value' => 'wide', 'label' => 'Wide (1.72:1)'],
        ['value' => 'hero', 'label' => 'Hero (1.85:1)'],
    ]"
    note="Crop the image above to the same ratio in its Crop tab. The ratio chosen here is what the site renders."
/>

<x-twill::select
    name="frame"
    label="Frame"
    default="none"
    :options="[
        ['value' => 'none', 'label' => 'No frame'],
        ['value' => 'safari', 'label' => 'Safari browser window'],
    ]"
    note="Safari places the image inside a browser window mockup. The window screen is about 1.71:1, so pick a wide ratio below — other ratios are centre-cropped to fit."
/>

<x-twill::input
    name="frame_url"
    label="Address bar text"
    placeholder="teamsi7.com"
    note="Shown in the mockup address bar. Only used when the Safari frame is on."
/>

<x-twill::input name="caption" label="Caption (optional)" :translated="true" />
