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
                    <th class="min-w-200px">patient_name</th>
                    <th class="text-end min-w-100px">Clinic</th>
                    <th class="text-end min-w-70px">Reservation Date</th>
                    <th class="text-end min-w-70px">Time </th>
                    <th class="text-end min-w-70px">status </th>
                    <th class="text-end min-w-150px">Action </th>
                </tr>
                <!--end::Table row-->
            </thead>
            <!--end::Table head-->
            <!--begin::Table body-->
            <tbody class="fw-bold text-gray-600">
                @foreach ($rows as $index => $row)
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
<td>
<div class="d-flex align-items-center">

    <div class="ms-5">
        <!--begin::Title-->
        <a href="#" class="text-gray-800 text-hover-primary fs-5 fw-bolder mb-1"
        data-kt-ecommerce-category-filter="category_name" >{{ $row->patient_name }}</a>
        <!--end::Title-->
    </div>
</div>
</td>
<!--end::Category=-->
<!--begin::SKU=-->
<td class="text-end pe-0">
<input type="hidden" name="" id=""  data-kt-ecommerce-category-filter="category_id" value="{{$row->id}}" >
<span class="fw-bolder">{{ $row->clinic->doctor->name ?? '' }}</span>
</td>
<!--end::SKU=-->
<!--begin::Qty=-->
<td class="text-end pe-0" data-order="15">
<span class="fw-bolder ms-3">{{ $row->reservation_date }}</span>
</td>
<!--end::Qty=-->
<td class="text-end pe-0" data-order="15">
<span class="fw-bolder ms-3">{{ $row->time_from }} - {{$row->time_to}}</span>
</td>
<td class="text-end pe-0" data-order="15">
    <span class="fw-bolder ms-3" @if($row->reservation_status_id == 3)  style="color: red;" @elseif($row->reservation_status_id == 2)  style="color: green;" @endif>{{ $row->status->en_status ?? '' }}</span>
</td>
<td class="text-end pe-0">
@if (Auth::guard('admin')->check())
<div class="menu-item px-3">
    <a href="{{ route('admin.show-cancelled-reservation', $row->id) }}"
        class="menu-link px-3"><i class="fa fa-eye" aria-hidden="true"></i></a>
</div>
@else
<div class="menu-item px-3">
    <a href="{{ route('doctor.show-cancelled-reservation', $row->id) }}"
        class="menu-link px-3"><i class="fa fa-eye" aria-hidden="true"></i></a>
</div>
@endif
</td>
</tr>
<!--end::Table row-->
@endforeach


            </tbody>
            <!--end::Table body-->
        </table>
        <!--end::Table-->
    </div>
    <!--end::Card body-->
</div>
<!--end::Category-->
