import { VERT, FRAG } from './liquid-shaders.js';

// The shader never sees the logo — it samples a field where R is 255 outside the shape and
// falls toward 0 at the shape's core (same encoding as the site's public/img/logo-liquid.png).
// The site bakes that PNG ahead of time because its mark is large; the scoop is small enough
// to solve here on load.
const PAD = 0.03;   // empty margin inside the texture, so the shape never touches the frame
const ITER = 300;

function buildScoopField(W, H) {
  const c = document.createElement('canvas');
  c.width = W; c.height = H;
  const ctx = c.getContext('2d', { willReadFrequently: true });

  // Same proportions as the <rect rx="153.538"> in the logo: rx = half the width, ry = 37.5%.
  const x = W * PAD, y = H * PAD, w = W * (1 - 2 * PAD), h = H * (1 - 2 * PAD);
  ctx.fillStyle = '#fff';
  ctx.beginPath();
  if (ctx.roundRect) ctx.roundRect(x, y, w, h, [{ x: w / 2, y: h * 0.375 }]);
  else ctx.rect(x, y, w, h);
  ctx.fill();

  const alpha = ctx.getImageData(0, 0, W, H).data;
  const inside = new Uint8Array(W * H);
  for (let i = 0; i < W * H; i++) inside[i] = alpha[i * 4 + 3] > 127 ? 1 : 0;

  // Jacobi relaxation of ∇²u = -1 with u = 0 on the boundary: a smooth bump, deepest at the core.
  let u = new Float32Array(W * H);
  let next = new Float32Array(W * H);
  for (let it = 0; it < ITER; it++) {
    for (let yy = 1; yy < H - 1; yy++) {
      for (let xx = 1; xx < W - 1; xx++) {
        const i = yy * W + xx;
        next[i] = inside[i] ? (u[i - 1] + u[i + 1] + u[i - W] + u[i + W] + 1) * 0.25 : 0;
      }
    }
    const swap = u; u = next; next = swap;
  }

  let max = 0;
  for (let i = 0; i < u.length; i++) if (u[i] > max) max = u[i];

  const out = ctx.createImageData(W, H);
  for (let i = 0; i < W * H; i++) {
    const depth = max ? u[i] / max : 0;          // 0 at the boundary, 1 at the core
    const v = Math.round(255 * (1 - depth));     // 255 outside, 0 at the core
    out.data[i * 4] = out.data[i * 4 + 1] = out.data[i * 4 + 2] = v;
    out.data[i * 4 + 3] = 255;
  }
  ctx.putImageData(out, 0, 0);
  return c;
}

export function liquidScoop(canvas, opts = {}) {
  const gl = canvas.getContext('webgl2', { antialias: true, alpha: true });
  if (!gl) return { ok: false, reason: 'no webgl2' };

  const compile = (src, type) => {
    const sh = gl.createShader(type);
    gl.shaderSource(sh, src); gl.compileShader(sh);
    if (!gl.getShaderParameter(sh, gl.COMPILE_STATUS)) {
      return { err: gl.getShaderInfoLog(sh) };
    }
    return sh;
  };
  const vert = compile(VERT, gl.VERTEX_SHADER);
  const frag = compile(FRAG, gl.FRAGMENT_SHADER);
  if (vert.err || frag.err) return { ok: false, reason: vert.err || frag.err };

  const program = gl.createProgram();
  gl.attachShader(program, vert); gl.attachShader(program, frag); gl.linkProgram(program);
  if (!gl.getProgramParameter(program, gl.LINK_STATUS)) {
    return { ok: false, reason: gl.getProgramInfoLog(program) };
  }

  gl.enable(gl.BLEND);
  gl.blendFunc(gl.SRC_ALPHA, gl.ONE_MINUS_SRC_ALPHA);

  const uniforms = {};
  const n = gl.getProgramParameter(program, gl.ACTIVE_UNIFORMS);
  for (let i = 0; i < n; i++) {
    const name = gl.getActiveUniform(program, i).name;
    uniforms[name] = gl.getUniformLocation(program, name);
  }

  gl.bindBuffer(gl.ARRAY_BUFFER, gl.createBuffer());
  gl.bufferData(gl.ARRAY_BUFFER, new Float32Array([-1, -1, 1, -1, -1, 1, 1, 1]), gl.STATIC_DRAW);
  gl.useProgram(program);
  const pos = gl.getAttribLocation(program, 'a_position');
  gl.enableVertexAttribArray(pos);
  gl.vertexAttribPointer(pos, 2, gl.FLOAT, false, 0, 0);

  const o = Object.assign(
    { patternScale: 2, refraction: 0.015, edge: 0.4, patternBlur: 0.005, liquid: 0.07, speed: 0.3 },
    opts
  );
  gl.uniform1f(uniforms.u_edge, o.edge);
  gl.uniform1f(uniforms.u_patternBlur, o.patternBlur);
  gl.uniform1f(uniforms.u_patternScale, o.patternScale);
  gl.uniform1f(uniforms.u_refraction, o.refraction);
  gl.uniform1f(uniforms.u_liquid, o.liquid);
  gl.uniform1f(uniforms.u_time, 0);

  const TW = 256, TH = 341;                 // same 0.75 ratio as the scoop rect
  const field = buildScoopField(TW, TH);

  const tex = gl.createTexture();
  gl.activeTexture(gl.TEXTURE0);
  gl.bindTexture(gl.TEXTURE_2D, tex);
  gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_MIN_FILTER, gl.LINEAR);
  gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_MAG_FILTER, gl.LINEAR);
  gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_WRAP_S, gl.CLAMP_TO_EDGE);
  gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_WRAP_T, gl.CLAMP_TO_EDGE);
  gl.pixelStorei(gl.UNPACK_ALIGNMENT, 1);
  gl.texImage2D(gl.TEXTURE_2D, 0, gl.RGBA, gl.RGBA, gl.UNSIGNED_BYTE, field);
  gl.uniform1i(uniforms.u_image_texture, 0);

  // Canvas and texture share the 0.75 ratio, so the field maps onto the canvas 1:1.
  const resize = () => {
    const r = canvas.getBoundingClientRect();
    canvas.width = Math.max(1, Math.round(r.width * devicePixelRatio));
    canvas.height = Math.max(1, Math.round(r.height * devicePixelRatio));
    gl.viewport(0, 0, canvas.width, canvas.height);
    gl.uniform1f(uniforms.u_ratio, canvas.width / canvas.height);
    gl.uniform1f(uniforms.u_img_ratio, TW / TH);
  };
  resize();
  new ResizeObserver(resize).observe(canvas);

  let elapsed = 0, last = 0, raf = 0, running = false;
  const frame = (now) => {
    elapsed += (now - last) * o.speed;
    last = now;
    gl.uniform1f(uniforms.u_time, elapsed);
    gl.drawArrays(gl.TRIANGLE_STRIP, 0, 4);
    raf = requestAnimationFrame(frame);
  };
  const start = () => { if (running) return; running = true; last = performance.now(); raf = requestAnimationFrame(frame); };
  const stop = () => { running = false; cancelAnimationFrame(raf); };

  let onScreen = false;
  const sync = () => (onScreen && !document.hidden) ? start() : stop();
  new IntersectionObserver((e) => { onScreen = e[0].isIntersecting; sync(); }).observe(canvas);
  document.addEventListener('visibilitychange', sync);

  return { ok: true };
}
