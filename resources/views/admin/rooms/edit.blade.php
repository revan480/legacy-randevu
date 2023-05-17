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
            <h1 class="h3 mb-0 text-gray-800">{{ __('Otaq redaktə edin') }}</h1>
                <div class="ml-auto">
                    <a href="{{ route('admin.rooms.index') }}" class="btn btn-primary">
                        <span class="text">{{ __('Geriyə Qayıt') }}</span>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.rooms.update', $room->id) }}" method="POST">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label for="room_number">{{ __('Otaq nömrəsi') }}</label>
                        <input type="text" class="form-control" id="room_number" placeholder="{{ __('Otaq nömrəsi') }}" name="room_number" value="{{ old('room_number', $room->room_number) }}" />
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">{{ __('Yadda Saxla') }}</button>
                </form>
            </div>
        </div>
    

    <!-- Content Row -->

</div>
@endsection