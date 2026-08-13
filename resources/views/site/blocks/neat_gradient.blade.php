@php
    $cfg = trim((string) $block->input('config'));
    $h = (int) $block->input('height');
    $uid = 'neat-' . $block->id;
@endphp

@if($cfg !== '')
    <div class="neat-block"@if($h > 0) style="height:{{ $h }}px"@endif>
        <canvas class="neat-block__canvas" id="{{ $uid }}"></canvas>
    </div>

    @push('scripts')
    <script type="module">
        import { NeatGradient } from "https://esm.sh/@firecms/neat";
        (() => {
            const el = document.getElementById(@json($uid));
            if (!el) return;
            try {
                const config = {!! $block->input('config') !!};
                new NeatGradient(Object.assign({}, config, { ref: el }));
            } catch (e) {
                console.warn('Neat block init failed:', e);
                el.closest('.neat-block')?.remove();
            }
        })();
    </script>
    @endpush
@endif
