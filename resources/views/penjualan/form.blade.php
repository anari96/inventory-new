@push('scripts')
<!-- Input Mask Plugin Js -->
    <script src="https://unpkg.com/autonumeric"></script>
    <script>
        const tableSparepart = document.getElementById('table-sparepart');
        const tableSparepartShow = document.getElementById('table-sparepart-list');
        const tableDetail = document.getElementById('table-detail-item');
        const itemDeleteButton = document.querySelectorAll(".item-delete");
        const itemDiskonInput = document.querySelectorAll(".item-diskon");
        const itemQtyInput = document.querySelectorAll(".qty");

        let itemId = document.querySelectorAll(".item_id");

        // console.log(itemId);

        const numberFormat = new Intl.NumberFormat({ style: 'currency' });

        let itemIdArray = [];

        tableSparepartShow.addEventListener("click", function () {
            tableShowData();
        });

        function tableShowData(){
             fetch("{{route('get-item')}}",{
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
                    let namaSparepartText = document.createTextNode(item.nama_item);
                    let hargaJualText = document.createTextNode(numberFormat.format(item.harga_item));
                    let hargaBeliText = document.createTextNode(numberFormat.format(item.biaya_item));
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

                    addEventPilih(pilihButton);
                });
            });

        }


        function addEventPilih(element){
            element.addEventListener('click', function(event){

                console.log("test");

                let jumlah = this.parentElement.parentElement.childNodes[4];

                let jumlahValue = jumlah.querySelector(".jumlah-input").value;

                fetch("{{route('get-item')}}?search=" + this.dataset.id,{
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
                            let namaSparepartText = document.createTextNode(item.nama_item);
                            let hargaJualText = document.createTextNode(numberFormat.format(item.harga_item));
                            let hargaBeliText = document.createTextNode(numberFormat.format(item.biaya_item));
                            let jumlahText = document.createTextNode(jumlahValue);
                            let subTotalText = document.createTextNode(numberFormat.format(item.harga_item * jumlahValue));
                            let hapusButtonText = document.createTextNode("X");

                            let hapusButton = document.createElement("button");
                            hapusButton.classList.add("btn","btn-danger","item-delete");
                            hapusButton.appendChild(hapusButtonText);
                            hapusButton.setAttribute('type', "button");

                            let diskonInput = document.createElement("input");
                            diskonInput.classList.add("item-diskon");
                            diskonInput.setAttribute("name", "diskon[]");
                            diskonInput.setAttribute("type", "number");
                            diskonInput.setAttribute("min", 0);
                            diskonInput.setAttribute("value", 0);

                            //hidden input for form request
                            let jumlahInput = document.createElement("input");
                            jumlahInput.classList.add("qty");
                            jumlahInput.setAttribute('name', "jumlah[]");
                            jumlahInput.setAttribute('type', "number");
                            jumlahInput.setAttribute('max', item.stok);
                            jumlahInput.setAttribute('min', 0);
                            jumlahInput.setAttribute('value', jumlahValue);
                            // jumlahInput.setAttribute('hidden', true);

                             //hidden input for form request
                            let idInput = document.createElement("input");
                            idInput.setAttribute('name', "id[]");
                            idInput.classList.add("item_id");
                            idInput.setAttribute('type', "text");
                            idInput.setAttribute('value', item.id);
                            idInput.setAttribute('hidden', true);

                            let hargaInput = document.createElement("input");
                            hargaInput.setAttribute('name', "harga[]");
                            hargaInput.classList.add("harga");
                            hargaInput.setAttribute('type', "number");
                            hargaInput.setAttribute('value', item.harga_item);
                            hargaInput.setAttribute('hidden', true);

                            let row = tableDetail.querySelector("tbody").insertRow(-1);
                            let namaSparepart = row.insertCell(0);
                            let hargaBeli = row.insertCell(1);
                            let jumlah = row.insertCell(2);
                            let hargaJual = row.insertCell(3);
                            let subTotal = row.insertCell(4);
                            subTotal.classList.add("subTotal");
                            let hapus = row.insertCell(5);

                            namaSparepart.appendChild(namaSparepartText);
                            hargaJual.appendChild(hargaJualText);
                            hargaBeli.appendChild(diskonInput);
                            subTotal.appendChild(subTotalText);
                            // jumlah.appendChild(jumlahText);
                            jumlah.appendChild(jumlahInput);
                            jumlah.appendChild(idInput);
                            jumlah.appendChild(hargaInput);
                            hapus.appendChild(hapusButton);

                            let detail = [item.id,jumlahValue];

                            addEventHapus(hapusButton);
                            addEventDiskon(diskonInput);
                            addEventQty(jumlahInput);
                            countGrandTotal();
                        }
                    });
                });


            })
        }

        function addEventHapus(element){
           element.addEventListener("click", function(event){
                this.parentElement.parentElement.remove();
                countGrandTotal();
            });
        }

        function addEventDiskon(e){
            countSubTotal(e);
        }

        function addEventQty(e){
            countSubTotal(e);
        }

        itemDeleteButton.forEach( (e)=>{
            e.addEventListener("click", function(event){
                this.parentElement.parentElement.remove();
                countGrandTotal();
            });
        } );

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
