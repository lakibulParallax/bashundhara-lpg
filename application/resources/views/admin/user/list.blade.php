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
                    <h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bold fs-3 m-0">Users List</h1>
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
                        <li class="breadcrumb-item text-muted">User Management</li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Users</li>
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
            <div class="card">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <!--begin::Search-->
                        <div class="d-flex align-items-center position-relative my-1">
                            <i class="ki-outline ki-magnifier fs-3 position-absolute ms-5"></i>
                            <input type="text" data-kt-user-table-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="Search user" />
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--begin::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                            <!--begin::Filter-->
                            <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <i class="ki-outline ki-filter fs-2"></i>Filter</button>
                            <!--begin::Menu 1-->
                            <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true">
                                <!--begin::Header-->
                                <div class="px-7 py-5">
                                    <div class="fs-5 text-dark fw-bold">Filter Options</div>
                                </div>
                                <!--end::Header-->
                                <!--begin::Separator-->
                                <div class="separator border-gray-200"></div>
                                <!--end::Separator-->
                                <!--begin::Content-->
                                <div class="px-7 py-5" data-kt-user-table-filter="form">
                                    <!--begin::Input group-->
                                    <div class="mb-10">
                                        <label class="form-label fs-6 fw-semibold">Role:</label>
                                        <select class="form-select form-select-solid fw-bold" data-kt-select2="true" data-placeholder="Select option" data-allow-clear="true" data-kt-user-table-filter="role" data-hide-search="true">
                                            <option></option>
                                            <option value="Administrator">Administrator</option>
                                            <option value="Analyst">Analyst</option>
                                            <option value="Developer">Developer</option>
                                            <option value="Support">Support</option>
                                            <option value="Trial">Trial</option>
                                        </select>
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="mb-10">
                                        <label class="form-label fs-6 fw-semibold">Two Step Verification:</label>
                                        <select class="form-select form-select-solid fw-bold" data-kt-select2="true" data-placeholder="Select option" data-allow-clear="true" data-kt-user-table-filter="two-step" data-hide-search="true">
                                            <option></option>
                                            <option value="Enabled">Enabled</option>
                                        </select>
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Actions-->
                                    <div class="d-flex justify-content-end">
                                        <button type="reset" class="btn btn-light btn-active-light-primary fw-semibold me-2 px-6" data-kt-menu-dismiss="true" data-kt-user-table-filter="reset">Reset</button>
                                        <button type="submit" class="btn btn-primary fw-semibold px-6" data-kt-menu-dismiss="true" data-kt-user-table-filter="filter">Apply</button>
                                    </div>
                                    <!--end::Actions-->
                                </div>
                                <!--end::Content-->
                            </div>
                            <!--end::Menu 1-->
                            <!--end::Filter-->
                            <!--begin::Export-->
                            <div class="" style="margin-right: 8px;">
                                <select class="form-select form-select-dark fw-bold" onchange="filterUserType(this)">
                                    <option value="" selected>Filter User Type</option>
                                    <option value="0" {{@$_GET['is_staff'] == '0' ? 'selected' : ''}}>General</option>
                                    <option value="1" {{@$_GET['is_staff'] == '1' ? 'selected' : ''}}>Staff</option>
                                </select>
                            </div>
                            <!--end::Export-->
                            <!--begin::Add user-->
                            <a href="{{ route('admin.user.add') }}">
                            <button type="button" class="btn btn-primary">
                                <i class="ki-outline ki-plus fs-2"></i>Add Staff</button>
                            </a>
                            <!--end::Add user-->
                        </div>
                        <!--end::Toolbar-->
                        <!--begin::Group actions-->
                        <div class="d-flex justify-content-end align-items-center d-none" data-kt-user-table-toolbar="selected">
                            <div class="fw-bold me-5">
                                <span class="me-2" data-kt-user-table-select="selected_count"></span>Selected</div>
                            <button type="button" class="btn btn-danger" data-kt-user-table-select="delete_selected">Delete Selected</button>
                        </div>
                        <!--end::Group actions-->
                        <!--begin::Modal - Adjust Balance-->
                        <div class="modal fade" id="kt_modal_export_users" tabindex="-1" aria-hidden="true">
                            <!--begin::Modal dialog-->
                            <div class="modal-dialog modal-dialog-centered mw-650px">
                                <!--begin::Modal content-->
                                <div class="modal-content">
                                    <!--begin::Modal header-->
                                    <div class="modal-header">
                                        <!--begin::Modal title-->
                                        <h2 class="fw-bold">Export Users</h2>
                                        <!--end::Modal title-->
                                        <!--begin::Close-->
                                        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
                                            <i class="ki-outline ki-cross fs-1"></i>
                                        </div>
                                        <!--end::Close-->
                                    </div>
                                    <!--end::Modal header-->
                                    <!--begin::Modal body-->
                                    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                                        <!--begin::Form-->
                                        <form id="kt_modal_export_users_form" class="form" action="#">
                                            <!--begin::Input group-->
                                            <div class="fv-row mb-10">
                                                <!--begin::Label-->
                                                <label class="fs-6 fw-semibold form-label mb-2">Select Roles:</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <select name="role" data-control="select2" data-placeholder="Select a role" data-hide-search="true" class="form-select form-select-solid fw-bold">
                                                    <option></option>
                                                    <option value="Administrator">Administrator</option>
                                                    <option value="Analyst">Analyst</option>
                                                    <option value="Developer">Developer</option>
                                                    <option value="Support">Support</option>
                                                    <option value="Trial">Trial</option>
                                                </select>
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div class="fv-row mb-10">
                                                <!--begin::Label-->
                                                <label class="required fs-6 fw-semibold form-label mb-2">Select Export Format:</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <select name="format" data-control="select2" data-placeholder="Select a format" data-hide-search="true" class="form-select form-select-solid fw-bold">
                                                    <option></option>
                                                    <option value="excel">Excel</option>
                                                    <option value="pdf">PDF</option>
                                                    <option value="cvs">CVS</option>
                                                    <option value="zip">ZIP</option>
                                                </select>
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Actions-->
                                            <div class="text-center">
                                                <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">Discard</button>
                                                <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                                                    <span class="indicator-label">Submit</span>
                                                    <span class="indicator-progress">Please wait...
																			<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                </button>
                                            </div>
                                            <!--end::Actions-->
                                        </form>
                                        <!--end::Form-->
                                    </div>
                                    <!--end::Modal body-->
                                </div>
                                <!--end::Modal content-->
                            </div>
                            <!--end::Modal dialog-->
                        </div>
                        <!--end::Modal - New Card-->
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body py-4">
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
                        <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th class="min-w-50px">SL</th>
                            <th class="min-w-125px">User</th>
                            <th class="min-w-125px">Is Staff</th>
                            <th class="min-w-125px">Active Status</th>
                            <th class="min-w-125px">Created Time</th>
                            <th class="text-center min-w-100px">Actions</th>
                        </tr>
                        </thead>
                        @foreach($users as $key=>$user)
                        <tbody class="text-gray-600 fw-semibold">
                        <tr>
                            <td>{{$key+=1}}</td>
                            <td class="d-flex align-items-center">
                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                    <a href="{{ route('admin.user.details', $user->id) }}">
                                        <div class="symbol-label">
                                            <img src="{{ asset('/') }}assets/media/avatars/blank.png" alt="" class="w-50px" />
                                        </div>
                                    </a>
                                </div>
                                <div class="d-flex flex-column">
                                    <a href="{{ route('admin.user.details', $user->id) }}" class="text-gray-800 text-hover-primary mb-1">{{$user->name ?? 'N/A'}}</a>
                                    <span>{{$user->email ?? 'N/A'}}</span>
                                    <span>{{$user->phone ?? 'N/A'}}</span>
                                </div>
                            </td>
                            <td>
                                @if($user->is_staff == '0')
                                    <span class="badge badge-light-info">NO</span>
                                @elseif($user->is_staff == '1')
                                    <span class="badge badge-light-success">YES</span>
                                @endif
                            </td>
                            <td>
                                <div class="form-check form-switch form-check-custom form-check-solid me-10">
                                    <input class="form-check-input h-20px w-30px" type="checkbox" value="" id="flexSwitch20x30 welcome_status_{{$user->id}}" {{$user ? ($user->status == 1 ? 'checked':''):''}} onclick="location.href='{{route('admin.user.status',$user->id)}}'">
                                </div>
                            </td>
                            <td>{{ $user->created_at->format('Y-m-d') }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.user.details', $user->id) }}" class="menu-link" title="View">
                                    <button class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_update_permission">
                                        <i class="ki-outline ki-eye fs-3"></i>
                                    </button>
                                </a>
                                @if(isset($user->is_staff) && $user->is_staff == 1)
                                    <a href="{{route('admin.user.edit', $user->id)}}" class="menu-link" title="Edit">
                                        <button class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_update_permission">
                                            <i class="ki-outline ki-user-edit fs-3"></i>
                                        </button>
                                    </a>
                                @endif

                                    <a href="#" data-i="{{ $user->id }}" class="menu-link delete"  title="Delete">
                                        <button class="btn btn-icon btn-active-light-primary w-30px h-30px" data-kt-permissions-table-filter="delete_row">
                                            <i class="ki-outline ki-trash fs-3"></i>
                                        </button>
                                    </a>
                            </td>
                        </tr>
                        </tbody>
                        @endforeach
                    </table>
                </div>
                <div class="d-flex justify-content-center">
                    {!! $users->links() !!}
                </div>
            </div>
            <!--end::Card-->
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
        <!--end::Content container-->
    </div>
@endsection

<script>
    function filterUserType(select) {
        const value = select.value;
        const url = new URL(window.location.href);

        if (value === "") {
            url.searchParams.delete('is_staff');
        } else {
            url.searchParams.set('is_staff', value);
        }

        window.location.href = url.toString();
    }
</script>
