@extends('admin.layouts.app')

@section('content')
<!--begin::Post-->
<div class="post d-flex flex-column-fluid" id="kt_post">
    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">
        <!--begin::Contact-->
        <div class="card">
            <!--begin::Body-->
            <div class="card-body p-lg-17">
                <!--begin::Row-->
                <div class="row mb-3">
                    <!--begin::Col-->
                    <div class="col-md-12 pe-lg-10">
                        <!--begin::Form-->
                        <form action="{{route('role-management.update', $role->id)}}" class="form mb-15" name="role-management-form" method="POST" id="kt_contact_form">
                            {{csrf_field()}}
                            {{method_field('PUT')}}
                            <h1 class="fw-bolder text-dark mb-9">Update Role</h1>
                            <!--begin::Input group-->
                            <input type="hidden" name="id" value="{{$role->id}}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="d-flex flex-column mb-5 fv-row">
                                        <!--begin::Label-->
                                        <label class="required fs-5 fw-bold mb-2">Name</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-solid" placeholder="Enter Name" value="{{$role->name}}" name="name" autocomplete="off"/>
                                        @if($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif

                                        <!--end::Input-->
                                    </div>
                                </div>
								<!-- <div class="d-flex flex-column mb-5 fv-row col-md-6">
                                    <label class="required fs-6 fw-bold mb-2">Role Type</label>
                                    <select id="role_type" class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Select a Role Type" name="role_type">
                                        <option selected disabled>Select Role Type</option>
                                        <option value="1" {{$role->role_type == 1 ? 'selected' : ''}}>Admin</option>
                                        <option value="2" {{$role->role_type == 2 ? 'selected' : ''}}>institute</option>
                                        <option value="3" {{$role->role_type == 3 ? 'selected' : ''}}>Student</option>
                                    </select>
                                    @if($errors->has('role_type'))
                                        <span class="text-danger">{{ $errors->first('role_type') }}</span>
                                    @endif
                                </div> -->
                                <div class="col-md-12">
                                    <div class="d-flex flex-column mb-5 fv-row">
                                        <!--begin::Label-->
                                        <label class="fs-5 fw-bold mb-2">Permissions</label>
                                        <div class="row" style="margin-top: 10px;margin-bottom: 15px;">
                                            <div class="col-md-12 form-check form-check-custom form-check-solid me-10">
                                                <span class="form-check-label fw-bold" style="margin-right: 10px;">Check All</span>
                                                <input id="selectAll" class="form-check-input h-20px w-20px permission" type="checkbox" name="checkAll" value="1" />
                                            </div>
                                        </div>
                                        @foreach($permissions as $permission)
                                        <div class="row">
                                            <div class="col-md-2">
                                                <span class="form-check-label" style="text-transform: capitalize;">{{$permission['group_name']}}</span>
                                            </div>
                                            <div class="col-md-10 d-flex">
                                                @foreach($permission['permissions'] as $single_permission)
                                                    <span>
                                                        <label class="form-check form-check-custom form-check-solid me-10">
                                                            <input class="permission form-check-input h-20px w-20px" type="checkbox" name="permissions[]" value="{{$single_permission['id']}}"
                                                            @foreach($role->permissions as $role_permit)
                                                                @if($role_permit->permission_id == $single_permission['id'])
                                                                    checked
                                                                @endif
                                                            @endforeach
                                                            />
                                                            @if($single_permission['permission_type'] == 1)
                                                                <span class="form-check-label fw-bold">View</span>
                                                            @elseif($single_permission['permission_type'] == 2)
                                                                <span class="form-check-label fw-bold">Create</span>
                                                            @elseif($single_permission['permission_type'] == 3)
                                                                <span class="form-check-label fw-bold">Update</span>
                                                            @else
                                                                <span class="form-check-label fw-bold">Delete</span>
                                                            @endif
                                                        </label>
                                                        <br>
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                        @endforeach

                                        @if($errors->has('permissions'))
                                            <span class="text-danger">{{ $errors->first('permissions') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex mb-5 fv-row">
                                <label class="form-check form-switch form-check-custom form-check-solid">
                                    <span class="required form-check-label fw-bold text-muted" style="margin-right: 10px;margin-left: 0px;">Status</span>
                                    <input class="form-check-input radio-btn" name="status" type="checkbox" value="1" {{$role->status == 0 ? '' : 'checked'}} />
                                </label>
                                <!--end::Switch-->
                            </div>
                            <div class="d-flex">
                                <a style="margin-right:5px;" href="{{route('role-management.index')}}" class="btn btn-secondary">Back</a>
                                <button type="submit" class="btn btn-primary" id="kt_contact_submit_button">
                                    <!--begin::Indicator-->
                                    <span class="indicator-label">Update</span>
                                </button>
                            </div>
                            <!--end::Submit-->
                        </form>
                        <!--end::Form-->
                    </div>
                </div>
            </div>
            <!--end::Body-->
        </div>
        <!--end::Contact-->
    </div>
    <!--end::Container-->
</div>
<!--end::Post-->
@endsection
