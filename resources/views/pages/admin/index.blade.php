@extends('layouts.app')

@section('title', 'Admin Page')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Admin Page</h1>
</div>

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title mb-0">Data Admin</h5>

        <a href="{{ route('admin.admins.create') }}" class="btn btn-primary">
            <span class="fa fa-plus-circle mr-2"></span>
            <span>Create New</span>
        </a>
    </div>

    <div class="card-body">
        <table class="table table-striped table-hover datatable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th width="150">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>

                    <td>
                        <a href="{{ route('admin.admins.show', $user->id) }}"
                            class="btn btn-link text-secondary p-0 mx-1">
                            <span class="fa fa-eye"></span>
                        </a>

                        <a href="{{ route('admin.admins.edit', $user->id) }}"
                            class="btn btn-link text-primary p-0 mx-1">
                            <span class="fa fa-edit"></span>
                        </a>

                        <a href="javascript:void(0)"
                            onclick="actionDestroy('{{ route('admin.admins.destroy', $user->id) }}')"
                            class="btn btn-link text-danger p-0 mx-1">
                            <span class="fa fa-trash"></span>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<form id="form-destroy" method="POST">
    @csrf
    @method('DELETE')
</form>

@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}">
@endpush

@push('script')
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<script>
$(document).ready(function () {
    $('.datatable').DataTable();
});

function actionDestroy(url) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
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
        title: "Success!",
        text: "{{ Session::get('success') }}",
        icon: "success",
        timer: 2000,
        showConfirmButton: false
    });
    </script>
    @endif
@endpush