<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
  
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
   
   
    <link rel="shortcut icon" href="{{asset('/fav.png')}}" type="image/x-icon">
   
    <link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="{{asset('/css/Restaurant.css')}}">
    <link rel="stylesheet" href="{{asset('/css/Profile.css')}}">
    <link rel="stylesheet" href="{{asset('/css/Cart.css')}}">


    



</head>
<body>
    @section('navBar')
            <div class="navBar">
                <img src="{{asset('/images/business.webp')}}">
                <div class="currentUser">
                    @if(@session()->has('zomatoUser'))
                    
                    @if(session()->get('zomatoUser')->userPic=='')
                    <img src="{{asset('images/default.jpg')}}" id="userImage">
                    @else
                        <img src="{{asset('getImage/'.session()->get('zomatoUser')->userPic)}}" id="userImage">
                    @endif



                    @endif




                    <button class="userDrops">
                    <i class="material-icons">menu</i>
                    </button>
                </div>
            </div>
            <div class="dropDown">
                @csrf
                <button class="logOutBtn" onclick="logOut()">Log out</button>
            </div>
            <script>

                function logOut(){
                    var xhr=new XMLHttpRequest();
                    var token=document.querySelector(".dropDown").children[0].value

                    xhr.open("POST","/signOut");
                    xhr.setRequestHeader("X-CSRF-TOKEN",token);
                    let formData=new FormData()
                    formData.append("signOut",true);
                    
                    xhr.send(formData);
                    xhr.onreadystatechange=function(){
                        if(xhr.status==200 && xhr.readyState==4){
                            if(xhr.response=="Done"){
                                window.location.href="/";
                            }
                        }
                    }
                }



            </script>
    @show
    @yield('addDetails')
    <script src="{{asset('/js/Restaurant.js')}}"></script>

</body>
</html>