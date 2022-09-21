@extends('layout.main')

@section('breadcrumb')
    <div class="toolbar" id="kt_toolbar">
        <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                <!--begin::Title-->
                <h1 class="text-dark fw-bolder my-1 fs-2">Organizers</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb fw-bold fs-base my-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="../dist/index.html" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item text-muted">Organizers</li>

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
        <form id="kt_ecommerce_add_category_form" class="form d-flex flex-column flex-lg-row"    action="{{ route('organizers.update', $organizer->id) }}"
            method="post" enctype="multipart/form-data">
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
                        <div class="image-input image-input-empty image-input-outline mb-3"


                            data-kt-image-input="true"
                            style="background-image: url('{{ asset('uploads/organizers') }}/{{ $organizer->img }}')">
                            <div class="image-input-wrapper w-150px h-150px"
                                style="background-image: url(' {{ asset('uploads/organizers') }}/{{ $organizer->img }}')">

                            </div>
                            <!--end::Preview existing avatar-->
                            <!--begin::Edit-->
                            <label
                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="change"
                                data-bs-toggle="tooltip" title="Change avatar">
                                <i class="bi bi-pencil-fill fs-7"></i>
                                <!--begin::Inputs-->
                                <input type="file" name="img"
                                    accept=".png, .jpg, .jpeg" />
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
                            <label class="required form-label">Organize Name</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="name" value="{{ $organizer->name }}" class="form-control mb-2" placeholder="Organize name" value="" />
                            <!--end::Input-->

                        </div>
                        	<!--begin::Tax-->
															<div class="d-flex flex-wrap gap-5">
																<!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root">
                                                                    <label class="required form-label">phone</label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="text" value="{{ $organizer->phone }}" name="phone" class="form-control mb-2" placeholder="phone" value="" />
                                                                    <!--end::Input-->
																</div>
																<!--end::Input group-->
																<!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root">
																	  <!--begin::Label-->
                                                                      <label class="required form-label">Email</label>
                                                                      <!--end::Label-->
                                                                      <!--begin::Input-->
                                                                      <input type="email" value="{{ $organizer->email }}" name="email" class="form-control mb-2" placeholder="email" value="" />
                                                                      <!--end::Input-->
																</div>
																<!--end::Input group-->
															</div>
															<!--end:Tax-->
<!--begin::Tax-->
<div class="d-flex flex-wrap gap-5">
    <!--begin::Input group-->
    <div class="fv-row w-100 flex-md-root">
        <label class="required form-label">Website</label>
        <!--end::Label-->
        <!--begin::Input-->
        <input type="text" name="website" value="{{ $organizer->website }}" class="form-control mb-2" placeholder="website" value="" />
        <!--end::Input-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row w-100 flex-md-root">
          <!--begin::Label-->
          <label class="required form-label">Fb Account</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="fb_account" value="{{ $organizer->fb_account }}" class="form-control mb-2" placeholder="fb account" value="" />
                            <!--end::Input-->
    </div>
    <!--end::Input group-->
</div>
<!--end:Tax-->

                        <!--begin::Input group-->
                        <div>
                            <!--begin::Label-->
                            <label class="form-label">Overview</label>
                            <!--end::Label-->
                            <!--begin::Editor-->
                            <textarea class="form-control form-control-solid" rows="3" name="overview"
                            placeholder="Type Organizer Overview">{{ $organizer->overview }}</textarea>
                            <!--end::Editor-->

                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--end::Card header-->
                </div>
                <!--end::General options-->
                <!--begin::Social options-->
                <div class="card card-flush py-4">
                    <!--begin::Card header-->
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Social links</h2>
                        </div>
                          <!--begin::Row-->

																<div class="row row-cols-1 row-cols-md-3 row-cols-lg-1 row-cols-xl-3 g-9" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button='true']">
																	<!--begin::Col-->
																	<div class="col">
																		<!--begin::Option-->
																		   <!--begin::Label-->
                                                                           <label class="form-label ">Linkedin Account</label>
                                                                           <!--end::Label-->
                                                                           <!--begin::Input-->
                                                                           <input type="text" class="form-control mb-2" value="{{ $organizer->linkedin_account }}" name="linkedin_account" placeholder="Linkedin Account" />
                                                                           <!--end::Input-->
																		<!--end::Option-->
																	</div>
																	<!--end::Col-->
																	<!--begin::Col-->
																	<div class="col">
																		<!--begin::Option-->
																	   <!--begin::Label-->
                                                                       <label class="form-label">Twitter Account</label>
                                                                       <!--end::Label-->
                                                                       <!--begin::Input-->
                                                                       <input type="text" class="form-control mb-2" value="{{ $organizer->twitter_account }}" name="twitter_account" placeholder="Twitter Account" />
                                                                       <!--end::Input-->
																		<!--end::Option-->
																	</div>
																	<!--end::Col-->
																	<!--begin::Col-->
																	<div class="col">
																		<!--begin::Option-->
																	   <!--begin::Label-->
                                                                       <label class="form-label">Youtube Account</label>
                                                                       <!--end::Label-->
                                                                       <!--begin::Input-->
                                                                       <input type="text" class="form-control mb-2" value="{{ $organizer->youtube_account }}" name="youtube_account" placeholder="Youtube Account" />
                                                                       <!--end::Input-->
																		<!--end::Option-->
																	</div>
																	<!--end::Col-->
																</div>
																<!--end::Row-->
                    </div>
                    <!--end::Card header-->


                    <!--end::Card header-->
                </div>
                <!--end::Social options-->

                <div class="d-flex justify-content-end">
                    <!--begin::Button-->
                    <a href="{{ route('organizers.index') }}" id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">Cancel</a>
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
