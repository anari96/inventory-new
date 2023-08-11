
@push('scripts')
    <script>
        $('.pilih-warna').on('click', function(){
            $('.pilih-warna').html('');
            $(this).html('<i class="material-icons" style="font-size: 100px;color:white;">check</i>');
            $("#warna_kategori").val($(this).data('warna'));
        });
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
                                <input type="text" name="nama_kategori" class="form-control" value="{{ old('nama_kategori',@$data->nama_kategori) }}">
                                <label class="form-label">Nama</label>
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
