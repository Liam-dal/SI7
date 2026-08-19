@twillBlockTitle('영상')
@twillBlockIcon('video')
@twillBlockGroup('프로젝트 본문')

<x-twill::files
    name="video"
    label="영상 파일 (mp4 / webm)"
    :max="1"
    note="직접 올린 영상이 있으면 아래 URL보다 우선합니다. 화질 대비 용량이 커지지 않게 mp4(H.264) 권장."
/>

<x-twill::input
    name="url"
    label="또는 YouTube / Vimeo URL"
    type="url"
    note="파일을 올리지 않았을 때만 사용됩니다."
/>

<x-twill::medias
    name="poster"
    label="Poster 이미지 (선택)"
    :max="1"
    note="영상이 로드되기 전에 보여줄 정지 컷. 업로드 영상에만 적용됩니다."
/>

<x-twill::select
    name="mode"
    label="재생 방식"
    default="controls"
    :options="[
        ['value' => 'controls', 'label' => '컨트롤 표시 (소리 있음, 수동 재생)'],
        ['value' => 'demo', 'label' => 'UI 데모 (자동재생·음소거·무한반복, 컨트롤 없음)'],
    ]"
    note="'UI 데모'는 화면 밖으로 나가면 자동으로 일시정지됩니다."
/>

<x-twill::select
    name="width"
    label="폭"
    default="full"
    :options="[
        ['value' => 'full', 'label' => '본문 풀폭'],
        ['value' => 'measure', 'label' => '읽기 폭 (텍스트와 동일)'],
    ]"
/>

<x-twill::input name="caption" label="Caption (optional)" :translated="true" />
