@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-info">
                        <strong>Matching</strong>
                    </div>
                    <div class="card-body">
                        <div id="success" class="alert-success text-center"></div>
                        <div id="error" class="alert-danger text-center"></div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <strong>Inner</strong>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="name">{{ __('Serial') }}</label>
                                                    <input id="serial" type="text" class="form-control inputs"
                                                        required style="user-select: auto" autofocus name="serial">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="name">{{ __('Part') }}</label>
                                                    <input id="part" class="form-control inputs" type="text"
                                                        required name="part">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="name">{{ __('Qty') }}</label>
                                                    <input id="qty" class="form-control inputs" type="number"
                                                        required name="qty">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header"><strong>Customer</strong></div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="name">{{ __('Customer Part') }}</label>
                                                    <input id="custPart" class="form-control inputs" type="text"
                                                        required name="cust_part">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="name">{{ __('Qty') }}</label>
                                                    <input id="custQty" class="form-control inputs" type="number"
                                                        required name="cust_qty" style="user-select: none">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form class="mt-3" action="{{ url('export') }}" method="get">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="" class="font-weight-bold">From</label>
                                        <input type="date" id="date" class="form-control" name="From">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="" class="font-weight-bold">To</label>
                                        <input type="date" id="date" class="form-control" name="To">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group mt-4 pt-2">
                                        <button type="submit" class="btn btn-primary">Export</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//cdn.datatables.net/v/bs4/jqc-1.12.4/dt-1.12.1/datatables.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        // use Sweet Alert 
        function sweetAlert(position, icon, title, showConfirmButton, timer) {
            Swal.fire({
                position: position,
                icon: icon,
                title: title,
                showConfirmButton: showConfirmButton,
                timer: timer,
            });
        };
        // modalLoader Ajax 
        function modalLoader(type, Router, data) {
            $.ajax({
                type: type,
                url: '{{ url('') }}/' + Router,
                data: data,
            });
            $('#serial').focus();
        };
        // resetInputs
        function resetInputs() {
            for (var i = 0; i < $('.inputs').length; i++) {
                $('.inputs')[i].value = "";
            };
            $("input[type=date]").val("")
            $('#serial').focus();
        };

        var serial = "";
        var part = "";
        var qty = "";
        var custPart = "";
        var custQty = "";


        $('#serial').change(function() {
            serial = $('#serial').val();
            $('#part').focus()
        });
        $('#part').change(function() {
            part = $('#part').val();
            $('#qty').focus()
        });
        $('#qty').change(function() {
            qty = $('#qty').val();
            $('#custPart').focus()
        });
        $('#custPart').change(function() {
            custPart = $('#custPart').val();
            $('#custQty').focus()
        });

        $('#custQty').change(function() {
            custQty = $('#custQty').val();
            var char = part.charAt(0);
            custPart = char + custPart;
            let ageRejex = /^[a-z||A-Z]{1}[0-9][^.]{4,9}$/;
            if (part === custPart && qty === custQty && ageRejex.test(serial)) {
                resetInputs();
                let data = {
                    serial: serial,
                    lnner_part: part,
                    lnner_qty: qty,
                    customer_part: custPart,
                    customer_qty: custQty,
                    status: 0
                };
                modalLoader('GET', 'log/', data);
                sweetAlert('center', 'success', "Added successfully!", false, 1200);
            } else {
                let data = {
                    serial: serial,
                    lnner_part: part,
                    lnner_qty: qty,
                    customer_part: custPart,
                    customer_qty: custQty,
                    status: 1
                };
                modalLoader('GET', 'log/', data);
                let audio = new Audio('public/sounds/Wrong-alert-beep-sound.mp3');
                audio.play();
                sweetAlert('center', 'error', "Input Error, Please try again!!!", false, 3000);
                resetInputs();
            };
        });
    });
</script>
