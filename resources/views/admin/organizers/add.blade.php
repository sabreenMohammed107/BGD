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
        <form id="kt_ecommerce_add_category_form" class="form d-flex flex-column flex-lg-row" action="{{ route('organizers.store') }}"
        method="post" enctype="multipart/form-data">
        @csrf
            <!--begin::Aside column-->
            <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
                <!--begin::Thumbnail settings-->
                <div class="card card-flush py-4">
                    <!--begin::Card header-->
                    <div class="card-header">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <h2>Thumbnail</h2>
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
                            <label class="required form-label">Organize Name</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="name" class="form-control mb-2" placeholder="Organize name" value="" />
                            <!--end::Input-->

                        </div>
                        	<!--begin::Tax-->
															<div class="d-flex flex-wrap gap-5">
																<!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root">
                                                                    <label class="required form-label">phone</label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="text" name="phone" class="form-control mb-2" placeholder="phone" value="" />
                                                                    <!--end::Input-->
																</div>
																<!--end::Input group-->
																<!--begin::Input group-->
																<div class="fv-row w-100 flex-md-root">
																	  <!--begin::Label-->
                                                                      <label class="required form-label">Email</label>
                                                                      <!--end::Label-->
                                                                      <!--begin::Input-->
                                                                      <input type="email" name="email" class="form-control mb-2" placeholder="email" value="" />
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
        <input type="text" name="website" class="form-control mb-2" placeholder="website" value="" />
        <!--end::Input-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row w-100 flex-md-root">
          <!--begin::Label-->
          <label class="required form-label">Fb Account</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="fb_account" class="form-control mb-2" placeholder="fb account" value="" />
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
                            placeholder="Type Organizer Overview"></textarea>
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
                                                                           <input type="text" class="form-control mb-2" name="linkedin_account" placeholder="Linkedin Account" />
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
                                                                       <input type="text" class="form-control mb-2" name="twitter_account" placeholder="Twitter Account" />
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
                                                                       <input type="text" class="form-control mb-2" name="youtube_account" placeholder="Youtube Account" />
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
