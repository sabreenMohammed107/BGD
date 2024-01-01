<!--begin::Javascript-->
<script>
    var hostUrl ='{{asset('assets/')}}';
</script>
{{-- <script>
    var hostUrl = "../assets/";
</script> --}}
<!--begin::Global Javascript Bundle(used by all pages)-->


<script src="{{asset('dist/assets/plugins/global/plugins.bundle.js')}}"></script>
<script src="{{asset('dist/assets/js/scripts.bundle.js')}}"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Page Vendors Javascript(used by this page)-->
<script src="{{asset('dist/assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<!--end::Page Vendors Javascript-->
<!--begin::Page Custom Javascript(used by this page)-->
<script src="{{asset('dist/assets/js/custom/apps/ecommerce/catalog/categories.js')}}"></script>
<script src="{{asset('dist/assets/js/custom/apps/projects/users/users.js')}}"></script>

<script src="{{asset('dist/assets/plugins/custom/formrepeater/formrepeater.bundle.js')}}"></script>
<!--end::Page Vendors Javascript-->


<!--end::Page Vendors Javascript-->
<!--begin::Page Custom Javascript(used by this page)-->
<script src="{{asset('dist/assets/js/custom/apps/ecommerce/catalog/save-product.js')}}"></script>

<!--begin::Page Custom Javascript(used by this page)-->
<script src="{{asset('dist/assets/js/custom/apps/ecommerce/catalog/save-category.js')}}"></script>
<!--begin::Page Custom Javascript(used by this page)-->

<script src="{{asset('dist/assets/js/widgets.bundle.js')}}"></script>
<script src="{{asset('dist/assets/js/custom/widgets.js')}}"></script>
<script src="{{asset('dist/assets/js/custom/apps/chat/chat.js')}}"></script>
<script src="{{asset('dist/assets/js/custom/utilities/modals/upgrade-plan.js')}}"></script>
<script src="{{asset('dist/assets/js/custom/utilities/modals/create-project/type.js')}}"></script>
<script src="{{asset('dist/assets/js/custom/utilities/modals/create-project/budget.js')}}"></script>
<script src="{{asset('dist/assets/js/custom/utilities/modals/create-project/settings.js')}}"></script>
<script src="{{asset('dist/assets/js/custom/utilities/modals/create-project/team.js')}}"></script>
<script src="{{asset('dist/assets/js/custom/utilities/modals/create-project/targets.js')}}"></script>
<script src="{{asset('dist/assets/js/custom/utilities/modals/create-project/files.js')}}"></script>
<script src="{{asset('dist/assets/js/custom/utilities/modals/create-project/complete.js')}}"></script>
<script src="{{asset('dist/assets/js/custom/utilities/modals/create-project/main.js')}}"></script>
<script src="{{asset('dist/assets/js/custom/utilities/modals/users-search.js')}}"></script>
<script src="{{asset('dist/assets/js/custom/utilities/modals/new-target.js')}}"></script>

<script>
    $(function() {
function loadLink(){
    $('.count').text({{count(Auth::guard('doctor')->user()->unreadNotifications ) }});
console.log($('.count').text());
}
setInterval(function() {
    // loadRequest();
    loadRequest();

    }, 30000);


    $('.mark-as-read').click(function() {
                var request = sendRequest($(this).data('id'));
                loadRequest();
                // request.done(() => {
                //     $(this).parents('.main-cls').remove();
                // });
                // $('.count').text({{count(Auth::guard('doctor')->user()->unreadNotifications ) }}-1);
            });

            $('#mark-all').click(function() {
                var request = sendRequest();
                request.done(() => {
                    $('.main-cls').remove();
                })
                $('.count').text(0);
            });
        });

        function sendRequest(id = null) {
            var _token = "{{ csrf_token() }}";
            return $.ajax("{{ route('markAsNotification') }}", {
                method: 'POST',
                data: {_token, id}
            });
        }
        function loadRequest(id = null) {
            // return $.ajax("{{ route('getRefreshNotification') }}", {
            //     method: 'get',
            //     data: {id}
            // });


            $.ajax({
                    type: 'GET',
                    data: {id},
                    url: "{{ route('getRefreshNotification') }}",

                    success: function(data) {
                        var result = $.parseJSON(data);
                        console.log(result[1]);
                        $('.count').text(result[0]);

                        var dd=``;
                        const markAllRead ='<a href="{{route("markAllRead")}}" id="mark-all" style="padding-left: 10px">Mark all as read</a>';
                        const noData ='<p>There are no new notifications.</p>';
                        // ${prettyDate(notification.created_at) =='undefined' ? prettyDate(notification.created_at) : notification.created_at}

                        const notifications =result[1];
                        for(let notification of result[1]){
                            var xx= notification.id;
                        dd +=`<div class="alert main-cls mb-0" style="border-bottom: 1px solid #ccc">
                             <div>
                                    <i class="fa fa-bell text-primary"></i>
                                    <div class="float-end" style="color:#7c7c7c">
                                        ${prettyDate(notification.created_at)}
                                        </div>
                                </div>
                                <p class="m-0">

                                    ${notification.data['name']}
                                    ${notification.data['body']}

                                </p>
                                <p class="m-0">
                                    ${notification.data['date']} -   ${notification.data['time']}
                                </p>
                                <a style="color:#000;text-decoration:underline"
                                    href="${notification.data['reservUrl']}">click here to show </a>
                                <div>
                                    <div class="float-end">
                                        <a href="#" class="mark-as-read"  onclick="markRead(this); return false;" data-id="${notification.id}" >Mark as
                                            read </a>
                                    </div>
                                </div>
</div>

                        `;
                        };
                        if(notifications.length > 0){
                            dd += `<a href="{{route("markAllRead")}}" id="mark-all" style="padding-left: 10px">Mark all as read</a>`;
                        }else{
                            dd += `<p>There are no new notifications.</p>`;
                        }

                        $('#main-cls').html(dd);
                        console.log(dd);
                    },
                    error: function(request, status, error) {
                        $('.count').text(0);

                    }
                });
        }

        function markRead(obj) {
            var id = obj.getAttribute('data-id');
    console.log(id);
            var request = sendRequest(id);
            loadRequest();

                // request.done(() => {
                //     $(this).parents('.main-cls').remove();
                // });
                // $('.count').text({{count(Auth::guard('doctor')->user()->unreadNotifications ) }}-1);
            };

        function prettyDate(time){
	var date = new Date((time || "").replace(/-/g,"/").replace(/[TZ]/g," ")),
		diff = (((new Date()).getTime() - date.getTime()) / 1000),
		day_diff = Math.floor(diff / 86400);

	if ( isNaN(day_diff) || day_diff < 0 || day_diff >= 31 )
		return;

	return day_diff == 0 && (
			diff < 60 && "just now" ||
			diff < 120 && "1 minute ago" ||
			diff < 3600 && Math.floor( diff / 60 ) + " minutes ago" ||
			diff < 7200 && "1 hour ago" ||
			diff < 86400 && Math.floor( diff / 3600 ) + " hours ago") ||
		day_diff == 1 && "Yesterday" ||
		day_diff < 7 && day_diff + " days ago" ||
		day_diff < 31 && Math.ceil( day_diff / 7 ) + " weeks ago";
}
if ( typeof jQuery != "undefined" )
	jQuery.fn.prettyDate = function(){
		return this.each(function(){
			var date = prettyDate(this.title);
			if ( date )
				jQuery(this).text( date );
		});
	};
</script>
@yield('scripts')
<!--end::Page Custom Javascript-->
<!--end::Javascript-->
