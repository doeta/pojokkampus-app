<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Performa Rating Produk</title>
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
            margin: 0;
            font-size: 12pt;
            font-weight: normal;
        }
        .header h2 {
            margin: 5px 0;
            font-size: 14pt;
            font-weight: bold;
        }
        .header .subtitle {
            margin: 5px 0;
            font-size: 11pt;
            font-style: italic;
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
        th.center {
            text-align: center;
        }
        th.right {
            text-align: right;
        }
        td {
            padding: 6px 8px;
            border: 1px solid #000;
            font-size: 11pt;
        }
        td.center {
            text-align: center;
        }
        td.right {
            text-align: right;
        }
        .footer {
            margin-top: 20px;
            font-size: 10pt;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Performa Rating Produk</h2>
        <div class="subtitle">Tanggal dibuat: {{ now()->format('d-m-Y') }} oleh {{ auth()->user()->name }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%" class="center">No</th>
                <th width="30%">Produk</th>
                <th width="20%">Kategori</th>
                <th width="20%" class="right">Harga</th>
                <th width="12%" class="center">Stock</th>
                <th width="13%" class="center">Rating</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $index => $product)
            <tr>
                <td class="center">{{ $index + 1 }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category->name ?? 'Tanpa Kategori' }}</td>
                <td class="right">{{ number_format($product->price, 0, ',', '.') }}</td>
                <td class="center">{{ $product->stock }}</td>
                <td class="center">{{ number_format($product->avg_rating, 2) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="center" style="padding: 20px;">
                    Tidak ada data produk
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        ***) urutkan berdasarkan rating
    </div>
</body>
</html>
