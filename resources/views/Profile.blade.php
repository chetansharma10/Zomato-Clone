@extends("Parent")
@section('title',"Profile")

@section('navBar')
    @parent
@stop

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

@section("addDetails")
    <div class="resDetails">
        <h1>Your Restaurants</h1>
        <p>Choose your restaurant and add food items</p>
        
        <form id="ress">
        </form>
        <br>
        <p>Add your restaurant food items</p>
        <form class="itemArea">
            @csrf
            <input type="text" id="itemName" placeholder="Food Item name">
            <input type="text" id="itemType" placeholder="Food Item type eg. Fast Food etc">

            <input type="number" id="itemPrice" placeholder="Food Item price">
            
            <textarea placeholder="Food Item Description" id="itemDesc"></textarea>

            <input type="file" accept="image/*" hidden id="itemImg1" >
            
            <button id="itemImg">Choose your Item Image</button>
            <button id="itemRes">Add Item to Restaurant</button>
        </form>

     
        
        
        <script>
            var data=@json($data);
            var ress=document.getElementById("ress");
            var elms="";
            for(let i=0;i<data.length;i++){
                let resName=data[i].resName;
                let resAddress=data[i].resAddress;
                let resOwnerName=data[i].resOwnerName;
                let resDate=data[i].resJoin;
                let resId=data[i].resId;

                elms+=`
                <br>
                <input type="radio" id="${resId}" name="restaurants" value="${resName}" class="selectRes" >
                <label for="${resId}" class="mylabel">
                    <b>${resName}</b><br>
                    <span><small>${resOwnerName}</small>  
                        <small> ,${resDate}<i> ${resAddress}</i></small>
                    </span>
                </label>
                
                `;

            }
            ress.innerHTML=elms;
        </script>
        <script src="{{asset('js/Profile.js')}}"></script>
        
    </div>
@stop