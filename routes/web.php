<?php

use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\Auth;
use App\Http\Controllers\Orders;
use App\Http\Controllers\Pay;
use App\Http\Controllers\Restaurant;
use App\Http\Controllers\Profile;
use Illuminate\Support\Facades\DB;




Route::get("/",function(){
    
    return view("Welcome");
});

Route::get("/profile",function(){
    if(session()->has("zomatoUser")){
        $id=session()->get("zomatoUser")->id;
        $result=DB::select('select * from Restaurant where uid_fk = ? ', [$id]);
        return view("Profile",["data"=>$result]);
    }
    else{
        return redirect("/");
    }
});

Route::get("/addRestaurant",function(){
    if(session()->has("zomatoUser")){
        return view("Restaurant");
    }
    else{
        return redirect("/");
    }
});
Route::post("/login",[Auth::class,"login"]);
Route::post("/signOut",[Auth::class,"signOut"]);
Route::post("/signUp",[Auth::class,"signUp"]);
Route::post("/updateImage",[Auth::class,"updateImage"]);
Route::get("/getImage/{imageName}",[Auth::class,"getImage"]);

Route::post("/addRestaurantDB",[Restaurant::class,"createRest"]);


Route::post("/addItem",[Profile::class,"addItem"]);
Route::get("/allItems",[Profile::class,"getAllItems"]);
Route::get("/getItemImage/{imageName}",[Profile::class,"getImage"]);

Route::post("/addToCart",[Profile::class,"addToCart"]);
Route::get("/getCartValue",[Profile::class,"getCartValue"]);
Route::get("readOrders",[Orders::class,"readOrders"]);
Route::get("deleteOrder/{id}",[Orders::class,"deleteOrder"]);




Route::get("/cart",function(){
    if(session()->has("zomatoUser")){
        return view("cart");

    }
    else{
        return redirect("/");
    }
});

Route::post("submitPayment",[Pay::class,"submitPayment"]);

