<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Stok Produk</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #9333ea;
        }
        .header h1 {
            font-size: 16px;
            color: #333;
            margin-bottom: 2px;
            font-weight: bold;
        }
        .header h2 {
            font-size: 14px;
            color: #333;
            font-weight: normal;
            margin-bottom: 5px;
        }
        .header h3 {
            font-size: 15px;
            color: #333;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .header p {
            font-size: 10px;
            color: #666;
            font-style: italic;
        }
        .info-section {
            margin-bottom: 20px;
            background: #f3f4f6;
            padding: 15px;
            border-radius: 5px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        .info-label {
            font-weight: bold;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th {
            background-color: #9333ea;
            color: white;
            padding: 10px 8px;
            text-align: left;
            font-weight: bold;
            font-size: 11px;
        }
        th.center {
            text-align: center;
        }
        th.right {
            text-align: right;
        }
        td {
            padding: 8px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 11px;
        }
        td.center {
            text-align: center;
        }
        td.right {
            text-align: right;
        }
        tr:nth-child(even) {
            background-color: #f9fafb;
        }
        .stock-high {
            color: #059669;
            font-weight: bold;
        }
        .stock-medium {
            color: #d97706;
            font-weight: bold;
        }
        .stock-low {
            color: #dc2626;
            font-weight: bold;
        }
        .rating {
            color: #f59e0b;
        }
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #e5e7eb;
            font-size: 10px;
        }
        .footer p {
            margin-bottom: 5px;
            color: #666;
        }
        .footer .note {
            background: #fef3c7;
            padding: 10px;
            border-left: 3px solid #f59e0b;
            margin-top: 10px;
        }
        .page-number {
            position: absolute;
            bottom: 20px;
            right: 20px;
            font-size: 10px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Format Laporan Bagian Penjual (toko)</h1>
        <h2>(SRS-MartPlace-12)</h2>
        <h3>Laporan Daftar Produk Berdasarkan Stock</h3>
        <p>Tanggal dibuat: {{ now()->format('d-m-Y') }} oleh {{ auth()->user()->name }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 30%;">Produk</th>
                <th style="width: 20%;">Kategori</th>
                <th class="right" style="width: 15%;">Harga</th>
                <th class="center" style="width: 15%;">Rating</th>
                <th class="center" style="width: 15%;">Stock</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $index => $product)
            <tr>
                <td class="center">{{ $index + 1 }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category->name ?? 'Tanpa Kategori' }}</td>
                <td class="right">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                <td class="center rating">
                    ★ {{ number_format($product->avg_rating, 2) }}
                </td>
                <td class="center">
                    <span class="{{ $product->stock == 0 ? 'stock-low' : ($product->stock < 10 ? 'stock-medium' : 'stock-high') }}">
                        {{ $product->stock }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="center" style="padding: 20px; color: #999;">
                    Tidak ada data produk
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <div class="note">
            <strong>***)</strong> urutkan berdasarkan stock
        </div>
    </div>
</body>
</html>
