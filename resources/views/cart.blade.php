@extends("Parent")

@section("addDetails")
    <!-- Replace "test" with your own sandbox Business account app client ID -->
    <script src="https://www.paypal.com/sdk/js?client-id=AYWdEQEuNKDH-v-B6egaavUDIMloybJZEaFnuhIvK7w6FhsSMbQCIsS0gzKrtKRjnIWCbdpIjjs96HTe&currency=USD"></script>
    <!-- Set up a container element for the button -->
    <div class="mainCart">
        <div class="itemsArea">
            <h2>Your Cart Items</h2>
            <h5>Total Amount is <strong id="totalPrice" >$0</strong></h5>



            <div class="cartItems">

                {{-- Item Cart --}}





            
            </div>
        </div>
        
        <div id="paypal-button-container"></div>
        <div class="tk">
          @csrf
        </div>
    </div>
    <script src="{{asset('/js/Cart.js')}}"></script>

  
   
@stop