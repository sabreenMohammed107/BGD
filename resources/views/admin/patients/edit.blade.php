@extends('layout.main')

@section('breadcrumb')
    <div class="toolbar" id="kt_toolbar">
        <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                <!--begin::Title-->
                <h1 class="text-dark fw-bolder my-1 fs-2">Patient</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb fw-bold fs-base my-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="../dist/index.html" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item text-muted">Patient</li>


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
            <form id="kt_ecommerce_add_category_form" class="form d-flex flex-column flex-lg-row" action="#"
                enctype="multipart/form-data">

                <input type="hidden" name="id" value="{{ $row->id }}">
                {{-- <!--begin::Aside column-->
                <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
                    <!--begin::Thumbnail settings-->
                    <div class="card card-flush py-4">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <h2> Thumbnail</h2>
                            </div>
                            <!--end::Card title-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Image input wrapper-->
                        <div class="card-body text-center pt-0">
                            <!--begin::Image input-->
                            <div class="image-input image-input-empty image-input-outline mb-3" data-kt-image-input="true"
                                style="background-image: url('{{ asset('uploads/doctors') }}/{{ $row->image }}')">
                                <div class="image-input-wrapper w-150px h-150px"
                                    style="background-image: url(' {{ asset('uploads/doctors') }}/{{ $row->image }}')">

                                </div>
                                <!--end::Preview existing avatar-->
                                <!--begin::Edit-->
                                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                                    <i class="bi bi-pencil-fill fs-7"></i>
                                    <!--begin::Inputs-->
                                    <input type="file" name="image" accept=".png, .jpg, .jpeg" />
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
                <!--end::Aside column--> --}}
                <!--begin::Main column-->
                <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                    <!--begin::General options-->
                    <div class="card card-flush py-4">
                        <!--begin::Card header-->
                        <div class="card-header">
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
                                        href="#kt_ecommerce_add_days_advanced">Reservations</a>
                                </li>
                            </ul>
                        </div>
                        <!--end::Card header-->
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="kt_ecommerce_add_product_general" role="tab-panel">
                                <div class="d-flex flex-column gap-7 gap-lg-10">


                                    <div class="card card-flush py-4">
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <!--begin::Input group-->
                            <div class="mb-10 fv-row">
                                <!--begin::Label-->
                                <label class=" form-label"> Name</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input id="name" type="text"
                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                    value="{{ $row->name }}" autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror


                            </div>
                            <!--end::Input-->

                            <!--begin::Input group-->
                            <div class="mb-10 fv-row">
                                <!--begin::Label-->
                                <label class=" form-label">Email</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ $row->email }}" autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror


                            </div>
                            <!--end::Input-->

                            <!--begin::Input group-->
                            <div class="mb-10 fv-row">
                                <!--begin::Label-->
                                <label class=" form-label">mobile</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="mobile" value="{{ $row->mobile }}" class="form-control mb-2"
                                    placeholder="mobile" value="" />


                            </div>
                            <!--end::Input-->

                            <!--begin::Input group-->
                            <div class="mb-10 fv-row">
                                <!--begin::Label-->
                                <label class=" form-label">Date Of Birth</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="birth_date" value="{{ $row->birth_date }}"
                                    class="form-control mb-2" placeholder="birth_date" value="" />


                            </div>
                            <!--end::Input-->



                            <!--begin::Input group-->
                            <div>
                                <!--begin::Label-->
                                <label class="form-label">Zip Code</label>
                                <!--end::Label-->
                                <!--begin::Editor-->
                                <textarea class="form-control form-control-solid" rows="3" name="details_address" placeholder="Type ">{{ $row->details_address }}</textarea>
                                <!--end::Editor-->

                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div>
                                <!--begin::Label-->
                                <label class="form-label">google_map</label>
                                <!--end::Label-->
                                <!--begin::Editor-->
                                <textarea class="form-control form-control-solid" rows="3" name="google_map" placeholder="Type">{{ $row->google_map }}</textarea>
                                <!--end::Editor-->

                            </div>
                            <!--end::Input group-->


                            <!--begin::Input group-->










                            <!--begin::checkbox-->

                            <div class="d-flex flex-wrap gap-5 mt-4">
                                <!--begin::Input group-->
                                <div class="fv-row w-100 flex-md-root">
                                    <div class="form-check form-switch form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" name="gender[]" value="1"
                                            id="flexSwitchDefault" {{ $row->gender == 'f' ? ' checked' : '' }} />
                                        <label class="form-check-label" for="flexSwitchDefault">
                                            Female
                                        </label>
                                    </div>
                                </div>
                                <!--end::Input group-->


                                <!--begin::Input group-->
                                <div class="fv-row w-100 flex-md-root">
                                    <div class="form-check form-switch form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" name="gender[]" value="1"
                                            id="flexSwitchDefault" {{ $row->gender == 'm' ? ' checked' : '' }} />
                                        <label class="form-check-label" for="flexSwitchDefault">
                                            Male
                                        </label>
                                    </div>
                                </div>
                                <!--end::Input group-->

                            </div>
                            <!--end:checkbox-->

                        </div>
                        <!--end::Card header-->
                                    </div>
                                </div>
                            </div>
                            {{-- tab 2222222222222222 --}}

                    <!--end::General options-->
                    <div class="tab-pane fade" id="kt_ecommerce_add_days_advanced" role="tab-panel">
                        <div class="d-flex flex-column gap-7 gap-lg-10">


                            <div class="card card-flush py-4">
                <!--begin::Card body-->
                <div class="card-body pt-0">
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
                                                <a href="#"
                                                    class="text-gray-800 text-hover-primary fs-5 fw-bolder mb-1"
                                                    data-kt-ecommerce-category-filter="category_name">{{ $row->patient_name }}</a>
                                                <!--end::Title-->
                                            </div>
                                        </div>
                                    </td>
                                    <!--end::Category=-->
                                    <!--begin::SKU=-->
                                    <td class="text-end pe-0">
                                        <input type="hidden" name="" id=""
                                            data-kt-ecommerce-category-filter="category_id" value="{{ $row->id }}">
                                        <span class="fw-bolder">{{ $row->clinic->doctor->name ?? '' }}</span>
                                    </td>
                                    <!--end::SKU=-->
                                    <!--begin::Qty=-->
                                    <td class="text-end pe-0" data-order="15">
                                        <span class="fw-bolder ms-3">{{ $row->reservation_date }}</span>
                                    </td>
                                    <!--end::Qty=-->
                                    <td class="text-end pe-0" data-order="15">
                                        <span class="fw-bolder ms-3">{{ $row->time_from }} - {{ $row->time_to }}</span>
                                    </td>
                                    <td class="text-end pe-0" data-order="15">
                                        <span class="fw-bolder ms-3" @if($row->reservation_status_id ==3)  style="color: red;" @elseif($row->reservation_status_id ==2)  style="color: green;" @endif>{{ $row->status->en_status ?? '' }}</span>
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
                            </div>
                        </div>
                    </div>

{{-- end tab --}}
                    </div>

                    <div class="d-flex justify-content-end">
                        <!--begin::Button-->
                        <a href="{{ route('doctor-profile', $row->id) }}" id="kt_ecommerce_add_product_cancel"
                            class="btn btn-light me-5">Cancel</a>
                        <!--end::Button-->
                        {{-- <!--begin::Button-->
                        <button type="submit" id="kt_ecommerce_add_category_submit" class="btn btn-primary">
                            <span class="indicator-label">Save Changes</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button> --}}
                        <!--end::Button-->
                    </div>
                </div></div>
                <!--end::Main column-->
            </form>
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->
@endsection
