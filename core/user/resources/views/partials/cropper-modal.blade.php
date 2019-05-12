<div class="modal fade text-left" tabindex="-1" role="dialog" id="avatar-modal" aria-labelledby="myModalLabel18" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form class="avatar-form" method="post" action="{{ route('admin.profile.image') }}" enctype="multipart/form-data">
                <div class="modal-header bg-info white">
                    <h4 class="modal-title white" id="myModalLabel18"><i class="fab fa-windows"></i> {{ trans('core-user::users.change_profile_image') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('core-media::media.close') }}" data-dismiss-modal="#avatar-modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="avatar-body">
                        <!-- Upload image and data -->
                        <div class="avatar-upload">
                            <input class="avatar-src" name="avatar_src" type="hidden">
                            <input class="avatar-data" name="avatar_data" type="hidden">
                            <input type="hidden" name="user_id" value="{{ $user->id }}"/>
                            {!! Form::token() !!}
                            <label for="avatarInput">{{ trans('core-user::users.new_image') }}</label>
                            <input class="avatar-input" id="avatarInput" name="avatar_file" type="file">
                        </div>

                        <div class="loading" tabindex="-1" role="img" aria-label="{{ trans('core-user::users.loading') }}"></div>

                        <!-- Crop and preview -->
                        <div class="row">
                            <div class="col-md-9">
                                <div class="avatar-wrapper"></div>
                            </div>
                            <div class="col-md-3">
                                <div class="avatar-preview preview-lg"></div>
                                <div class="avatar-preview preview-md"></div>
                                <div class="avatar-preview preview-sm"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss-modal="#avatar-modal" data-dismiss="modal">
                        {{ trans('core-user::users.close') }}
                    </button>
                    <button type="submit" class="btn btn-info">
                        {{ trans('core-user::users.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
