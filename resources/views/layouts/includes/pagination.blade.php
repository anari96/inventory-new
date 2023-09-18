<tr>
    <td colspan="5">
        @if($datas->currentPage() != 1)
            <a href="{{ $datas->previousPageUrl() }}" @if($datas->currentPage() == 1) style="display:none;" @endif > Previous </a>
            <a href="{{ $datas->url(1) }}">1</a>
        @endif
        @for($i = max($datas->currentPage() - 5,2); $i < $datas->currentPage(); $i++ )
            <a href="{{ $datas->url($i) }}">{{ $i }}</a>
        @endfor
        <a href="{{ $datas->url($datas->currentPage()) }}" style="font-weight: bold"> {{$datas->currentPage()}} </a>
        @if($datas->currentPage() != $datas->lastPage() && $datas->currentPage() !=  $datas->lastPage() - 1)
            @for($i = $datas->currentPage() + 1; $i < $datas->currentPage() + 5; $i++ )
                @if($i < $datas->lastPage() )
                    <a href="{{ $datas->url($i) }}">{{ $i }}</a>
                @endif
            @endfor
        @endif
        @if($datas->currentPage() != $datas->lastPage())
            <a href="{{$datas->url($datas->lastPage())}}">{{$datas->lastPage()}}</a>
            <a href="{{ $datas->nextPageUrl() }}"  > Next </a>
        @endif
    </td>
</tr>
