<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Daftar Akun Penjual Berdasarkan Status</title>
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
        .section-title {
            background-color: #e0e0e0;
            padding: 8px;
            margin: 15px 0 8px 0;
            font-weight: bold;
            font-size: 11px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
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
        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
        }
        .badge-success {
            background-color: #d1fae5;
            color: #065f46;
        }
        .badge-warning {
            background-color: #fef3c7;
            color: #92400e;
        }
        .badge-danger {
            background-color: #fee2e2;
            color: #991b1b;
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
        <div class="subtitle">(SRS-MartPlace-09)</div>
        <div class="subtitle"><strong>Laporan Daftar Akun Penjual Berdasarkan Status</strong></div>
        <div class="subtitle">Tanggal dibuat: {{ now()->format('d-m-Y') }} oleh {{ auth()->user()->name }}</div>
    </div>

    <div class="section-title">PENJUAL AKTIF ({{ $activeSellers->count() }} akun)</div>
    @if($activeSellers->isEmpty())
        <p style="text-align: center; color: #666; padding: 15px;">Tidak ada penjual aktif</p>
    @else
    <table>
        <thead>
            <tr>
                <th width="5%" style="text-align: center;">No</th>
                <th width="23%">Nama User</th>
                <th width="23%">Nama PIC</th>
                <th width="23%">Nama Toko</th>
                <th width="13%" style="text-align: center;">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($activeSellers as $index => $seller)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $seller->name }}</td>
                <td>{{ $seller->seller->nama_pic ?? '-' }}</td>
                <td>{{ $seller->seller->nama_toko ?? '-' }}</td>
                <td style="text-align: center;">Aktif</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="note">***) urutkan berdasarkan status (aktif dulu baru tidak aktif)</div>
    @endif

    <div class="section-title">PENJUAL TIDAK AKTIF ({{ $inactiveSellers->count() }} akun)</div>
    @if($inactiveSellers->isEmpty())
        <p style="text-align: center; color: #666; padding: 15px;">Tidak ada penjual tidak aktif</p>
    @else
    <table>
        <thead>
            <tr>
                <th width="5%" style="text-align: center;">No</th>
                <th width="23%">Nama User</th>
                <th width="23%">Nama PIC</th>
                <th width="23%">Nama Toko</th>
                <th width="13%" style="text-align: center;">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inactiveSellers as $index => $seller)
            <tr>
                <td style="text-align: center;">{{ $activeSellers->count() + $index + 1 }}</td>
                <td>{{ $seller->name }}</td>
                <td>{{ $seller->seller->nama_pic ?? '-' }}</td>
                <td>{{ $seller->seller->nama_toko ?? '-' }}</td>
                <td style="text-align: center;">Tidak Aktif</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d F Y H:i') }} WIB</p>
    </div>
</body>
</html>
