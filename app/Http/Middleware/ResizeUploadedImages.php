<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

/**
 * Twill 미디어 라이브러리(이미지) 업로드를 가로채, 지나치게 큰 원본을 저장 전에 축소한다.
 *
 * 이유: 웹 표시는 가로 ~2400px면 충분한데, 5296×10770 같은 큰 원본은 Glide 변환 때
 * GD가 전체를 메모리에 펼치느라(수백 MB) 1GB 서버에서 느려지거나 깨진다.
 *
 * 정책: 메모리를 좌우하는 건 "긴 변"이 아니라 "총 넓이(픽셀)"다. 세로로 긴 얇은
 * 이미지는 넓이가 작아 부담이 없으므로 건드리지 않는다. → **가로만 MAX_WIDTH 로
 * 제한**하고, 세로는 넉넉한 MAX_HEIGHT(극단적 초고height 방어용) 까지 허용한다.
 * 그래서 긴 스크린샷의 가로가 짜부되지 않는다.
 */
class ResizeUploadedImages
{
    /** 가로 최대 (레티나 풀와이드 기준 충분). 이보다 넓으면 이 폭으로 축소. */
    private const MAX_WIDTH = 2560;

    /** 세로 최대 (거의 안 걸리는 안전장치 — 총 넓이를 변환 가능 범위로 묶는 용도). */
    private const MAX_HEIGHT = 12000;

    /** 축소 대상 래스터 포맷만. SVG(벡터)·GIF(애니메이션)는 제외. */
    private const RESIZABLE_MIMES = ['image/jpeg', 'image/png', 'image/webp'];

    public function handle(Request $request, Closure $next)
    {
        if (! $request->isMethod('post') || ! $request->is('admin/media-library/medias')) {
            return $next($request);
        }

        $file = $request->file('qqfile');

        if (! $file instanceof UploadedFile || ! $file->isValid()) {
            return $next($request);
        }

        $mime = (string) $file->getMimeType();

        if (! in_array($mime, self::RESIZABLE_MIMES, true)) {
            return $next($request);
        }

        try {
            $size = @getimagesize($file->getPathname());

            if (! $size) {
                return $next($request);
            }

            [$w, $h] = $size;

            if ($w <= self::MAX_WIDTH && $h <= self::MAX_HEIGHT) {
                return $next($request); // 가로도 넉넉하고 세로도 한도 내 — 손대지 않음
            }

            // 대형 원본 디코딩에 메모리가 필요하므로 이 요청에 한해 상향(단, 물리 RAM 1GB라 과하지 않게).
            @ini_set('memory_limit', '512M');
            @set_time_limit(300);

            // 여러 장을 동시에 올려도 리사이즈는 서버에서 "한 번에 하나씩"만.
            // (병렬 대형 디코딩이 겹치면 1GB RAM이 OOM → 502. flock 으로 직렬화)
            $lockHandle = @fopen(storage_path('app/.image-resize.lock'), 'c');

            if ($lockHandle) {
                @flock($lockHandle, LOCK_EX); // 앞선 리사이즈가 끝날 때까지 대기
            }

            try {
                $image = (new ImageManager(new Driver()))->read($file->getPathname());
                $image->scaleDown(self::MAX_WIDTH, self::MAX_HEIGHT);

                $ext = strtolower($file->getClientOriginalExtension() ?: $file->guessExtension() ?: 'jpg');
                $tmp = tempnam(sys_get_temp_dir(), 'twill_rz_') . '.' . $ext;
                $image->save($tmp, quality: 90);

                $newW = $image->width();
                $newH = $image->height();

                // GD 리소스를 즉시 해제해 다음 리사이즈로 메모리를 넘겨줌.
                unset($image);
                gc_collect_cycles();
            } finally {
                if ($lockHandle) {
                    @flock($lockHandle, LOCK_UN);
                    @fclose($lockHandle);
                }
            }

            $resized = new UploadedFile(
                $tmp,
                $file->getClientOriginalName(),
                $mime,
                null,
                true // 이미 신뢰된 임시 파일(is_uploaded_file 검사 건너뜀)
            );

            // 컨트롤러는 클라이언트가 보낸 width/height(원본값)를 우선 사용하므로 새 치수로 덮어씀.
            $request->files->set('qqfile', $resized);
            $request->merge([
                'width' => $newW,
                'height' => $newH,
            ]);
        } catch (\Throwable $e) {
            // 실패해도 업로드는 막지 않고 원본 그대로 진행.
            Log::warning('[ResizeUploadedImages] skipped resize: ' . $e->getMessage());
        }

        return $next($request);
    }
}
