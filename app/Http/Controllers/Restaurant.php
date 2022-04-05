<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class Restaurant extends Controller
{
    function createRest(Request $req){
   
        $validator=Validator::make($req->all(),[
            "Address"=>"required|unique:Restaurant,resAddress",
            "RestName"=>"required|unique:Restaurant,resName",
            "OwnerName"=>"required",
            "mobile"=>"required|unique:Restaurant,resMobile",
            "openTime"=>"required",
            "closeTime"=>"required",
            "Location"=>"required|unique:Restaurant,resLoc"
        ]);
        $errors=$validator->errors();
        if(count($errors)>0)
        {
            return print_r(json_encode($errors,JSON_PRETTY_PRINT));
        }
        else{
            // Add In Database
            DB::insert('insert into Restaurant (resName,resLoc,resAddress,resOwnerName,resOpen,
            resClose,resMobile,uid_fk) values (?, ?,?,?,?,?,?,?)',
             [
                 $req->input('RestName'),
                 $req->input('Location'),
                 $req->input('Address'),
                 $req->input('OwnerName'),
                 $req->input('openTime'),
                 $req->input('closeTime'),
                 $req->input('mobile'),
                 session()->get("zomatoUser")->id
            
            
             ]);
             
             return 200;
        }


    }
}
