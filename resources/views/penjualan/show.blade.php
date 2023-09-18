@extends('layouts.app')


@push('scripts')
<!-- Input Mask Plugin Js -->
    <script src="https://unpkg.com/autonumeric"></script>
    <script>
        const tableDetail = document.getElementById('table-detail-item');
        const itemDeleteButton = document.querySelectorAll(".item-delete");
        const itemDiskonInput = document.querySelectorAll(".item-diskon");
        const itemQtyInput = document.querySelectorAll(".qty");

        let itemId = document.querySelectorAll(".item_id");

        // console.log(itemId);

        const numberFormat = new Intl.NumberFormat({ style: 'currency' });

        let itemIdArray = [];

        function addEventDiskon(e){
            countSubTotal(e);
        }

        function addEventQty(e){
            countSubTotal(e);
        }

        itemDiskonInput.forEach( (e)=>{
            countSubTotal(e);
        } );

        itemQtyInput.forEach( (e)=>{
            countSubTotal(e);
        } );

        function countSubTotal(e){
            e.addEventListener("input", function(event){
               let qty = this.parentElement.parentElement.children[2].children[0];
               let hargaItem = this.parentElement.parentElement.children[3];
               let subTotalElement = this.parentElement.parentElement.children[4];
               let diskonInput = this.parentElement.parentElement.children[1].children[0];

               const harga = this.parentElement.parentElement.children[2].children[2];

               let hargaDiskon = Math.max(parseFloat(harga.value) - diskonInput.value,0) ;

               // hargaItem.textContent = hargaDiskon;

               let subtotal = hargaDiskon * qty.value;

               subTotalElement.textContent = numberFormat.format(subtotal);

                countGrandTotal();
            });
        }

        function countGrandTotal(){
            let subTotal = document.querySelectorAll(".subTotal");
            let grandTotal = document.querySelector("#grandTotal");
            let grandTotalValue = 0;
            subTotal.forEach((element) => {
                subTotalValue = parseFloat(element.textContent.replaceAll(",",""));
                grandTotalValue += subTotalValue;
            });

            grandTotal.textContent = numberFormat.format(grandTotalValue);
        }

        countGrandTotal();
    </script>
@endpush

@push('styles')
    <style>
        .image-upload {
            width: 200px;
            height: 200px;
            background-color: gainsboro;
            display: block;
            margin: auto;
            background-size: contain;
        }
        .image-upload>input {
            display: none;
        }

        .pilih-bentuk svg {
            width: 100px;
            height: 100px;
            display: block;
            margin: auto;
        }

        .pilih-bentuk i {
            font-size: 100px;
            color:grey;
            position:absolute;
            left: 0%;
            top: 0%;
            right: 0%;
            bottom: 0%;
        }

        .qty{
            width:55px;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>Detail Penjualan</h2>
        </div>



<div class="row clearfix">
    <!-- Task Info -->
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="card">
            <div class="header">
                <a href="{{ route('penjualan.index') }}" class="btn btn-warning">Kembali</a>
            </div>
            <div class="body">

                <div class="row clearfix">
                    <div class="col-md-3">
                        <b>Invoice</b>
                        <div class="input-group colorpicker colorpicker-element">
                            <div class="form-line focused">
                                <input type="text" class="form-control" name="no_penjualan" @if(isset($data)) value="{{ $data->no_service }}" @else value="{{ "P-". date('Y')."".date('m')."".date('d')."".date("his") }}" @endif required>
                            </div>
                            <span class="input-group-addon">
                                <i style="background-color: rgb(0, 170, 187);"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <b>Tanggal</b>
                        <div class="input-group colorpicker colorpicker-element">
                            <div class="form-line focused">
                                <input type="text" class="form-control" name="tanggal" value="{{ date('Y-m-d') }}" readonly>
                            </div>
                            <span class="input-group-addon">
                                <i style="background-color: rgb(0, 170, 187);"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <b>Kasir</b>
                        <div class="input-group colorpicker colorpicker-element">
                            <div class="form-line focused">
                                <input type="hidden" name="pengguna_id" value="{{ auth()->user()->id }}" readonly>
                                <input type="text" class="form-control" value="{{ auth()->user()->nama_pengguna }}" readonly>
                            </div>
                            <span class="input-group-addon">
                                <i style="background-color: rgba(0, 0, 0, 0.7);"></i>
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- #END# Task Info -->
</div>

<div class="col-md-6">

    <div class="row clearfix">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Pelanggan
                    </h2>
                </div>
                <div class="body">
                    <h2 class="card-inside-title">Pelanggan</h2>
                    <div class="row clearfix">
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <div class="form-line">
                                <input type="text" class="form-control" value="{{ $datas->pelanggan->nama_pelanggan }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


</div>

<div class="row clearfix">
    <!-- Task Info -->
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="card">
            <div class="header">
                <h2>Daftar Barang</h2>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table id="table-detail-item" class="table table-hover ">
                        <thead>
                            <tr>
                                <th>Nama Barang</th>
                                <th>Diskon</th>
                                <th>Jumlah</th>
                                <th>Harga Jual</th>
                                <th>Subtotal</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                                @foreach($datas->detail_penjualan as $d)
                                    <tr>
                                        <td>{{ $d->item->nama_item }}</td>
                                        <td>
                                            {{$d->diskon}}
                                        <td>
                                            {{ $d->qty }}
                                        </td>
                                        <td>{{ number_format($d->item->harga_item) }}</td>
                                        <td class="subTotal">{{ number_format( $d->qty * ($d->item->harga_item - $d->diskon)) }}</td>
                                        <td><a href="{{ route('penjualan.retur', $d->id) }}" class="btn btn-danger item-delete" type="button" >Retur</a></td>
                                    </tr>
                                @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3">
                                    <div class="text-center">
                                    </div>
                                </td>
                                <td>
                                    <div class="text-right">
                                        <p style="font-weight:bold;">Grand Total : </p>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-left">
                                        <p style="font-weight:bold;" id="grandTotal">0</p>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Task Info -->
</div>

<div class="row">
    <div class="col-md-12"><hr></div>
</div>
<div class="row" style="margin-bottom: 50px;">
    <div class="col-md-12" style="text-align: right;">
    </div>
</div>


    </div>
@endsection
