@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

<!-- Content Row -->
        <div class="card shadow">
            <div class="card-header py-3 d-flex">
            <h1 class="h3 mb-0 text-gray-800">{{ __('Mütəxəssis yarat') }}</h1>
                <div class="ml-auto">
                    <a href="{{ route('admin.doctors.index') }}" class="btn btn-primary">
                        <span class="text">{{ __('Geriyə qayıt') }}</span>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.doctors.update', $doctor->id) }}" method="POST">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label for="name">{{ __('Ad') }}</label>
                        <input type="text" class="form-control" id="name" placeholder="{{ __('Ad') }}" name="name" value="{{ old('name', $doctor->name) }}" />
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">{{ __('Yadda Saxla') }}</button>
                </form>
            </div>
        </div>
        

    <!-- Content Row -->

</div>
@endsection
