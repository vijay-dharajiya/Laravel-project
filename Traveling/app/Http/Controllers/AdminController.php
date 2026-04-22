<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Flight;

class AdminController extends Controller
{
    function addflight(){
        return view('admin.addflight');
    }

    function viewflight(){
        //return flight::all();
        $flights = flight::all();
        return view('admin.viewflight', compact('flights'));
    }

    function postAddflight(request $rq){
        $flight = new flight;
        $flight-> airline_name = $rq->airline_name;
        $flight-> from_city = $rq-> from_city;
        $flight-> to_city = $rq-> to_city;
        $flight-> departure_time = $rq-> departure_time;
        $flight-> arrival_time = $rq-> arrival_time;
        $flight-> price = $rq-> price;
        $flight->save();
        return redirect()->route('admin.viewflight')->with('msg' , 'Flight Added Successfully');
    }

    function editflight($id){
        $flight = flight::findOrfail($id);
        return view('admin.updateflight', compact('flight'));
    }

    function posteditflight(request $rq, $id){
        $flight = flight::findOrfail($id);
        $flight-> airline_name = $rq->airline_name;
        $flight-> image = $rq->image;
        $flight-> from_city = $rq-> from_city;
        $flight-> to_city = $rq-> to_city;
        $flight-> departure_time = $rq-> departure_time;
        $flight-> arrival_time = $rq-> arrival_time;
        $flight-> price = $rq-> price;
        $flight->save();
        return redirect()->route('admin.viewflight')->with('msg' , 'Flight Updated Successfully');
    }

    function deleteflight($id){
        $flight = flight::findOrfail($id);
        $flight->delete();
        return redirect()->route('admin.viewflight')->with('msg' , 'Flight Deleted Successfully');
    }

    /*HOTELS FUNCTIONS*/ 

    function addhotel(){
        return view('admin.addhotel');
    }
}
