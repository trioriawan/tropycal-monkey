<!DOCTYPE html>
<html>
<head>
    <title>Nota_{{ $no_transaksi }}</title>
    <style>
        body { font-family: 'Courier New', Courier, monospace; width: 58mm; font-size: 12px; }
        .text-center { text-align: center; }
        .border-bottom { border-bottom: 1px dashed #000; margin: 5px 0; }
        table { width: 100%; }
    </style>
</head>
<body onload="window.print();">
    <div class="text-center">
        <h3 style="margin-bottom:0">TROPICAL MONKEY</h3>
        <p style="margin-top:0">Gianyar, Bali</p>
    </div>
    <div class="border-bottom"></div>
    <p>No: {{ $no_transaksi }}<br>Tgl: {{ date('d/m/Y H:i') }}</p>
    <div class="border-bottom"></div>
    <table>
        @foreach($detail as $item)
        <tr>
            <td colspan="2">{{ $item->produk->nama_produk }}</td>
        </tr>
        <tr>
            <td>{{ $item->qty_keluar ?? $item->qty_masuk }} x {{ number_format($item->harga_jual_saat_ini ?? $item->harga_beli) }}</td>
            <td style="text-align:right">{{ number_format(($item->qty_keluar ?? $item->qty_masuk) * ($item->harga_jual_saat_ini ?? $item->harga_beli)) }}</td>
        </tr>
        @endforeach
    </table>
    <div class="border-bottom"></div>
    <h4 style="text-align:right">TOTAL: Rp {{ number_format($detail->sum(fn($i) => ($i->qty_keluar ?? $i->qty_masuk) * ($i->harga_jual_saat_ini ?? $i->harga_beli))) }}</h4>
    <p class="text-center">--- TERIMA KASIH ---</p>
</body>
</html>