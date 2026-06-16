<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>

    <h2>Reminder Pengembalian Barang</h2>

    <p>Halo {{ $peminjaman->nama_peminjam }},</p>

    <p>
        Ini adalah pengingat bahwa masa peminjaman barang Anda akan berakhir besok.
    </p>

    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <td><b>Barang</b></td>
            <td>{{ $peminjaman->barang->nama_barang }}</td>
        </tr>

        <tr>
            <td><b>Tanggal Pinjam</b></td>
            <td>{{ $peminjaman->tanggal_pinjam }}</td>
        </tr>

        <tr>
            <td><b>Tanggal Kembali</b></td>
            <td>{{ $peminjaman->tanggal_kembali }}</td>
        </tr>
    </table>

    <br>

    <p>
        Mohon segera mengembalikan barang tepat waktu untuk menghindari denda.
    </p>

    <p>
        Terima kasih.<br>
        SI Gudang Desa Daleman
    </p>

</body>
</html>