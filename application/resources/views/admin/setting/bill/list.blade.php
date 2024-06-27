@extends('admin.layouts.app')

@section('content')
    <style>
        .form-check-input:checked {
            background-color: #00b300 !important;
        }
    </style>
    <div id="kt_app_toolbar" class="app-toolbar pt-6 pb-2">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex align-items-stretch">
            <!--begin::Toolbar wrapper-->
            <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bold fs-3 m-0">Bill Setting List</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="{{route('admin.home')}}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Bill Setting Management</li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Bill Setting</li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <!--end::Actions-->
            </div>
            <!--end::Toolbar wrapper-->
        </div>
        <!--end::Toolbar container-->
    </div>
    <!--end::Toolbar-->
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-fluid">
            <!--begin::Card-->
            <form enctype="multipart/form-data" action="{{route('admin.bill-settings.update')}}" name="application" class="form" method="POST">
                @csrf

                @foreach($settings as $item)
                    <div class="card mt-5">
                        <!--begin::Card body-->
                        <div class="card-body py-4">
                            <h3>{{ @strtoupper(str_replace('_', ' ', $item->title)) }}</h3>
                            <!--begin::Table-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                    <span>Type</span>
                                    <span class="ms-1" data-bs-toggle="tooltip">
                                        <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                    </span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <div class="col-lg-8 fv-row">
                                    <div class="col-lg-12 fv-row">
                                        <select name="{{$item->id}}[type]" id="type" aria-label="Select a meter" data-placeholder="Select Type"
                                                class="form-select form-select-solid form-select-lg fw-semibold" required>
                                            <option value="">Select Type</option>
                                            <option value="1" {{$item->type == '1' ? 'selected' : ''}}>Fixed</option>
                                            <option value="2" {{$item->type == '2' ? 'selected' : ''}}>Percentage</option>
                                        </select>
                                    </div>
                                </div>
                                <!--end::Input-->
                            </div>

                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                    <span>Value</span>
                                    <span class="ms-1" data-bs-toggle="tooltip">
                                        <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                    </span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <div class="col-lg-8 fv-row">
                                    <input type="text" name="{{$item->id}}[value]" class="form-control form-control-solid mb-3 mb-lg-0"
                                           placeholder="Enter Value" value="{{@$item->value}}" autocomplete="off"/>
                                    @if($errors->has('value'))
                                        <div class="error text-danger">{{ $errors->first('value') }}</div>
                                    @endif
                                </div>
                                <!--end::Input-->
                            </div>
                            <!--end::Table-->
                        </div>
                    </div>
                @endforeach

                <div class="d-flex justify-content-end mt-5">
                    <button type="submit" class="btn btn-sm btn-success">Update</button>
                </div>
            </form>

            <div class="modal fade in" id="modalDel">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bb-0">
                            <h4 class="modal-title">Delete Confirmation</h4>
                            <div class="btn btn-icon btn-sm btn-active-icon-primary" id="closeModalButton" data-kt-users-modal-action="close">
                                <i class="ki-outline ki-cross fs-1"></i>
                            </div>
                        </div>
                        <form method="GET" action="{{ route('admin.user.delete') }}" id="frmDel">
                            <div class="modal-body">
                                <p>User's all asset will be deleted. Are you sure you want to delete?</p>
                            </div>
                            <div class="modal-footer bt-0">
                                <input type="hidden" name="id" value="">
                                <button type="button" class="btn btn-default" id="closeModalButton">Close</button>
                                <input type="submit" class="btn btn-primary btnclass" value="Yes Delete!">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade in" tabindex="-1" id="kt_modal_add_type">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg--primary text-white">
                    <h3 class="modal-title">Add New Bill Setting</h3>
                    <button type="button" class="btn btn-icon btn-sm btn-secondary modal-close-btn" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="bill-setting-add-form" action="{{route('admin.bill-settings.store')}}" method="POST">
                        @csrf
                        <div class="row g-2 mb-4">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="type" class="form-label required">Type</label>
                                    <input type="text" class="form-control" id="type" name="type" placeholder="Enter Name" required/>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="value" class="form-label required">Value</label>
                                    <input type="text" class="form-control" id="value" name="value" placeholder="Enter Name" required/>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary rounded-btn">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

<script type="text/javascript">
    function openAddTypeModal()
    {
        $("#kt_modal_add_type").modal('show');
    }
</script>
