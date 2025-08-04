@extends('admin.layouts.master')

@section('content')

<!--begin::Toolbar-->
<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
	<!--begin::Toolbar container-->
	<div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
		<!--begin::Page title-->
		<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
			<!--begin::Title-->
			<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Category</h1>
			<!--end::Title-->
			<!--begin::Breadcrumb-->
			<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
				<!--begin::Item-->
				<li class="breadcrumb-item text-muted">
					<a href="{{ url('/home') }}" class="text-muted text-hover-primary">Home</a>
				</li>
				<!--end::Item-->
				<!--begin::Item-->
				<li class="breadcrumb-item">
					<span class="bullet bg-gray-400 w-5px h-2px"></span>
				</li>
				<!--end::Item-->
				<!--begin::Item-->
				<li class="breadcrumb-item text-muted">Category</li>
				<!--end::Item-->
			</ul>
			<!--end::Breadcrumb-->
		</div>
		<!--end::Page title-->
		<!--begin::Actions-->
		<div class="d-flex align-items-center gap-2 gap-lg-3">
			

			<!--begin::Secondary button-->
			<!--end::Secondary button-->
			<!--begin::Primary button-->
			<button id="bulk-delete-btn" class="btn btn-danger">Delete Selected</button>
			<!--end::Primary button-->
		</div>
		<!--end::Actions-->
	</div>
	<!--end::Toolbar container-->
</div>
<!--end::Toolbar-->


<!--begin::Content-->
<div id="kt_app_content" class="app-content flex-column-fluid">
    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-xxl">

        <!--begin::Tables Widget 9-->
        <div class="card mb-5 mb-xl-8">
            <!--begin::Header-->
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-3 mb-1">Category Statistics</span>
                    <!--<span class="text-muted mt-1 fw-semibold fs-7">Over 500 Category</span> -->
                </h3>

               

                <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title="Click to add a Category">
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-sm fw-bold btn-primary">
                    <i class="ki-duotone ki-plus fs-2"></i>Add New Category</a>
                </div>
            </div>
            <!--end::Header-->

            @if(session('success'))
		        <div class="alert alert-success">{{ session('success') }}</div>
		    @endif



            <!--begin::Body-->
            <div class="card-body py-3">
                <!--begin::Table container-->
                <div class="table-responsive">
                    <!--begin::Table-->
                    <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4" id="category-table">
                        <!--begin::Table head-->
                        <thead>
                            <tr class="fw-bold text-muted">
                                <th class="w-25px">
                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" id="select-all" />
                                    </div>
                                </th>
                                <th class="min-w-200px">Name</th>
                                <th class="min-w-200px">Status</th>
                                <th class="min-w-100px text-end">Actions</th>
                            </tr>
                        </thead>
                        <!--end::Table head-->
                    </table>
                    <!--end::Table-->
                </div>
                <!--end::Table container-->
            </div>
            <!--begin::Body-->



        </div>
        <!--end::Tables Widget 9-->
    </div>
    <!--end::Content container-->
</div>
<!--end::Content-->


@endsection

@push('scripts')

{{-- DataTables --}}
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">



<script>
$(document).ready(function () {

    //  Initialize DataTable
    var table = $('#category-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.categories.index') }}",
        columns: [
            {
                data: 'id',
                render: function (data) {
                    return `<input type="checkbox" class="select-row" value="${data}">`;
                },
                orderable: false,
                searchable: false
            },
            { data: 'name', name: 'name' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });

    // Select/Deselect all rows
    $(document).on('click', '#select-all', function () {
        $('.select-row').prop('checked', this.checked);
    });

    //  If any checkbox is unchecked, uncheck the "select all" checkbox
    $(document).on('click', '.select-row', function () {
        if ($('.select-row:checked').length === $('.select-row').length) {
            $('#select-all').prop('checked', true);
        } else {
            $('#select-all').prop('checked', false);
        }
    });

    //  Bulk Delete Action
    $('#bulk-delete-btn').on('click', function () {
        var ids = $('.select-row:checked').map(function () {
            return $(this).val();
        }).get();

        if (ids.length === 0) {
            alert('No categories selected.');
            return;
        }

        if (confirm('Are you sure you want to delete selected categories?')) {
            $.ajax({
			    url: "{{ route('admin.categories.bulkDelete') }}",
			    method: 'POST', // Laravel DELETE spoof
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