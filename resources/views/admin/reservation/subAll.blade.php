<div class="card card-flush">
    <!--begin::Card header-->


    <div class="card-header align-items-center py-5 gap-2 gap-md-5">
        <!--begin::Card title-->
        <div class="card-title">
            <!--begin::Search-->
            <div class="d-flex align-items-center position-relative my-1">
                <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                <span class="svg-icon svg-icon-1 position-absolute ms-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none">
                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2"
                            rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
                        <path
                            d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                            fill="black" />
                    </svg>
                </span>
                <!--end::Svg Icon-->
                <input type="text" data-kt-ecommerce-category-filter="search"
                    class="form-control form-control-solid w-250px ps-14" placeholder="Search Field" />
            </div>
            <!--end::Search-->
        </div>
        <!--end::Card title-->
        <!--begin::Card toolbar-->
        <div class="card-toolbar">
            <!--begin::Add customer-->
            <!--begin::Add product-->
            {{-- <a href="{{ route('Doctors.create') }}" class="btn btn-primary">Add Doctors</a> --}}
            <!--end::Add product-->

            <!--end::Add customer-->
        </div>
        <!--end::Card toolbar-->
    </div>
    <!--end::Card header-->
    <!--begin::Card body-->
    <div class="card-body pt-0">

        <!--begin::Table-->
        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_category_table">
            <!--begin::Table head-->
            <thead>
                <!--begin::Table row-->
                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                    <th class="w-10px pe-2">
                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                            <input class="form-check-input" type="checkbox" data-kt-check="true"
                                data-kt-check-target="#kt_ecommerce_category_table .form-check-input"
                                value="1" />
                        </div>
                    </th>
                    <th class="text-start min-w-70px">ID </th>
                    <th class="min-w-200px">patient_name</th>
                    <th class="text-end min-w-100px">Clinic</th>
                    <th class="text-end min-w-70px">Reservation Date</th>
                    <th class="text-end min-w-70px">Time </th>
                    <th class="text-end min-w-70px">status </th>
                    <th>Action</th>

                </tr>
                <!--end::Table row-->
            </thead>
            <!--end::Table head-->
            <!--begin::Table body-->
            <tbody class="fw-bold text-gray-600">
                @foreach ($rows as $index => $newrow)
                    <!--begin::Table row-->

                    <tr>
                        <!--begin::Checkbox-->
                        <td>
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" />
                            </div>
                        </td>
                        <!--end::Checkbox-->
                        <!--begin::Category=-->
                        <td class="text-start pe-0" data-order="15">
                            <span class="fw-bolder ms-3">{{ $newrow->id }}</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">

                                <div class="ms-5">
                                    <!--begin::Title-->
                                    <a href="#"
                                        class="text-gray-800 text-hover-primary fs-5 fw-bolder mb-1"
                                        data-kt-ecommerce-category-filter="category_name">{{ $newrow->patient_name }}</a>
                                    <!--end::Title-->
                                </div>
                            </div>
                        </td>
                        <!--end::Category=-->
                        <!--begin::SKU=-->

                        <td class="text-end pe-0">
                            <input type="hidden" name="" id=""
                                data-kt-ecommerce-category-filter="category_id" value="{{ $newrow->id }}">
                            <span class="fw-bolder">{{ $newrow->clinic->doctor->name ?? '' }}</span>
                        </td>
                        <!--end::SKU=-->
                        <!--begin::Qty=-->
                        <td class="text-end pe-0" data-order="15">
                            <span class="fw-bolder ms-3">{{ $newrow->reservation_date }}</span>
                        </td>
                        <!--end::Qty=-->
                        <td class="text-end pe-0" data-order="15">
                            <span class="fw-bolder ms-3">{{ $newrow->time_from }} - {{ $newrow->time_to }}</span>
                        </td>
                        <td class="text-end pe-0" data-order="15">
                            <span class="fw-bolder ms-3" @if($newrow->reservation_status_id == 3)  style="color: red;" @elseif($newrow->reservation_status_id == 2)  style="color: green;" @endif>{{ $newrow->status->en_status ?? '' }}</span>
                        </td>
                        <td>
                            @if (Auth::guard('admin')->check())
                                <div class="menu-item px-3">
                                    <a href="{{ route('admin.show-all-reservation', $newrow->id) }}"
                                        class="menu-link px-3"><i class="fa fa-eye" aria-hidden="true"></i></a>

                                </div>
                            @endif
                            @if (Auth::guard('doctor')->check())
                                <div class="menu-item px-3">
                                    <a href="{{ route('doctor.show-all-reservation',$newrow->id) }}"
                                        class="menu-link px-3"><i class="fa fa-eye" aria-hidden="true"></i></a>

                                </div>
                                <div class="menu-item px-3">

@if($newrow->reservation_status_id == 5 || $newrow->reservation_status_id == 1)
                                    <a data-bs-toggle="modal"
                                        data-bs-target="#comReservation{{$newrow->id }}" title="complete"
                                        class="menu-link px-3"><i class="fa fa-check" style="color: green;font-weight: bold"
                                            aria-hidden="true"></i></a>
                                            @endif
                                            @if($newrow->reservation_status_id == 1 || $newrow->reservation_status_id == 5 )
                                    <a data-bs-toggle="modal"
                                        data-bs-target="#delReservation{{$newrow->id }}" title="cancelled"
                                        class="menu-link px-3"><span style="color: red;font-weight: bold">x</span></a>
<a data-bs-toggle="modal"  @endif
@if($newrow->reservation_status_id == 1)
                                        data-bs-target="#confReservation{{$newrow->id }}"
                                        class="menu-link px-3"><span style="color: green;font-weight: bold" title="confirm"><i style="color: green;font-weight: bold" class="fa fa-file"></i></span></a>

@endif </div>

                            @endif
                        </td>

                    <!--end::Table row-->
<!--begin::Modal - New Target-->
                    <div class="modal fade" id="confReservation{{ $newrow->id }}" tabindex="-1"
                        aria-hidden="true">
                        <!--begin::Modal dialog-->
                        <div class="modal-dialog modal-dialog-centered mw-650px">
                            <!--begin::Modal content-->
                            <div class="modal-content rounded">
                                <!--begin::Modal header-->
                                <div class="modal-header pb-0 border-0 justify-content-end">
                                    <!--begin::Close-->
                                    <div class="btn btn-sm btn-icon btn-active-color-primary"
                                        data-bs-dismiss="modal">
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                        <span class="svg-icon svg-icon-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.5" x="6" y="17.3137"
                                                    width="16" height="2" rx="1"
                                                    transform="rotate(-45 6 17.3137)" fill="black" />
                                                <rect x="7.41422" y="6" width="16"
                                                    height="2" rx="1"
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
                                        action="{{ route('doctor.conf-action-reservation', $newrow->id) }}" method="get">

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
                                                    class="btn btn-light me-3"
                                                    data-dismiss="modal">Cancel</button>
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
                    <div class="modal fade" id="comReservation{{ $newrow->id }}" tabindex="-1"
                        aria-hidden="true">
                        <!--begin::Modal dialog-->
                        <div class="modal-dialog modal-dialog-centered mw-650px">
                            <!--begin::Modal content-->
                            <div class="modal-content rounded">
                                <!--begin::Modal header-->
                                <div class="modal-header pb-0 border-0 justify-content-end">
                                    <!--begin::Close-->
                                    <div class="btn btn-sm btn-icon btn-active-color-primary"
                                        data-bs-dismiss="modal">
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                        <span class="svg-icon svg-icon-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.5" x="6" y="17.3137"
                                                    width="16" height="2" rx="1"
                                                    transform="rotate(-45 6 17.3137)" fill="black" />
                                                <rect x="7.41422" y="6" width="16"
                                                    height="2" rx="1"
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
                                        action="{{ route('doctor.com-action-reservation', $newrow->id) }}" method="get">

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
                                                    class="btn btn-light me-3"
                                                    data-dismiss="modal">Cancel</button>
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
                     <div class="modal fade" id="delReservation{{ $newrow->id }}" tabindex="-1"
                        aria-hidden="true">
                        <!--begin::Modal dialog-->
                        <div class="modal-dialog modal-dialog-centered mw-650px">
                            <!--begin::Modal content-->
                            <div class="modal-content rounded">
                                <!--begin::Modal header-->
                                <div class="modal-header pb-0 border-0 justify-content-end">
                                    <!--begin::Close-->
                                    <div class="btn btn-sm btn-icon btn-active-color-primary"
                                        data-bs-dismiss="modal">
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                        <span class="svg-icon svg-icon-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.5" x="6" y="17.3137"
                                                    width="16" height="2" rx="1"
                                                    transform="rotate(-45 6 17.3137)" fill="black" />
                                                <rect x="7.41422" y="6" width="16"
                                                    height="2" rx="1"
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
                                        action="{{ route('doctor.del-action-reservation', $newrow->id) }}" method="get">

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
                                                    class="btn btn-light me-3"
                                                    data-dismiss="modal">Cancel</button>
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

                </tr>
                @endforeach


            </tbody>
            <!--end::Table body-->
        </table>
        <!--end::Table-->
    </div>
    <!--end::Card body-->
</div>
<!--end::Category-->
