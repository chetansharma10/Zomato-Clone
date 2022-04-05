<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Orders extends Controller
{
    function readOrders(){

        $uid=session()->get("zomatoUser")->id;
        $result=DB::select('select itemId from Orders where uid_fk = ?', [$uid]);
        $details=[];
        for($i=0;$i<count($result);$i++){
            $data=DB::select("select itemName,itemImg,itemPrice,itemId from Items where itemId=?",[$result[$i]->itemId]);
            array_push($details,$data);
        }
        
        return $details;
    }
    
    function deleteOrder($id){
        $currentUser=session()->get("zomatoUser")->id;
        DB::delete('delete from Orders where itemId = ? && uid_fk=?', [$id,$currentUser]);
        return true;
    }
  
  
}
