<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;


class Profile extends Controller
{
    function addItem(Request $req){
   
        $validator=Validator::make($req->all(),[
            "itemName"=>"required",
            "itemType"=>"required",
            "itemPrice"=>"required",
            "itemDesc"=>"required",
            "id"=>"required"
        ]);
        $errors=$validator->errors();
        if(count($errors)>0){
            return print_r(json_encode($errors,JSON_PRETTY_PRINT));
        }
        else{

            
            // Handle Images
            $imagePath=$req->file("image")->store("public/itemsImages");
            $fileName=explode("public/itemsImages/",$imagePath)[1];


            DB::insert('insert into Items (itemName,itemType,itemPrice,itemDesc,itemImg,
            uid_resId) values (?,?,?,?,?,?)',
             [
                 $req->input('itemName'),
                 $req->input('itemType'),
                 $req->input('itemPrice'),
                 $req->input('itemDesc'),
                 $fileName,
                 $req->input('id')

            
             ]);
             
             return print_r($req->all());

        }
        

    }

    function getImage($imageName){
        $path = storage_path('app/public/itemsImages/'. $imageName);

        if (!File::exists($path)) {
            abort(404);
        }
    
        $file = File::get($path);
        
        $type = File::mimeType($path);
    
        $response = Response::make($file, 200);
    
        $response->header("Content-Type", $type);
    
        return $response;
    }


    function getAllItems(Request $req){
        $result=DB::select('select * from Items ');
        return $result;
    }

    

    function addToCart(Request $req){
      
        $itemId=$req->input('itemId');
        if(session()->has("zomatoUser")){
            $currentUserId=session()->get("zomatoUser")->id;
            $result=DB::select('select * from Orders where itemId = ? && uid_fk = ? ', [$itemId,$currentUserId]);
            if(count($result) ==0){
                DB::insert('insert into Orders (itemId, uid_fk) values (?, ?)', [$itemId,$currentUserId ]);
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return redirect("/");
        }



        
        
       
    }

    function getCartValue(){
        if(session()->has("zomatoUser")){
            $currentUserId=session()->get("zomatoUser")->id;

            // read Orders
            $result=DB::select('select * from Orders where uid_fk = ? ', [$currentUserId]);
            return count($result);
            
        }
        else{
            return 0;
        }
    }


}
