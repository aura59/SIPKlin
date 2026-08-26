@extends('layouts.app')

@section('title', 'Employee Page')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Employees Page</h1>
</div>

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title mb-0">Data Employees</h5>

        <a href="{{ route('admin.employees.create') }}" class="btn btn-primary">
            <span class="fa fa-plus-circle mr-2"></span>
            <span>Create New</span>
        </a>
    </div>

    <div class="card-body">
        <table class="table table-striped table-hover datatable">
            <thead>
                <tr>
                    <th>Nip</th>
                    <th>Name</th>
                    <th>Position</th>
                    <th width="150">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($employees as $employee)
                <tr>
                    <td>{{ $employee->nip }}</td>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->position }}</td>

                    <td>
                        <a href="{{ route('admin.employees.show', $employee->id) }}"
                            class="btn btn-link text-secondary p-0 mx-1">
                            <span class="fa fa-eye"></span>
                        </a>

                        <a href="{{ route('admin.employees.edit', $employee->id) }}"
                            class="btn btn-link text-primary p-0 mx-1">
                            <span class="fa fa-edit"></span>
                        </a>

                        <a href="javascript:void(0)"
                            onclick="actionDestroy('{{ route('admin.employees.destroy', $employee->id) }}')"
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