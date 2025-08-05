@extends('admin.layouts.master')

@section('content')

<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Gallery</h1>
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <li class="breadcrumb-item text-muted">
                    <a href="{{ url('/home') }}" class="text-muted text-hover-primary">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-400 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">Gallery</li>
            </ul>
        </div>

        <div class="d-flex align-items-center gap-2 gap-lg-3">
            <button id="bulk-delete-btn" class="btn btn-danger">Delete Selected</button>
        </div>
    </div>
</div>

<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-xxl">

        <div class="card mb-5 mb-xl-8">
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-3 mb-1">Gallery Statistics</span>
                </h3>

                <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" title="Click to add an Image">
                    <a href="{{ route('admin.galleries.create') }}" class="btn btn-sm fw-bold btn-primary">
                        <i class="ki-duotone ki-plus fs-2"></i>Add New Image</a>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card-body py-3">
                <div class="table-responsive">
                    <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4" id="gallery-table">
                        <thead>
                            <tr class="fw-bold text-muted">
                                <th class="w-25px">
                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" id="select-all" />
                                    </div>
                                </th>
                                <th class="min-w-200px">Title</th>
                                <th class="min-w-150px">Image</th>
                                <th class="min-w-150px">Status</th>
                                <th class="min-w-100px text-end">Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<script>
$(document).ready(function () {
    var table = $('#gallery-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.galleries.index') }}",
        columns: [
            {
                data: 'id',
                render: function (data) {
                    return `<input type="checkbox" class="select-row" value="${data}">`;
                },
                orderable: false,
                searchable: false
            },
            { data: 'title', name: 'title' },
            {
                data: 'image',
                render: function (data) {
                    return `<img src="${window.location.origin}/storage/${data}" width="60" class="img-thumbnail">`;
                },
                orderable: false,
                searchable: false
            },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });

    // Select/Deselect all rows
    $(document).on('click', '#select-all', function () {
        $('.select-row').prop('checked', this.checked);
    });

    $(document).on('click', '.select-row', function () {
        $('#select-all').prop('checked', $('.select-row:checked').length === $('.select-row').length);
    });

    // Bulk Delete
    $('#bulk-delete-btn').on('click', function () {
        var ids = $('.select-row:checked').map(function () { return $(this).val(); }).get();

        if (ids.length === 0) {
            alert('No images selected.');
            return;
        }

        if (confirm('Are you sure you want to delete selected images?')) {
            $.ajax({
                url: "{{ route('admin.galleries.bulkDelete') }}",
                method: 'POST',
                data: {
                    ids: ids,
                    _token: '{{ csrf_token() }}',
                    _method: 'DELETE'
                },
                success: function (response) {
                    alert(response.success);
                    $('#select-all').prop('checked', false);
                    table.ajax.reload();
                },
                error: function () {
                    alert('Something went wrong!');
                }
            });
        }
    });
});
</script>
@endpush