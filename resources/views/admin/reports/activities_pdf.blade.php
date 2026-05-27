<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Kegiatan Magang</title>
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
        .data-table th { background-color: #f4f4f4; }
        .section-title { font-size: 14px; font-weight: bold; margin-bottom: 10px; margin-top: 20px; background-color: #eee; padding: 5px; }
    </style>
</head>
<body>

    <div class="header">
        <h1>LAPORAN KEGIATAN MAGANG / PKL</h1>
        <p>Sistem Monitoring Magang (Simagang)</p>
    </div>

    <table class="info-table">
        <tr>
            <td class="label">Nama Mahasiswa</td>
            <td>: {{ $studentUser->name }}</td>
            <td class="label">NIM</td>
            <td>: {{ $studentUser->username }}</td>
        </tr>
    </table>

    @forelse($internships as $internship)
        <div style="border: 1px solid #333; padding: 10px; margin-bottom: 20px;">
            <table class="info-table" style="margin-bottom: 0;">
                <tr>
                    <td class="label">Perusahaan</td>
                    <td>: {{ $internship->company->name }}</td>
                    <td class="label">Periode</td>
                    <td>: {{ $internship->internshipPeriod->name }}</td>
                </tr>
                <tr>
                    <td class="label">Dosen Pembimbing</td>
                    <td>: {{ $internship->lecturer->user->name }}</td>
                    <td class="label">Status</td>
                    <td>: {{ ucfirst($internship->status) }}</td>
                </tr>
            </table>

            <div class="section-title">Laporan Mingguan (Weekly Reports)</div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th width="10%">Minggu Ke</th>
                        <th width="20%">Tanggal Mulai</th>
                        <th width="20%">Tanggal Selesai</th>
                        <th width="35%">Ringkasan / Kegiatan</th>
                        <th width="15%">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($internship->weeklyReports as $report)
                        <tr>
                            <td style="text-align: center;">{{ $report->week_number }}</td>
                            <td>{{ $report->start_date->format('d M Y') }}</td>
                            <td>{{ $report->end_date->format('d M Y') }}</td>
                            <td>{{ Str::limit($report->summary ?? 'Tidak ada ringkasan', 100) }}</td>
                            <td>{{ ucfirst($report->status) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center;">Belum ada laporan mingguan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="section-title">Sesi Bimbingan (Mentorship Sessions)</div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th width="20%">Tanggal</th>
                        <th width="15%">Media</th>
                        <th width="35%">Topik Diskusi</th>
                        <th width="15%">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($internship->mentorshipSessions as $session)
                        <tr>
                            <td>{{ $session->date->format('d M Y H:i') }}</td>
                            <td>{{ ucfirst($session->type) }}</td>
                            <td>{{ Str::limit($session->discussion_topics ?? 'Belum ada topik', 100) }}</td>
                            <td>{{ ucfirst($session->status) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center;">Belum ada sesi bimbingan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @empty
        <p style="text-align: center; color: #666;">Mahasiswa ini belum memiliki data magang yang disetujui atau selesai.</p>
    @endforelse

</body>
</html>
