@extends (Auth::guard('admin')->check() ? 'layout.main' : 'layout.doctor.main')
@section('breadcrumb')
    <div class="toolbar" id="kt_toolbar">
        <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                <!--begin::Title-->
                <h1 class="text-dark fw-bolder my-1 fs-2">Reservations</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb fw-bold fs-base my-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="#" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item text-muted">Reservations</li>

                    <li class="breadcrumb-item text-dark">All</li>
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Info-->

        </div>
    </div>
@endsection

@section('content')
{{-- <style>
    .dropbtn {
      background-color: #3498DB;
      color: white;
      padding: 16px;
      font-size: 16px;
      border: none;
      cursor: pointer;
    }

    .dropbtn:hover, .dropbtn:focus {
      background-color: #2980B9;
    }

    .dropdown {
         position: inherit !important;
         display: block;


    }

    .dropdown-content {
      display: none;
      /* position: relative; */
      background-color: #f6f6f6;
      min-width: 120px;
      overflow: auto;

      box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
      z-index: 9999999;
    }


    .dropdown-content a {
      padding: 5px 16px;
      text-decoration: none;
      display: block;
    }

    .dropdown a:hover {background-color: #ddd;}

    .show {display: block;}
    </style> --}}
    <!--begin::Post-->
    <div class="post fs-6 d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div class="container-xxl">
            <!--begin::Search Form-->
            <div class="card card-flush">

                <form id="search-form" class="form d-flex flex-column flex-lg-row">
                    <input type="hidden" id="testCheck" name="testCheck"
                        @if (Auth::guard('admin')->check()) value="admin"
                      @else
                      value="doctor" @endif>
                    <div class="card-body pt-0">

                        <!--begin::Input group-->
                        <div class="d-flex flex-wrap gap-5">
                            <!--begin::Input group-->
                            <div class="fv-row w-100 flex-md-root">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <option value=""> Status </option>
                                    {{-- <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Interviewer who conducts the meeting with the interviewee"></i> --}}
                                </label>
                                <!--end::Label-->
                                <select class="form-select form-select-solid" id="status_id" name="status_id"
                                    data-control="select2" data-placeholder="Select an option">
                                    <option value="0">show all</option>
                                    @foreach ($status as $obj)
                                        <option value="{{ $obj->id }}">{{ $obj->en_status }}</option>
                                    @endforeach

                                </select>
                            </div>
                            <!--end::Input group-->
                            <div class="fv-row w-100 flex-md-root">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <option value=""> Sort by</option>
                                    {{-- <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Interviewer who conducts the meeting with the interviewee"></i> --}}
                                </label>
                                <!--end::Label-->
                                <select class="form-select form-select-solid" id="filter_date" name="filter_date"
                                    data-control="select2" data-placeholder=" reservation date ">
                                    <option value=""> reservation date</option>
                                    <option value="1">reservation date : asc </option>
                                    <option value="2">reservation date : desc</option>

                                </select>
                            </div>
                            <!--end::Input group-->
                            <div class="fv-row w-100 flex-md-root mt-5">
                                <button onclick="$('#search-form').submit()" class="btn btn-primary mt-5">
                                    <span class="indicator-label">Filter</span>
                                    <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                            </div>





                        </div>

                    </div>
                </form>
            </div>
            <!--End::Search Form-->
            <!--begin::Category-->
            <div id="preIndex" class="card card-flush">
                <!--begin::Card header-->
                @include('admin.reservation.subAll')



            </div>
            <!--end::Category-->

        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->
@endsection
@section('scripts')
    <script>
        /* When the user clicks on the button,
toggle between hiding and showing the dropdown content */
// function myFunction() {
//   document.getElementById("myDropdown").classList.toggle("show");
// }

// // Close the dropdown if the user clicks outside of it
// window.onclick = function(event) {
//   if (!event.target.matches('.dropbtn')) {
//     var dropdowns = document.getElementsByClassName("dropdown-content");
//     var i;
//     for (i = 0; i < dropdowns.length; i++) {
//       var openDropdown = dropdowns[i];
//       if (openDropdown.classList.contains('show')) {
//         openDropdown.classList.remove('show');
//       }
//     }
//   }
// }
        $('#search-form').on('submit', function(e) {
            var name = $('#testCheck').val();
            if (name == "admin") {
                var url = "{{ route('admin.reservation-filter') }}";

            } else {
                var url = "{{ route('doctor.reservation-filter') }}";
            }
            e.preventDefault();
            $.ajax({
                type: 'GET',
                data: {


                    status_id: $('#status_id option:selected').val(),
                    filter_date: $('#filter_date option:selected').val(),




                },

                url: url,
                success: function(result) {
                    console.log(result)

                    $('#preIndex').html(result);

                    $('#name').val(name);

                    datatable = $('#kt_ecommerce_category_table').DataTable({
                        "info": false,
                        'order': [],
                        'pageLength': 10,
                        'columnDefs': [{
                                orderable: false,
                                targets: 0
                            }, // Disable ordering on column 0 (checkbox)
                            {
                                orderable: false,
                                targets: 3
                            }, // Disable ordering on column 3 (actions)
                        ]
                    });
                    // $(".dropdown-toggle").dropdown();
                    $('.menu-sub-dropdown').get('menu');
                    const filterSearch = document.querySelector(
                        '[data-kt-ecommerce-category-filter="search"]');
                    filterSearch.addEventListener('keyup', function(e) {
                        datatable.search(e.target.value).draw();
                    });




                },
                error: function(request, status, error) {
                    console.log("error")



                }
            });
        });
    </script>
@endsection
