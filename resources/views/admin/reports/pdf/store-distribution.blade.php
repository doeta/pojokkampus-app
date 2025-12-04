<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Daftar Toko Berdasarkan Lokasi Propinsi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 3px solid #000;
        }
        .header h1 {
            margin: 0 0 5px 0;
            font-size: 16px;
            font-weight: bold;
        }
        .header .subtitle {
            margin: 3px 0;
            font-size: 10px;
            color: #333;
        }
        .meta-info {
            margin-bottom: 20px;
            font-size: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        th {
            background-color: #f5f5f5;
            padding: 6px 8px;
            text-align: left;
            font-size: 10px;
            font-weight: bold;
            border: 1px solid #999;
        }
        td {
            padding: 5px 8px;
            border: 1px solid #999;
            font-size: 10px;
        }
        tr:nth-child(even) {
            background-color: #f9fafb;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 9px;
            color: #666;
        }
        .note {
            font-size: 9px;
            color: #666;
            font-style: italic;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Format Laporan Bagian Platform (pengelola market place)</h1>
        <div class="subtitle">(SRS-MartPlace-10)</div>
        <div class="subtitle"><strong>Laporan Daftar Toko Berdasarkan Lokasi Propinsi</strong></div>
        <div class="subtitle">Tanggal dibuat: {{ now()->format('d-m-Y') }} oleh {{ auth()->user()->name }}</div>
    </div>

    @if($storesByProvince->isEmpty())
        <p style="text-align: center; color: #666; padding: 15px;">Tidak ada data toko</p>
    @else
    <table>
        <thead>
            <tr>
                <th width="10%" style="text-align: center;">No</th>
                <th width="40%">Nama Toko</th>
                <th width="30%">Nama PIC</th>
                <th width="20%">Propinsi</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
            @endphp
            @foreach($storesByProvince as $provinsi => $sellers)
                @foreach($sellers as $seller)
                <tr>
                    <td style="text-align: center;">{{ $no++ }}</td>
                    <td>{{ $seller->nama_toko }}</td>
                    <td>{{ $seller->nama_pic }}</td>
                    <td>{{ $seller->provinsi }}</td>
                </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
    <div class="note">***) urutkan berdasarkan propinsi</div>
    @endif

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d F Y H:i') }} WIB</p>
    </div>
</body>
</html>
