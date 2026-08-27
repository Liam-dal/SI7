// Apple-style liquid glass: an SVG displacement map drives feDisplacementMap inside a
// backdrop-filter, so whatever sits behind the element gets refracted through a lens.
// Chromium only — Safari has no SVG backdrop filters and Firefox's support is partial.

let seq = 0;

function displacementMapUri(w, h, rx, ry, o) {
  // Red ramps left->right and blue top->bottom; differencing them yields a map whose R and B
  // channels encode how far each pixel should be pushed horizontally and vertically.
  const inset = Math.round(Math.min(w, h) * o.border);
  const svg = `<svg xmlns="http://www.w3.org/2000/svg" width="${w}" height="${h}" viewBox="0 0 ${w} ${h}">
<defs>
<linearGradient id="r" x1="100%" y1="0%" x2="0%" y2="0%"><stop offset="0%" stop-color="#000"/><stop offset="100%" stop-color="#f00"/></linearGradient>
<linearGradient id="b" x1="0%" y1="0%" x2="0%" y2="100%"><stop offset="0%" stop-color="#000"/><stop offset="100%" stop-color="#00f"/></linearGradient>
</defs>
<rect width="${w}" height="${h}" fill="#000"/>
<rect width="${w}" height="${h}" rx="${rx}" ry="${ry}" fill="url(#r)"/>
<rect width="${w}" height="${h}" rx="${rx}" ry="${ry}" fill="url(#b)" style="mix-blend-mode:${o.blend}"/>
<rect x="${inset}" y="${inset}" width="${Math.max(0, w - inset * 2)}" height="${Math.max(0, h - inset * 2)}" rx="${Math.max(0, rx - inset)}" ry="${Math.max(0, ry - inset)}" fill="hsl(0 0% ${o.lightness}% / ${o.alpha})" style="filter:blur(${o.blur}px)"/>
</svg>`;
  return 'data:image/svg+xml,' + encodeURIComponent(svg);
}

export function liquidGlass(el, opts = {}) {
  const o = Object.assign({
    border: 0.07, lightness: 50, blend: 'difference', xChannel: 'R', yChannel: 'B',
    alpha: 0.93, blur: 11, rOffset: 0, gOffset: 10, bOffset: 20, scale: -180, frost: 0.05,
    backdropBlur: 3,   // softens what shows through the lens; not part of the displacement map
  }, opts);

  const id = 'liquid-glass-' + (++seq);
  const svgNS = 'http://www.w3.org/2000/svg';
  const holder = document.createElementNS(svgNS, 'svg');
  holder.setAttribute('aria-hidden', 'true');
  holder.setAttribute('width', '0');
  holder.setAttribute('height', '0');
  holder.style.cssText = 'position:absolute;width:0;height:0;pointer-events:none';
  document.body.appendChild(holder);

  const filter = document.createElementNS(svgNS, 'filter');
  filter.setAttribute('id', id);
  filter.setAttribute('color-interpolation-filters', 'sRGB');
  holder.appendChild(filter);

  const mk = (tag, attrs) => {
    const n = document.createElementNS(svgNS, tag);
    for (const k in attrs) n.setAttribute(k, attrs[k]);
    filter.appendChild(n);
    return n;
  };

  const feImage = mk('feImage', { result: 'map', preserveAspectRatio: 'none' });

  // One displacement pass per channel at slightly different strengths — that spread is what
  // reads as chromatic fringing at the lens edge.
  for (const [ch, offset, matrix] of [
    ['R', o.rOffset, '1 0 0 0 0  0 0 0 0 0  0 0 0 0 0  0 0 0 1 0'],
    ['G', o.gOffset, '0 0 0 0 0  0 1 0 0 0  0 0 0 0 0  0 0 0 1 0'],
    ['B', o.bOffset, '0 0 0 0 0  0 0 0 0 0  0 0 1 0 0  0 0 0 1 0'],
  ]) {
    mk('feDisplacementMap', {
      in: 'SourceGraphic', in2: 'map',
      scale: String(o.scale + offset),
      xChannelSelector: o.xChannel, yChannelSelector: o.yChannel,
      result: 'disp' + ch,
    });
    mk('feColorMatrix', { in: 'disp' + ch, type: 'matrix', values: matrix, result: 'ch' + ch });
  }
  mk('feBlend', { in: 'chR', in2: 'chG', mode: 'screen', result: 'rg' });
  mk('feBlend', { in: 'rg', in2: 'chB', mode: 'screen', result: 'rgb' });
  mk('feGaussianBlur', { in: 'rgb', stdDeviation: '0.7' });

  el.style.backdropFilter = `url(#${id}) blur(${o.backdropBlur}px)`;
  el.style.background = `hsl(0 0% 100% / ${o.frost})`;

  const sync = () => {
    const r = el.getBoundingClientRect();
    const w = Math.max(1, Math.round(r.width));
    const h = Math.max(1, Math.round(r.height));
    // Same corner geometry as the scoop rect: rx = half the width, ry = 37.5% of the height.
    const uri = displacementMapUri(w, h, w / 2, h * 0.375, o);
    feImage.setAttribute('href', uri);
    feImage.setAttributeNS('http://www.w3.org/1999/xlink', 'xlink:href', uri);
    for (const a of [['x', 0], ['y', 0], ['width', w], ['height', h]]) feImage.setAttribute(a[0], a[1]);
  };
  sync();
  new ResizeObserver(sync).observe(el);

  return { id, supported: CSS.supports('backdrop-filter', `url(#${id})`) };
}
