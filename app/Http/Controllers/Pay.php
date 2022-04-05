<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Pay extends Controller
{
    //
    function submitPayment(Request $req){

        $payerId=$req->input("payerId");
        $status=$req->input("status");
        $email=$req->input("email");
        $paymentId=$req->input("paymentId");
        $total=$req->input("total");
        $time=$req->input("time");

        $currentUser=session()->get("zomatoUser")->id;
        DB::insert('insert into Payments (paymentId, payerId,time,email,status,total,uid_fk) values (?, ?,?,?,?,?,?)',
         [$paymentId, $payerId,$time,$email,$status,$total,$currentUser]);

         return print_r($req->all());




    
    }
}
