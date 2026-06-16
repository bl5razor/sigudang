<table border="1">
    <thead>
        <tr>
            <th colspan="12" style="font-weight: bold; font-size: 16px; text-align: center;">
                LAPORAN PEMINJAMAN
            </th>
        </tr>
        
        <tr>
            <th colspan="2" style="font-weight: bold;">Total Peminjaman:</th>
            <th colspan="10" style="text-align: left;">
                {{ $totalPeminjaman ?? count($peminjamans) }}
            </th>
        </tr>

        <tr>
            <th colspan="2" style="font-weight: bold;">Total Denda Belum Lunas:</th>
            <th colspan="10" style="text-align: left;">
                Rp {{ number_format($totalDenda ?? 0, 0, ',', '.') }}
            </th>
        </tr>

        <tr>
            <th colspan="12"></th>
        </tr>

        <tr>
            <th>No</th>
            <th>Nama Peminjam</th>
            <th>NIK</th>
            <th>Alamat Peminjam</th>
            <th>Barang</th>
            <th>Jumlah</th>
            <th>Catatan</th>
            <th>Tanggal Pinjam</th>
            <th>Tanggal Kembali</th>
            <th>Status</th>
            <th>Denda</th>
            <th>Status Denda</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($peminjamans as $peminjaman)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $peminjaman->nama_peminjam }}</td>
                <td style="mso-number-format:'\@';">{{ $peminjaman->nik }}</td>
                <td>{{ $peminjaman->alamat_peminjam }}</td>
                <td>{{ $peminjaman->barang->nama_barang ?? '-' }}</td>
                <td>{{ $peminjaman->jumlah_pinjam }}</td>
                <td>{{ $peminjaman->catatan ?? '-' }}</td>
                <td>{{ $peminjaman->tanggal_pinjam }}</td>
                <td>{{ $peminjaman->tanggal_kembali }}</td>
                <td>{{ ucfirst($peminjaman->status) }}</td>
                <td>Rp {{ number_format($peminjaman->denda, 0, ',', '.') }}</td>
                <td>
                    @if ($peminjaman->denda > 0)
                        @if ($peminjaman->status_denda == 'lunas')
                            Lunas
                        @else
                            Belum Lunas
                        @endif
                    @else
                        Tidak Ada Denda
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>