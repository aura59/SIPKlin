@extends('layouts.app')

@section('title', 'Jadwal Saya - SIPKlin')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h5 class="h3 mb-0 text-gray-900">Jadwal Saya</h5>
</div>

<h1 class="h6 text-gray-800 mb-4">Data Klinik / Jadwal Saya</h1>

<div class="card">
    <div class="card-header d-flex justify-content-end align-items-center">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="searchJadwalDokter" placeholder="Cari Jadwal...">
        </div>
    </div>

    <div class="card-body">
        <table class="table table-striped table-hover dashboard-table" id="tableJadwalDokter">
            
        <thead>
            <tr>
                <th>No</th>
                <th>Poli</th>
                <th>Hari</th>
                <th>Jam Mulai</th>
                <th>Jam Selasai</th>
                <th>Kuota Tersedia</th>
                <th width="80">Aksi</th>
            </tr>
        </thead>

        <tbody>

                @forelse($doctorschedules as $schedule)

                <tr>
                    <td>{{ $doctorschedules->firstItem() + $loop->index }}</td>
                    <td>{{ $schedule->doctor->department->name ?? '-' }}</td>
                    <td>{{ $schedule->hari }}</td>
                    <td>{{ \Carbon\Carbon::parse($schedule->jam_mulai)->format('H:i') }}</td>
                    <td>{{ \Carbon\Carbon::parse($schedule->jam_selesai)->format('H:i') }}</td>
                    <td>{{ max(0, $schedule->kuota - $schedule->registration_today_count) }}</td>
                    <td class="text-center">
                        <a href="{{ route('doctorschedules.show', $schedule->id) }}" class="btn btn-link text-secondary p-0 mx-1">
                            <span class="fa fa-eye"></span>
                        </a>
                    </td>
                </tr>

                @empty

                <tr>
                    <td colspan="7" class="text-center">
                        Belum ada jadwal dokter
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

        <div class="d-flex justify-content-end mt-3">
            {{ $doctorschedules->links() }}
        </div>
    </div>
</div>

@push('styles')
<style>

    .search-box {
        position: relative;
        width: 220px;
    }

    .search-box i {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #06285c;
    }

    .search-box input {
        width: 220px;
        height: 38px;
        border: 1px solid #06285c;
        border-radius: 5px;
        color: #06285c;
        padding-right: 35px;
    }

    .dashboard-table,
    .dashboard-table th,
    .dashboard-table td {
        border: 1px solid #afaeae !important;
        color: #06285c !important;
    }

    .dashboard-table thead th {
        background-color: #06285c !important;
        color: white !important;
        font-weight: bold;
        text-align: center;
        vertical-align: middle;
    }

    .dashboard-table tbody td {
        color: #06285c !important;
        vertical-align: middle;
    }

    .dashboard-table tbody tr:hover {
        background-color: #EAF1FB !important;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f4f7fc !important;
    }

    .dashboard-table th:first-child,
    .dashboard-table td:first-child {
        width: 60px !important;
        max-width: 60px;
        text-align: center;
    }

    .pagination {
        margin-bottom: 0;
    }

    .pagination .page-link {
        color: #06285c;
        border: 1px solid #ddd;
    }

    .pagination .page-item.active .page-link {
        background-color: #06285c;
        border-color: #06285c;
        color: white;
    }

    .pagination .page-link:hover {
        background-color: #EAF1FB;
        color: #06285c;
    }

</style>
@endpush


@endsection


@push('script')
<script>

document.getElementById('searchJadwalDokter').addEventListener('keyup', function () {

    let keyword = this.value.toLowerCase();
    let rows = document.querySelectorAll('#tableJadwalDokter tbody tr');

    rows.forEach(function (row) {

        let text = row.textContent.toLowerCase();

        if (text.includes(keyword)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }

    });

});

</script>
@endpush