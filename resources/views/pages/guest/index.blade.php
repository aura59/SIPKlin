@extends('layouts.app')

@section('title', 'Guest Page')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Guest Data</h1>
</div>

<div class="card-body">
    <table class="table table-striped table-hover datatable">
        <thead>
            <tr>
                <th>Name</th>
                <th>Telephone</th>
                <th>Email</th>
                <th>Agency Of Origin</th>
                <th width="120">Action</th>
            </tr>
        </thead>

        <tbody>
            @foreach($guests as $guest)
            <tr>
                <td>{{ $guest->name }}</td>
                <td>{{ $guest->telephone }}</td>
                <td>{{ $guest->email }}</td>
                <td>{{ $guest->agency_of_origin }}</td>

                <td>
                    <a href="{{ route('admin.guest.show', $guest->id) }}"
                        class="btn btn-link text-secondary p-0 mx-1">
                        <span class="fa fa-eye"></span>
                    </a>

                    <a href="javascript:void(0)"
                        onclick="actionDestroy('{{ route('admin.guest.destroy', $guest->id) }}')"
                        class="btn btn-link text-danger p-0 mx-1">
                        <span class="fa fa-trash"></span>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@push('styles')
@endpush

@push('script')

@if(Session::has('success'))
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