<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Nilai Magang</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 18px; }
        .header p { margin: 5px 0 0 0; font-size: 14px; }
        .info-table { width: 100%; margin-bottom: 20px; }
        .info-table td { padding: 5px; vertical-align: top; }
        .info-table .label { width: 150px; font-weight: bold; }
        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .data-table th, .data-table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .data-table th { background-color: #f4f4f4; text-align: center; }
        .text-center { text-align: center; }
    </style>
</head>
<body>

    <div class="header">
        <h1>REKAPITULASI NILAI MAGANG / PKL</h1>
        <p>Sistem Monitoring Magang (Simagang)</p>
    </div>

    <table class="info-table">
        <tr>
            <td class="label">Periode Magang</td>
            <td>: {{ $period->name }}</td>
        </tr>
        <tr>
            <td class="label">Tanggal Pelaksanaan</td>
            <td>: {{ $period->start_date->format('d M Y') }} - {{ $period->end_date->format('d M Y') }}</td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">NIM</th>
                <th width="25%">Nama Mahasiswa</th>
                <th width="20%">Perusahaan</th>
                <th width="20%">Dosen Pembimbing</th>
                <th width="10%">Nilai Akhir</th>
            </tr>
        </thead>
        <tbody>
            @forelse($internships as $index => $internship)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $internship->student->user->username }}</td>
                    <td>{{ $internship->student->user->name }}</td>
                    <td>{{ $internship->company->name }}</td>
                    <td>{{ $internship->lecturer->user->name }}</td>
                    <td class="text-center">
                        @if($internship->finalGrade)
                            <strong>{{ number_format($internship->finalGrade->final_score, 2) }}</strong>
                        @else
                            <span style="color: #999;">Belum Dinilai</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data magang yang disetujui pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
