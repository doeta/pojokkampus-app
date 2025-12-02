<!DOCTYPE html>
<html>
<head>
    <title>Laporan Daftar Akun Penjual Berdasarkan Status</title>
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
    <h3>Laporan Daftar Akun Penjual Berdasarkan Status</h3>
    <div class="subtitle">Tanggal dibuat: {{ $generatedAt }} oleh {{ $generatedBy }}</div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="25%">Nama User</th>
                <th width="25%">Nama PIC</th>
                <th width="25%">Nama Toko</th>
                <th width="20%">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sellers as $index => $seller)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $seller->user->name }}</td>
                <td>{{ $seller->nama_pic }}</td>
                <td>{{ $seller->nama_toko }}</td>
                <td>
                    @if($seller->verification_status == 'approved')
                        Aktif
                    @elseif($seller->verification_status == 'pending')
                        Pending
                    @else
                        Tidak Aktif
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer-note">***) urutkan berdasarkan status (aktif dulu baru tidak aktif)</div>
</body>
</html>
