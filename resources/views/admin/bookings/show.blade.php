@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->


    <!-- Content Row -->
        <div class="card">
            <div class="card-header py-3 d-flex">
                <h6 class="m-0 font-weight-bold text-primary">
                    {{ __('Rezervasiyalar') }}
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover" cellspacing="0" width="100%">
                        <tr>
                            <th>Xəstənin adı</th>
                            <td>{{ $booking->customer_name }}</td>
                        </tr>
                        <tr>
                            <th>Xəstənin soyadı</th>
                            <td>{{ $booking->customer_surname }}</td>
                        </tr>
                        <tr>
                            <th>Mütəxəssis</th>
                            <td>{{ $booking->doctor->name }}</td>
                        <tr>
                            <th>Otaq</th>
                            <td>{{ $booking->room->room_number }}</td>
                        </tr>
                        <tr>
                            <th>Başlama tarixi</th>
                            <td>{{ $booking->time_from }}</td>
                        </tr>
                        <tr>
                            <th>Bitmə tarixi</th>
                            <td>{{ $booking->time_to }}</td>
                        </tr>
                        <tr>
                            <th>Qeyd</th>
                            @if($booking->additional_information == NULL)
                            <td>-</td>
                            @else
                            <td>{{ $booking->additional_information }}</td>
                            @endif
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    <!-- Content Row -->

</div>
@endsection
