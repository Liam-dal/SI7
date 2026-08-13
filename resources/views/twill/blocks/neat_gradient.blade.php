@twillBlockTitle('Neat 그라디언트')
@twillBlockIcon('image')
@twillBlockGroup('프로젝트 본문')

<x-twill::input
    name="config"
    label="Neat 설정 (JSON)"
    type="textarea"
    :rows="12"
    note="neat.firecms.co에서 디자인 → 설정 객체 { ... } 부분만 붙여넣으세요 (import·new NeatGradient·scroll 줄 제외)."
/>

<x-twill::input
    name="height"
    label="높이 (px, 선택)"
    type="number"
    note="비우면 반응형 기본 높이(약 50vh, 최대 560px)."
/>
