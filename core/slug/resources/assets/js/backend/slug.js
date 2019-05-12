class SlugBoxManagement {
    init() {
        $('#change_slug').click((event) => {
            $('.default-slug').unwrap();
            let $slug_input = $('#editable-post-name');
            $slug_input.html('<input type="text" id="new-post-slug" class="form-control" value="' + $slug_input.text() + '" autocomplete="off">');
            $('#edit-slug-box .cancel').show();
            $('#edit-slug-box .save').show();
            $(event.currentTarget).hide();
        });

        $('#edit-slug-box .cancel').click(() => {
            let currentSlug = $('#current-slug').val();
            let $permalink = $('#sample-permalink');
            $permalink.html('<a class="permalink" href="' + $('#slug_id').data('view') + currentSlug.replace('/', '') + '">' + $permalink.html() + '</a>');
            $('#editable-post-name').text(currentSlug);
            $('#edit-slug-box .cancel').hide();
            $('#edit-slug-box .save').hide();
            $('#change_slug').show();
        });

        let createSlug = (name, id, exist) => {
            $.ajax({
                url: $('#slug_id').data('url'),
                type: 'POST',
                data: {
                    name: name,
                    slug_id: id,
                    screen: $('input[name=slug-screen]').val(),
                },
                success: (data) => {
                    let $permalink = $('#sample-permalink');
                    let $slug_id = $('#slug_id');
                    if (exist) {
                        $permalink.find('.permalink').prop('href', $slug_id.data('view') + data.replace('/', ''));
                    } else {
                        $permalink.html('<a class="permalink" target="_blank" href="' + $slug_id.data('view') + data.replace('/', '') + '">' + $permalink.html() + '</a>');
                    }

                    $('.page-url-seo p').text($slug_id.data('view') + data.replace('/', ''));

                    $('#editable-post-name').text(data);
                    $('#current-slug').val(data);
                    $('#edit-slug-box .cancel').hide();
                    $('#edit-slug-box .save').hide();
                    $('#change_slug').show();
                    $('#edit-slug-box').removeClass('hidden');
                },
                error: (data) => {
                    Lcms.handleError(data);
                }
            });
        };

        $('#edit-slug-box .save').click(() => {
            let $post_slug = $('#new-post-slug');
            let name = $post_slug.val();
            let id = $('#slug_id').data('id');
            if (id == null) {
                id = 0;
            }
            if (name != null && name !== '') {
                createSlug(name, id, false);
            } else {
                $post_slug.closest('.form-group').addClass('has-error');
            }
        });

        $('#name').blur(() => {
            if ($('#edit-slug-box').hasClass('hidden')) {
                let name = $('#name').val();

                if (name !== null && name !== '') {
                    createSlug(name, 0, true);
                }
            }

        });
    }
}

$(document).ready(() => {
    new SlugBoxManagement().init();
});
