<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Room;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Booking;
use App\Models\Doctor;

class SystemCalendarController extends Controller
{
    public $sources = [
        [
            'model'      => Booking::class,
            'date_field' => 'time_from',
            'date_field_to' => 'time_to',
            'field'      => 'additional_information',
            'prefix'     => '',
            'suffix'     => '',
            'route'      => 'admin.bookings.edit',
        ],
    ];

    public function index(Request $request)
    {
        $bookings = [];
        $rooms = Room::all()->pluck('room_number', 'id');
        $doctors = Doctor::all()->pluck('name', 'id');

        foreach ($this->sources as $source) {
            // If the request consists of only room, show all bookings in this room
            // If the request consists of only doctor, show all bookings of this doctor
            // If the request consists of both room and doctor, show all bookings of this doctor in this room
            if ($request->input('room')!="-" && $request->input('doctor')!="-") {
                $models = $source['model']::when($request->input('room'), function ($query) use ($request) {
                    $query->where('room_number', $request->input('room'));
                })
                ->when($request->input('doctor'), function ($query) use ($request) {
                    $query->where('doctor', $request->input('doctor'));
                })
                ->get();
            } else if ($request->input('room')!="-" && $request->input('doctor')=="-") {
                $models = $source['model']::when($request->input('room'), function ($query) use ($request) {
                    $query->where('room', $request->input('room'));
                })
                ->get();
            } else if ($request->input('doctor')!="-" && $request->input('room')=="-") {
                $models = $source['model']::when($request->input('doctor'), function ($query) use ($request) {
                    $query->where('doctor', $request->input('doctor'));
                })
                ->get();
            } else {
                $models = $source['model']::all();
            }
            foreach ($models as $model) {
                $crudFieldValue = $model->getOriginal($source['date_field']);
                $crudFieldValueTo = $model->getOriginal($source['date_field_to']);

                if (!$crudFieldValue && $crudFieldValueTo) {
                    continue;
                }

                $bookings[] = [
                    'title' => trim($source['prefix'] . " " . $model->{$source['field']}
                        . " " . $source['suffix']),
                    'start' => $crudFieldValue,
                    'end' => $crudFieldValueTo,
                    'url'   => route($source['route'], $model->id),
                ];
            }
        }

        return view('admin.calendar.calendar', compact('bookings', 'rooms', 'doctors'));

    }

}
