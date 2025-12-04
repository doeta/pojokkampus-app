<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Produk Berdasarkan Rating</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h2 {
            margin: 5px 0;
            font-size: 16px;
        }
        .header p {
            margin: 3px 0;
            font-size: 10px;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th {
            background-color: #9333ea;
            color: white;
            padding: 8px;
            text-align: left;
            font-size: 10px;
            border: 1px solid #7e22ce;
        }
        td {
            padding: 6px 8px;
            border: 1px solid #ddd;
            font-size: 10px;
        }
        tr:nth-child(even) {
            background-color: #f9fafb;
        }
        .footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            font-size: 9px;
            color: #666;
        }
        .rating {
            color: #fbbf24;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Produk Berdasarkan Rating</h2>
        <p>SRS-MartPlace-11</p>
        <p>Format Laporan Bagian Penjual (toko)</p>
        <p>Tanggal: {{ date('d-m-Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 25%;">Produk</th>
                <th style="width: 15%;">Kategori</th>
                <th style="width: 15%;">Harga</th>
                <th style="width: 10%;">Rating</th>
                <th style="width: 15%;">Nama Toko</th>
                <th style="width: 15%;">Propinsi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $index => $item)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $item['product']->name }}</td>
                <td>{{ $item['product']->category->name ?? '-' }}</td>
                <td>Rp {{ number_format($item['product']->price, 0, ',', '.') }}</td>
                <td>
                    <span class="rating">★</span> {{ number_format($item['avg_rating'], 1) }} ({{ $item['total_reviews'] }})
                </td>
                <td>{{ $item['seller_name'] }}</td>
                <td>{{ $item['province'] }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; padding: 20px;">
                    Tidak ada data produk dengan rating
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Catatan: Daftar produk diurutkan berdasarkan rating tertinggi ke terendah</p>
    </div>
</body>
</html>
