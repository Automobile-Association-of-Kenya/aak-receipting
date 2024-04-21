<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\flights;

class FlightsController extends Controller
{
    // function __construct()
    // {
    //     $this->middleware('auth');
    // }
    //
    function addFlight(Request $req){

        $flight=new flights;
        $flight->flightId=$req->flightId;
        $flight->memberId=$req->memberId;
        $flight->MembershipNumber=$req->MembershipNumber;
        $flight->MemberName=$req->MemberName;
        $flight->flightCode=$req->flightCode;
        $flight->departureAirport=$req->departureAirport;
        $flight->destinationAirport=$req->destinationAirport;
        $result=$flight->save();
        if($result)
        {
            return ["Result"=>"Data has been Saved"];
        }
        else
        {
            return ["Result"=>"The operation Failed"];
       }

    }

    function getFlight($memberId)
    {
        return flights::where("memberId",$memberId)->latest()->limit(5)->get();
    }

    function getAllFlights(){
         $data=flights::all();
        return view('flight',['flights'=>$data]);
    }
}
