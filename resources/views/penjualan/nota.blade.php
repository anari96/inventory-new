<head>
<title>Cetak Nota Penjualan - Program Kasir Toko Minimarket</title>
<script type="text/javascript">
  window.print();
  window.onfocus=function(){ window.close();}
</script>
<style type="text/css">

.garisatas{
  border-top:1px solid #000;
}

.garisbawah{
  border-bottom:1px solid #000;
}

.teks{
  font-size: 10px;
}

.teks2{
  font-size: 10px;
}

body{
  margin:0px auto 0px;
  padding:3px;
  width:100%;
  font-size: 12px;
  background-position:top;
}
.table-list {
  font-size: 12px;
  clear: both;
  text-align: left;
  border-collapse: collapse;
  margin: 0px 0px 12px 0px;
}

.table-tok {
  font-size: 12px;
  clear: both;
  text-align: left;
  margin: 0px 0px 12px 0px;
}

.table-list tr:first-child {
  color: #000;
  font-size: 12px;
  border-collapse: collapse;
  vertical-align: center;
  padding: 3px 5px;
  border-bottom:1px #000 solid;
}

</style>
</head>
<body onLoad="window.print()">
<!-- Default : width='1560' Last : width='1460' -->
<table style=" margin-top: 0px; margin-left: 0px;" class="table-tok" width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <div class="head">
        <td height="87" colspan="5" style=��font-size:13px�� align="center">
            <p>{{ $profil->nama_toko }}</p>
            <p>{{ $profil->alamat }}</p>
            <p>{{ $profil->kontak }}</p>
        </td>
    </div>
  </tr>
  </table>
  <table style="margin-top: -15px;">
   <tr class="teks">
    <td colspan="2">No. Nota </td>
    <td> : </td>
    <td colspan="3" align="left">{{ $datas->nomor_nota }}</td>
  </tr>
   <tr class="teks">
    <td colspan="2">Tanggal </td>
    <td> : </td>
    <td colspan="3" align="left">{{ $datas->tanggal_penjualan }}</td>
  </tr>

  </table>
  <div style="border-bottom: #000 solid 2px; margin-left: 0px; width: 100%;">&nbsp;</div>
  <table style="margin-left: 0px; padding-top: 15px;" class="table-list" width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr class="teks2">
    <td width="103" bgcolor="#F5F5F5">Nama</td>
    <td width="50" align="right" bgcolor="#F5F5F5">IMEI</td>
    <td width="49" align="right" bgcolor="#F5F5F5">Harga</td>
    <td width="22" align="right" bgcolor="#F5F5F5">DIskon</td>
    <td width="22" align="right" bgcolor="#F5F5F5">Qty</td>
    <td width="103" align="right" bgcolor="#F5F5F5">Subtotal </strong></td>
  </tr>
  </div>
<!--put foreach here -->
@foreach($datas->detail_penjualan as $detail)
    @php
        $grandTotal = 0;
        $subTotal =  $detail->qty * ($detail->harga_item - $detail->diskon);
        $grandTotal += $subTotal;
    @endphp
    <tr>
        <td><div class="teks">{{ $detail->item->nama_item }}</div></td>
        <td align="right"><div class="teks">{{ $detail->item->sku }}</div></td>
        <td align="right"><div class="teks">Rp. {{ number_format($detail->harga_item) }}</div></td>
        <td align="right"><div class="teks">Rp. {{ number_format($detail->diskon) }}</div></td>
        <td align="right"><div class="teks">{{$detail->qty}}</div></td>
        <td align="right"><div class="teks">Rp. {{ number_format($subTotal) }}</div></td>
    </tr>
@endforeach
<!-- this is the foreach tail -->
  <tr class="garisatas teks2">
    <td colspan="3" align="left">Total Belanja (Rp) : </td>
    <td colspan="3" align="right" bgcolor="#F5F5F5">Rp. {{ number_format($grandTotal) }}</td>
  </tr>
<!--  <tr class="teks2">
    <td  colspan="3" align="left"> Uang Bayar (Rp) : </td>
    <td colspan="3" align="right">(Uang Bayar)</td>
  </tr>

  <tr class="garisbawah teks2">
    <td colspan="3" align="left">Uang Kembali (Rp) : </td>
    <td colspan="3" align="right">(Kembali)</td>
  </tr>-->

</table>

<table style="margin-left: 0px;">
  <tr>
    <td colspan="2"><div class="teks">Kasir :</div></td>
    <td colspan="3" align="right"><div class="teks">{{ $datas->pengguna->nama_pengguna }}</div></td>
  </tr>
  <tr>
    <td colspan="2"><div class="teks">Pelanggan :</div></td>
    <td colspan="3" align="right"><div class="teks">{{ $datas->pelanggan->nama_pelanggan }}</div></td>
  </tr>
</table>

<table style=" margin-top: 0px; margin-left: 0px;" class="table-tok" width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td height="87" colspan="5" style="font-size:10px" align="center">
      <div class="head">
            <p>{{ $profil->keterangan }}</p>
        </div>
      </td>
  </tr>
  </table>
</body>
</html>

