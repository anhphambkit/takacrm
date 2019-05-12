<script>
    var RV_MEDIA_URL = {!! json_encode(BMedia::getUrls()) !!};
    var RV_MEDIA_CONFIG = {!! json_encode([
        'mode' => config('core-media.media.mode'),
        'permissions' => BMedia::getPermissions(),
        'translations' => trans('core-media::media.javascript'),
        'pagination' => [
            'paged' => config('core-media.media.pagination.paged'),
            'posts_per_page' => config('core-media.media.pagination.per_page'),
            'in_process_get_media' => false,
            'has_more' =>  true,
        ],
    ]) !!}
</script>