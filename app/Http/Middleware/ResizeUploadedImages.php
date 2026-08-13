<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

/**
 * Twill 미디어 라이브러리(이미지) 업로드를 가로채, 긴 변이 MAX_EDGE 를 넘는
 * 초대형 원본을 저장 전에 축소한다.
 *
 * 이유: 웹 표시는 최대 ~2400px면 충분한데, 5296×10770 같은 초대형 원본은
 * Glide 첫 변환 때 GD가 전체를 메모리에 펼치느라(수백 MB) 1GB 서버에서
 * 느려지거나 메모리 한도를 넘겨 깨진다. 업로드 시 한 번만 줄여두면
 * 이후 모든 변환이 가볍고 빨라진다. (표시 화질 손실 없음)
 */
class ResizeUploadedImages
{
    /** 긴 변 최대 픽셀 (이 값 이하이면 손대지 않음) */
    private const MAX_EDGE = 2560;

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

            if ($w <= self::MAX_EDGE && $h <= self::MAX_EDGE) {
                return $next($request); // 이미 충분히 작음
            }

            // 초대형 원본 디코딩에 메모리가 필요하므로 이 요청에 한해 상향.
            @ini_set('memory_limit', '1536M');
            @set_time_limit(300);

            $image = (new ImageManager(new Driver()))->read($file->getPathname());
            $image->scaleDown(self::MAX_EDGE, self::MAX_EDGE);

            $ext = strtolower($file->getClientOriginalExtension() ?: $file->guessExtension() ?: 'jpg');
            $tmp = tempnam(sys_get_temp_dir(), 'twill_rz_') . '.' . $ext;
            $image->save($tmp, quality: 90);

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
                'width' => $image->width(),
                'height' => $image->height(),
            ]);
        } catch (\Throwable $e) {
            // 실패해도 업로드는 막지 않고 원본 그대로 진행.
            Log::warning('[ResizeUploadedImages] skipped resize: ' . $e->getMessage());
        }

        return $next($request);
    }
}
