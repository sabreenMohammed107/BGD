@extends('layout.main')

@section('breadcrumb')
    <div class="toolbar" id="kt_toolbar">
        <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                <!--begin::Title-->
                <h1 class="text-dark fw-bolder my-1 fs-2">Doctors</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb fw-bold fs-base my-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="../dist/index.html" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item text-muted">Doctors</li>

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
                action="{{ route('doctors.store') }}" method="post" enctype="multipart/form-data" >
                @csrf
 <!--begin::Aside column-->
 <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
    <!--begin::Thumbnail settings-->
    <div class="card card-flush py-4">
        <!--begin::Card header-->
        <div class="card-header">
            <!--begin::Card title-->
            <div class="card-title">
                <h2>Image</h2>
            </div>
            <!--end::Card title-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body text-center pt-0">
            <!--begin::Image input-->
            <div class="image-input image-input-empty image-input-outline mb-3" data-kt-image-input="true" style="background-image: url(assets/media/svg/files/blank-image.svg)">
                <!--begin::Preview existing avatar-->
                <div class="image-input-wrapper w-150px h-150px"></div>
                <!--end::Preview existing avatar-->
                <!--begin::Label-->
                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                    <!--begin::Icon-->
                    <i class="bi bi-pencil-fill fs-7"></i>
                    <!--end::Icon-->
                    <!--begin::Inputs-->
                    <input type="file" name="img" accept=".png, .jpg, .jpeg" />
                    <input type="hidden" name="avatar_remove" />
                    <!--end::Inputs-->
                </label>
                <!--end::Label-->
                <!--begin::Cancel-->
                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                    <i class="bi bi-x fs-2"></i>
                </span>
                <!--end::Cancel-->
                <!--begin::Remove-->
                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                    <i class="bi bi-x fs-2"></i>
                </span>
                <!--end::Remove-->
            </div>
            <!--end::Image input-->

        </div>
        <!--end::Card body-->
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
                                <label class="required form-label">  Name</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

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
                                <label class="required form-label">Email</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

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
    <label class="required form-label">mobile</label>
    <!--end::Label-->
    <!--begin::Input-->
    <input type="text" name="mobile" class="form-control mb-2" placeholder="mobile"
        value="" />


</div>
<!--end::Input-->

                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <option value="">Select Medical..</option>
                                    {{-- <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Interviewer who conducts the meeting with the interviewee"></i> --}}
                                </label>
                                <!--end::Label-->
                                <select  class="form-select form-select-solid" name="medical_field_id" data-control="select2"
                                    data-placeholder="Select an option">
                                    <option value=""></option>
                                     @foreach ($medicals as $medical)
                                        <option value="{{ $medical->id }}">{{ $medical->field_enname }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!--end::Input group-->


                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <option value="">Select Position..</option>
                                    {{-- <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Interviewer who conducts the meeting with the interviewee"></i> --}}
                                </label>
                                <!--end::Label-->
                                <select  class="form-select form-select-solid" name="doctor_position_id" data-control="select2"
                                    data-placeholder="Select an option">
                                    <option value=""></option>
                                    @foreach ($positions as $position)
                                        <option value="{{ $position->id }}">{{ $position->en_pasition }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!--end::Input group-->
<!--begin::Input group-->
<div>
    <!--begin::Label-->
    <label class="form-label">En Overview</label>
    <!--end::Label-->
    <!--begin::Editor-->
    <textarea class="form-control form-control-solid" rows="3" name="en_overview"
        placeholder="Type  En Overview"></textarea>
    <!--end::Editor-->

</div>
<!--end::Input group-->
<!--begin::Input group-->
<div>
    <!--begin::Label-->
    <label class="form-label">Dt Overview</label>
    <!--end::Label-->
    <!--begin::Editor-->
    <textarea class="form-control form-control-solid" rows="3" name="dt_overview"
        placeholder="Type  dt Overview"></textarea>
    <!--end::Editor-->

</div>
<!--end::Input group-->

<!--begin::Input group-->
<div>
    <!--begin::Label-->
    <label class="form-label">En Brief</label>
    <!--end::Label-->
    <!--begin::Editor-->
    <textarea class="form-control form-control-solid" rows="3" name="en_brief"
        placeholder="Type En Breif"></textarea>
    <!--end::Editor-->

</div>
<!--end::Input group-->
<!--begin::Input group-->
<div>
    <!--begin::Label-->
    <label class="form-label">dt Breif</label>
    <!--end::Label-->
    <!--begin::Editor-->
    <textarea class="form-control form-control-solid" rows="3" name="dt_brief"
        placeholder="Type dt Breif"></textarea>
    <!--end::Editor-->

</div>
<!--end::Input group-->
<!--begin::Input group-->


                            <!--begin::Input group-->
                            <div class="fv-row w-100 flex-md-root">
                                <label class="required form-label">Password</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                                 <!--begin::Input group-->
                                 <div class="fv-row w-100 flex-md-root">
                                    <label class="required form-label">{{ __('Confirm Password') }}</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">

                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->

	<!--begin::Input group-->
    <div class="fv-row mb-7">
        <!--begin::Label-->
        <label class="fs-6 fw-bold form-label mt-3">
            <span class="required">Add Status</span>
            <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Interviewer who conducts the meeting with the interviewee"></i>
        </label>
        <!--end::Label-->
        <select  class="form-select form-select-solid" name="doctor_status_id" data-control="select2" data-placeholder="Select an option" data-allow-clear="true" >
            <option></option>
            @foreach ($status as $st)
            <option value="{{$st->id}}">{{$st->en_status}}</option>
            @endforeach

        </select>
    </div>
    <!--end::Input group-->








                            <!--begin::checkbox-->

                            <div class="d-flex flex-wrap gap-5 mt-4">
                                <!--begin::Input group-->
                                <div class="fv-row w-100 flex-md-root">
                                    <div class="form-check form-switch form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" name="verified[]" value="1"
                                            id="flexSwitchDefault" />
                                        <label class="form-check-label" for="flexSwitchDefault">
                                            Verfied
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
                        <a href="{{ route('doctors.index') }}" id="kt_ecommerce_add_product_cancel"
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
