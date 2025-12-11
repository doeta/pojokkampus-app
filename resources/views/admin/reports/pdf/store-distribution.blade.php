<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Daftar Toko Berdasarkan Lokasi Provinsi</title>
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
        th.center {
            text-align: center;
        }
        td {
            padding: 6px 8px;
            border: 1px solid #000;
            font-size: 11pt;
        }
        td.center {
            text-align: center;
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
        <h1>Laporan Sebaran Toko per Wilayah</h1>
    </div>
    
    <div class="meta-info">
        <div>Tanggal Dibuat: {{ now()->format('d F Y') }}</div>
        <div>Dibuat Oleh: {{ auth()->user()->name }}</div>
        @if($provinsi !== 'all')
        <div>Filter Provinsi: <strong>{{ $provinsi }}</strong></div>
        @endif
    </div>

    @if($stores->isEmpty())
        <p style="text-align: center; color: #666; padding: 15px;">Tidak ada data toko</p>
    @else
    <table>
        <thead>
            <tr>
                <th width="5%" class="center">No</th>
                <th width="35%">Nama Toko</th>
                <th width="30%">Nama PIC</th>
                <th width="30%">Provinsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stores as $index => $store)
            <tr>
                <td class="center">{{ $index + 1 }}</td>
                <td>{{ $store->nama_toko }}</td>
                <td>{{ $store->nama_pic }}</td>
                <td>{{ $store->provinsi }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="note">***) Data diurutkan berdasarkan provinsi</div>
    @endif
    
    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d F Y, H:i') }} WIB</p>
    </div>
</body>
</html>
