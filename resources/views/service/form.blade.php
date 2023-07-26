@push('scripts')
    <script>
        const tableSparepart = document.getElementById('table-sparepart');
        const tableSparepartShow = document.getElementById('table-sparepart-list');
        const tableDetail = document.getElementById('table-detail-sparepart');

        let detailArray = [];

        tableSparepartShow.addEventListener("click", function () {
            fetch("{{route('get-sparepart')}}",{
                method: "GET"
            })
            .then(
                (response) => {
                    return response.json();
                }
            )
            .then((data) => {
                const rowCount = tableSparepart.querySelector('tbody');

                while(rowCount.firstChild){
                    rowCount.removeChild(rowCount.firstChild);
                }

                let items = data;
                items.data.forEach(item => {
                    let namaSparepartText = document.createTextNode(item.tipe);
                    let hargaJualText = document.createTextNode(item.harga_jual);
                    let hargaBeliText = document.createTextNode(item.harga_beli);
                    let stokText = document.createTextNode(item.stok);

                    let pilihButtonText = document.createTextNode(`Pilih`);

                    let pilihButton = document.createElement("button");
                    pilihButton.classList.add('btn','btn-primary','item-add');
                    // pilihButton.setAttribute('data-id', item.id);
                    pilihButton.setAttribute('type', "button");
                    pilihButton.dataset.id = item.id;
                    pilihButton.appendChild(pilihButtonText);

                    let jumlahInput = document.createElement("input");
                    jumlahInput.setAttribute('type', "number");
                    jumlahInput.setAttribute('value', 0);
                    jumlahInput.setAttribute('max', item.stok == null ? 0 : item.stok);
                    jumlahInput.setAttribute('min', 0);
                    jumlahInput.classList.add('form-control','jumlah-input');

                    let row = tableSparepart.querySelector("tbody").insertRow(-1);
                    let namaSparepart = row.insertCell(0);
                    let hargaJual = row.insertCell(1);
                    let hargaBeli = row.insertCell(2);
                    let stok = row.insertCell(3);
                    let jumlah = row.insertCell(4);
                    let pilih = row.insertCell(5);

                    namaSparepart.appendChild(namaSparepartText);
                    hargaJual.appendChild(hargaJualText);
                    hargaBeli.appendChild(hargaBeliText);
                    stok.appendChild(stokText);
                    jumlah.appendChild(jumlahInput);
                    pilih.appendChild(pilihButton);

                    addEvent(pilihButton);
                });
            });

        });


        function addEvent(element){
            element.addEventListener('click', function(event){

                let jumlah = this.parentElement.parentElement.childNodes[4];

                let jumlahValue = jumlah.querySelector(".jumlah-input").value;

                fetch("{{route('get-sparepart')}}?search=" + this.dataset.id,{
                    method: "GET"
                })
                .then(
                    (response) => {
                        return response.json();
                    }
                )
                .then((data) => {

                    let items = data;
                    items.data.forEach(item => {
                        if(jumlahValue > 0){
                            addDetailBarangRow();
                        }

                        function addDetailBarangRow()
                        {
                            //new text element
                            let namaSparepartText = document.createTextNode(item.tipe);
                            let hargaJualText = document.createTextNode(item.harga_jual);
                            let hargaBeliText = document.createTextNode(item.harga_beli);
                            let jumlahText = document.createTextNode(jumlahValue);

                            //hidden input for form request
                            let jumlahInput = document.createElement("input");
                            jumlahInput.setAttribute('name', "jumlah[]");
                            jumlahInput.setAttribute('type', "number");
                            jumlahInput.setAttribute('value', jumlahValue);
                            jumlahInput.setAttribute('hidden', true);

                             //hidden input for form request
                            let idInput = document.createElement("input");
                            idInput.setAttribute('name', "id[]");
                            idInput.setAttribute('type', "text");
                            idInput.setAttribute('value', item.id);
                            idInput.setAttribute('hidden', true);

                            let row = tableDetail.querySelector("tbody").insertRow(-1);
                            let namaSparepart = row.insertCell(0);
                            let hargaJual = row.insertCell(1);
                            let hargaBeli = row.insertCell(2);
                            let jumlah = row.insertCell(3);

                            namaSparepart.appendChild(namaSparepartText);
                            hargaJual.appendChild(hargaJualText);
                            hargaBeli.appendChild(hargaBeliText);
                            jumlah.appendChild(jumlahText);
                            jumlah.appendChild(jumlahInput);
                            jumlah.appendChild(idInput);

                            let detail = [item.id,jumlahValue];
                            detailArray.push(detail);
                        }
                    });
                });


            })
        }

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
    </style>
@endpush

<div class="row clearfix">
    <!-- Task Info -->
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="card">
            <div class="header">
                <a href="{{ route('service.index') }}" class="btn btn-warning">Kembali</a>
            </div>
            <div class="body">

                <div class="row clearfix">
                    <div class="col-md-3">
                        <b>Invoice</b>
                        <div class="input-group colorpicker colorpicker-element">
                            <div class="form-line focused">
                                <input type="text" class="form-control" name="no_service" @if(isset($data)) value="{{ $data->no_service }}" @else value="{{ "S-". date('Y')."".date('m')."".date('d')."".date("his") }}" @endif>
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
                                <input type="text" class="form-control" name="tanggal" value="{{ date('Y-m-d') }}">
                            </div>
                            <span class="input-group-addon">
                                <i style="background-color: rgb(0, 170, 187);"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <b>Teknisi</b>
                        <div class="input-group colorpicker colorpicker-element">
                            <div class="form-line focused">
                                <select name="teknisi_id" class="form-control">
                                    @foreach($teknisi as $t)
                                        <option value="{{ $t->id }}" @if(isset($data)) @if($t->id == $data->teknisi_id) selected @endif @endif> {{ $t->nama_teknisi }} </option>
                                    @endforeach
                                </select>
<!--                                 <input type="text" class="form-control" value="Teknisi 1"> -->
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
                                <input type="hidden" name="pengguna_id" value="{{ auth()->user()->id }}">
                                <input type="text" class="form-control" value="{{ auth()->user()->nama_pengguna }}">
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
                        Konsumen
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">add</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="javascript:void(0);" class=" waves-effect waves-block">Tambah Konsumen</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <h2 class="card-inside-title">Konsumen</h2>
                    <div class="row clearfix">
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="nama" class="form-control" @if(isset($data)) value="{{ $data->pelanggan->nama_pelanggan }}" @endif placeholder="Nama">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="alamat" class="form-control" @if(isset($data)) value="{{ $data->pelanggan->alamat_pelanggan }}" @endif placeholder="Alamat">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="kontak" class="form-control" @if(isset($data)) value="{{ $data->pelanggan->telp_pelanggan }}" @endif placeholder="Kontak">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <div class="row clearfix">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Detail Gadget
                    </h2>
                </div>
                <div class="body">
                    <h2 class="card-inside-title">Detail Gadget</h2>
                    <div class="row clearfix">
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="merk" class="form-control" @if(isset($data)) value="{{ $data->merk }}" @endif placeholder="Merk">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="tipe" class="form-control" @if(isset($data)) value="{{ $data->tipe }}" @endif placeholder="Tipe">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="imei1" class="form-control" @if(isset($data)) value="{{ $data->imei1 }}" @endif placeholder="IMEI 1">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="imei2" class="form-control" @if(isset($data)) value="{{ $data->imei2 }}" @endif placeholder="IMEI 2">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>

<div class="col-md-6">
    <div class="row clearfix">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Detail Service
                    </h2>
                </div>
                <div class="body">
                    <div class="row clearfix">
                        <div class="col-sm-12 col-md-12">

                            <div class="form-group">
                                <div class="form-line">
                                    <h2 class="card-inside-title">Untuk Klaim Garansi</h2>
                                    <input name="garansi" type="radio" id="radio_1" value='1' @if(isset($data)) @if($data->garansi == 1) checked="" @endif @endif>
                                    <label for="radio_1">Ya</label>
                                    <input name="garansi" type="radio" id="radio_2" value='0' @if(isset($data)) @if($data->garansi == 0) checked="" @endif @endif>
                                    <label for="radio_2">Tidak</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="kerusakan" class="form-control" class="form-control" @if(isset($data)) value="{{ $data->kerusakan }}" @endif placeholder="Kerusakan">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="deskripsi" class="form-control" class="form-control" @if(isset($data)) value="{{ $data->deskripsi }}" @endif placeholder="Deskripsi">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="kelengkapan" class="form-control" class="form-control" @if(isset($data)) value="{{ $data->kelengkapan }}" @endif placeholder="Kelengkapan">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="biaya" class="form-control" class="form-control" @if(isset($data)) value="" @endif placeholder="Total Biaya">
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
                <h2>Daftar Sparepart</h2>
                <button type="button" id="table-sparepart-list" class="btn btn-primary" data-toggle="modal" data-target="#list-sparepart">Pilih Sparepart</button>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table id="table-detail-sparepart" class="table table-hover ">
                        <thead>
                            <tr>
                                <th>Nama Sparepart</th>
                                <th>Harga Jual</th>
                                <th>Harga Beli</th>
                                <th>Stok</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($detail))
                                @foreach($detail as $d)
                                    <tr>
                                        <td>{{ $d->sparepart->nama_sparepart }}</td>
                                        <td>{{ $d->sparepart->harga_jual }}</td>
                                        <td>{{ $d->sparepart->harga_beli }}</td>
                                        <td>
                                            <input name="jumlah[]" value="{{$d->jumlah}}" hidden>
                                            <input name="id[]" value="{{$d->id}}" hidden>
                                            {{ $d->jumlah }}
                                        </td>
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
        <h5 class="modal-title" id="exampleModalLabel">Pilih Sparepart</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="table-responsive">
                <table id="table-sparepart" class="table table-hover ">
                    <thead>
                        <tr>
                            <th>Nama Sparepart</th>
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
