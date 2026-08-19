@twillBlockTitle('Video')
@twillBlockIcon('video')
@twillBlockGroup('Content')

<x-twill::files
    name="video"
    label="Video file (mp4 / webm)"
    :max="1"
    note="An uploaded file takes priority over the URL below. mp4 (H.264) is recommended to keep the file size down."
/>

<x-twill::input
    name="url"
    label="Or a YouTube / Vimeo URL"
    type="url"
    note="Used only when no file is uploaded."
/>

<x-twill::medias
    name="poster"
    label="Poster image (optional)"
    :max="1"
    note="Still frame shown before the video loads. Applies to uploaded videos only."
/>

<x-twill::select
    name="mode"
    label="Playback"
    default="controls"
    :options="[
        ['value' => 'controls', 'label' => 'Show controls (with sound, manual play)'],
        ['value' => 'demo', 'label' => 'UI demo (autoplay, muted, looping, no controls)'],
    ]"
    note="UI demo pauses automatically when it scrolls out of view."
/>

<x-twill::select
    name="width"
    label="Width"
    default="full"
    :options="[
        ['value' => 'full', 'label' => 'Full content width'],
        ['value' => 'measure', 'label' => 'Reading width (same as text)'],
    ]"
/>

<x-twill::input name="caption" label="Caption (optional)" :translated="true" />
