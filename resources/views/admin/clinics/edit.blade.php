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
                        <a href="../dist/index.html" class="text-muted text-hover-primary">Home</a>
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
                action="{{ route('clinics.update', $row->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!--begin::Main column-->
                <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                    <!--begin::General options-->
                    <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-n2">
                        <!--begin:::Tab item-->
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                                href="#kt_ecommerce_add_product_general">General</a>
                        </li>
                        <!--end:::Tab item-->
                        <!--begin:::Tab item-->
                        {{-- <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                                href="#kt_ecommerce_add_product_advanced">Specialization</a>
                        </li> --}}
                        <!--end:::Tab item-->

                        <!--begin:::Tab item-->
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                                href="#kt_ecommerce_add_days_advanced">Days</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="kt_ecommerce_add_product_general" role="tab-panel">
                            <div class="d-flex flex-column gap-7 gap-lg-10">

                                <div class="card card-flush py-4">
                                    <!--begin::Card header-->

                                    <!--end::Card header-->
                                    <!--begin::Card body-->
                                    <div class="card-body pt-0">

                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Name</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" name="name" class="form-control mb-2"
                                                placeholder="name" value="{{ $row->name }}" />


                                        </div>
                                        <!--end::Input-->
                                        <!--begin::Input group-->
                                        <div class="mb-10 fv-row">
                                            <!--begin::Label-->
                                            <label class="required form-label">Phone</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" name="phone" class="form-control mb-2"
                                                placeholder="phone" value="{{ $row->phone }}" />


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
                                            <select class="form-select form-select-solid" name="doctor_id"
                                                data-control="select2" data-placeholder="Select an option">
                                                <option value=""></option>
                                                @foreach ($doctors as $doctor)
                                                    <option value="{{ $doctor->id }}"
                                                        {{ $row->doctor_id == $doctor->id ? 'selected' : '' }}>
                                                        {{ $doctor->name }}</option>
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
                                                    <option value="{{ $city->id }}"
                                                        {{ $row->city_id == $city->id ? 'selected' : '' }}>
                                                        {{ $city->en_city }}
                                                    </option>
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
                                            <textarea class="form-control form-control-solid" rows="3" name="en_street" placeholder="Type  En Street">{{ $row->en_street }}</textarea>
                                            <!--end::Editor-->

                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div>
                                            <!--begin::Label-->
                                            <label class="form-label">Dt Street</label>
                                            <!--end::Label-->
                                            <!--begin::Editor-->
                                            <textarea class="form-control form-control-solid" rows="3" name="dt_street" placeholder="Type  dt Street">{{ $row->dt_street }}</textarea>
                                            <!--end::Editor-->

                                        </div>
                                        <!--end::Input group-->

                                        <!--begin::Input group-->
                                        <div>
                                            <!--begin::Label-->
                                            <label class="form-label">Postal Code</label>
                                            <!--end::Label-->
                                            <!--begin::Editor-->

                                            <input type="text" name="postal_code" class="form-control mb-2"
                                                placeholder="postal_code" value="{{ $row->postal_code }}" />
                                            <!--end::Editor-->

                                        </div>
                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div>
                                            <!--begin::Label-->
                                            <label class="form-label">google map</label>
                                            <!--end::Label-->
                                            <!--begin::Editor-->
                                            <input type="text" name="google_map" class="form-control mb-2"
                                                placeholder="google_map" value="{{ $row->google_map }}" />
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
                                            data-control="select2" data-placeholder="Select an option"
                                            data-allow-clear="true">
                                            <option></option>
                                            @foreach ($status as $st)
                                                <option value="{{ $st->id }}"
                                                    {{ $row->clinic_status_id == $st->id ? 'selected' : '' }}>
                                                    {{ $st->en_status }}</option>
                                            @endforeach

                                        </select>
                                    </div> --}}
                                        <!--end::Input group-->

                                        <!--begin::Input group-->
                                        <div class="fv-row mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span class="required">Add insurance</span>
                                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                                                    title="Interviewer who conducts the meeting with the interviewee"></i>
                                            </label>
                                            <!--end::Label-->
                                            <select class="form-select form-select-solid" onchange="showDiv(this)"
                                                name="insurance_type_id" data-control="select2"
                                                data-placeholder="Select an option">

                                                @foreach ($insurances as $insurance)
                                                    <option value="{{ $insurance->id }}"
                                                        {{ $row->insurance_type_id == $insurance->id ? 'selected' : '' }}>
                                                        {{ $insurance->en_type }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                        <!--end::Input group-->



                                        <!--begin::Input group-->
                                        <div id="hidden_div"
                                            @if ($row->insurance_type_id == 1) style="display:block;"  @else style="display:none;" @endif>
                                            <!--begin::Label-->
                                            <label class="form-label">Visit Fees</label>
                                            <!--end::Label-->
                                            <!--begin::Editor-->
                                            <input type="text" name="visit_fees" class="form-control mb-2"
                                                placeholder="visit_fees" value="{{ $row->visit_fees }}" />
                                            <!--end::Editor-->

                                        </div>
                                        <!--end::Input group-->


                                        <!--begin::checkbox-->

                                        <div class="d-flex flex-wrap gap-5 mt-4">
                                            <!--begin::Input group-->
                                            <div class="fv-row w-100 flex-md-root">
                                                <div class="form-check form-switch form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="parking_allowed[]" value="1" id="flexSwitchDefault"
                                                        {{ $row->parking_allowed == 1 ? ' checked' : '' }} />
                                                    <label class="form-check-label" for="flexSwitchDefault">
                                                        parking_allowed
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="fv-row w-100 flex-md-root">
                                                <div class="form-check form-switch form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="home_visit_allowed[]" value="1" id="flexSwitchDefault"
                                                        {{ $row->home_visit_allowed == 1 ? ' checked' : '' }} />
                                                    <label class="form-check-label" for="flexSwitchDefault">
                                                        home_visit_allowed
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="fv-row w-100 flex-md-root">
                                                <div class="form-check form-switch form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="disability_allowed[]" value="1" id="flexSwitchDefault"
                                                        {{ $row->disability_allowed == 1 ? ' checked' : '' }} />
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
                            </div>
                        </div>
                        <!--begin::Tab pane-->
                        <div class="tab-pane fade" id="kt_ecommerce_add_days_advanced" role="tab-panel">
                            <div class="d-flex flex-column gap-7 gap-lg-10">

                                <!--begin::Variations-->
                                <div class="card card-flush py-4">
                                    <!--begin::Card header-->
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h2>Days</h2>
                                        </div>
                                    </div>
                                    <!--end::Card header-->
                                    <!--begin::Card body-->
                                    <div class="card-body pt-0">
                                        <!--begin::Input group-->
                                        <div class="">
                                            <!--begin::Label-->
                                            <label class="form-label">Add Day</label>
                                            <!--end::Label-->


                                            <!--begin::Repeater-->
                                            <div id="kt_docs_repeater_basic">


                                                <!--begin::Form group-->
                                                <div class="form-group">
                                                    <div data-repeater-list="kt_docs_repeater_basic"
                                                        class="d-flex flex-column gap-3">
                                                        @if ($doctorDays->count() > 0)
                                                            @foreach ($doctorDays as $index => $doctorDay)
                                                                <div data-repeater-item>
                                                                    <div class="form-group row">
                                                                        <div class="col-md-3">
                                                                            <!--begin::Label-->
                                                                            <label class="fs-6 fw-bold form-label ">
                                                                                <option value="">Select Day..
                                                                                </option>

                                                                            </label>
                                                                            <!--end::Label-->
                                                                            <select class="form-select" name="days_id"
                                                                                data-placeholder="Select a variation"
                                                                                data-kt-ecommerce-catalog-add-product="product_option">
                                                                                <option></option>
                                                                                @foreach ($days as $day)
                                                                                    <option value="{{ $day->id }}"
                                                                                        {{ $doctorDay->days_id == $day->id ? 'selected' : '' }}>
                                                                                        {{ $day->en_day }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <label class="form-label">Time To:</label>
                                                                            <input
                                                                                class="form-control  form-control-solid tPick"
                                                                                name="time_from"
                                                                                value="{{ $doctorDay->time_from }}"
                                                                                placeholder="Pick date"
                                                                                id="kt_datepicker_3" />
                                                                        </div>

                                                                        <div class="col-md-3">
                                                                            <label class="form-label">Time To:</label>
                                                                            <input
                                                                                class="form-control  form-control-solid tPick"
                                                                                name="time_to"
                                                                                value="{{ $doctorDay->time_to }}"
                                                                                placeholder="Pick date"
                                                                                id="kt_datepicker_3" />
                                                                        </div>

                                                                        <div class="col-md-4">
                                                                            <a href="javascript:;" data-repeater-delete
                                                                                class="btn btn-sm btn-light-danger mt-3 mt-md-8">
                                                                                <i class="la la-trash-o"></i>Delete
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @else
                                                            <div data-repeater-item>
                                                                <div class="form-group row">
                                                                    <div class="col-md-3">
                                                                        <!--begin::Label-->
                                                                        <label class="fs-6 fw-bold form-label ">
                                                                            <option value="">Select Day..</option>
                                                                            {{-- <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Interviewer who conducts the meeting with the interviewee"></i> --}}
                                                                        </label>
                                                                        <!--end::Label-->
                                                                        <select class="form-select" name="days_id"
                                                                            data-placeholder="Select a variation"
                                                                            data-kt-ecommerce-catalog-add-product="product_option">
                                                                            <option></option>
                                                                            @foreach ($days as $day)
                                                                                <option value="{{ $day->id }}">
                                                                                    {{ $day->en_day }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <label class="form-label">Time From:</label>
                                                                        <input
                                                                            class="form-control  form-control-solid tPick"
                                                                            name="time_from" placeholder="Pick date"
                                                                            id="kt_datepicker_3" />
                                                                    </div>

                                                                    <div class="col-md-3">
                                                                        <label class="form-label">Time To:</label>
                                                                        <input
                                                                            class="form-control  form-control-solid tPick"
                                                                            name="time_to" placeholder="Pick date"
                                                                            id="kt_datepicker_3" />
                                                                    </div>

                                                                    <div class="col-md-4">
                                                                        <a href="javascript:;" data-repeater-delete
                                                                            class="btn btn-sm btn-light-danger mt-3 mt-md-8">
                                                                            <i class="la la-trash-o"></i>Delete
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif

                                                    </div>
                                                </div>

                                                <!--end::Form group-->
                                                <!--begin::Form group-->
                                                <div class="form-group mt-5">
                                                    <button type="button" data-repeater-create=""
                                                        class="btn btn-sm btn-light-primary">
                                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr087.svg-->
                                                        <span class="svg-icon svg-icon-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none">
                                                                <rect opacity="0.5" x="11" y="18"
                                                                    width="12" height="2" rx="1"
                                                                    transform="rotate(-90 11 18)" fill="black" />
                                                                <rect x="6" y="11" width="12"
                                                                    height="2" rx="1" fill="black" />
                                                            </svg>
                                                        </span>
                                                        <!--end::Svg Icon-->Add another Day
                                                    </button>
                                                </div>
                                                <!--end::Form group-->
                                            </div>
                                            <!--end::Repeater-->
                                        </div>
                                        <!--end::Input group-->
                                    </div>
                                    <!--end::Card header-->
                                </div>
                                <!--end::Variations-->

                            </div>
                        </div>
                        <!--end::Tab pane-->

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
                </div>
                <!--end::Main column-->
            </form>
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->
@endsection
@section('scripts')
    <script>
        $(".dPick").flatpickr();
        $(".tPick").flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
        });

        function showDiv(select) {

            if (select.value == 1) {
                document.getElementById('hidden_div').style.display = "block";
            } else {
                document.getElementById('hidden_div').style.display = "none";
            }
        }
    </script>
@endsection
