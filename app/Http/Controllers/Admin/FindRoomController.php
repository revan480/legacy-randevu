<?php

namespace App\Http\Controllers\Admin;

use App\Models\Room;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Doctor;

class FindRoomController extends Controller
{
    public function index(Request $request){
        $time_from = $request->input('time_from');
        $time_to = $request->input('time_to');
        $room = $request->input('room');
        $doctor = $request->input('doctor');

        $rooms = Room::select('room_number')->get();
        $doctors = Doctor::select('name')->get();

        // dd($request);

        if ($request->isMethod('POST')) {
            // If request consist of only time_from and time_to show the bookings in this time range
            if($time_from && $time_to && $room == "-" && $doctor == "-")
            {
                $bookings = Booking::where('time_from', '>=', $time_from)
                        ->where('time_to', '<=', $time_to)
                        ->get();
            }
            // If request consist of only room show the bookings in this room
            elseif($time_from == "" && $time_to == "" && $room != "-" && $doctor == "-")
            {
                // Join tables booking and room to find the appropriate booking
                $bookings = Booking::join('rooms', 'bookings.room_id', '=', 'rooms.id')
                        ->where('room_number', '=', $room)
                        ->get();
            }
            // If request consist of only doctor show the booking with this doctor
            elseif($time_from == "" && $time_to == "" && $room == "-" && $doctor != "-")
            {
                // Join tables booking and room to find the appropriate booking
                $bookings = Booking::join('doctors', 'bookings.doctor_id', '=', 'doctors.id')
                        ->where('name', '=', $doctor)
                        ->get();
            }
            // If request consist of only time_from and time_to and room show the bookings in this time range and room
            elseif($time_from && $time_to && $room != "-" && $doctor == "-")
            {
                // Join tables booking and room to find the appropriate booking
                $bookings = Booking::join('rooms', 'bookings.room_id', '=', 'rooms.id')
                        ->where('time_from', '>=', $time_from)
                        ->where('time_to', '<=', $time_to)
                        ->where('room_number', '=', $room)
                        ->get();
            }
            // If request consist of only time_from and time_to and doctor show the bookings in this time range and doctor
            elseif($time_from && $time_to && $room == "-" && $doctor != "-")
            {
                // Join tables booking and room to find the appropriate booking
                $bookings = Booking::join('doctors', 'bookings.doctor_id', '=', 'doctors.id')
                        ->where('time_from', '>=', $time_from)
                        ->where('time_to', '<=', $time_to)
                        ->where('name', '=', $doctor)
                        ->get();
            }
            // If request consist of only room and doctor show the bookings with this room and doctor
            elseif(!$time_from && !$time_to && $room != "-" && $doctor != "-")
            {
                // Join tables booking and room to find the appropriate booking
                $bookings = Booking::join('rooms', 'bookings.room_id', '=', 'rooms.id')
                        ->join('doctors', 'bookings.doctor_id', '=', 'doctors.id')
                        ->where('room_number', '=', $room)
                        ->where('name', '=', $doctor)
                        ->get();
            }
            // If request consist of time_from, time_to, room and doctor show the bookings in this time range, room and doctor
            elseif($time_from && $time_to && $room != "-" && $doctor != "-")
            {
                // Join tables booking and room to find the appropriate booking
                $bookings = Booking::join('rooms', 'bookings.room_id', '=', 'rooms.id')
                        ->join('doctors', 'bookings.doctor_id', '=', 'doctors.id')
                        ->where('time_from', '>=', $time_from)
                        ->where('time_to', '<=', $time_to)
                        ->where('room_number', '=', $room)
                        ->where('name', '=', $doctor)
                        ->get();
            }
            


        } else {
            $rooms = Room::select('room_number')->get();
            $doctors = Doctor::select('name')->get();
            $bookings = [];
        }

        return view('admin.find_rooms.index', compact('bookings','doctors','rooms', 'time_from', 'time_to'));
    }
}
