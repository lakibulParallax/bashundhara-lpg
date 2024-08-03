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
                    <h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bold fs-3 m-0">Role List</h1>
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
                        <li class="breadcrumb-item text-muted">Role Management</li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Roles</li>
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
                            <input type="text" data-kt-user-table-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="Search" />
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--begin::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                            <!--begin::Add user-->
                            <a href="{{ route('admin.role.add') }}">
                                <button type="button" class="btn btn-primary">
                                    <i class="ki-outline ki-plus fs-2"></i>New Role</button>
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
                    </div>
                    <!--end::Modal - Add task-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body py-4">
                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
                    <thead>
                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                        <th class="min-w-50px">SL</th>
                        <th class="min-w-50px">Name</th>
                        <th class="min-w-50px">Role Type</th>
                        <th class="min-w-50px">Status</th>
                        <th class="min-w-50px">Created By</th>
                        <th class="text-end">Actions</th>
                    </tr>
                    </thead>
                    @if(!empty($roles))
                        @foreach($roles as $key=>$role)
                            <tbody class="text-gray-600 fw-semibold">
                            <tr>
                                <td>{{$key+=1}}</td>
                                <td>{{$role->name}}</td>
                                <td>
                                    @if($role->role_type == '1')
                                        Admin
                                    @endif
                                </td>
                                <td>
                                    @if($role->status == '1')
                                        <span class="badge badge-light-success">Active</span>
                                    @else
                                        <span class="badge badge-light-danger">In Active</span>
                                    @endif
                                </td>
                                <td>Super Admin</td>
                                <td class="text-end">
                                    <a href="{{route('admin.role.edit', $role->id)}}" class="menu-link" title="Edit">
                                        <button class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_update_permission">
                                            <i class="ki-outline ki-user-edit fs-3"></i>
                                        </button>
                                    </a>
{{--                                    <a href="#" data-i="{{ $role->id }}" class="menu-link delete"  title="Delete">--}}
{{--                                        <button class="btn btn-icon btn-active-light-primary w-30px h-30px" data-kt-permissions-table-filter="delete_row">--}}
{{--                                            <i class="ki-outline ki-trash fs-3"></i>--}}
{{--                                        </button>--}}
{{--                                    </a>--}}
                                </td>
                            </tr>
                            </tbody>
                        @endforeach
                    @endif
                </table>
                <!--end::Table-->
            </div>
            <!--end::Card body-->
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
                    <form method="GET" action="{{ route('admin.role.delete') }}" id="frmDel">
                        <div class="modal-body">
                            <p>Are you sure you want to delete this Role?</p>
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

@endsection
