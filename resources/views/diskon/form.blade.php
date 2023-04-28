
@push('scripts')
    <script src="https://unpkg.com/autonumeric"></script>
    <script>
        var nilaiDiskon = new AutoNumeric('#nilai_diskon',{ currencySymbol : '',decimalPlaces: 0, digitGroupSeparator: '.', decimalCharacter: ',' });
        $("#jenis_diskon").change(function(){
            if($(this).val() == "persen"){
                nilaiDiskon.update({ currencySymbol : '',decimalPlaces: 0, digitGroupSeparator: '.', decimalCharacter: ',' });
            } else {
                nilaiDiskon.update({ currencySymbol : 'Rp ',decimalPlaces: 0, digitGroupSeparator: '.', decimalCharacter: ',' });
            }
        })
    </script>
@endpush

<div class="row clearfix">
    <!-- Task Info -->
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="card">
            <div class="header">
                <a href="{{ route('kategori-item.index') }}" class="btn btn-warning">Kembali</a>
            </div>
            <div class="body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" name="nama_diskon" class="form-control" value="{{ old('nama_diskon',@$data->nama_diskon) }}">
                                <label class="form-label">Nama</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-float ">
                            <div class="form-line focused">
                                <label for="jenis_diskon" class="form-label" style="top: -18px">Jenis Diskon</label>
                                <select class="form-control" name="jenis_diskon" id="jenis_diskon">
                                    <option value="persen" @if(old('jenis_diskon',@$data->jenis_diskon) == 'persen') selected @endif>Persen</option>
                                    <option value="rupiah" @if(old('jenis_diskon',@$data->jenis_diskon) == 'rupiah') selected @endif>Rupiah</option>
                                </select>
                            </div>
                            
                        </div>
                        
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" name="nilai_diskon" class="form-control" id="nilai_diskon" value="{{ old('nilai_diskon',@$data->nilai_diskon) }}">
                                <label class="form-label">Nilai Diskon</label>
                            </div>
                        </div>
                    </div>
                   
                </div>
                
              
            </div>
        </div>
    </div>
    <!-- #END# Task Info -->
</div>



<div class="row" style="margin-bottom: 50px;">
    <div class="col-md-12" style="text-align: right;">
        <button type="submit" class="btn btn-success">Simpan</button>
    </div>
</div>
