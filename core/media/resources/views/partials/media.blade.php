<div class="modal fade text-left media-modal"
    data-keyboard="false"
    id="rv_media_modal" 
    tabindex="-1" 
    role="dialog" 
    aria-labelledby="myModalLabel18" 
    aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content bb-loading">
        <div class="modal-header bg-info white">
            <h4 class="modal-title white" id="myModalLabel11"><i class="la la-tree"></i> {{ trans('core-media::media.gallery') }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-dismiss-modal="#rv_media_modal">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body media-modal-body media-modal-loading" id="rv_media_body"></div>
        <div class="loading-wrapper">
            <div class="loader">
                <svg class="circular" viewBox="25 25 50 50">
                    <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2"
                            stroke-miterlimit="10"/>
                </svg>
            </div>
        </div>
    </div>
  </div>
</div>

@include('core-media::config')
<link href="{{ asset('backend/core/media/assets/css/media.css?v=' . time()) }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('backend/core/media/assets/js/integrate.js?v=' . time()) }}"></script>
