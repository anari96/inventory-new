@push('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endpush
@push("scripts")

    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        $(function() {
            $('#daterange').daterangepicker({
                opens: 'left',
                locale: {
                    format: 'DD/MM/YYYY'
                }
            }, function(start, end, label) {

                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end
                    .format('YYYY-MM-DD'));
                var delayInMilliseconds = 500; //1 second

                setTimeout(function() {
                    $("#filter-form").submit();
                }, delayInMilliseconds);

            });
        });
    </script>
@endpush

<form action="" id="filter-form">
    <div class="row">
        <div class="col-lg-2 col-md-3">
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="material-icons">date_range</i>
                </span>
                <div class="form-line">

                    <input type="text" class="form-control" name="periode" id="daterange"
                        value="{{ $periode[0] }} - {{ $periode[1] }}">
                </div>
            </div>
        </div>
    </div>
</form>
