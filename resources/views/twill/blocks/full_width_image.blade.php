@twillBlockTitle('Full width image')
@twillBlockIcon('image')
@twillBlockGroup('프로젝트 본문')

<x-twill::medias name="image" label="Image" :max="1" />
<x-twill::input name="caption" label="Caption (optional)" :translated="true" />
