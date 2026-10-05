@extends('layouts.app')

@section('title', 'Data Poli - SIPKlin')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h5 class="h3 mb-0 text-gray-900">Data Poli</h5>
</div>

<h1 class="h6 text-gray-800 mb-4">Data Klinik / Poli</h1>

<div class="card">
   <div class="card-header d-flex justify-content-between align-items-center">

        <a href="{{ route('departments.create', request()->only(['page', 'search'])) }}" class="btn btn-sipklin px-4">
            <span class="fa fa-plus-circle mr-2"></span>
            <span>Tambah Poli</span>
        </a>

        <form action="{{ route('departments.index') }}" method="GET" class="search-box">
            <button type="submit" aria-label="Cari poli"><i class="fas fa-search"></i></button>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Poli...">
        </form>

    </div>
</div>

<div class="card-body">
   <table class="table table-striped table-hover datatable dashboard-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Poli</th>
                <th>Deskripsi</th>
                <th width="150">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($departments as $department)
            <tr>
                <td>{{ $departments->firstItem() + $loop->index }}</td>
                <td>{{ $department->name  }}</td>
                <td>{{ $department->description }}</td>

                <td>
                    <a href="{{ route('departments.show', array_merge(['department' => $department->id], request()->only(['page', 'search']))) }}" class="btn btn-link text-secondary p-0 mx-1">
                        <span class="fa fa-eye"></span>
                    </a>

                    <a href="{{ route('departments.edit', array_merge(['department' => $department->id], request()->only(['page', 'search']))) }}" class="btn btn-link text-secondary p-0 mx-1">
                        <span class="fa fa-edit"></span>
                    </a>

                    <a href="javascript:void(0)" onclick="actionDestroy(this.dataset.url)" data-url="{{ route('departments.destroy', array_merge(['department' => $department->id], request()->only(['page', 'search']))) }}" class="btn btn-link text-danger p-0 mx-1">
                        <span class="fa fa-trash"></span>
                    </a>
                </td>
            </tr>

            @empty
            <tr>
                <td colspan="4" class="text-center">Belum ada data poli</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center mt-3">
        {{ $departments->links('pagination::bootstrap-4') }}
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

    .search-box {
        position: relative;
        width: 220px;
    }

    .search-box button {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #06285c;
        border: 0;
        padding: 0;
        background: transparent;
        cursor: pointer;
    }

    .search-box input {
        width: 220px;
        height: 38px;
        border: 1px solid #06285c;
        border-radius: 5px;
        color: #06285c;
        padding-right: 35px;
    }

    .pagination .page-link {
        color: #06285c !important;
        border: 1px solid #ddd;
        font-size: 14px !important;
        line-height: 1.2;
        padding: 6px 10px;
    }

    .pagination .page-item.active .page-link {
        background-color: #06285c !important;
        border-color: #06285c !important;
        color: white !important;
    }

    .pagination .page-link:hover {
        background-color: #EAF1FB !important;
        color: #06285c !important;
    }

    .pagination svg {
        width: 16px !important;
        height: 16px !important;
        max-width: 16px !important;
        max-height: 16px !important;
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
