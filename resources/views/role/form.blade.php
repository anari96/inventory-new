@push('scripts')
    <script>

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
                <a href="{{ route('role.index') }}" class="btn btn-warning">Kembali</a>
            </div>
            <div class="body">
                <div class="row clearfix">
                    <div class="col-md-3">
                        <b>Nama Role</b>
                        <div class="input-group colorpicker colorpicker-element">
                            <div class="form-line ">
                                <input type="text" class="form-control" name="nama_role" value="@if(isset($datas)){{ $datas->nama_role }}@endif">
                            </div>
                            <span class="input-group-addon">
                                <i style="background-color: rgb(0, 170, 187);"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <p style="font-weight:bold;">Detail Role</p>
                    </div>
                    <div class="col-md-1">
                    </div>
                    <div class="col-md-1">
                    </div>
                    <div class="col-md-1">
                    </div>
                    <div class="col-md-1">
                    </div>
                </div>
                @foreach($menu_lists as $menu_list)
                    <div class="row">
                        <div class="col-md-2">
                            <p>{{ str_replace("_"," ",$menu_list->nama_menu) }}</p>
                        </div>
                        @php
                            $menu_action = $menu_model->where("nama_menu", $menu_list->nama_menu)->get();
                        @endphp

                        @foreach($menu_action as $menu_aksi)
                            <div class="col-md-1">
                            @if(isset($datas))
                                <input type="checkbox" id="{{ $menu_aksi->nama_menu }}_{{$menu_aksi->aksi_menu}}" name="menu_id[]" value="{{ $menu_aksi->id }}" @if( \Helper::hakAksesUser($id,$menu_aksi->nama_menu,$menu_aksi->aksi_menu)) checked @endif ) class="filled-in"/>
                                <label for="{{ $menu_aksi->nama_menu }}_{{$menu_aksi->aksi_menu}}">{{ $menu_aksi->aksi_menu }}</label>
                            @else
                                <input type="checkbox" id="{{ $menu_aksi->nama_menu }}_{{$menu_aksi->aksi_menu}}" name="menu_id[]" value="{{ $menu_aksi->id }}" class="filled-in"/>
                                <label for="{{ $menu_aksi->nama_menu }}_{{$menu_aksi->aksi_menu}}">{{ $menu_aksi->aksi_menu }}</label>
                            @endif
                            </div>
                        @endforeach
                    </div>
                @endforeach
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-line">
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </div>
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
