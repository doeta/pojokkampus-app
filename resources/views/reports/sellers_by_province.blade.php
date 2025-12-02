<!DOCTYPE html>
<html>
<head>
    <title>Laporan Daftar Toko Berdasarkan Lokasi Propinsi</title>
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
    <h3>Laporan Daftar Toko Berdasarkan Lokasi Propinsi</h3>
    <div class="subtitle">Tanggal dibuat: {{ $generatedAt }} oleh {{ $generatedBy }}</div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="30%">Nama Toko</th>
                <th width="35%">Nama PIC</th>
                <th width="30%">Propinsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sellers as $index => $seller)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $seller->nama_toko }}</td>
                <td>{{ $seller->nama_pic }}</td>
                <td>{{ $seller->provinsi }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer-note">***) urutkan berdasarkan propinsi</div>
</body>
</html>
