@extends("Parent")
@section('title',"Add Restaurant")


@section('navBar')
    @parent
@stop



@section('addDetails')
    <div class="resDetails">
       
        <form id="formx">
            @csrf
            <h1>Restaurant Details</h1>
            <p>Name, Address and Location</p>
            <input type="text" placeholder="Restaurant Name" name="resName" required>
            <input type="text" placeholder="Restaurant Complete Address" name="resAdd" required>
            <div id="map">
            </div>
            <div class="latlog">
                <input type="text" placeholder="Latitude" id="lati" name="long">
                <input type="text" placeholder="Longitude" id="longi" name="lati" >
                <button class="manual">
                   Verify
                </button>
            </div>
            <h1>Contact Details</h1>
            <p>Your customers will call on this number for general enquiries</p>
            <input type="text" placeholder="Owner Name" name="ownerName" required>
            <input type="number" placeholder="Mobile Number" name="mobileNumber" required>
            <p style="font-size: 11px;">Opening Time</p>
            <input type="time" name="openTime" required>
            <p style="font-size: 11px;">Closing Time</p>
            <input type="time" name="closeTime" required>
            <button id="createRest">Create Restaurant</button>
        </form>

    </div>
@stop
