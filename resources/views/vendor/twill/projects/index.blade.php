@extends('twill::layouts.listing')

@push('extra_css')
    <style>
        /* Project listing: show cover images as consistent 1:1 thumbnails. */
        .body--listing .tablecell__thumb--square {
            width: 80px;
            height: 80px;
            overflow: hidden;
        }

        .body--listing .tablecell__thumb--square img {
            display: block;
            width: 80px !important;
            min-width: 80px;
            height: 80px !important;
            min-height: 80px;
            object-fit: cover;
            object-position: center;
        }
    </style>
@endpush
