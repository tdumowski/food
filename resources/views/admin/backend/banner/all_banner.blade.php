@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">All Banners</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#myModal">Add Banner</button>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Image</th>
                                    <th>Url</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($banners as $key => $banner)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td><img src={{ asset($banner->image) }} alt="" style="width: 50px; height:50px;"></td>
                                    <td>{{ $banner->url }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#myEdit" 
                                            id="{{ $banner->id }}" onclick='bannerEdit(this.id)''>Edit</button>
                                        <a href="{{ route('delete.banner', $banner->id) }}" class="btn btn-danger waves-effect waves-light" id="delete">Delete</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row --> 
    </div> <!-- container-fluid -->
</div>

{{-- modal --}}
<div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Add Banner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="myForm" action="{{ route('banner.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-lg-12">
                            <div>
                                <div class="form-group mb-3">
                                    <label for="example-text-input" class="form-label">Url</label>
                                    <input class="form-control" name="url" type="text">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div>
                                <div class="form-group mb-3">
                                    <label for="example-text-input" class="form-label">Image</label>
                                    <input class="form-control" name="image" type="file" id="image">
                                </div>
                                <div class="form-group mb-3">
                                    <img id="showImage" src="{{ url('upload/no_image.jpg') }}" 
                                        alt="" class="rounded-circle p-1 bg-primary" width="110" height="110">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="myEdit" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Edit Banner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="myForm" action="{{ route('banner.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="banner_id" id="banner_id" value="{{ $banner->id }}">
                    <div class="row">
                        <div class="col-lg-12">
                            <div>
                                <div class="form-group mb-3">
                                    <label for="example-text-input" class="form-label">Url</label>
                                    <input class="form-control" name="url" id="url" type="text">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div>
                                <div class="form-group mb-3">
                                    <label for="example-text-input" class="form-label">Image</label>
                                    <input class="form-control" name="image" type="file" id="bannerImage">
                                </div>
                                <div class="form-group mb-3">
                                    <img id="showBannerImage" src="{{ url('upload/no_image.jpg') }}" 
                                        alt="" class="rounded-circle p-1 bg-primary" width="110" height="110">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
    $(document).ready(function() {
        $('#image').change(function(e) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#showImage').attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files[0]);
        });
        $('#bannerImage').change(function(e) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#showBannerImage').attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files[0]);
        });
    });
</script>

<script>
    function bannerEdit(id) {
        $.ajax({
            type: "GET",
            url: "/edit/banner/" + id,
            dataType: 'json',
            success: function(response) {
                // console.log(response)
                $('#url').val(response.url);
                $('#showBannerImage').attr('src', response.image);
                $('#banner_id').val(response.id);
                // $('form#myForm').attr('action', '/update/city/' + response.city.id);
            }
        });
    }
</script>

@endsection