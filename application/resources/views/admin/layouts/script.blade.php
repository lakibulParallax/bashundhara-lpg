<script>
    var hostUrl = "assets/";
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', '.delete', function() {
            var i = $(this).data('i');
            $("#frmDel input[name='id']").val(i);
            $("#modalDel").modal('show');
        });
    });
    $(document).ready(function () {
        // Initialize Select2 for your <select> element
        $('select[data-control="select2"]').select2();
    });
</script>
<script>
    $("#kt_daterangepicker_3").daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 1901,
            maxYear: parseInt(moment().format("YYYY"),12)
        }, function(start, end, label) {
            var years = moment().diff(start, "years");
        }
    );
    $('input[name="datefilter"]').daterangepicker({      autoUpdateInput: false,      locale: {          cancelLabel: 'Clear'      }  });
</script>
<script>
     /* To show the image preview and clear the file input when "Cancel avatar" is clicked */
     $(document).ready(function () {
        var imageInput = document.getElementById('imageInput');
        var cancelButton = document.getElementById('cancelButton');

        $(imageInput).on('change', function () {
            var input = this;
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('.image-input-wrapper img').attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        });

        $(cancelButton).on('click', function () {
            imageInput.value = '';
            $('.image-input-wrapper img').attr('src', '{{ asset('assets/media/avatars/blank.png') }}');
        });
    });
</script>

<script>
    @if(Session::has('message'))
        toastr.options = {
        "closeButton": true,
        "progressBar": true
    }
    toastr.success("{{ session('message') }}");
    @endif

        @if(Session::has('error'))
        toastr.options = {
        "closeButton": true,
        "progressBar": true
    }
    toastr.error("{{ session('error') }}");
    @endif

        @if(Session::has('info'))
        toastr.options = {
        "closeButton": true,
        "progressBar": true
    }
    toastr.info("{{ session('info') }}");
    @endif

        @if(Session::has('warning'))
        toastr.options = {
        "closeButton": true,
        "progressBar": true
    }
    toastr.warning("{{ session('warning') }}");
    @endif
</script>
<script src="{{ asset('/') }}assets/plugins/global/plugins.bundle.js"></script>
<script src="{{ asset('/') }}assets/js/scripts.bundle.js"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Vendors Javascript(used for this page only)-->
<script src="{{ asset('/') }}assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script src="https://cdn.amcharts.com/lib/5/map.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>
<script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
<!--end::Vendors Javascript-->
<!--begin::Custom Javascript(used for this page only)-->
<script src="{{ asset('/') }}assets/js/custom/apps/user-management/users/list/table.js"></script>
<script src="{{ asset('/') }}assets/js/custom/apps/user-management/users/list/export-users.js"></script>
<script src="{{ asset('/') }}assets/js/custom/apps/user-management/users/list/add.js"></script>
<script src="{{ asset('/') }}assets/js/widgets.bundle.js"></script>
<script src="{{ asset('/') }}assets/js/custom/widgets.js"></script>
<script src="{{ asset('/') }}assets/js/custom/apps/chat/chat.js"></script>
<script src="{{ asset('/') }}assets/js/custom/utilities/modals/upgrade-plan.js"></script>
<script src="{{ asset('/') }}assets/js/custom/utilities/modals/create-campaign.js"></script>
<script src="{{ asset('/') }}assets/js/custom/utilities/modals/users-search.js"></script>
<!--end::Custom Javascript-->
<script>
    $(document).ready(function() {
        $("#closeModalButton, #submitButton").click(function() {
            $("#add_property_modal").modal("hide");
            $("#modalDel").modal("hide");
        });
    });
</script>
<!--end::Javascript-->
