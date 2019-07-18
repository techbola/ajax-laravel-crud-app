@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <h1>Simple Laravel CRUD Ajax</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="table table-responsive">
                <table class="table table-bordered" id="table">

                    <tr>
                        <th width="150px">No</th>
                        <th>Title</th>
                        <th>Body</th>
                        <th>Date Created</th>
                        <th class="text-center" width="150px">
                            <a href="#" class="create-modal btn btn-success btn-sm">
                                <i class="fa fa-plus"></i>
                            </a>
                        </th>
                    </tr>

                    {{ csrf_field() }}

                    <?php $no=1; ?>

                    @foreach($posts as $key => $value)

                        <tr class="post{{ $value->id }}">
                            <td>{{ $no++ }}</td>
                            <td>{{ $value->title }}</td>
                            <td>{{ $value->body }}</td>
                            <td>{{ $value->created_at }}</td>
                            <td>
                                <a href="#" class="show-modal btn btn-info btn-sm"
                                   data-id="{{ $value->id }}"
                                   data-title="{{ $value->title }}"
                                   data-body="{{ $value->body }}">
                                    <i class="fa fa-eye "></i>
                                </a>
                                <a href="#" class="edit-modal btn btn-warning btn-sm"
                                   data-id="{{ $value->id }}"
                                   data-title="{{ $value->title }}"
                                   data-body="{{ $value->body }}">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="#" class="delete-modal btn btn-danger btn-sm"
                                   data-id="{{ $value->id }}">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>

                    @endforeach

                </table>
            </div>
        </div>
    </div>

    {{-- Create Post Modal --}}
    <div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Create Post</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group row">
                            <label for="title" class="col-sm-2 col-form-label">Title:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="title" name="title" placeholder="Your title here">
                                <p class="error text-center alert alert-danger d-none"></p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="body" class="col-sm-2 col-form-label">Body:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="body" name="body" placeholder="Your post content here">
                                <p class="error text-center alert alert-danger d-none"></p>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="add" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Save Post
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Show Post Modal --}}
    <div class="modal fade" id="show" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Post</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Title: <span id="postTitle"></span></p>
                    <p>Body: <span id="postBody"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Post Modal --}}
    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Post</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group row">
                            <label for="fID" class="col-sm-2 col-form-label">No:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="fID" name="fID">
                                <p class="error text-center alert alert-danger d-none"></p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="t" class="col-sm-2 col-form-label">Title:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="t" name="t">
                                <p class="error text-center alert alert-danger d-none"></p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="b" class="col-sm-2 col-form-label">Body:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="b" name="b">
                                <p class="error text-center alert alert-danger d-none"></p>
                            </div>
                        </div>
                    </form>

                    <div class="deleteContent">
                        Are you sure you want to delete <span class="title"></span>?
                        <span class="d-none id"></span>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="editPostBtn" class="btn btn-primary">
                        <span class="footer_action_button"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Post Modal --}}
    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Edit Post</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form>
                        <div class="deleteContent">
                            Are you sure you want to delete <span class="title"></span>?
                            <input type="hidden" class="form-control" id="postIdDel" name="postIdDel">
                        </div>
                    </form>

                </div>
                <div class="modal-footer modal-footer-delete">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary del">
                        <span class="footer_action_button"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection