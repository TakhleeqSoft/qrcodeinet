<div id="waiter_call_modal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
    data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">{{ trans('system.call_waiters.customer_waiting') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5 id="waiter_call_modal_text"></h5>
                <p class="mb-1">{{ trans('system.restaurants.title') }}: <span id="waiter_call_modal_restro"></span>
                </p>
                <p class="mb-1">{{ trans('system.tables.menu') }}: <span id="waiter_call_modal_table"></span></p>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<script>
    $(document).on("click", "body", function (t) {
        0 < $(t.target).closest(".right-bar-toggle, .right-bar").length ||
        $("body").removeClass("right-bar-enabled");
    });

    const body = document.querySelector('body');
    lazyload();

    function changedefaultRestaurant(id){
        document.getElementById('restaurant_default_restaurant'+id).submit()
    }

    window.setTimeout(function() {
        $(".success_error_alerts").fadeTo(3000, 0).slideUp(2000, function() {
            $(this).remove();
        });
    }, 8000);

    $(document).on('submit', '.data-confirm', function(e) {
        let that = $(this);
        e.preventDefault();
        alertify.confirm(
            that.data('confirm-message'),
            function() {
                e.currentTarget.submit();
            },
            function() {
                alertify.error('{{ __('system.messages.operation_canceled') }}');
            }
        ).set({
            title: that.data('confirm-title')
        }).set({
            labels: {
                ok: '{{ __('system.crud.confirmed') }}',
                cancel: '{{ __('system.crud.cancel') }}'
            }
        });
    })
</script>
<script>
    function filter(key, that) {
        var url = '{{ request()->url() }}'
        var query = {!! json_encode(request()->query()) !!}

        var
            value = that.val();
        if (value != null) {
            query[key] = value;
        }
        document.location.href = url + "?" + objectToQueryString(query);

    }

    function objectToQueryString(obj) {
        var str = [];
        for (var p in obj)
            if (obj.hasOwnProperty(p)) {
                if (obj[p])
                    str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
            }
        return str.join("&");
    }



    $(document).on('keypress', '.filter-on-enter', function(e) {
        if (e.which == 13) { //Enter key pressed
            var that = $(this)
            filter('filter', that)
        }
    });
    $(document).on('change', '.filter-on-change', function(e) {

        var that = $(this)

        $name = 'par_page';
        if (that)
            $name = that.attr('name');
        filter($name, that)

    });
    $(document).on('click', '.filter-on-click', function(e) {

        var that = $(this)
        $name = that.attr('name');
        filter($name, that)

    });
</script>
<script src="{{ asset('assets/js/app.js') }}"></script>
<script src="{{ asset('assets/cdns/intlTelInput.min.js') }}"></script>
<script>
    var input = document.querySelector("#pristine-phone-valid");

    if (input) {
        iti = window.intlTelInput(input, {
            initialCountry: "auto",
            separateDialCode: true,
            formatOnDisplay: false,
            hiddenInput: "phone_number",
            geoIpLookup: function(callback) {
                $.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
                    var countryCode = (resp && resp.country) ? resp.country : "us";
                    callback(countryCode);
                });
            },

            utilsScript: "{{ asset('assets/js/utils.js') }}" // just for formatting/placeholders etc
        });
        $(input).on('blur', function() {
            var number = iti.getNumber();
            $(document).find("[name=phone_number]:last-child").val(number);
        })
    }
</script>
@php($logged_in_user = auth()->user())
@if ($logged_in_user->user_type != 1)
    <?php
    $pusher_key = $pusher_cluster = null;
    if (!empty($logged_in_user->pusher_setting)) {
        $pusher_key = $logged_in_user->pusher_setting->pusher_key;
        $pusher_cluster = $logged_in_user->pusher_setting->pusher_cluster;
    }
    ?>
    @php($pusher_vendor_id = $logged_in_user->user_type)
    @if (!empty($pusher_key) && !empty($pusher_cluster))
        <script>
            if ($("#vendor_staff_current_restro").length > 0) {
                let vendor_staff_current_restro = $("#vendor_staff_current_restro").val();

                if (vendor_staff_current_restro > 0) {
                    Pusher.logToConsole = false;

                    var pusher = new Pusher('{{ $pusher_key }}', {
                        cluster: '{{ $pusher_cluster }}'
                    });

                    let my_channel = "myrestro_" + vendor_staff_current_restro;
                    let my_event = "myrestro_" + vendor_staff_current_restro;

                    var channel = pusher.subscribe(my_channel);

                    channel.bind(my_event, function(data) {
                        console.log(data.message + "--" + data.table + "--" + data.restaurant);
                        $("#waiter_call_modal_text").text(data.message);
                        $("#waiter_call_modal_table").text(data.table);
                        $("#waiter_call_modal_restro").text(data.restaurant);
                        $("#waiter_call_modal").modal('show');
                    });
                }
            }
        </script>
    @endif
@endif
