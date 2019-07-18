<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>Laravel, Ajax CRUD</title>
</head>
<body>

    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <a href="{{ route('post.index') }}" class="navbar-brand">
                    codElog
                </a>
            </div>
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ asset('js/jquery-3.4.1.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    {{-- Ajax - Add Post --}}
    <script type="text/javascript">

        $(document).on('click','.create-modal', function(){
            $('#create').modal('show');
        })

        $("#add").click(function(){
            $.ajax({
                type: 'POST',
                url: 'addPost',
                data: {
                    '_token': $('input[name=_token]').val(),
                    'title': $('input[name=title]').val(),
                    'body': $('input[name=body]').val(),
                },
                success: function(data){
                    let errorField = $('.error');
                    if((data.errors)){
                        errorField.removeClass('d-none');
                        errorField.text(data.errors.title);
                        errorField.text(data.errors.body);
                    }else{
                        errorField.remove();
                        $('#table').append("<tr class='post" + data.id + "'>\n" +
                            "                            <td>" + data.id + "</td>\n" +
                            "                            <td>" + data.title + "</td>\n" +
                            "                            <td>" + data.body + "</td>\n" +
                            "                            <td>" + data.created_at + "</td>\n" +
                            "                            <td>\n" +
                            "                                <a href='#' class='show-modal btn btn-info btn-sm'\n" +
                            "                                   data-id=' + data.id + '\n" +
                            "                                   data-title=' + data.title + '\n" +
                            "                                   data-body=' + data.body + '>\n" +
                            "                                    <i class='fa fa-eye '></i>\n" +
                            "                                </a>\n" +
                            "                                <a href='#' class='edit-modal btn btn-warning btn-sm'\n" +
                            "                                   data-id=' + data.id + '\n" +
                            "                                   data-title=' + data.title + '\n" +
                            "                                   data-body=' + data.body + '>\n" +
                            "                                    <i class='fa fa-edit'></i>\n" +
                            "                                </a>\n" +
                            "                                <a href=\'#\' class=\'delete-modal btn btn-danger btn-sm\'\n" +
                            "                                   data-id=\' + data.id + \'\n" +
                            "                                   data-title=\' + data.title + \'\n" +
                            "                                   data-body=\' + data.body + \'>\n" +
                            "                                    <i class=\'fa fa-trash\'></i>\n" +
                            "                                </a>\n" +
                            "                            </td>\n" +
                            "                        </tr>");

                        $('#create').modal('hide');

                    }

                },
            });

            $('#title').val('');
            $('#body').val('');

        });

        {{-- Ajax - Add Post --}}
        $(document).on('click','.show-modal', function(){

            let postId = $(this).data('id');
            let postTitle = $(this).data('title');
            let postBody = $(this).data('body');

            $("#postId").text( postId );
            $("#postTitle").text( postTitle );
            $("#postBody").text( postBody );

            $('#show').modal('show');
        })

        {{-- Ajax - Edit Post --}}
        $(document).on('click', '.edit-modal', function(){

            let editPostId = $(this).data('id');
            let editPostTitle = $(this).data('title');
            let editPostBody = $(this).data('body');

            $("#fID").val( editPostId );
            $("#t").val( editPostTitle );
            $("#b").val( editPostBody );

            $('.deleteContent').hide();
            $('.footer_action_button').text('Update Post');
            $('#edit').modal('show');
        });

        $('.modal-footer').on('click', '#editPostBtn', function(){
            $.ajax({
                type: 'POST',
                url: 'editPost',
                data: {
                    '_token': $('input[name=_token]').val(),
                    'id': $('#fID').val(),
                    'title': $('#t').val(),
                    'body': $('#b').val(),
                },
                success: function(data){
                    let errorField = $('.error');
                    if((data.errors)){
                        errorField.removeClass('d-none');
                        errorField.text(data.errors.title);
                        errorField.text(data.errors.body);
                    }else{
                        errorField.remove();
                        $('.post' + data.id).replaceWith("<tr class='post" + data.id + "'>\n" +
                            "                            <td>" + data.id + "</td>\n" +
                            "                            <td>" + data.title + "</td>\n" +
                            "                            <td>" + data.body + "</td>\n" +
                            "                            <td>" + data.created_at + "</td>\n" +
                            "                            <td>\n" +
                            "                                <a href='#' class='show-modal btn btn-info btn-sm'\n" +
                            "                                   data-id=' + data.id + '\n" +
                            "                                   data-title=' + data.title + '\n" +
                            "                                   data-body=' + data.body + '>\n" +
                            "                                    <i class='fa fa-eye '></i>\n" +
                            "                                </a>\n" +
                            "                                <a href='#' class='edit-modal btn btn-warning btn-sm'\n" +
                            "                                   data-id=' + data.id + '\n" +
                            "                                   data-title=' + data.title + '\n" +
                            "                                   data-body=' + data.body + '>\n" +
                            "                                    <i class='fa fa-edit'></i>\n" +
                            "                                </a>\n" +
                            "                                <a href=\'#\' class=\'delete-modal btn btn-danger btn-sm\'\n" +
                            "                                   data-id=\' + data.id + \'\n" +
                            "                                   data-title=\' + data.title + \'\n" +
                            "                                   data-body=\' + data.body + \'>\n" +
                            "                                    <i class=\'fa fa-trash\'></i>\n" +
                            "                                </a>\n" +
                            "                            </td>\n" +
                            "                        </tr>");

                        $('#edit').modal('hide');
                        location.reload();

                    }

                },
            });
        });

        {{-- Ajax - Delete Post --}}
        $(document).on('click', '.delete-modal', function(){

            let editPostId = $(this).data('id');

            $('#postIdDel').val(editPostId);
            $('.deleteContent').show();
            $('.footer_action_button').text('Delete Post');
            $('#delete').modal('show');
        });

        $('.modal-footer-delete').on('click', '.del', function(){

            $.ajax({
                type: 'POST',
                url: 'deletePost',
                data: {
                    '_token': $('input[name=_token]').val(),
                    'id': $('input[name=postIdDel]').val()
                },
                success: function(){

                    $('.post' + $('.id').text()).remove();

                    $('#delete').modal('hide');
                    location.reload();
                },
            });
        });

    </script>

</body>
</html>