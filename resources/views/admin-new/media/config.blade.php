<script>
    RS_MEDIA_URL = {!! json_encode(RsMedia::getUrls()) !!};
    RS_MEDIA_CONFIG = {!! json_encode([
        'permissions' => RsMedia::getPermissions(),
        'translations' => trans('media.javascript'),
        'pagination' => [
            'paged' => config('media.pagination.paged'),
            'posts_per_page' => config('media.pagination.per_page'),
            'in_process_get_media' => false,
            'has_more' =>  true,
        ],
    ]) !!}
</script>
