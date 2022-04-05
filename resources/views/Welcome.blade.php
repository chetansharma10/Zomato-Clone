<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="shortcut icon" href="{{asset('/fav.png')}}" type="image/x-icon">
    <link rel="stylesheet" href="{{asset('/css/Welcome.css')}}">
    <link rel="stylesheet" href="{{asset('/css/Dialog.css')}}">
    <link rel="stylesheet" href="{{asset('/css/Items.css')}}">

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
 
    <title>Zomato</title>
</head>
<body>
    <div class="main">

        {{-- Header --}}
        <div class="hd" style="background-image: url({{asset('images/background.avif')}})">
            <div class="nav-hd">
                <a href="/cart"><i class="material-icons">shopping_cart</i><sup id="cartValue" style="color:white;font-weight:bolder;">
                   
                   0
                 
                </sup></a>

                <a href="/addRestaurant">Add restaurant</a>
                @if( !session()->has("zomatoUser"))
                    <button class="nav-login">Login</button>
                    <button class="nav-signup">Sign up</button>
                @else
                    <button class="nav-profile">
                        @if(session()->get('zomatoUser')->userPic=='')
                            <img src="{{asset('images/default.jpg')}}" id="userImage">
                        @else
                            <img src="{{asset('getImage/'.session()->get('zomatoUser')->userPic)}}" id="userImage">
                        @endif
                    </button>
                    <div class="dropList">
                        @csrf
                        <button class="profileBtn" onclick="redirectTo()">Profile</button>
                        <button class="imgBtn" >Change Image</button>
                        <button onclick="signOut()">Log out</button>
                    </div>
                    <form enctype="multipart/form-data" action="/updateImage" method="POST" id="imageForm">
                        @csrf
                        <input type="file" hidden accept="image/*" id="chooseImg" >
                        <input type="submit" hidden id="submitImg" >
                    </form>
                @endif
                <script>
                   function redirectTo(){
                       window.location.pathname="/profile";
                   }
                </script>
                
              
               
              
            </div>
            <div class="content-hd">
                <img class="content-img" src="{{asset('images/zomato.avif')}}" alt="Zomato Icon">
                <p class="content-desc">Discover the best food & drinks in Ludhiana</p>
                <div class="content-search">
                    <div class="loc"><svg xmlns="http://www.w3.org/2000/svg" fill="#FF7E8B" width="20" height="20" viewBox="0 0 20 20" aria-labelledby="icon-svg-title- icon-svg-desc-" role="img" class="sc-rbbb40-0 iRDDBk" style=""><title>location-fill</title><path d="M10.2 0.42c-4.5 0-8.2 3.7-8.2 8.3 0 6.2 7.5 11.3 7.8 11.6 0.2 0.1 0.3 0.1 0.4 0.1s0.3 0 0.4-0.1c0.3-0.2 7.8-5.3 7.8-11.6 0.1-4.6-3.6-8.3-8.2-8.3zM10.2 11.42c-1.7 0-3-1.3-3-3s1.3-3 3-3c1.7 0 3 1.3 3 3s-1.3 3-3 3z" style=""></path></svg></div>
                    <input type="text" class="firstInput" placeholder="Location">
                    <div class="loc"><svg xmlns="http://www.w3.org/2000/svg" fill="#828282" width="18" height="18" viewBox="0 0 20 20" aria-labelledby="icon-svg-title- icon-svg-desc-" role="img" class="sc-rbbb40-0 iwHbVQ"><title>Search</title><path d="M19.78 19.12l-3.88-3.9c1.28-1.6 2.080-3.6 2.080-5.8 0-5-3.98-9-8.98-9s-9 4-9 9c0 5 4 9 9 9 2.2 0 4.2-0.8 5.8-2.1l3.88 3.9c0.1 0.1 0.3 0.2 0.5 0.2s0.4-0.1 0.5-0.2c0.4-0.3 0.4-0.8 0.1-1.1zM1.5 9.42c0-4.1 3.4-7.5 7.5-7.5s7.48 3.4 7.48 7.5-3.38 7.5-7.48 7.5c-4.1 0-7.5-3.4-7.5-7.5z"></path></svg></div>
                    <input type="text" class="lastInput" placeholder="Search for restaurant ,or a dish">
                </div>
            </div>
        </div>

    </div>
    {{-- SignUp and Login Component Dialog --}}
    <x-signUp />
    <x-login />

    <div class="foodItems">
        @csrf
        <h1>Latest </h1>

        <div class="itemsBox">
        </div>


    </div>
 


 
    <script src="{{asset('js/Welcome.js')}}"></script>

    <script>
        var obj=@json($errors??"");
        var accCreated=@json($accCreated??false);
        var loginSuccess=@json($loginSuccess??false);

        var keys = Object.keys(obj);

        for (var i = 0; i < keys.length; i++) {
            
            var val = obj[keys[i]];
            callToast(val);
        }

        if(accCreated){
            callToast("Account Created Successfully","green")
            dialogBox2.style.display="flex";
        }
        if(loginSuccess){
            callToast("Success...","green")
        }

      
    </script>

  
 
</body>
</html>