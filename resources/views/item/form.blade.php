@push('scripts')
    

    <!-- Input Mask Plugin Js -->
    <script src="https://unpkg.com/autonumeric"></script>
    <script>
        new AutoNumeric('#harga_item', { currencySymbol : 'Rp ',decimalPlaces: 0, digitGroupSeparator: '.', decimalCharacter: ',' })
        new AutoNumeric('#biaya_item', { currencySymbol : 'Rp ',decimalPlaces: 0, digitGroupSeparator: '.', decimalCharacter: ',' });

        $(document).ready(function(){
            var input = $("#lacak_stok_input");
            $('#lacak_stok').on('change', function(){
                if($(this).is(':checked')){
                    input.show();
                    //find and enable all input  
                    input.find('input').removeAttr('disabled');
                    
                }else{
                    input.hide();
                    //find and disable all input
                    input.find('input').prop('disabled', true);
                }
            });
            var warna_dan_bentuk = $("#warna_dan_bentuk");
            warna_dan_bentuk.on('change', function(){
                if($(this).is(':checked')){
                    $('.pilihan-warna').removeAttr('disabled');
                    $("#file-input").prop('disabled', true);
                }else{
                    $("#file-input").removeAttr('disabled');
                }
            });

            $("#gambar").on('change', function(){
                if($(this).is(':checked')){
                    $('.pilihan-warna').prop('disabled', true);
                    $("#file-input").removeAttr('disabled');
                    
                }else{
                    $("#file-input").prop('disabled', true);
                    
                }
            });
            $('.pilih-warna').on('click', function(){
                //empty html inside all .pilih-warna
                //check warna_dan_bentuk is checked
                if(warna_dan_bentuk.is(':checked')){
                    $('.pilih-warna').html('');
                    $(this).html('<i class="material-icons" style="font-size: 100px;color:white;">check</i>');
                }
                
            });

            $('.pilih-bentuk').on('click', function(){
                //empty html inside all .pilih-warna
                //check warna_dan_bentuk is checked
                if(warna_dan_bentuk.is(':checked')){
                    $('.pilih-bentuk i').remove();
                    $(this).append('<i class="material-icons">check</i>');
                }
                
            });

            $("#file-input").on('change',function(){
                var parent = $(this).closest('.image-upload');
                var files = $(this)[0].files;
                if(files.length > 0){
                    var reader = new FileReader();
                    reader.onload = function(e){
                        //chaneg bg parent
                        parent.css('background-image', 'url('+e.target.result+')');
                    }
                    reader.readAsDataURL(files[0]);
                }
            })
        });
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
                <a href="{{ route('item.index') }}" class="btn btn-warning">Kembali</a>
            </div>
            <div class="body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" name="nama_item" class="form-control" value="{{ old('nama_item',@$data->nama_item) }}">
                                <label class="form-label">Nama</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-float ">
                            <div class="form-line focused">
                                <label for="" class="form-label" style="top: -18px">Kategori</label>
                                <select class="form-control" name="kategori_item_id">
                                    <option value="">Tidak Ada</option>
                                    @foreach ($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}" @if(old('kategori_item_id',@$data->kategori_item_id) == $kategori->id) selected @endif>{{ $kategori->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                        </div>
                        
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" class="form-control money-rupiah" name="harga_item" id="harga_item" value="{{ old('harga_item',@$data->harga_item) }}">
                                <label class="form-label">Harga Jual</label>
                            </div>
                        </div>
                        
                    </div>
                
                    <div class="col-md-6">
                        
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" class="form-control money-rupiah" name="biaya_item" id="biaya_item" value="{{ old('biaya_item',@$data->biaya_item) }}">
                                <label class="form-label">Harga Beli</label>
                            </div>
                        </div>
                        
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <p>Dijual Per</p>
                        <div class="demo-radio-button">
                            <input name="tipe_jual" type="radio" id="radio_30" value="satuan" class="with-gap" @if(old('tipe_jual',@$data->tipe_jual)=='satuan'||old('tipe_jual',@$data->tipe_jual)=='') checked="true" @endif>
                            <label for="radio_30">Satuan</label>
                            <input name="tipe_jual" type="radio" id="radio_31" value="berat" class="with-gap" @if(old('tipe_jual',@$data->tipe_jual)=='berat') checked="true" @endif>
                            <label for="radio_31">Berat</label>
                            
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" name="sku" class="form-control" value="{{ old('sku',@$data->sku) }}">
                                <label class="form-label">Sku</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" name="barcode" class="form-control" value="{{ old('barcode',@$data->barcode) }}">
                                <label class="form-label">Barcode</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Task Info -->
</div>

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    INVENTARIS
                    
                </h2>
                
            </div>
            <div class="body">
                

                
                <div class="demo-switch">
                    <div class="row clearfix">
                        <div class="col-sm-3">
                            <div class="demo-switch-title">Lacal Stok</div>
                            <div class="switch">
                                <label><input type="checkbox" name="lacak_stok" id="lacak_stok" @if(old('lacak_stok',@$data->lacak_stok)) checked @endif><span class="lever "></span></label>
                            </div>
                        </div>
                        
                    </div>
                    <div class="row" id="lacak_stok_input" @if(old('lacak_stok',@$data->lacak_stok)) @else style="display:none;"  @endif>
                        <div class="col-md-6">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="number" name="stok" class="form-control" value="{{ old('stok',@$data->stok ?? 0) }}">
                                    <label class="form-label">Stok Tersedia</label>
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
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    PENGENAL ITEM
                    
                </h2>
                
            </div>
            <div class="body">
                
                <div class="demo-radio-button row">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-12">
                                <input name="pengenal" type="radio" id="warna_dan_bentuk" value="warna_dan_bentuk" class="with-gap" checked="">
                                <label for="warna_dan_bentuk">Warna & Bentuk</label>
                            </div>
                        </div>
                        <div class="row">
                            
                            @foreach ($colors as $index => $color)
                                <div class="col-sm-2 pilihan-warna">
                                    
                                    <label for="warna_{{$index}}" style="text-align: center;width: 100px;height: 100px;background: {{ $color }};border-radius: 5px;display:block;margin:auto;" class="pilih-warna" data-warna="{{$color}}">
                                        @if (@$data->warna_item == strtolower($color) || ((!isset($data) || @$data->warna_item == null) && $index == 0))
                                            <i class="material-icons" style="font-size: 100px;color:white;">check</i>
                                        @endif
                                    </label>
                                    <input name="warna_item" type="radio" id="warna_{{$index}}" value="{{strtolower($color)}}" @if(@$data->warna_item == strtolower($color) || ((!isset($data) || @$data->warna_item == null) && $index == 0)) checked @endif style="display:none;">
                                </div>
                            @endforeach
                            @foreach ($bentukItems as $index => $bentukItem)
                                <div class="col-sm-2 pilihan-bentuk">
                                    <label for="bentuk_{{$index}}" style="text-align: center;width: 100px;height: 100px;display:block;margin:auto;" class="pilih-bentuk" data-bentuk="{{$index}}">
                                        {!! $bentukItem !!}
                                        @if (@$data->bentuk_item == $index || ((!isset($data) || @$data->bentuk_item == null) && $index == 0))
                                            <i class="material-icons" >check</i>
                                        @endif
                                    </label>
                                    <input name="bentuk_item" type="radio" id="bentuk_{{$index}}" value="{{$index}}" @if(@$data->bentuk_item == $index || ((!isset($data) || @$data->bentuk_item == null) && $index == 0)) checked @endif style="display:none;">
                                </div>
                            @endforeach
                            
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-12">
                                <input name="pengenal" type="radio" id="gambar" value="gambar" class="with-gap">
                                <label for="gambar">Gambar</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="file-input" class="image-upload">
                                    <label for="file-input" style="margin:auto;display:block;height: 50px;width: 50px;position: absolute; top:0px;bottom:0px;left:0px;right:0px;text-align: center;">
                                        <i class="material-icons" style="font-size: 50px;margin:auto;display:block;">image</i>
                                    </label>
                                  
                                    <input id="file-input" type="file" name="gambar_item_file" disabled/>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                </div>
                
                
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12"><hr></div>
</div>
<div class="row" style="margin-bottom: 50px;">
    <div class="col-md-12" style="text-align: right;">
        <button type="submit" class="btn btn-success">Simpan</button>
    </div>
</div>
