@push('scripts')
<!-- Input Mask Plugin Js -->
    <script src="https://unpkg.com/autonumeric"></script>
    @include("penjualan.script");
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
                                <input type="text" class="form-control" name="tanggal" value="{{ date('Y-m-d') }}" required>
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
                                <input type="hidden" name="pengguna_id" value="{{ auth()->user()->id }}" required>
                                <input type="text" class="form-control" value="{{ auth()->user()->nama_pengguna }}" required>
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
                    <ul class="header-dropdown m-r--5">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">add</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="javascript:void(0);" class=" waves-effect waves-block">Tambah Pelanggan</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <h2 class="card-inside-title">Pelanggan</h2>
                    <div class="row clearfix">
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <div class="form-line">
                                    <select class="form-control" name="pelanggan_id">
                                        @foreach($pelanggans as $data)
                                            <option value="{{ $data->id }}" @if(isset($datas)) @if($data->id == $datas->pelanggan_id) selected @endif @endif>{{ $data->nama_pelanggan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-line">
                                    <select class="form-control" name="metode_bayar">
                                        <option value="cash">Cash</option>
                                        <option value="kredit">Kredit</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="number" id="uang_bayar" name="uang_bayar" required class="form-control" placeholder="Uang Bayar" step="500">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="kembali" name="kembali" readonly value="0" class="form-control" placeholder="Kembali"  step="500">
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success">Simpan</button>
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
                <button type="button" id="table-sparepart-list" class="btn btn-primary" data-toggle="modal" data-target="#list-sparepart">Pilih Barang</button>
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
                            @if(isset($datas->detail_penjualan))
                                @foreach($datas->detail_penjualan as $d)
                                    <tr>
                                        <td>{{ $d->item->nama_item }}</td>
                                        <td>
                                            <input class="item-diskon" name="diskon[]" value="{{$d->diskon}}" step="500" min="0" type="number"></td>
                                        <td>
                                            <input class="qty" name="jumlah[]" value="{{$d->qty}}"  min="0" max="{{$d->item->stok + $d->qty}}" type="number">
                                            <input class="item_id" name="id[]" value="{{$d->item_id}}" hidden>
                                            <input class="harga" name="harga[]" value="{{$d->item->harga_item}}" hidden>
                                        </td>
                                        <td>{{ number_format($d->item->harga_item) }}</td>
                                        <td class="subTotal">{{ number_format( $d->qty * ($d->item->harga_item - $d->diskon)) }}</td>
                                        <td><button class="btn btn-danger item-delete"  type="button" >X</button></td>
                                    </tr>
                                @endforeach
                            @endif
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

<!-- Modal -->
<div class="modal fade" id="list-sparepart" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pilih Item</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>

        <div class="text-center">
            <button type="button" id="page-change-previous" class="page-change" data-page="1">Previous</button>
            <button type="button" id="current-page">1</button>
            <button type="button" id="page-change-next" class="page-change" data-page="1">Next</button>
        </div>
      </div>
      <div class="modal-body">
            <div class="table-responsive">
                <table id="table-sparepart" class="table table-hover ">
                    <thead>
                        <tr>
                            <th>Nama Item</th>
                            <th>Harga Jual</th>
                            <th>Harga Beli</th>
                            <th>Jumlah</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3">
                                <div class="text-center">
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="row">
    <div class="col-md-12"><hr></div>
</div>
<div class="row" style="margin-bottom: 50px;">
    <div class="col-md-12" style="text-align: right;">
    </div>
</div>
