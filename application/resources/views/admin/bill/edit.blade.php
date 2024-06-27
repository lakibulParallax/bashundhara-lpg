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
                <h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bold fs-3 m-0">Edit Meter</h1>
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
                    <li class="breadcrumb-item text-muted">Edit</li>
                    <!--end::Item-->
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <a href="{{route('admin.user.list')}}" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"><i class="fa fa-backward"></i>Back to the List</a>
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
            <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
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
                <form method="POST" action="{{ route('admin.user.store') }}" class="form" enctype="multipart/form-data">
                    @csrf
                    <!--begin::Card body-->
                    <div class="card-body border-top p-9">
                        <!--begin::Input group-->
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">Image</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <!--begin::Image input-->
                                <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('{{ isset($user->fileManager[0]) ? $user->fileManager[0]->url : asset('assets/media/svg/avatars/blank.svg') }}')">
                                    <!--begin::Preview existing avatar-->
                                    <div class="image-input-wrapper w-125px h-125px" style="background-image: url({{ asset('assets/media/svg/avatars/blank.svg') }})">

                                            <img src="{{ $user->getFirstMediaUrl('avatar') }}" alt="pic" class="w-100 h-100" />

                                    </div>
                                    <!--end::Preview existing avatar-->
                                    <!--begin::Label-->
                                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                                        <i class="ki-outline ki-pencil fs-7"></i>
                                        <!--begin::Inputs-->
                                        <input type="file" name="image" id="imageInput" />
                                        <input type="hidden" name="avatar_remove" />
                                        <!--end::Inputs-->
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Cancel-->
                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar" id="cancelButton">
                                        <i class="ki-outline ki-cross fs-2"></i>
                                    </span>
                                    <!--end::Cancel-->
                                    <!--begin::Remove-->
                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                                        <i class="ki-outline ki-cross fs-2"></i>
                                    </span>
                                    <!--end::Remove-->
                                </div>
                                <!--end::Image input-->
                                <!--begin::Hint-->
                                <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                                <!--end::Hint-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
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
                                <input type="text" name="name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter Name" value="{{ @$user->name }}" required/>
                                @if($errors->has('name'))
                                    <div class="error text-danger">{{ $errors->first('name') }}</div>
                                @endif
                                <input type="hidden" name="id" value="{{ $user->id }}" />
                            </div>
                            <!--end::Input-->
                        </div>
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                <span class="required">Contact Information</span>
                                <span class="ms-1" data-bs-toggle="tooltip" title="Phone Number must be active">
                                    <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                </span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <!--begin::Row-->
                                <div class="row">
                                    <!--begin::Col-->
                                    <div class="col-lg-4 fv-row">
                                        <input type="text" name="phone_code" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="Phone Code" value="{{ @$user->phone_code }}" required/>
                                    </div>
                                    <!--end::Col-->
                                    <!--begin::Col-->
                                    <div class="col-lg-8 fv-row">
                                        <input type="text" name="phone_number" class="form-control form-control-lg form-control-solid" placeholder="Phone Number" value="{{ @$user->phone_number }}" required/>
                                    </div>
                                    <!--end::Col-->
                                </div>
                                @if($errors->has('phone_number'))
                                    <div class="error text-danger">{{ $errors->first('phone_number') }}</div>
                                @endif
                                <!--end::Row-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                <span class="required">Email</span>
                                <span class="ms-1" data-bs-toggle="tooltip" title="Email must be active">
                                    <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                </span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="col-lg-8 fv-row">
                                <input type="text" name="email" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter Email" value="{{ @$user->email }}" / required>
                                @if($errors->has('email'))
                                    <div class="error text-danger">{{ $errors->first('email') }}</div>
                                @endif
                            </div>
                            <!--end::Input-->
                        </div>
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">Parent's Information</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8">
                                <!--begin::Row-->
                                <div class="row">
                                    <!--begin::Col-->
                                    <div class="col-lg-6 fv-row">
                                        <input type="text" name="father_name" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="Father Name" value="{{ @$user->father_name }}" />
                                    </div>
                                    <!--end::Col-->
                                    <!--begin::Col-->
                                    <div class="col-lg-6 fv-row">
                                        <input type="text" name="mother_name" class="form-control form-control-lg form-control-solid" placeholder="Mother Name" value="{{ @$user->mother_name }}" />
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Row-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                <span>Date of Birth</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="col-lg-8 fv-row">
                                {{-- <input type="text" name="date_of_birth" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter Birth Date" value="{{ @$user->date_of_birth }}" /> --}}
                                <input class="form-control form-control-solid" name="date_of_birth" placeholder="Enter Birth Date" id="kt_daterangepicker_3" value="{{ @$user->date_of_birth }}"/>
                            </div>
                            <!--end::Input-->
                        </div>
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                <span>Age</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="col-lg-8 fv-row">
                                <input type="text" name="age" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter Age" value="{{ @$user->age }}" />
                            </div>
                            <!--end::Input-->
                        </div>
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                <span class="required">NID</span>
                                <span class="ms-1" data-bs-toggle="tooltip" title="NID must be active">
                                    <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                </span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="col-lg-8 fv-row">
                                <input type="number" name="nid" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter NID Number" value="{{ @$user->nid }}" required/>
                                @if($errors->has('nid'))
                                    <div class="error text-danger">{{ $errors->first('nid') }}</div>
                                @endif
                            </div>
                            <!--end::Input-->
                        </div>
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                <span>Passport</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="col-lg-8 fv-row">
                                <input type="number" name="passport" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter Passport Number" value="{{ @$user->passport }}" />
                            </div>
                            <!--end::Input-->
                        </div>
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                <span>Marital Status</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="col-lg-8 fv-row">
                                <input type="text" name="marital_status" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Marital Status" value="{{ @$user->marital_status }}" />
                            </div>
                            <!--end::Input-->
                        </div>
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                <span>Religion</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="col-lg-8 fv-row">
                                <input type="text" name="religion" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Religion" value="{{ @$user->religion }}" />
                            </div>
                            <!--end::Input-->
                        </div>
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                <span class="required">Permanent Village</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="col-lg-8 fv-row">
                                <input type="text" name="permanent_village" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Permanent Village" value="{{ @$user->permanent_village }}" />
                            </div>
                            <!--end::Input-->
                        </div>
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                <span class="required">Permanent District</span>
                                <span class="ms-1" data-bs-toggle="tooltip" title="Country of origination">
            <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
        </span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <select name="permanent_district" id="permanent_district" aria-label="Select a District" data-control="select2" data-placeholder="Select a District..." class="form-select form-select-solid form-select-lg fw-semibold">
                                    <option value="">Select a District...</option>
                                    @foreach($districts as $district)
                                        <option value="{{$district->id}}" @if(($user->permanent_district == $district->id)) selected @endif>{{@$district->name}} ({{@$district->bn_name}})</option>
                                    @endforeach
                                </select>
                            </div>
                            <!--end::Col-->
                        </div>

                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                <span class="required">Permanent Thana</span>
                                <span class="ms-1" data-bs-toggle="tooltip" title="Country of origination">
            <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
        </span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <select name="permanent_thana" id="permanent_thana" aria-label="Select a Thana" data-control="select2" data-placeholder="Select a Thana..." class="form-select form-select-solid form-select-lg fw-semibold">
                                    <option value="">Select a Thana...</option>
                                    <!-- Thana options will be populated dynamically using JavaScript -->
                                </select>
                            </div>
                            <!--end::Col-->
                        </div>

                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                <span class="required">Permanent Union</span>
                                <span class="ms-1" data-bs-toggle="tooltip" title="Country of origination">
            <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
        </span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <select name="permanent_union" id="permanent_union" aria-label="Select a Union" data-control="select2" data-placeholder="Select a Union..." class="form-select form-select-solid form-select-lg fw-semibold">
                                    <option value="">Select a Union...</option>
                                    <!-- Union options will be populated dynamically using JavaScript -->
                                </select>
                            </div>
                            <!--end::Col-->
                        </div>

                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                <span>Address of Work Place</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="col-lg-8 fv-row">
                                <input type="text" name="address_of_work_place" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter Address" value="{{ @$user->address_of_work_place }}" />
                            </div>
                            <!--end::Input-->
                        </div>
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                <span>Educational Qualification</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="col-lg-8 fv-row">
                                <input type="text" name="educational_qualification" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Educational Qualification" value="{{ @$user->educational_qualification }}" />
                            </div>
                            <!--end::Input-->
                        </div>


                        <label class="col-lg-4 col-form-label fw-semibold fs-6">
                            <h5><u>Emergency Contact Information</u></h5>
                        </label>
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                <span>Name</span>
                                <span class="ms-1" data-bs-toggle="tooltip" title="Emergency Contact Details">
                                    <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                </span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="col-lg-8 fv-row">
                                <input type="text" name="ice_name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter Name" value="{{ @$user->emergencyContact->name }}" />
                            </div>
                            <!--end::Input-->
                        </div>
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                <span>Relation</span>
                                <span class="ms-1" data-bs-toggle="tooltip" title="Emergency Contact Details">
                                    <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                </span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="col-lg-8 fv-row">
                                <input type="text" name="ice_relation" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter Relation" value="{{ @$user->emergencyContact->relation }}" />
                            </div>
                            <!--end::Input-->
                        </div>
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                <span>Address</span>
                                <span class="ms-1" data-bs-toggle="tooltip" title="Emergency Contact Details">
                                    <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                </span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="col-lg-8 fv-row">
                                <input type="text" name="ice_address" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter Address" value="{{ @$user->emergencyContact->address }}" />
                            </div>
                            <!--end::Input-->
                        </div>
                        <div class="row mb-6">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                <span>Contact Phone</span>
                                <span class="ms-1" data-bs-toggle="tooltip" title="Emergency Contact Details">
                                    <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                </span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div class="col-lg-8 fv-row">
                                <input type="text" name="ice_phone_number" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter Phone Number" value="{{ @$user->emergencyContact->phone_number }}" />
                            </div>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--end::Card body-->
                    <!--begin::Actions-->
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <button type="reset" class="btn btn-light btn-active-light-primary me-2">Discard</button>
                        <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Save Changes</button>
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
