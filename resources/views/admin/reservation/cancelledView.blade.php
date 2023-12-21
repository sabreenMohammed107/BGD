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
            action="{{ route('doctors.update', $row->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
 <!--begin::Aside column-->
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
                                    <input type="file" name="img" accept=".png, .jpg, .jpeg" />
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
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <!--begin::Input group-->
                            <div class="mb-10 fv-row">
                                <!--begin::Label-->
                                <label class=" form-label"> Patient Name</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input id="name" type="text" class="form-control " name="name" value="{{$row->patient_name}}"  autocomplete="name" autofocus>


                            </div>
                            <!--end::Input-->

                               <!--begin::Input group-->
                               <div class="mb-10 fv-row">
                                <!--begin::Label-->
                                <label class=" form-label"> Patient Mobile</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input id="mobile" type="text" class="form-control " name="patient_mobile"  @if ( $row->other_flag == 1)
                                value="{{$row->patient_mobile}}"
                                 @else
                                 value="{{$row->patient->mobile ?? ''}}"
                                @endif  autocomplete="mobile">




                            </div>
                            <!--end::Input-->

 <!--begin::Input group-->
 <div class="mb-10 fv-row">
    <!--begin::Label-->
    <label class=" form-label">address</label>
    <!--end::Label-->
    <!--begin::Input-->
    <input type="text" name="address"  @if ( $row->other_flag == 1)
    value="{{$row->patient_address}}"
                                 @else
                                 value="{{$row->patient->details_address ?? ''}}"
                                @endif class="form-control mb-2" placeholder="address"
        value="" />


</div>
<!--end::Input-->
<div class="mb-10 fv-row">
    <!--begin::Label-->
    <label class=" form-label">User</label>
    <!--end::Label-->
    <!--begin::Input-->
    <input type="text" name="User" value="{{$row->patient->name ?? ''}}" class="form-control mb-2" placeholder="User"
        value="" />


</div>

     <!--end::Input-->
<div class="mb-10 fv-row">
    <!--begin::Label-->
    <label class=" form-label">Date</label>
    <!--end::Label-->
    <!--begin::Input-->
    <input type="text" name="mobile" value="{{$row->reservation_date}}" class="form-control mb-2" placeholder="mobile"
        value="" />


</div>

     <!--end::Input-->
     <div class="mb-10 fv-row">
        <!--begin::Label-->
        <label class=" form-label">Time</label>
        <!--end::Label-->
        <!--begin::Input-->
        <input type="text" name="mobile" value="{{$row->time_from}} - {{$row->time_to}}" class="form-control mb-2" placeholder="mobile"
            value="" />


    </div>

<!--begin::Input group-->
<div>
    <!--begin::Label-->
    <label class="form-label">Notes</label>
    <!--end::Label-->
    <!--begin::Editor-->
    <textarea class="form-control form-control-solid" rows="3" name="en_overview"
        placeholder="Type  En Overview">{{$row->notes}}</textarea>
    <!--end::Editor-->

</div>
<!--end::Input group-->












                            <!--begin::checkbox-->

                            <div class="d-flex flex-wrap gap-5 mt-4">
                                <!--begin::Input group-->
                                <div class="fv-row w-100 flex-md-root">
                                    <div class="form-check form-switch form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" name="verified[]" value="1"
                                            id="flexSwitchDefault" {{ $row->other_flag == 1 ? ' checked' : '' }} />
                                        <label class="form-check-label" for="flexSwitchDefault">
                                            Another Person
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

                    @if(Auth::guard('admin')->check())
                    <div class="d-flex justify-content-end">
                        <!--begin::Button-->
                        <a href="{{ route('admin.cancelled-reservations') }}" id="kt_ecommerce_add_product_cancel"
                            class="btn btn-light me-5">Cancel</a>
                        <!--end::Button-->
                        <!--begin::Button-->

                        <!--end::Button-->
                    </div>
                    @else
                    <div class="d-flex justify-content-end">
                        <!--begin::Button-->
                        <a href="{{ route('doctor.cancelled-reservations') }}" id="kt_ecommerce_add_product_cancel"
                            class="btn btn-light me-5">Cancel</a>
                        <!--end::Button-->
                        <!--begin::Button-->

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
