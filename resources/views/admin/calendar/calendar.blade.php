@extends('layouts.admin')
@section('content')

<div class="container">
    <div class="card">
        <div class="card-header">
            Kalendar
        </div>

        <div class="card-body">
            <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css' />
            <form>
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="room">Otaq</label>
                            <select class="form-control select2" name="room" id="room">
                                <option value="-">--Otaq seçin--</option>
                                @foreach($rooms as $room)
                                    <option value="{{ $room }}">{{ $room }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="doctor">Mütəxəssis</label>
                            <select class="form-control select2" name="doctor" id="doctor">
                                <option value="-">--Mütəxəssis seçin--</option>
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor }}">{{ $doctor }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary mt-4">
                            Axtar
                        </button>
                    </div>
                </div>
            </form>

            <div id='calendar'></div>
        </div>
    </div>
</div>

@endsection

@push('script-alt')
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script>
<script>
    $(document).ready(function () {
            // page is now ready, initialize the calendar...

            bookings={!! json_encode($bookings) !!};
            // console.log(bookings);

            $('#calendar').fullCalendar({
                header: {
                    left: 'prev',
                    center: 'title',
                    right: 'next, today, agendaWeek, agendaDay'
                }


            });
        });
</script>

@endpush
