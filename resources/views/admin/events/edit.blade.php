@extends('layout.main')

@section('breadcrumb')
    <div class="toolbar" id="kt_toolbar">
        <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                <!--begin::Title-->
                <h1 class="text-dark fw-bolder my-1 fs-2">Events</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb fw-bold fs-base my-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="../dist/index.html" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item text-muted">Events</li>

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
                action="{{ route('events.update', $event->id) }}" method="post" enctype="multipart/form-data">
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
                                <h2> Edit Thumbnail</h2>
                            </div>
                            <!--end::Card title-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Image input wrapper-->
                        <div class="card-body text-center pt-0">
                            <!--begin::Image input-->
                            <div class="image-input image-input-empty image-input-outline mb-3" data-kt-image-input="true"
                                style="background-image: url('{{ asset('uploads/events') }}/{{ $event->img }}')">
                                <div class="image-input-wrapper w-150px h-150px"
                                    style="background-image: url(' {{ asset('uploads/events') }}/{{ $event->img }}')">

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
                <!--begin::Main column-->
                <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                    <!--begin:::Tabs-->
                    <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-n2">
                        <!--begin:::Tab item-->
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                                href="#kt_ecommerce_add_product_general">General</a>
                        </li>
                        <!--end:::Tab item-->
                        <!--begin:::Tab item-->
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                                href="#kt_ecommerce_add_product_advanced">Specialization</a>
                        </li>
                        <!--end:::Tab item-->

                         <!--begin:::Tab item-->
                         <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                                href="#kt_ecommerce_add_days_advanced">Days</a>
                        </li>
                        <!--end:::Tab item-->
                    </ul>
                    <!--end:::Tabs-->
                    <!--begin::Tab content-->
                    <div class="tab-content">
                        <!--begin::Tab pane-->
                        <div class="tab-pane fade show active" id="kt_ecommerce_add_product_general" role="tab-panel">
                            <div class="d-flex flex-column gap-7 gap-lg-10">
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
                                            <label class="required form-label">Event Name</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" name="name" class="form-control mb-2"
                                                placeholder="Event name" value="{{ $event->name }}" />


                                        </div>
                                        <!--end::Input-->



                                        <!--begin::Input group-->
                                        <div class="fv-row mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <option value="">Select City..</option>
                                                {{-- <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Interviewer who conducts the meeting with the interviewee"></i> --}}
                                            </label>
                                            <!--end::Label-->
                                            <select class="form-select form-select-solid" name="city_id"
                                                data-control="select2" data-placeholder="Select an option">
                                                <option value=""></option>
                                                @foreach ($cities as $city)
                                                    <option value="{{ $city->id }}"
                                                        {{ $event->city_id == $city->id ? 'selected' : '' }}>
                                                        {{ $city->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!--end::Input group-->


                                        <!--begin::Input group-->
                                        <div class="fv-row mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <option value="">Select Organizer..</option>
                                                {{-- <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Interviewer who conducts the meeting with the interviewee"></i> --}}
                                            </label>
                                            <!--end::Label-->
                                            <select class="form-select form-select-solid" name="organizer_id"
                                                data-control="select2" data-placeholder="Select an option">
                                                <option value=""></option>
                                                @foreach ($organizers as $organizer)
                                                    <option value="{{ $organizer->id }}"
                                                        {{ $event->organizer_id == $organizer->id ? 'selected' : '' }}>
                                                        {{ $organizer->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!--end::Input group-->


                                        <!--begin::Input group-->
                                        <div class="fv-row w-100 flex-md-root">
                                            <label class="required form-label">Event Fees</label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <input type="text" name="event_fees" class="form-control mb-2"
                                                placeholder="event_fees" value="{{ $event->event_fees }}" />
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->

                                        <!--begin::Input group-->
                                        <div class="fv-row mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span class="required">Add Medicine Fields</span>
                                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                                                    title="Interviewer who conducts the meeting with the interviewee"></i>
                                            </label>
                                            <!--end::Label-->
                                            <select class="form-select form-select-solid" name="medicines[]"
                                                data-control="select2" data-placeholder="Select an option"
                                                data-allow-clear="true" multiple="multiple">
                                                <option></option>
                                                @foreach ($medicines as $field)
                                                    <option value="{{ $field->id }}"
                                                        @foreach ($eventMedicines as $sublist) {{ $sublist->pivot->medicine_field_id == $field->id ? 'selected' : '' }} @endforeach>
                                                        {{ $field->field_enname }}
                                                    </option>
                                                @endforeach



                                            </select>
                                        </div>
                                        <!--end::Input group-->

                                        <!--begin::Input group-->
                                        <div class="fv-row mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span class="required">Add Categories</span>
                                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                                                    title="Interviewer who conducts the meeting with the interviewee"></i>
                                            </label>
                                            <!--end::Label-->
                                            <select class="form-select form-select-solid" name="categories[]"
                                                data-control="select2" data-placeholder="Select an option"
                                                data-allow-clear="true" multiple="multiple">
                                                <option></option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        @foreach ($eventcategories as $sublist) {{ $sublist->pivot->category_id == $category->id ? 'selected' : '' }} @endforeach>
                                                        {{ $category->category_enname }}
                                                    </option>
                                                @endforeach


                                            </select>
                                        </div>
                                        <!--end::Input group-->

                                        <!--begin::Input group-->
                                        <div class="fv-row mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span class="required">Add Tags</span>
                                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                                                    title="Interviewer who conducts the meeting with the interviewee"></i>
                                            </label>
                                            <!--end::Label-->
                                            <select class="form-select form-select-solid" name="tags[]"
                                                data-control="select2" data-placeholder="Select an option"
                                                data-allow-clear="true" multiple="multiple">
                                                <option></option>
                                                @foreach ($tags as $tag)
                                                    <option value="{{ $tag->id }}"
                                                        @foreach ($eventTags as $sublist) {{ $sublist->pivot->tag_id == $tag->id ? 'selected' : '' }} @endforeach>
                                                        {{ $tag->tag }}
                                                    </option>
                                                @endforeach


                                            </select>
                                        </div>
                                        <!--end::Input group-->

                                        <!--begin::Input group-->
                                        <div>
                                            <!--begin::Label-->
                                            <label class="form-label">Overview</label>
                                            <!--end::Label-->
                                            <!--begin::Editor-->
                                            <textarea class="form-control form-control-solid" rows="3" name="event_overview"
                                                placeholder="Type Organizer Overview">{{ $event->event_overview }}</textarea>
                                            <!--end::Editor-->

                                        </div>
                                        <!--end::Input group-->





                                        <!--begin::checkbox-->

                                        <div class="d-flex flex-wrap gap-5 mt-4">
                                            <!--begin::Input group-->
                                            <div class="fv-row w-100 flex-md-root">
                                                <div class="form-check form-switch form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" name="featured"
                                                        value="" {{ $event->featured == 1 ? ' checked' : '' }}
                                                        id="flexSwitchDefault" />
                                                    <label class="form-check-label" for="flexSwitchDefault">
                                                        Featured
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div class="fv-row w-100 flex-md-root">
                                                <div class="form-check form-switch form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" name="premium"
                                                        value="" {{ $event->premium == 1 ? ' checked' : '' }}
                                                        id="flexSwitchDefault" />
                                                    <label class="form-check-label" for="flexSwitchDefault">
                                                        Premium
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
                        <!--end::Tab pane-->
                        <!--begin::Tab pane-->
                        <div class="tab-pane fade" id="kt_ecommerce_add_product_advanced" role="tab-panel">
                            <div class="d-flex flex-column gap-7 gap-lg-10">

                                <!--begin::Variations-->
                                <div class="card card-flush py-4">
                                    <!--begin::Card header-->
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h2>Specialization</h2>
                                        </div>
                                    </div>
                                    <!--end::Card header-->
                                    <!--begin::Card body-->
                                    <div class="card-body pt-0">
                                        <!--begin::Input group-->
                                        <div class="" data-kt-ecommerce-catalog-add-product="auto-options">
                                            <!--begin::Label-->
                                            <label class="form-label">Add Specialization</label>
                                            <!--end::Label-->


                                            <!--begin::Repeater-->
                                            <div id="kt_ecommerce_add_product_options">


                                                <!--begin::Form group-->
                                                <div class="form-group">
                                                    <div data-repeater-list="kt_ecommerce_add_product_options"
                                                        class="d-flex flex-column gap-3">
                                                        @if ($eventSpecialzation->count()>0)
                                                        @foreach ($eventSpecialzation as $index=>$specialList)
                                                        <div data-repeater-item=""
                                                            class="form-group d-flex flex-wrap gap-5">
                                                            <!--begin::Select2-->
                                                            <div class="w-100 w-md-200px">
                                                                <select class="form-select" name="specialize_id"
                                                                    data-placeholder="Select a variation"
                                                                    data-kt-ecommerce-catalog-add-product="product_option">
                                                                    <option></option>
                                                                    @foreach ($specialzations as $specialzation)
                                                                    <option value="{{$specialzation->id}}" {{ $specialList->specialize_id == $specialzation->id ? 'selected' : '' }} >{{$specialzation->specialize_name}}</option>
                                                                    @endforeach

                                                                </select>
                                                            </div>
                                                            <!--end::Select2-->
                                                            <!--begin::Input-->
                                                            <input type="text" class="form-control mw-100 w-200px"
                                                                name="fees" value="{{$specialList->fees}}" placeholder="Fees" />
                                                            <!--end::Input-->
                                                            <button type="button" data-repeater-delete=""
                                                                class="btn btn-sm btn-icon btn-light-danger">
                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr088.svg-->
                                                                <span class="svg-icon svg-icon-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24"
                                                                        fill="none">
                                                                        <rect opacity="0.5" x="7.05025"
                                                                            y="15.5356" width="12" height="2"
                                                                            rx="1"
                                                                            transform="rotate(-45 7.05025 15.5356)"
                                                                            fill="black" />
                                                                        <rect x="8.46447" y="7.05029"
                                                                            width="12" height="2" rx="1"
                                                                            transform="rotate(45 8.46447 7.05029)"
                                                                            fill="black" />
                                                                    </svg>
                                                                </span>
                                                                <!--end::Svg Icon-->
                                                            </button>
                                                        </div>
                                                        @endforeach
                                                        @else

                                                        <div data-repeater-item=""
                                                            class="form-group d-flex flex-wrap gap-5">
                                                            <!--begin::Select2-->
                                                            <div class="w-100 w-md-200px">
                                                                <select class="form-select" name="specialize_id"
                                                                    data-placeholder="Select a variation"
                                                                    data-kt-ecommerce-catalog-add-product="product_option">
                                                                    <option></option>
                                                                    @foreach ($specialzations as $specialzation)
                                                                    <option value="{{$specialzation->id}}"  >{{$specialzation->specialize_name}}</option>
                                                                    @endforeach

                                                                </select>
                                                            </div>
                                                            <!--end::Select2-->
                                                            <!--begin::Input-->
                                                            <input type="text" class="form-control mw-100 w-200px"
                                                                name="fees" value="" placeholder="Fees" />
                                                            <!--end::Input-->
                                                            <button type="button" data-repeater-delete=""
                                                                class="btn btn-sm btn-icon btn-light-danger">
                                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr088.svg-->
                                                                <span class="svg-icon svg-icon-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24"
                                                                        fill="none">
                                                                        <rect opacity="0.5" x="7.05025"
                                                                            y="15.5356" width="12" height="2"
                                                                            rx="1"
                                                                            transform="rotate(-45 7.05025 15.5356)"
                                                                            fill="black" />
                                                                        <rect x="8.46447" y="7.05029"
                                                                            width="12" height="2" rx="1"
                                                                            transform="rotate(45 8.46447 7.05029)"
                                                                            fill="black" />
                                                                    </svg>
                                                                </span>
                                                                <!--end::Svg Icon-->
                                                            </button>
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
                                                        <!--end::Svg Icon-->Add another Specialzation
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
                                        <div class="" >
                                            <!--begin::Label-->
                                            <label class="form-label">Add Day</label>
                                            <!--end::Label-->


                                            <!--begin::Repeater-->
                                            <div id="kt_docs_repeater_basic">


                                                <!--begin::Form group-->
                                                <div class="form-group">
                                                    <div data-repeater-list="kt_docs_repeater_basic"
                                                        class="d-flex flex-column gap-3">
                                                        @if ($eventDays->count()>0)
                                                        @foreach ($eventDays as $index=>$eventDay)
                                                        <div data-repeater-item>
                                                            <div class="form-group row">
                                                                <div class="col-md-4">
                                                                    <label class="form-label">Date From:</label>
                                                                    <input  class="form-control  form-control-solid dPick"   name="event_date_from" value="{{$eventDay->event_date_from}}" placeholder="Pick date & time" id="kt_datepicker_3"/>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label  class="form-label">Date To:</label>
                                                                    <input  class="form-control form-control-solid dPick"  name="event_date_to" value="{{$eventDay->event_date_to}}" placeholder="Pick date & time" id="kt_datepicker_4"/>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger mt-3 mt-md-8">
                                                                        <i class="la la-trash-o"></i>Delete
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                        @else
                                                        <div data-repeater-item>
                                                            <div class="form-group row">
                                                                <div class="col-md-4">
                                                                    <label class="form-label">Date From:</label>
                                                                    <input class="form-control form-control-solid dPick" name="event_date_from" placeholder="Pick date & time" id="kt_datepicker_3"/>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label">Date To:</label>
                                                                    <input class="form-control form-control-solid dPick" name="event_date_to" placeholder="Pick date & time" id="kt_datepicker_4"/>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger mt-3 mt-md-8">
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




                    </div>
                    <!--end::Tab content-->
                    <div class="d-flex justify-content-end">
                        <!--begin::Button-->
                        <a href="{{ route('events.index') }}" id="kt_ecommerce_add_product_cancel"
                            class="btn btn-light me-5">Cancel</a>
                        <!--end::Button-->
                        <!--begin::Button-->
                        <button type="submit" id="kt_ecommerce_add_product_submit" class="btn btn-primary">
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
    <script>
    $(".dPick").flatpickr({
    enableTime: true,
    dateFormat: "Y-m-d H:i",
});
    </script>
@endsection
