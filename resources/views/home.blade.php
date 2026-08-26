@extends('layouts.guest')

@section('title', 'Guestbook')

@section('content')

<div class="col-lg-8">

    <div class="card shadow-lg border-0">

        <div class="card-header bg-primary text-white text-center">
            <h3 class="mb-0">
                <i class="fas fa-book mr-2"></i>
                <h3 class="mb-0">Welcome! Form Guestbook</h3>
            </div>

            <div class="card-body">

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('guest.store') }}" method="POST">
                    @csrf

                    <div class="form-group mb-3">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>Telephone</label>
                        <input type="text" name="telephone" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>

                    <div class="form-group mb-3">
                        <label>Address</label>
                        <textarea name="address" rows="3" class="form-control" required></textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label>Agency Of Origin</label>
                        <input type="text" name="agency_of_origin" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>Target Employee</label>
                        <select name="employee_id" class="form-control" required>
                            <option value=""> Select Epmoloyee</option>

                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}">
                                    {{ $employee->name }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="form-group mb-4">
                        <label>Purpose</label>
                        <textarea name="purpose" rows="3" class="form-control" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">
                        Save
                    </button>

                </form>

            </div>
        </div>

    </div>
</div>

@endsection