@extends('layout.main')

@section('breadcrumb')
    <div class="toolbar" id="kt_toolbar">
        <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                <!--begin::Title-->
                <h1 class="text-dark fw-bolder my-1 fs-2">Clinics</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb fw-bold fs-base my-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="#" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item text-muted">Clinics</li>

                    <li class="breadcrumb-item text-dark">All</li>
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Info-->

        </div>
    </div>
@endsection

@section('content')
    <!--begin::Post-->
    <div class="post fs-6 d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div class="container-xxl">
            <form id="kt_ecommerce_add_category_form" class="form d-flex flex-column flex-lg-row"
                action="{{ route('clinics.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <!--begin::Main column-->
                <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                    <!--begin::General options-->
                    <div class="card card-flush py-4">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <div class="card-title">
                                <h2>General</h2>
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
 <!--begin::Input group-->
 <div class="mb-10 fv-row">
    <!--begin::Label-->
    <label class="required form-label">Name</label>
    <!--end::Label-->
    <!--begin::Input-->
    <input type="text" name="name" class="form-control mb-2" placeholder="name"
        value="" />


</div>
<!--end::Input-->

                            <!--begin::Input group-->
                            <div class="mb-10 fv-row">
                                <!--begin::Label-->
                                <label class="required form-label">Phone</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="phone" class="form-control mb-2" placeholder="phone"
                                    value="" />


                            </div>
                            <!--end::Input-->

                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <option value="">Select Doctor..</option>
                                    {{-- <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Interviewer who conducts the meeting with the interviewee"></i> --}}
                                </label>
                                <!--end::Label-->
                                <select class="form-select form-select-solid" name="doctor_id" data-control="select2"
                                    data-placeholder="Select an option">
                                    <option value=""></option>
                                    @foreach ($doctors as $doctor)
                                        <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!--end::Input group-->


                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <option value="">Select city..</option>
                                    {{-- <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Interviewer who conducts the meeting with the interviewee"></i> --}}
                                </label>
                                <!--end::Label-->
                                <select class="form-select form-select-solid" name="city_id"
                                    data-control="select2" data-placeholder="Select an option">
                                    <option value=""></option>
                                    @foreach ($cities as $city)
                                        <option value="{{ $city->id }}">{{ $city->en_city }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div>
                                <!--begin::Label-->
                                <label class="form-label">En street</label>
                                <!--end::Label-->
                                <!--begin::Editor-->
                                <textarea class="form-control form-control-solid" rows="3" name="en_street" placeholder="Type  En Street"></textarea>
                                <!--end::Editor-->

                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div>
                                <!--begin::Label-->
                                <label class="form-label">Dt Street</label>
                                <!--end::Label-->
                                <!--begin::Editor-->
                                <textarea class="form-control form-control-solid" rows="3" name="dt_street" placeholder="Type  dt Street"></textarea>
                                <!--end::Editor-->

                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div>
                                <!--begin::Label-->
                                <label class="form-label">Postal Code</label>
                                <!--end::Label-->
                                <!--begin::Editor-->

 <input type="text" name="postal_code" class="form-control mb-2" placeholder="postal_code"
                                    value="" />
                                                                    <!--end::Editor-->

                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div>
                                <!--begin::Label-->
                                <label class="form-label">google map</label>
                                <!--end::Label-->
                                <!--begin::Editor-->
                                <input type="text" name="google_map" class="form-control mb-2" placeholder="google_map"
                                value="" />
                                                                <!--end::Editor-->

                            </div>
                            <!--end::Input group-->
                             <!--begin::Input group-->
                             <div>
                                <!--begin::Label-->
                                <label class="form-label">map latitude - longitude </label>
                                <!--end::Label-->
                                <!--begin::Editor-->
                                <input type="text" name="map_tude" class="form-control mb-2" placeholder="map latitude - longitude"
                                value="" />
                                                                <!--end::Editor-->

                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->


                            <!--begin::Input group-->
                            {{-- <div class="fv-row mb-7">

                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Add Status</span>
                                    <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                                        title="Interviewer who conducts the meeting with the interviewee"></i>
                                </label>

                                <select class="form-select form-select-solid" name="clinic_status_id"
                                    data-control="select2" data-placeholder="Select an option" data-allow-clear="true">
                                    <option></option>
                                    @foreach ($status as $st)
                                        <option value="{{ $st->id }}">{{ $st->en_status }}</option>
                                    @endforeach

                                </select>
                            </div> --}}
                            <!--end::Input group-->

 <!--begin::Input group-->
 <!--begin::Input group-->
<div>
    <!--begin::Label-->
    <label class="form-label">En Reservation Notes</label>
    <!--end::Label-->
    <!--begin::Editor-->
    <textarea class="form-control form-control-solid" rows="3" name="en_reservation_notes"
        placeholder="Type En Reservation"></textarea>
    <!--end::Editor-->

</div>
<!--end::Input group-->
 <!--begin::Input group-->
 <div>
    <!--begin::Label-->
    <label class="form-label">Dt Reservation Notes</label>
    <!--end::Label-->
    <!--begin::Editor-->
    <textarea class="form-control form-control-solid" rows="3" name="dt_reservation_notes"
        placeholder="Type DT Reservation"></textarea>
    <!--end::Editor-->

</div>
<!--end::Input group-->
 <div class="fv-row mb-7">
    <!--begin::Label-->
    <label class="fs-6 fw-bold form-label mt-3">
        <span class="required">Add insurance</span>
        <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
            title="Interviewer who conducts the meeting with the interviewee"></i>
    </label>
    <!--end::Label-->
    <select class="form-select form-select-solid" onchange="showDiv(this)" name="insurance_type_id"
        data-control="select2" data-placeholder="Select an option" >

        @foreach ($insurances as $insurance)
            <option value="{{ $insurance->id }}">{{ $insurance->en_type }}</option>
        @endforeach

    </select>
</div>
<!--end::Input group-->



 <!--begin::Input group-->
 <div id="hidden_div" style="display:none;" >
    <!--begin::Label-->
    <label class="form-label">Visit Fees</label>
    <!--end::Label-->
    <!--begin::Editor-->
    <input type="text" id="visit_fees"  name="visit_fees" class="form-control mb-2" placeholder="visit_fees"
    value="" />
                                    <!--end::Editor-->

</div>
<!--end::Input group-->


                            <!--begin::checkbox-->

                            <div class="d-flex flex-wrap gap-5 mt-4">
                                <!--begin::Input group-->
                                <div class="fv-row w-100 flex-md-root">
                                    <div class="form-check form-switch form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" name="parking_allowed[]" value="1"
                                            id="flexSwitchDefault" />
                                        <label class="form-check-label" for="flexSwitchDefault">
                                            parking_allowed
                                        </label>
                                    </div>
                                </div>
                                <div class="fv-row w-100 flex-md-root">
                                    <div class="form-check form-switch form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" name="home_visit_allowed[]" value="1"
                                            id="flexSwitchDefault" />
                                        <label class="form-check-label" for="flexSwitchDefault">
                                            home_visit_allowed
                                        </label>
                                    </div>
                                </div>
                                <div class="fv-row w-100 flex-md-root">
                                    <div class="form-check form-switch form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" name="disability_allowed[]" value="1"
                                            id="flexSwitchDefault" />
                                        <label class="form-check-label" for="flexSwitchDefault">
                                            disability_allowed
                                        </label>
                                    </div>
                                </div>
                                <!--end::Input group-->

                            </div>
                            <!--end:checkbox-->

                        </div>
                        <!--end::Card header-->
                    </div>
                    <!--end::General options-->


                    <div class="d-flex justify-content-end">
                        <!--begin::Button-->
                        <a href="{{ route('clinics.index') }}" id="kt_ecommerce_add_product_cancel"
                            class="btn btn-light me-5">Cancel</a>
                        <!--end::Button-->
                        <!--begin::Button-->
                        <button type="submit" id="kt_ecommerce_add_category_submit" class="btn btn-primary">
                            <span class="indicator-label">Save Changes</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                        <!--end::Button-->
                    </div>
                </div>
                <!--end::Main column-->
            </form>
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->
@endsection
@section('scripts')
<script type="text/javascript">
    function showDiv(select){

       if(select.value==1){
        document.getElementById('visit_fees').value = "";
        document.getElementById('hidden_div').style.display = "none";
       } else{

        document.getElementById('hidden_div').style.display = "block";

       }
    }
    </script>
    @endsection
