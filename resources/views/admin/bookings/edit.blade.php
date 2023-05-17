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
            <h1 class="h3 mb-0 text-gray-800">{{ __('Rezervasiyanın redaktəsi') }}</h1>
                <div class="ml-auto">
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-primary">
                        <span class="text">{{ __('Geriyə qayıd') }}</span>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label for="customer_name">{{ __('Xəstənin Adı') }}</label>
                        {{-- <select class="form-control" name="customer_id" id="customer">
                            @foreach($customers as $id => $customer)
                                <option value="{{ $id }}">{{ $customer }}</option>
                            @endforeach
                        </select> --}}
                        <input class="form-control" type="text" name="customer_name" id="customer_name" value="{{ old('customer_name', $booking->customer_name) }}">
                    </div>
                    <div class="form-group">
                        <label for="customer_surname">{{ __('Xəstənin Soyadı') }}</label>
                        {{-- <select class="form-control" name="customer_id" id="customer">
                            @foreach($customers as $id => $customer)
                                <option value="{{ $id }}">{{ $customer }}</option>
                            @endforeach
                        </select> --}}
                        <input class="form-control" type="text" name="customer_surname" id="customer_surname" value="{{ old('customer_surname', $booking->customer_surname) }}">
                    </div>
                    <div class="form-group">
                        <label for="doctor">{{ __('Mütəxəssis') }}</label>
                        <select class="form-control" name="doctor_id" id="doctor">
                            @foreach($doctors as $id => $doctor)
                                <option value="{{ $id }}">{{ $doctor }}</option>
                            @endforeach
                        </select>
                        {{-- <input class="form-control" type="text" name="doctor" id="doctor" value="{{ old('doctor', $booking->doctor) }}"> --}}
                    </div>
                    <div class="form-group">
                        <label for="room">{{ __('Otaq') }}</label>
                        <select class="form-control" name="room_id" id="room">
                            @foreach($rooms as $id => $room)
                                <option value="{{ $id }}">{{ $room }}</option>
                            @endforeach
                        </select>
                        {{-- <input class="form-control" type="text" name="room" id="room" value="{{ old('room', $booking->room) }}"> --}}
                    </div>
                    <div class="form-group">
                        <label for="time_from">{{ __('Başlama tarixi') }}</label>
                        <input type="text" class="form-control datetimepicker" id="time_from" name="time_from" value="{{ old('time_from', $booking->time_from) }}" />
                    </div>
                    <div class="form-group">
                        <label for="time_to">{{ __('Bitmə tarixi') }}</label>
                        <input type="text" class="form-control datetimepicker" id="time_to" name="time_to" value="{{ old('time_to', $booking->time_to) }}" />
                    </div>
                    <div class="form-group">
                        <label for="additional_information">{{ __('Qeyd') }}</label>
                        <textarea class="form-control" name="additional_information" id="additional_information"  cols="30" rows="10">{{ old('additional_information', $booking->additional_information) }}</textarea>
                    </div>
                    {{-- <div class="form-group">
                        <label for="status">{{ __('Status') }}</label>
                        <select class="form-control" name="status" id="status">
                                <option value="0" {{ $booking->status == 0 ? 'selected' : null }} >Created</option>
                                <option value="1" {{ $booking->status == 1 ? 'selected' : null }} >Completed</option>
                                <option value="2" {{ $booking->status == 2 ? 'selected' : null }} >Concelled</option>
                        </select>
                    </div> --}}
                    <button type="submit" class="btn btn-primary btn-block">{{ __('Save') }}</button>
                </form>
            </div>
        </div>


    <!-- Content Row -->

</div>
@endsection


@push('style-alt')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
@endpush

@push('script-alt')
<script src="https://cdn.datatables.net/select/1.2.0/js/dataTables.select.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script>
        $('.datetimepicker').datetimepicker({
            format: "YYYY-MM-DD HH:mm"
        });
    </script>
@endpush
