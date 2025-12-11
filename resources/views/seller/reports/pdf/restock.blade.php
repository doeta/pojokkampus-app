<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Restock Produk</title>
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
            border-bottom: 3px solid #dc2626;
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
        .alert-banner {
            background: #fee2e2;
            border-left: 4px solid #dc2626;
            padding: 15px;
            margin-bottom: 20px;
        }
        .alert-banner h3 {
            color: #991b1b;
            font-size: 14px;
            margin-bottom: 5px;
        }
        .alert-banner p {
            color: #7f1d1d;
            font-size: 11px;
        }
        .info-section {
            margin-bottom: 20px;
            background: #f3f4f6;
            padding: 15px;
            border-radius: 5px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }
        .info-box {
            text-align: center;
            padding: 10px;
            background: white;
            border-radius: 5px;
            border: 2px solid #fecaca;
        }
        .info-label {
            font-size: 10px;
            color: #666;
            margin-bottom: 5px;
        }
        .info-value {
            font-size: 18px;
            font-weight: bold;
            color: #dc2626;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th {
            background-color: #dc2626;
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
            background-color: #fef2f2;
        }
        tr.stock-zero {
            background-color: #fee2e2 !important;
        }
        .stock-zero-badge {
            display: inline-block;
            padding: 3px 8px;
            background: #dc2626;
            color: white;
            border-radius: 10px;
            font-size: 9px;
            font-weight: bold;
        }
        .stock-critical-badge {
            display: inline-block;
            padding: 3px 8px;
            background: #f59e0b;
            color: white;
            border-radius: 10px;
            font-size: 9px;
            font-weight: bold;
        }
        .stock-value {
            font-size: 16px;
            font-weight: bold;
        }
        .stock-zero-value {
            color: #dc2626;
        }
        .stock-critical-value {
            color: #f59e0b;
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
            background: #fee2e2;
            padding: 10px;
            border-left: 3px solid #dc2626;
            margin-top: 10px;
        }
        .footer .recommendations {
            background: #fef3c7;
            padding: 10px;
            border-left: 3px solid #f59e0b;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Format Laporan Bagian Penjual (toko)</h1>
        <h3>Laporan Daftar Produk Segera Dipesan</h3>
        <p>Tanggal dibuat: {{ now()->format('d-m-Y') }} oleh {{ auth()->user()->name }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 30%;">Nama Produk</th>
                <th class="center" style="width: 15%;">Stok</th>
                <th class="center" style="width: 15%;">Rating</th>
                <th style="width: 20%;">Kategori</th>
                <th class="right" style="width: 15%;">Harga</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $index => $product)
            <tr class="{{ $product->stock == 0 ? 'stock-zero' : '' }}">
                <td class="center">{{ $index + 1 }}</td>
                <td>{{ $product->name }}</td>
                <td class="center">
                    <span class="stock-value {{ $product->stock == 0 ? 'stock-zero-value' : 'stock-critical-value' }}">
                        {{ $product->stock }}
                    </span>
                </td>
                <td class="center rating">
                    ★ {{ number_format($product->avg_rating, 2) }}
                </td>
                <td>{{ $product->category->name ?? 'Tanpa Kategori' }}</td>
                <td class="right">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="center" style="padding: 20px; color: #059669; background: #d1fae5;">
                    ✓ Tidak ada produk yang membutuhkan restock. Semua stok dalam kondisi aman.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <div class="note">
            <strong>***)</strong> urutkan berdasarkan kategori dan produk
        </div>
    </div>
</body>
</html>
