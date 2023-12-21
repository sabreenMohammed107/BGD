@extends (Auth::guard('admin')->check() ? 'layout.main' : 'layout.doctor.main')

@section('breadcrumb')
<div class="toolbar" id="kt_toolbar">
    <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
        <!--begin::Info-->
        <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
            <!--begin::Title-->
            <h1 class="text-dark fw-bolder my-1 fs-2">Reservation</h1>
            <!--end::Title-->
            <!--begin::Breadcrumb-->
            <ul class="breadcrumb fw-bold fs-base my-1">
                <li class="breadcrumb-item text-muted">
                    <a href="#" class="text-muted text-hover-primary">Home</a>
                </li>
                <li class="breadcrumb-item text-muted">Reservation</li>


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
            action="{{ route('doctors.update-reservation') }}" method="post" enctype="multipart/form-data">
            @csrf

            <!--begin::Aside column-->
            <input type="hidden" name="reservId" value="{{$row->id}}" id="">
            <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
                <!--begin::Thumbnail settings-->
                <div class="card card-flush py-4">
                    <!--begin::Card header-->
                    <div class="card-header">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <h2> Doctor</h2>
                        </div>
                        <!--end::Card title-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Image input wrapper-->
                    <div class="card-body text-center pt-0">
                        <!--begin::Image input-->
                        <div class="image-input image-input-empty image-input-outline mb-3" data-kt-image-input="true"
                            style="background-image: url('{{ asset('uploads/doctors') }}/{{ $row->clinic->doctor->img }}')">
                            <div class="image-input-wrapper w-150px h-150px"
                                style="background-image: url(' {{ asset('uploads/doctors') }}/{{ $row->clinic->doctor->img }}')">

                            </div>
                            <!--end::Preview existing avatar-->
                            <!--begin::Edit-->
                            <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                                <i class="bi bi-pencil-fill fs-7"></i>
                                <!--begin::Inputs-->
                                <input type="file" disabled name="img" accept=".png, .jpg, .jpeg" />
                                <input type="hidden" name="avatar_remove" />
                                <!--end::Inputs-->
                            </label>
                            <!--end::Edit-->

                        </div>
                        <!--end::Image input-->
                    </div>
                    <!--end::Image input wrapper-->
                </div>
                <!--end::Thumbnail settings-->


            </div>
            <!--end::Aside column-->
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

                    @if (Auth::guard('doctor')->check())

                    <div class="menu-item px-3">
                        @if($row->reservation_status_id == 5 || $row->reservation_status_id == 1)
                        <a data-bs-toggle="modal" data-bs-target="#comReservation{{$row->id }}" title="complete"
                            class="btn px-3"><i class="fa fa-check" style="color: green;font-weight: bold"
                                aria-hidden="true"></i>complete</a>
                        @endif
                        @if($row->reservation_status_id == 1 || $row->reservation_status_id == 5 )
                        <a data-bs-toggle="modal" data-bs-target="#delReservation{{$row->id }}" title="cancelled"
                            class="btn px-3"><span style="color: red;font-weight: bold">x cancelled</span></a>
                        <a data-bs-toggle="modal" @endif @if($row->reservation_status_id == 1)
                            data-bs-target="#confReservation{{$row->id }}"
                            class="btn px-3"><span style="color: green;font-weight: bold" title="confirm"><i
                                    style="color: green;font-weight: bold" class="fa fa-file"></i>confirm</span></a>

                        @endif
                    </div>

                    @endif

                    <!--begin::Modal - New Target-->
                    <div class="modal fade" id="confReservation{{ $row->id }}" tabindex="-1" aria-hidden="true">
                        <!--begin::Modal dialog-->
                        <div class="modal-dialog modal-dialog-centered mw-650px">
                            <!--begin::Modal content-->
                            <div class="modal-content rounded">
                                <!--begin::Modal header-->
                                <div class="modal-header pb-0 border-0 justify-content-end">
                                    <!--begin::Close-->
                                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                        <span class="svg-icon svg-icon-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                                    transform="rotate(-45 6 17.3137)" fill="black" />
                                                <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                                    transform="rotate(45 7.41422 6)" fill="black" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </div>
                                    <!--end::Close-->
                                </div>
                                <!--begin::Modal header-->
                                <!--begin::Modal body-->
                                <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                                    <!--begin:Form-->
                                    <form id="kt_modal_update_target_updateForm" class="form"
                                        action="{{ route('doctor.conf-action-reservation', $row->id) }}" method="get">

                                        <!--begin::Heading-->

                                        <div class="mb-13 text-center">
                                            <!--begin::Title-->
                                            <h1 class="mb-3">Confirmed Reservation</h1>
                                            <!--end::Title-->

                                        </div>
                                        <!--end::Heading-->
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <div class="text-center" style="color:rgb(179, 6, 6) ">
                                                <p>Confirmed Booking - Are you sure ?</p>
                                                <span>note: This action cannot be changed</span>
                                            </div>
                                        </div>
                                        <!--begin::Actions-->
                                        <div class="text-center">
                                            <div class="btn btn-sm btn-icon btn-active-color-primary"
                                                style="margin-right: 25px" data-bs-dismiss="modal">
                                                <button type="reset" id="kt_modal_update_target_cancel"
                                                    class="btn btn-light me-3" data-dismiss="modal">Cancel</button>
                                            </div>
                                            <button type="submit" id="kt_modal_update_target_submit"
                                                class="btn btn-danger">
                                                <span class="indicator-label">Submit</span>
                                                <span class="indicator-progress">Please wait...
                                                    <span
                                                        class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                            </button>
                                        </div>
                                        <!--end::Actions-->
                                    </form>
                                    <!--end:Form-->
                                </div>
                                <!--end::Modal body-->
                            </div>
                            <!--end::Modal content-->
                        </div>
                        <!--end::Modal dialog-->
                    </div>
                    <!--end::Modal - New Target-->
                    <!--begin::Modal - New Target-->
                    <div class="modal fade" id="comReservation{{ $row->id }}" tabindex="-1" aria-hidden="true">
                        <!--begin::Modal dialog-->
                        <div class="modal-dialog modal-dialog-centered mw-650px">
                            <!--begin::Modal content-->
                            <div class="modal-content rounded">
                                <!--begin::Modal header-->
                                <div class="modal-header pb-0 border-0 justify-content-end">
                                    <!--begin::Close-->
                                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                        <span class="svg-icon svg-icon-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                                    transform="rotate(-45 6 17.3137)" fill="black" />
                                                <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                                    transform="rotate(45 7.41422 6)" fill="black" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </div>
                                    <!--end::Close-->
                                </div>
                                <!--begin::Modal header-->
                                <!--begin::Modal body-->
                                <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                                    <!--begin:Form-->
                                    <form id="kt_modal_update_target_updateForm" class="form"
                                        action="{{ route('doctor.com-action-reservation', $row->id) }}" method="get">

                                        <!--begin::Heading-->

                                        <div class="mb-13 text-center">
                                            <!--begin::Title-->
                                            <h1 class="mb-3">Complete Reservation</h1>
                                            <!--end::Title-->

                                        </div>
                                        <!--end::Heading-->
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <div class="text-center" style="color:rgb(179, 6, 6) ">
                                                <p>Complete Booking - Are you sure ?</p>
                                                <span>note: This action cannot be changed</span>
                                            </div>
                                        </div>
                                        <!--begin::Actions-->
                                        <div class="text-center">
                                            <div class="btn btn-sm btn-icon btn-active-color-primary"
                                                style="margin-right: 25px" data-bs-dismiss="modal">
                                                <button type="reset" id="kt_modal_update_target_cancel"
                                                    class="btn btn-light me-3" data-dismiss="modal">Cancel</button>
                                            </div>
                                            <button type="submit" id="kt_modal_update_target_submit"
                                                class="btn btn-danger">
                                                <span class="indicator-label">Submit</span>
                                                <span class="indicator-progress">Please wait...
                                                    <span
                                                        class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                            </button>
                                        </div>
                                        <!--end::Actions-->
                                    </form>
                                    <!--end:Form-->
                                </div>
                                <!--end::Modal body-->
                            </div>
                            <!--end::Modal content-->
                        </div>
                        <!--end::Modal dialog-->
                    </div>
                    <!--end::Modal - New Target-->
                    <!--begin::Modal - New Target-->
                    <div class="modal fade" id="delReservation{{ $row->id }}" tabindex="-1" aria-hidden="true">
                        <!--begin::Modal dialog-->
                        <div class="modal-dialog modal-dialog-centered mw-650px">
                            <!--begin::Modal content-->
                            <div class="modal-content rounded">
                                <!--begin::Modal header-->
                                <div class="modal-header pb-0 border-0 justify-content-end">
                                    <!--begin::Close-->
                                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                        <span class="svg-icon svg-icon-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                                    transform="rotate(-45 6 17.3137)" fill="black" />
                                                <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                                    transform="rotate(45 7.41422 6)" fill="black" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </div>
                                    <!--end::Close-->
                                </div>
                                <!--begin::Modal header-->
                                <!--begin::Modal body-->
                                <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                                    <!--begin:Form-->
                                    <form id="kt_modal_update_target_updateForm" class="form"
                                        action="{{ route('doctor.del-action-reservation', $row->id) }}" method="get">

                                        <!--begin::Heading-->

                                        <div class="mb-13 text-center">
                                            <!--begin::Title-->
                                            <h1 class="mb-3">Cancel Reservation</h1>
                                            <!--end::Title-->

                                        </div>
                                        <!--end::Heading-->
                                        <div class="d-flex flex-column mb-8 fv-row">
                                            <div class="text-center" style="color:rgb(179, 6, 6) ">
                                                <p>Cancel Booking - Are you sure ?</p>
                                                <span>note: This action cannot be changed</span>
                                            </div>
                                        </div>
                                        <!--begin::Actions-->
                                        <div class="text-center">
                                            <div class="btn btn-sm btn-icon btn-active-color-primary"
                                                style="margin-right: 25px" data-bs-dismiss="modal">
                                                <button type="reset" id="kt_modal_update_target_cancel"
                                                    class="btn btn-light me-3" data-dismiss="modal">Cancel</button>
                                            </div>
                                            <button type="submit" id="kt_modal_update_target_submit"
                                                class="btn btn-danger">
                                                <span class="indicator-label">Submit</span>
                                                <span class="indicator-progress">Please wait...
                                                    <span
                                                        class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                            </button>
                                        </div>
                                        <!--end::Actions-->
                                    </form>
                                    <!--end:Form-->
                                </div>
                                <!--end::Modal body-->
                            </div>
                            <!--end::Modal content-->
                        </div>
                        <!--end::Modal dialog-->
                    </div>
                    <!--end::Modal - New Target-->

                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <!--begin::Input group-->
                        <div class="mb-10 fv-row">
                            <!--begin::Label-->
                            <label class=" form-label"> Patient Name</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input id="name" disabled type="text" class="form-control " name="name"
                                value="{{$row->patient_name}}" autocomplete="name" autofocus>


                        </div>
                        <!--end::Input-->

                        <!--begin::Input group-->
                        <div class="mb-10 fv-row">
                            <!--begin::Label-->
                            <label class=" form-label"> Patient Mobile</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input id="patient_mobile" disabled type="text" class="form-control " name="patient_mobile"
                                @if ( $row->other_flag == 1)
                            value="{{$row->patient_mobile}}"
                            @else
                            value="{{$row->patient->mobile ?? ''}}"
                            @endif
                            autocomplete="patient_mobile">




                        </div>
                        <!--end::Input-->

                        <!--begin::Input group-->
                        <div class="mb-10 fv-row">
                            <!--begin::Label-->
                            <label class=" form-label">address</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" disabled name="patient_address" @if ( $row->other_flag == 1)
                            value="{{$row->patient_address}}"
                            @else
                            value="{{$row->patient->details_address ?? ''}}"
                            @endif
                            class="form-control mb-2" placeholder="patient_address"
                            value="" />


                        </div>
                        <!--end::Input-->
                        <div class="mb-10 fv-row">
                            <!--begin::Label-->
                            <label class=" form-label">User</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" disabled name="name" value="{{$row->patient->name ?? ''}}"
                                class="form-control mb-2" placeholder="name" value="" />


                        </div>
                        <!--begin::checkbox-->

                        <div class="d-flex flex-wrap gap-5 mt-4">
                            <!--begin::Input group-->
                            <div class="fv-row w-100 flex-md-root">
                                <div class="form-check form-switch form-check-custom form-check-solid">
                                    <input class="form-check-input" disabled type="checkbox" name="verified[]" value="1"
                                        id="flexSwitchDefault" {{ $row->other_flag == 1 ? ' checked' : '' }} />
                                    <label class="form-check-label" for="flexSwitchDefault">
                                        User Book inbehalf of another
                                    </label>
                                </div>
                            </div>
                            <!--end::Input group-->

                        </div>
                        <!--end:checkbox-->
                        <!--end::Input-->
                        <div class="mb-10 fv-row">
                            <!--begin::Label-->
                            <label class=" form-label">Reservation Date</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" disabled name="mobile" value="{{$row->reservation_date}}"
                                class="form-control mb-2" placeholder="mobile" value="" />


                        </div>

                        <!--end::Input-->
                        <div class="mb-10 fv-row">
                            <!--begin::Label-->
                            <label class=" form-label">Time</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" disabled name="mobile" value="{{$row->time_from}} - {{$row->time_to}}"
                                class="form-control mb-2" placeholder="mobile" value="" />


                        </div>

                        <!--begin::Input group-->
                        <div>
                            <!--begin::Label-->
                            <label class="form-label">Doctor Notes</label>
                            <!--end::Label-->
                            <!--begin::Editor-->
                            <textarea class="form-control form-control-solid" rows="3" name="notes"
                                placeholder="Type  En Overview">{{$row->notes}}</textarea>
                            <!--end::Editor-->

                        </div>
                        <!--end::Input group-->













                    </div>
                    <!--end::Card header-->
                </div>
                <!--end::General options-->

                @if(Auth::guard('admin')->check())
                <div class="d-flex justify-content-end">
                    <!--begin::Button-->
                    <a href="{{ route('admin.all-reservations') }}" id="kt_ecommerce_add_product_cancel"
                        class="btn btn-light me-5">Cancel</a>
                    <!--end::Button-->
                    <!--begin::Button-->

                    <!--end::Button-->
                </div>
                @else
                <div class="d-flex justify-content-end">
                    <!--begin::Button-->
                    <a href="{{ route('doctor.all-reservations') }}" id="kt_ecommerce_add_product_cancel"
                        class="btn btn-light me-5">Cancel</a>
                    <!--end::Button-->
                    <!--begin::Button-->
                    <!--begin::Button-->
                    <button type="submit" id="kt_ecommerce_add_category_submit" class="btn btn-primary">
                        <span class="indicator-label">Save Changes</span>
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                    <!--end::Button-->
                    <!--end::Button-->
                </div>
                @endif
            </div>
            <!--end::Main column-->
        </form>
    </div>
    <!--end::Container-->
</div>
<!--end::Post-->

@endsection
