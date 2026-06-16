<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Laporan Peminjaman</title>
    <style>
        /* Pengaturan khusus untuk Microsoft Word agar kertas otomatis Landscape */
        @page WordSection1 {
            size: 841.9pt 595.3pt; /* Ukuran kertas A4 Landscape */
            mso-page-orientation: landscape;
            margin: 0.5in 0.5in 0.5in 0.5in;
        }
        div.WordSection1 {
            page: WordSection1;
        }
        
        /* Merapikan tabel dan sedikit mengecilkan font agar 12 kolom muat */
        table {
            border-collapse: collapse;
            width: 100%;
            font-size: 11px; 
        }
        th, td {
            word-wrap: break-word;
        }
        
        /* Styling untuk kotak informasi total */
        .summary-container {
            margin-bottom: 20px;
            font-family: sans-serif;
            font-size: 14px;
        }
        .summary-item {
            margin: 5px 0;
        }
    </style>
</head>

<body>

    <div class="WordSection1">

        <h2 style="text-align: center; font-family: sans-serif;">
            Laporan Peminjaman
        </h2>

        <div class="summary-container">
            <div class="summary-item">
                <strong>Total Peminjaman:</strong> {{ $totalPeminjaman ?? count($peminjamans) }}
            </div>
            <div class="summary-item">
                <strong>Total Denda Belum Lunas:</strong> Rp {{ number_format($totalDenda ?? 0, 0, ',', '.') }}
            </div>
        </div>

        <table border="1" cellspacing="0" cellpadding="4" width="100%">

            <thead>
                <tr style="background-color: #dddddd;">
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
                        <td style="text-align: center;">{{ $loop->iteration }}</td>
                        
                        <td>{{ $peminjaman->nama_peminjam }}</td>
                        
                        <td style="mso-number-format:'\@';">{{ $peminjaman->nik }}</td>
                        
                        <td>{{ $peminjaman->alamat_peminjam }}</td>
                        
                        <td style="text-align: center;">{{ $peminjaman->barang->nama_barang ?? '-' }}</td>
                        
                        <td style="text-align: center;">{{ $peminjaman->jumlah_pinjam }}</td>
                        
                        <td>{{ $peminjaman->catatan ?? '-' }}</td>
                        
                        <td style="text-align: center;">{{ $peminjaman->tanggal_pinjam }}</td>
                        
                        <td style="text-align: center;">{{ $peminjaman->tanggal_kembali }}</td>
                        
                        <td style="text-align: center;">{{ ucfirst($peminjaman->status) }}</td>
                        
                        <td style="white-space: nowrap;">
                            Rp {{ number_format($peminjaman->denda, 0, ',', '.') }}
                        </td>
                        
                        <td style="text-align: center;">
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

    </div>

</body>

</html>