<?php

return [
    'media_library' => [
        'allowed_extensions' => ['svg', 'jpg', 'gif', 'png', 'jpeg', 'webp', 'avif'],
    ],
    'buckets' => [
        'homepage' => [
            'sourceHeaderTitle' => '프로젝트 목록',
            'sectionIntroText' => '홈에 보여줄 프로젝트를 선택하고, 오른쪽 영역에서 순서를 정리하세요.',
            'restricted' => true,
            'buckets' => [
                'homepage_main_features' => [
                    'name' => '메인 피처 프로젝트',
                    'max_items' => 5,
                    'bucketables' => [
                        ['module' => 'projects', 'name' => 'Projects'],
                    ],
                ],
                'homepage_secondary_features' => [
                    'name' => '보조 피처 프로젝트',
                    'max_items' => 12,
                    'bucketables' => [
                        ['module' => 'projects', 'name' => 'Projects'],
                    ],
                ],
                'homepage_additional_features' => [
                    'name' => '추가 피처 프로젝트',
                    'max_items' => 24,
                    'bucketables' => [
                        ['module' => 'projects', 'name' => 'Projects'],
                    ],
                ],
            ],
        ],
    ],
    'bucketsRoutes' => [
        'homepage' => 'featured',
    ],
];
