<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Produk Berdasarkan Rating</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            margin: 2cm 2cm 2cm 2cm;
            color: #000;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0 0 10px 0;
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
        }
        .meta-info {
            margin-bottom: 20px;
            font-size: 11pt;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th {
            background-color: #ffffff;
            padding: 8px;
            text-align: left;
            font-size: 11pt;
            font-weight: bold;
            border: 1px solid #000;
        }
        td {
            padding: 6px 8px;
            border: 1px solid #000;
            font-size: 11pt;
        }
        .footer {
            margin-top: 40px;
            text-align: right;
            font-size: 10pt;
        }
        .note {
            font-size: 10pt;
            font-style: italic;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Produk Berdasarkan Rating</h1>
        <div class="subtitle"><strong>Laporan Produk Berdasarkan Rating</strong></div>
        <div class="subtitle">Tanggal dibuat: {{ now()->format('d-m-Y') }} oleh {{ auth()->user()->name }}</div>
    </div>
    
    <div class="meta-info">
        <div>Tanggal Dibuat: {{ now()->format('d F Y') }}</div>
        <div>Dibuat Oleh: {{ auth()->user()->name }}</div>
    </div>

    @if($products->isEmpty())
        <p style="text-align: center; color: #666; padding: 15px;">Tidak ada data produk dengan rating</p>
    @else
    <table>
        <thead>
            <tr>
                <th width="5%" style="text-align: center;">No</th>
                <th width="20%">Nama Produk</th>
                <th width="15%">Kategori</th>
                <th width="15%" style="text-align: right;">Harga</th>
                <th width="10%" style="text-align: center;">Rating</th>
                <th width="20%">Nama Toko</th>
                <th width="15%">Propinsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $index => $product)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category->name ?? '-' }}</td>
                <td style="text-align: right;">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                <td style="text-align: center;">{{ number_format($product->avg_rating, 1) }}</td>
                <td>{{ $product->seller->seller->nama_toko ?? '-' }}</td>
                <td>{{ $product->seller->seller->provinsi ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="note">***) Data diurutkan berdasarkan rating tertinggi</div>
    @endif

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d F Y, H:i') }} WIB</p>
    </div>
</body>
</html>
