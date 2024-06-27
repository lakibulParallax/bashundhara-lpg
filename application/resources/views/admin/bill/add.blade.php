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
                        Bill</h1>
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
                        <li class="breadcrumb-item text-muted">Bill Management</li>
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
                    <a href="{{route('admin.bill.list')}}" class="btn btn-flex btn-primary h-40px fs-7 fw-bold"><i
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
                        <h3 class="fw-bold m-0">Bill Details</h3>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--begin::Card header-->
                <!--begin::Content-->
                <div id="kt_account_settings_profile_details" class="collapse show">
                    <!--begin::Form-->
                    <form method="POST" action="{{ route('admin.bill.store') }}" class="form"
                          enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        <input type="hidden" name="id" value="{{@$bill->id}}">
                        <!--begin::Card body-->
                        <div class="card-body border-top p-9">

                            <div class="row mb-6">

                                <div class="col-md-12">
                                    <label class="col-lg-4 col-form-label fw-semibold fs-6"><span class="required">Meter</span>
                                        <span class="ms-1" data-bs-toggle="tooltip" title="Must be Active">
                                            <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                        </span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <select name="meter_id" id="meter_id"
                                            aria-label="Select a meter"
                                            data-placeholder="Select Meter" data-control="select2"
                                            class="form-select form-select-solid form-select-lg fw-semibold" required>
                                        <option value="">Select Type</option>
                                        @if(!empty($meters))
                                            @foreach($meters as $meter)
                                                <option value="{{$meter->id}}" {{@$bill->meter_id == $meter->id ? 'selected' : '' }}>{{$meter->number}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <!--end::Col-->
                                </div>
                                <!--begin::Label-->

                                <!--end::Col-->

                                <!--begin::Label-->
                                <div class="col-md-6">
                                    <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                        <span class="required">Present Reading</span>
                                        <span class="ms-1" data-bs-toggle="tooltip" title="Must be active">
                                            <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                        </span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="number" name="present_reading" id="present_reading" class="form-control form-control-solid mb-3 mb-lg-0"
                                           placeholder="Enter Present Reading" value="{{@$bill->present_reading}}" step="0.01" required/>
                                    @if($errors->has('present_reading'))
                                        <div class="error text-danger">{{ $errors->first('present_reading') }}</div>
                                    @endif
                                </div>
                                <!--end::Input-->

                                <!--begin::Label-->
                                <div class="col-md-6">
                                    <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                        <span class="required">Previous Reading</span>
                                        <span class="ms-1" data-bs-toggle="tooltip" title="Must be active">
                                            <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                        </span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="number" name="previous_reading" id="previous_reading" class="form-control form-control-solid mb-3 mb-lg-0"
                                           placeholder="Enter Previous Reading" value="{{@$bill->previous_reading}}" step="0.01" required/>
                                    @if($errors->has('previous_reading'))
                                        <div class="error text-danger">{{ $errors->first('previous_reading') }}</div>
                                    @endif
                                </div>
                                <!--end::Input-->

                                <!--begin::Label-->
                                <div class="col-md-3">
                                    <label class="col-lg-12 col-form-label fw-semibold fs-6">
                                        <span>Consumption
                                            <span class="text-danger fs-7">(Auto Generate)</span>
                                        </span>
                                    </span>
                                    </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                    <input type="number" id="consumption" name="consumption" class="form-control form-control-solid mb-3 mb-lg-0"
                                           value="{{$bill->consumption ?? '0'}}" step="0.01" readonly/>
                                    @if($errors->has('consumption'))
                                        <div class="error text-danger">{{ $errors->first('consumption') }}</div>
                                    @endif
                                </div>
                                <!--end::Input-->

                                <!--begin::Label-->
                                <div class="col-md-3">
                                    <label class="col-lg-12 col-form-label fw-semibold fs-6">
                                        <span>Unit Price
                                            <span class="text-danger fs-7">(Bill Setting)</span>
                                        </span>
                                    </span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <!--begin::Row-->
                                    <input type="number" id="unit_price" name="unit_price"
                                           class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                           placeholder="Enter Unit Price" value="{{@$unit_price ?? 0}}" step="0.01" readonly/>

                                    @if($errors->has('unit_price'))
                                        <div class="error text-danger">{{ $errors->first('unit_price') }}</div>
                                    @endif
                                    <!--end::Row-->
                                </div>
                                <!--end::Col-->

                                <!--begin::Label-->
                                <div class="col-md-3">
                                    <label class="col-lg-12 col-form-label fw-semibold fs-6">
                                        <span>Service Charge
                                            <span class="text-danger fs-7">(Bill Setting)</span>
                                        </span>
                                    </span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->

                                    <input type="number" id="service_charge" name="service_charge" class="form-control form-control-solid mb-3 mb-lg-0"
                                           placeholder="Enter Service Charge" value="{{@$service_charge ?? 0}}" autocomplete="off" step="0.01" readonly/>
                                    @if($errors->has('service_charge'))
                                        <div class="error text-danger">{{ $errors->first('service_charge') }}</div>
                                    @endif
                                </div>
                                <!--end::Input-->

                                <!--begin::Label-->
                                <div class="col-md-3">
                                    <label class="col-lg-12 col-form-label fw-semibold fs-6">
                                        <span>Amount
                                            <span class="text-danger fs-7">(Auto Generate)</span>
                                        </span>
                                    </label>
                                    <!--end::Label-->
                                    <input type="number" id="amount" name="amount" class="form-control form-control-solid mb-3 mb-lg-0"
                                           value="{{$bill->amount ?? '0'}}" step="0.01" readonly/>
                                    @if($errors->has('amount'))
                                        <div class="error text-danger">{{ $errors->first('amount') }}</div>
                                    @endif
                                </div>
                                <!--end::Input-->

                                <!--begin::Label-->
                                <div class="col-md-6">
                                    <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                        <span>Penalty for late Payment</span>
                                        <span class="ms-1" data-bs-toggle="tooltip">
                                    </span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="penalty_for_late_payment" id="penalty_for_late_payment"
                                           class="form-control form-control-solid mb-3 mb-lg-0"
                                           placeholder="Enter Value" value="{{@$penalty_for_late_payment}}" autocomplete="penalty_for_late_payment" readonly/>
                                    @if($errors->has('penalty_for_late_payment'))
                                        <div class="error text-danger">{{ $errors->first('penalty_for_late_payment') }}</div>
                                    @endif
                                </div>
                                <!--end::Input-->

                                <!--begin::Label-->
                                <div class="col-md-6">
                                    <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                        <span>Total after final payment date</span>
                                        <span class="ms-1" data-bs-toggle="tooltip">
                                    </span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="total_after_final_payment_date" id="total_after_final_payment_date"
                                           class="form-control form-control-solid mb-3 mb-lg-0"
                                           placeholder="Enter Value" value="{{$bill->total_after_final_payment_date ?? '0'}}" autocomplete="total_after_final_payment_date" readonly/>
                                    @if($errors->has('total_after_final_payment_date'))
                                        <div class="error text-danger">{{ $errors->first('total_after_final_payment_date') }}</div>
                                    @endif
                                </div>
                                <!--end::Input-->

                                <!--begin::Label-->
                                <div class="col-md-3">
                                    <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                        <span class="required">Bill Month</span>
                                        <span class="ms-1" data-bs-toggle="tooltip" title="Must be active">
                                        <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                    </span>
                                    </label>
                                    <!--end::Label-->

                                    <select name="bill_month" class="form-control form-control-solid mb-3 mb-lg-0" required>
                                        @php
                                            $months = [
                                                'January', 'February', 'March', 'April', 'May', 'June',
                                                'July', 'August', 'September', 'October', 'November', 'December'
                                            ];
                                            $currentMonth = date('F');
                                        @endphp
                                        @foreach($months as $month)
                                            <option value="{{ $month }}" {{ isset($bill->bill_month) && $bill->bill_month == $month ? 'selected' : ($month == $currentMonth ? 'selected' : '') }}>
                                                {{ $month }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @if($errors->has('bill_month'))
                                        <div class="error text-danger">{{ $errors->first('bill_month') }}</div>
                                    @endif
                                </div>
                                <!--end::Input-->

                                <!--begin::Label-->
                                <div class="col-md-3">
                                    <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                        <span class="required">Start Date</span>
                                        <span class="ms-1" data-bs-toggle="tooltip">
                                        <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                    </span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="date" name="start_date" class="form-control form-control-solid mb-3 mb-lg-0"
                                           placeholder="Enter start date" value="{{@$bill->start_date}}" autocomplete="off" required/>
                                    @if($errors->has('start_date'))
                                        <div class="error text-danger">{{ $errors->first('start_date') }}</div>
                                    @endif
                                </div>
                                <!--end::Input-->

                                <!--begin::Label-->
                                <div class="col-md-3">
                                    <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                        <span class="required">End Date</span>
                                        <span class="ms-1" data-bs-toggle="tooltip">
                                        <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                    </span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="date" name="end_date" class="form-control form-control-solid mb-3 mb-lg-0"
                                           placeholder="Enter end date" value="{{@$bill->end_date}}" autocomplete="off" required/>
                                    @if($errors->has('end_date'))
                                        <div class="error text-danger">{{ $errors->first('end_date') }}</div>
                                    @endif
                                </div>
                                <!--end::Input-->

                                <!--begin::Label-->
                                <div class="col-md-3">
                                    <label class="col-lg-12 col-form-label fw-semibold fs-6">
                                        <span class="required">Meter Reading Date</span>
                                        <span class="ms-1" data-bs-toggle="tooltip">
                                        <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                    </span>
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="date" name="meter_reading_date" class="form-control form-control-solid mb-3 mb-lg-0"
                                           placeholder="Enter date" value="{{@$bill->meter_reading_date}}" autocomplete="off" required/>
                                    @if($errors->has('meter_reading_date'))
                                        <div class="error text-danger">{{ $errors->first('meter_reading_date') }}</div>
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

    <script>
        $(document).ready(function() {

            function calculateConsumption() {
                var presentReading = parseFloat($('#present_reading').val()) || 0;
                var previousReading = parseFloat($('#previous_reading').val()) || 0;

                if (!isNaN(presentReading) && !isNaN(previousReading)) {
                    var consumption = presentReading - previousReading;
                    $('#consumption').val(consumption);
                } else {
                    $('#consumption').val('');
                }
            }

            function calculateAmount() {
                var consumption = parseFloat($('#consumption').val()) || 0;
                var unitPrice = parseFloat($('#unit_price').val()) || 0;
                var serviceCharge = parseFloat($('#service_charge').val()) || 0;

                var amount = (consumption * unitPrice) + serviceCharge;

                $('#amount').val(amount.toFixed(2));
            }

            function calculateTotalAfterFinalPaymentDate() {
                var amount = parseFloat($('#amount').val()) || 0;
                var penalty_for_late_payment = parseFloat($('#penalty_for_late_payment').val()) || 0;

                var total_after_final_payment_date = amount + penalty_for_late_payment;

                $('#total_after_final_payment_date').val(total_after_final_payment_date.toFixed(2));
            }

            //event listeners
            $('#present_reading, #previous_reading').on('keyup', calculateConsumption);
            $('#present_reading, #previous_reading').on('keyup', calculateAmount);
            $('#present_reading, #previous_reading').on('keyup', calculateTotalAfterFinalPaymentDate);

        });
    </script>
@endsection
