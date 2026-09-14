@extends('layouts.app')

@section('title', 'Data Pasien - SIPKlin')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h5 class="h3 mb-0 text-gray-900">Data Pasien</h5>
</div>

<h1 class="h6 text-gray-800 mb-4">Data Klinik / Pasien</h1>

<div class="card">
   <div class="card-header d-flex justify-content-between align-items-center">

        <a href="{{ route('patients.create') }}" class="btn btn-sipklin px-4">
            <span class="fa fa-plus-circle mr-2"></span>
            <span>Tambah Pasien</span>
        </a>

        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="searchPasien" placeholder="Cari Pasien...">
        </div>
        
    </div>
</div>

   <div class="card-body">
    <table class="table table-striped table-hover dashboard-table" id="tablePasien">
        <thead>
            <tr>
                <th>No</th>
                <th>Nik</th>
                <th>Nama</th>
                <th>Tanggal Lahir</th>
                <th>Jenis Kelamin</th>
                <th>Alamat</th>
                <th>No Telp</th>
                <th width="150">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($patients as $patient)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $patient->nik }}</td>
                <td>{{ $patient->nama }}</td>
                <td>{{ $patient->tanggal_lahir }}</td>
                <td>{{ $patient->jenis_kelamin }}</td>
                <td>{{ $patient->alamat }}</td>
                <td>{{ $patient->no_telepon }}</td>

                <td>
                    <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-link text-secondary p-0 mx-1">
                        <span class="fa fa-eye"></span>
                    </a>

                    <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-link text-secondary p-0 mx-1">
                        <span class="fa fa-edit"></span>
                    </a>

                    <a href="javascript:void(0)" onclick="actionDestroy('{{ route('patients.destroy', $patient->id) }}')" class="btn btn-link text-danger p-0 mx-1">
                        <span class="fa fa-trash"></span>
                    </a>
                </td>
            </tr>

            @empty
            <tr>
                <td colspan="8" class="text-center">Belum ada data pasien</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="d-flex justify-content-end mt-3">
        {{ $patients->links() }}
    </div>
</div>

@push('styles')
<style>

    .btn-sipklin {
        background-color: #06285c !important;
        border-color: #06285c !important;
        color: white !important;
    }

    .btn-sipklin:hover {
        background-color: #041c40 !important;
        border-color: #041c40 !important;
        color: white !important;
    }

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

    .page-item.active .page-link {
        background-color: #06285c !important;
        border-color: #06285c !important;
        color: white !important;
    }

    .page-link {
        color: #06285c !important;
    }

    .page-link:hover {
        background-color: #EAF1FB !important;
        color: #06285c !important;
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


<form id="form-destroy" method="POST">
    @csrf
    @method('DELETE')
</form>

@endsection

@push('script')

<script>

document.getElementById('searchPasien').addEventListener('keyup', function () {
    let keyword = this.value.toLowerCase();
    let rows = document.querySelectorAll('#tablePasien tbody tr');

    rows.forEach(function (row) {
        let text = row.textContent.toLowerCase();

        if (text.includes(keyword)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

function actionDestroy(url) {
    Swal.fire({
        title: 'Apakah Anda yakin ingin menghapus data ini?',
        text: 'Data yang dihapus tidak dapat dikembalikan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $('#form-destroy').attr('action', url);
            $('#form-destroy').submit();
        }
    });
}
</script>

@if (Session::has('success'))
<script>
Swal.fire({
    title: "Berhasil!",
    text: "{{ Session::get('success') }}",
    icon: "success",
    timer: 2000,
    showConfirmButton: false
});
</script>
@endif
@endpush

