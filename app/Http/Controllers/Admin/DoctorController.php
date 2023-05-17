<?php

namespace App\Http\Controllers\Admin;


use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\Admin\DoctorRequest;
use App\Http\Requests\DoctorRequest as RequestsDoctorRequest;
use Symfony\Component\HttpFoundation\Response;


class DoctorController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        // abort_if(Gate::denies('customer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $doctors = doctor::all();

        return view('admin.doctors.index', compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

        public function create()
    {
        // abort_if(Gate::denies('customer_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.doctors.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\DoctorRequest  $request
     * @return \Illuminate\Http\Response
     */

        public function store(DoctorRequest $request)
    {
        // abort_if(Gate::denies('customer_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        Doctor::create($request->validated());

        return redirect()->route('admin.doctors.index')->with([
            'message' => 'successfully created !',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Doctor  $doctor
     * @return \Illuminate\Http\Response
     */

        public function edit(Doctor $doctor)
    {
        // abort_if(Gate::denies('customer_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.doctors.edit', compact('doctor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\DoctorRequest  $request
     * @param  Doctor  $doctor
     * @return \Illuminate\Http\Response
     */

        public function update(DoctorRequest $request, Doctor $doctor)
    {
        // abort_if(Gate::denies('customer_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $doctor->update($request->validated());

        return redirect()->route('admin.doctors.index')->with([
            'message' => 'successfully updated !',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Doctor  $doctor
     * @return \Illuminate\Http\Response
     */

        public function destroy(Doctor $doctor)
    {
        // abort_if(Gate::denies('customer_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $doctor->delete();

        return redirect()->route('admin.doctors.index')->with([
            'message' => 'successfully deleted !',
            'alert-type' => 'success'
        ]);
    }

    public function massDestroy(Request $request)
    {
        // abort_if(Gate::denies('customer_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        Doctor::whereIn('id', request('ids'))->delete();

        return response()->noContent();
    }
}
