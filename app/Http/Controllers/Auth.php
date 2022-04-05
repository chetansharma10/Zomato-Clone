<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class Auth extends Controller
{
    function signUp(Request $req){
    
        $fullName=$req->input("fullName");
        $email=$req->input("email");
        $password=$req->input("password");
        $email_contain_name=preg_match("/$fullName/",$email);
        $userType=$req->input("userType");


        $validator=Validator::make($req->all(),[
            "fullName"=>"required|unique:Employee,fullName",
            "email"=>"required|unique:Employee,email",
            "password"=>"required|min:8",
            "userType"=>"required"
        ]);
        
        if(!$email_contain_name){
            
            $validator->errors()->add("Invalid Field","Full name Should be in Email");
            
        }
        $errors=$validator->errors();
        if(count($errors)>0){
            return view("Welcome",["errors"=>$errors]);
        }
        else{
            $password=Hash::make($password);
            DB::insert('insert into Employee(fullName,email,password,userType) values (?, ?,?,?)', [$fullName,$email,$password,$userType]);
            return view("Welcome",["accCreated"=>true]);
        }
    

    }
 
    function login(Request $req){
        
        $email=$req->input('email');
        $password=$req->input("password");
        $validator=Validator::make($req->all(),[
            "email"=>"required",
            "password"=>"required|min:8"
        ]);

        $errors=$validator->errors();
        if(count($errors)>0){
            return view("Welcome",["errors"=>$errors]);
        }
        else{
            $result=DB::select('select * from Employee where email = ? ', [$email]);
            if(count($result)==0){
               
                $validator->errors()->add("Invalid Email","Invalid Email Address");
                $errors=$validator->errors();
                return view("Welcome",["errors"=>$errors]);

            }
            else{
                $hashedPassword=$result[0]->password;
                if(Hash::check($password,$hashedPassword)){
                    //Put Data In Session
                    session()->put("zomatoUser",$result[0]);   
                    return view("Welcome",["loginSuccess"=>true]);

                }
                else{
                
                    $validator->errors()->add("PasswordError","Invalid Password");
                    $errors=$validator->errors();
                    return view("Welcome",["errors"=>$errors]);
                }
            }
        
        }




    }


    function signOut(Request $req){
        if($req->input('signOut')==true){
            if(session()->has("zomatoUser")){
                session()->flush();
            }
            
        }
        echo "Done";
    }

    function updateImage(Request $req){
        $validator=Validator::make($req->all(),[
            "image"=>"mimes:jpg|png|jpeg|svg|gif|max:2048"
        ]);
        $imagePath=$req->file("image")->store("public/uploads");
        
        $email=session()->get("zomatoUser")->email;
        $password=session()->get("zomatoUser")->password;
        $fileName=explode("public/uploads/",$imagePath)[1];

        session()->get('zomatoUser')->userPic=$fileName;
        // Save In Database
        $result=DB::update('update Employee set userPic = ? where email=? && password=?', [$fileName,$email,$password]);
      
        return $fileName;
    }


    function getImage($imageName){
        $path = storage_path('app/public/uploads/'. $imageName);

        if (!File::exists($path)) {
            abort(404);
        }
    
        $file = File::get($path);
        
        $type = File::mimeType($path);
    
        $response = Response::make($file, 200);
    
        $response->header("Content-Type", $type);
    
        return $response;
    }


    
    
}
