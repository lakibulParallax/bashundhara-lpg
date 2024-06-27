@extends('admin.layouts.app')

@section('content')

    <div id="kt_app_toolbar" class="app-toolbar pt-6 pb-2">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex align-items-stretch">
            <!--begin::Toolbar wrapper-->
            <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bold fs-3 m-0">Add
                        User</h1>
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
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">User Management</li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Add</li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <a href="{{route('admin.user.list')}}" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"><i
                            class="fa fa-backward"></i>Back to the List</a>
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

        <div id="kt_app_content_container" class="app-container container-fluid">
            <!--begin::Navbar-->

            <!--end::Navbar-->
            <!--begin::Basic info-->
            <div class="card mb-5 mb-xl-10">
                <!--begin::Card header-->
                <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
                     data-bs-target="#kt_account_profile_details" aria-expanded="true"
                     aria-controls="kt_account_profile_details">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">User Profile Details</h3>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--begin::Card header-->
                <!--begin::Content-->
                <div id="kt_account_settings_profile_details" class="collapse show">
                    <!--begin::Form-->
                    <form method="POST" action="{{ route('admin.store') }}" class="form"
                          enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        <input type="hidden" name="is_staff" value="1">
                        <input type="hidden" name="id" value="{{@$user->id}}">
                        <!--begin::Card body-->
                        <div class="card-body border-top p-9">

                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                    <span class="required">Name</span>
                                    <span class="ms-1" data-bs-toggle="tooltip" title="Name must be active">
                                    <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                </span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <div class="col-lg-8 fv-row">
                                    <input type="text" name="name" class="form-control form-control-solid mb-3 mb-lg-0"
                                           placeholder="Enter Name" value="{{@$user->name}}" autocomplete="off" required/>
                                    @if($errors->has('name'))
                                        <div class="error text-danger">{{ $errors->first('name') }}</div>
                                    @endif
                                </div>
                                <!--end::Input-->
                            </div>

                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                    <span class="required">User Name</span>
                                    <span class="ms-1" data-bs-toggle="tooltip" title="Name must be active">
                                    <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                </span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <div class="col-lg-8 fv-row">
                                    <input type="text" name="user_name" class="form-control form-control-solid mb-3 mb-lg-0"
                                           placeholder="Enter user name" value="{{@$user->user_name}}" autocomplete="off" required/>
                                    @if($errors->has('user_name'))
                                        <div class="error text-danger">{{ $errors->first('user_name') }}</div>
                                    @endif
                                </div>
                                <!--end::Input-->
                            </div>

                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                    <span class="required">Email</span>
                                    <span class="ms-1" data-bs-toggle="tooltip" title="Email">
                                    <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                </span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <div class="col-lg-8 fv-row">
                                    <input type="email" name="email" class="form-control form-control-solid mb-3 mb-lg-0"
                                           placeholder="Enter Email" value="{{@$user->email}}" autocomplete="email" required/>
                                    @if($errors->has('email'))
                                        <div class="error text-danger">{{ $errors->first('email') }}</div>
                                    @endif
                                </div>
                                <!--end::Input-->
                            </div>

                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                    <span class="required">Password</span>
                                    <span class="ms-1" data-bs-toggle="tooltip" title="Enter Password">
                                    <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                </span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <div class="col-lg-8 fv-row">
                                    <input type="password" name="password"
                                           class="form-control form-control-solid mb-3 mb-lg-0"
                                           placeholder="Type Password" value="" autocomplete="new_password" @if(empty($user->id)) required @endif/>
                                    <span class="alert-danger">At least 6 characters</span>
                                    @if($errors->has('password'))
                                        <div class="error text-danger">{{ $errors->first('password') }}</div>
                                    @endif
                                </div>
                                <!--end::Input-->
                            </div>

                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                    <span class="required">Phone</span>
                                    <span class="ms-1" data-bs-toggle="tooltip" title="Plot must be active">
                                    <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                </span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <div class="col-lg-8 fv-row">
                                    <input type="text" name="phone" class="form-control form-control-solid mb-3 mb-lg-0"
                                           placeholder="Enter Phone" value="{{@$user->phone}}" autocomplete="off" required/>
                                    @if($errors->has('phone'))
                                        <div class="error text-danger">{{ $errors->first('phone') }}</div>
                                    @endif
                                </div>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Card body-->
                        <!--begin::Actions-->
                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <button type="reset" class="btn btn-light btn-active-light-primary me-2">Discard</button>
                            <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Save
                                Changes
                            </button>
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Basic info-->
            <!--begin::Sign-in Method-->

            <!--end::Deactivate Account-->
        </div>
    </div>
@endsection
