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
                        Meter</h1>
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
                        <li class="breadcrumb-item text-muted">Meter Management</li>
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
                    <a href="{{route('admin.meter.list')}}" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"><i
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
                        <h3 class="fw-bold m-0">Meter Details</h3>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--begin::Card header-->
                <!--begin::Content-->
                <div id="kt_account_settings_profile_details" class="collapse show">
                    <!--begin::Form-->
                    <form method="POST" action="{{ route('admin.meter.store') }}" class="form"
                          enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        <input type="hidden" name="id" value="{{@$meter->id}}">
                        <!--begin::Card body-->
                        <div class="card-body border-top p-9">

                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6"><span class="required">Meter Type</span>
                                    <span class="ms-1" data-bs-toggle="tooltip" title="Pre Paid / Post Paid">
                                        <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                    </span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <!--begin::Row-->
                                    <div class="row">
                                        <!--begin::Col-->
                                        <div class="col-lg-12 fv-row">
                                            <select name="meter_type" id="meter_type"
                                                    aria-label="Select a type"
                                                    data-placeholder="Select Type"
                                                    class="form-select form-select-solid form-select-lg fw-semibold" required>
                                                <option value="">Select Type</option>
                                                <option value="1" {{@$meter->meter_type == '1' ? 'selected' : '' }}>Pre paid</option>
                                                <option value="2" {{@$meter->meter_type == '2' ? 'selected' : '' }}>Post paid</option>
                                            </select>
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Row-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                    <span class="required">Number</span>
                                    <span class="ms-1" data-bs-toggle="tooltip" title="Number must be active">
                                        <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                    </span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <div class="col-lg-8 fv-row">
                                    <input type="text" name="number" class="form-control form-control-solid mb-3 mb-lg-0"
                                           placeholder="Enter Meter Number" value="{{@$meter->number}}" required/>
                                    @if($errors->has('number'))
                                        <div class="error text-danger">{{ $errors->first('number') }}</div>
                                    @endif
                                </div>
                                <!--end::Input-->
                            </div>

                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                    <span class="required">SND</span>
                                    <span class="ms-1" data-bs-toggle="tooltip" title="SND must be active">
                                    <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                </span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <div class="col-lg-8 fv-row">
                                    <input type="text" name="snd" class="form-control form-control-solid mb-3 mb-lg-0"
                                           placeholder="Enter SND" value="{{@$meter->snd}}" required/>
                                    @if($errors->has('snd'))
                                        <div class="error text-danger">{{ $errors->first('snd') }}</div>
                                    @endif
                                </div>
                                <!--end::Input-->
                            </div>

                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                    <span class="required">Customer Name</span>
                                    <span class="ms-1" data-bs-toggle="tooltip" title="Name must be active">
                                    <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                </span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <div class="col-lg-8 fv-row">
                                    <input type="text" name="customer_name" class="form-control form-control-solid mb-3 mb-lg-0"
                                           placeholder="Enter Customer Name" value="{{@$meter->customer_name}}" required/>
                                    @if($errors->has('customer_name'))
                                        <div class="error text-danger">{{ $errors->first('customer_name') }}</div>
                                    @endif
                                </div>
                                <!--end::Input-->
                            </div>
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                    <span class="required">Building</span>
                                    <span class="ms-1" data-bs-toggle="tooltip" title="Building must be active">
                                    <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                </span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <!--begin::Row-->
                                    <div class="row">
                                        <!--begin::Col-->
                                        <div class="col-lg-12 fv-row">
                                            <input type="text" name="building"
                                                   class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                   placeholder="Enter Building Name" value="{{@$meter->building}}" required/>
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    @if($errors->has('building'))
                                        <div class="error text-danger">{{ $errors->first('building') }}</div>
                                    @endif
                                    <!--end::Row-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                    <span class="required">Flat No</span>
                                    <span class="ms-1" data-bs-toggle="tooltip" title="Floor No must be active">
                                    <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                </span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <div class="col-lg-8 fv-row">
                                    <input type="text" name="flat_no" class="form-control form-control-solid mb-3 mb-lg-0"
                                           placeholder="Enter Floor No" value="{{@$meter->flat_no}}" autocomplete="off" required/>
                                    @if($errors->has('flat_no'))
                                        <div class="error text-danger">{{ $errors->first('flat_no') }}</div>
                                    @endif
                                </div>
                                <!--end::Input-->
                            </div>
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                    <span>Address</span>
                                    <span class="ms-1" data-bs-toggle="tooltip">
                                </span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <div class="col-lg-8 fv-row">
                                    <input type="text" name="address"
                                           class="form-control form-control-solid mb-3 mb-lg-0"
                                           placeholder="Enter Address" value="{{@$meter->address}}" autocomplete="address"/>
                                    @if($errors->has('address'))
                                        <div class="error text-danger">{{ $errors->first('address') }}</div>
                                    @endif
                                </div>
                                <!--end::Input-->
                            </div>
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                    <span class="required">Last Reading</span>
                                    <span class="ms-1" data-bs-toggle="tooltip" title="Last Reading must be active">
                                    <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                </span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <div class="col-lg-8 fv-row">
                                    <input type="text" name="last_reading" class="form-control form-control-solid mb-3 mb-lg-0"
                                           placeholder="Enter Last Reading" value="{{@$meter->last_reading}}" autocomplete="off" required/>
                                    @if($errors->has('last_reading'))
                                        <div class="error text-danger">{{ $errors->first('last_reading') }}</div>
                                    @endif
                                </div>
                                <!--end::Input-->
                            </div>
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                    <span class="required">Installation Date</span>
                                    <span class="ms-1" data-bs-toggle="tooltip">
                                    <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                </span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <div class="col-lg-8 fv-row">
                                    <input type="date" name="installation_date" class="form-control form-control-solid mb-3 mb-lg-0"
                                           placeholder="Enter Installation Date" value="{{@$meter->installation_date}}" autocomplete="off" required/>
                                    @if($errors->has('installation_date'))
                                        <div class="error text-danger">{{ $errors->first('installation_date') }}</div>
                                    @endif
                                </div>
                                <!--end::Input-->
                            </div>
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                    <span>Last Reading Date</span>
                                    <span class="ms-1" data-bs-toggle="tooltip">
                                    <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                </span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <div class="col-lg-8 fv-row">
                                    <input type="date" name="last_reading_date" class="form-control form-control-solid mb-3 mb-lg-0"
                                           placeholder="Enter Last Reading Date" value="{{@$meter->last_reading_date}}" autocomplete="off"/>
                                    @if($errors->has('last_reading_date'))
                                        <div class="error text-danger">{{ $errors->first('last_reading_date') }}</div>
                                    @endif
                                </div>
                                <!--end::Input-->
                            </div>
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6"><span class="required">Assign Reader</span></label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8">
                                    <!--begin::Row-->
                                    <div class="row">
                                        <!--begin::Col-->
                                        <div class="col-lg-12 fv-row">
                                            <select name="reader_id[]" id="reader_id"
                                                    aria-label="Select a Reader" data-control="select2"
                                                    data-placeholder="Select Reader"
                                                    class="form-select form-select-solid form-select-lg fw-semibold" multiple>
                                                <option value="">Select Reader</option>
                                                @foreach($stuffs as $stuff)
                                                    <option value="{{$stuff->id}}" {{ isset($meter_readers) && is_array($meter_readers) && in_array($stuff->id, $meter_readers) ? 'selected' : '' }}>{{$stuff->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Row-->
                                </div>
                                <!--end::Col-->
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
