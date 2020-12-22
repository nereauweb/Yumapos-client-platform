<div>
    <div>
        <div wire:ignore class="uk-width-expand">
            <fieldset class="form-group">
                <label>{{ trans('titles.date') }}</label>
                <div class="input-group">
                    <span class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="cil-calendar"></i>
                        </span>
                    </span>
                    <input class="form-control" id="daterange" type="text">
                    <input type="hidden" name="date_begin" id="date_begin">
                    <input type="hidden" name="date_end" id="date_end">
                </div>
            </fieldset>
        </div>
    </div>
</div>
@section('javascript')
    {{-- <script src="{{ asset('js/jquery.dataTables.js') }}"></script> --}}
    {{-- <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('js/datatables.js') }}"></script>  --}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        $('#commitData').on('click', () => {
            @this.set('from', $("#date_begin").val());
            @this.set('to', $("#date_end").val());
        });
    </script>
    <script type="text/javascript">
        $(function() {
            $('#daterange').daterangepicker({
                opens: 'left',
                locale: {
                    format: 'DD/MM/YYYY',
                    separator: " - "

                },
            }, function(start, end, label) {
                $("#date_begin").val(start.format('YYYY-MM-DD'));
                $("#date_end").val(end.format('YYYY-MM-DD'));
            });
        });
    </script>
@endsection
