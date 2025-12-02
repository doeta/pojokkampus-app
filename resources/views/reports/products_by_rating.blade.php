<!DOCTYPE html>
<html>
<head>
    <title>Laporan Daftar Produk Berdasarkan Rating</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h3 { margin-bottom: 5px; }
        .subtitle { margin-bottom: 20px; font-style: italic; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 5px; text-align: left; }
        th { background-color: #f2f2f2; text-align: center; font-weight: bold; }
        .footer-note { margin-top: 10px; font-style: italic; font-size: 11px; }
    </style>
</head>
<body>
    <h3>Laporan Daftar Produk Berdasarkan Rating</h3>
    <div class="subtitle">Tanggal dibuat: {{ $generatedAt }} oleh {{ $generatedBy }}</div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Produk</th>
                <th width="15%">Kategori</th>
                <th width="15%">Harga</th>
                <th width="10%">Rating</th>
                <th width="20%">Nama Toko</th>
                <th width="15%">Propinsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $index => $product)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category->name }}</td>
                <td style="text-align: right;">{{ number_format($product->price, 0, ',', '.') }}</td>
                <td style="text-align: center;">{{ number_format($product->reviews_avg_rating, 1) }}</td>
                <td>{{ $product->seller->seller->nama_toko ?? $product->seller->name }}</td>
                <td>{{ $product->seller->seller->provinsi ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer-note">***) propinsi diisikan propinsi pemberi rating</div>
</body>
</html>
