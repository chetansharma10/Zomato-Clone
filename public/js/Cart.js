
var totalPriceForPay=0;

function readCartOrders(){
    let xhr=new XMLHttpRequest();
    var cartItems=document.querySelector(".cartItems");
    xhr.open("GET","/readOrders");
    xhr.send()
    xhr.onreadystatechange=function(){
        if(xhr.readyState==4 && xhr.status==200){

            var cartItem=``;
            var data=JSON.parse(xhr.response);
            for(let i=0;i<data.length;i++){
                cartItem+=`
                    <div class="cartItem">
                        <span class="cartTop">
                            <h5><strong>${data[i][0].itemName}</strong></h5>
                            <button class="del" >
                                <i  id="${data[i][0].itemId}" class="material-icons">close</i>
                            </button>
                        </span>
                        <div class="imgX">
                            <img src="${window.location.protocol}//${window.location.hostname}:${window.location.port}/getItemImage/${data[i][0].itemImg}" />
                            <h3 class="price">$
                            ${data[i][0].itemPrice}</h3>
                            <div class="btns">
                                <button class="incre">+</button>
                                <strong class="quantity">1</strong>
                                <button class="decre">-</button>
                            </div>
                        </div>
                    </div> 
                `;

            }
            cartItems.innerHTML=cartItem;

            let incres=document.querySelectorAll(".incre");
            incres.forEach((item)=>{
               item.addEventListener("click",(e)=>{
                    let x=e.target.parentNode.children;
                    var value=parseInt(x[1].innerText);
                    value+=1;
                    x[1].innerText=value;  
                    readAllAmount();

               })
            });


            let deles=document.querySelectorAll(".del");
            deles.forEach((item)=>{
                item.addEventListener("click",(e)=>{
                    let id=e.target.getAttribute("id");
                    let xhr3=new XMLHttpRequest();
                    xhr3.open("GET",`/deleteOrder/${id}`);
                    xhr3.send()
                    xhr3.onreadystatechange=function(){
                        if(xhr3.readyState==4 && xhr3.status==200){
                          if(xhr3.response){
                              readCartOrders();
                              readAllAmount();

                          }
                        }
                    }

                });
            });
            
            
            
            let decres=document.querySelectorAll(".decre");
            decres.forEach((item)=>{
               item.addEventListener("click",(e)=>{
                    let x=e.target.parentNode.children;
                    let value=parseInt(x[1].innerText);
                    value-=1;
                    if(value<1){
                        value=1;
                    }
                    x[1].innerText=value;

                    readAllAmount();

               })
            });

            readAllAmount();

           
        }
    }

  

}
readCartOrders();


function readAllAmount(){
    let totalPrice=document.getElementById("totalPrice");
    let prices=document.querySelectorAll(".price");
    let quantities=document.querySelectorAll(".quantity");
    let calulatedPrices=[];
    let calculatedQuntities=[];
    let calculatedTotal=0;
    prices.forEach((item)=>{
        let itemPrice=parseInt(item.innerText.split("$")[1])
        calulatedPrices.push(itemPrice);
    });


    quantities.forEach((item)=>{
       let itemQuantity=parseInt(item.innerText);
       calculatedQuntities.push(itemQuantity)
    });

    
    for(let i=0;i<calulatedPrices.length;i++){
        calculatedTotal+=(calulatedPrices[i]*calculatedQuntities[i])
    }
    totalPrice.innerText="$"+calculatedTotal;
    totalPriceForPay=calculatedTotal;



}

    var tk=document.querySelector(".tk").children[0].value;
    
    paypal.Buttons({



      // Sets up the transaction when a payment button is clicked
      createOrder: (data, actions) => {
        return actions.order.create({
          purchase_units: [{
            amount: {
              "currency_code": "USD",
              value: totalPriceForPay // Can also reference a variable or function
            }
          }]
        });
      },



      // Finalize the transaction after payer approval
      onApprove: (data, actions) => {
        return actions.order.capture().then(function(orderData) {
          // Successful capture! For dev/demo purposes:
          // var orderDetails=JSON.stringify(orderData, null, 2);
          var payerId=orderData.payer.payer_id;
          var status=orderData.status;
          var email=orderData.payer.email_address;
          var paymentId=orderData.id;
          var time=orderData.create_time;
          
          const transaction = orderData.purchase_units[0].payments.captures[0];
          alert(`Transaction ${transaction.status}: ${transaction.id}\n\nSee console for all available details`);
          // When ready to go live, remove the alert and show a success message within this page. For example:
          const element = document.getElementById('paypal-button-container');
          element.innerHTML = '<h3>Thank you for your payment!</h3>';
          // Or go to another URL:  actions.redirect('thank_you.html');

          updateInDb(payerId,status,email,paymentId,totalPriceForPay,time);
        });
      }



    }).render('#paypal-button-container');

function updateInDb(payerId,status,email,paymentId,total,time){
    let xhr=new XMLHttpRequest();
    xhr.open("POST","/submitPayment");
    xhr.setRequestHeader("X-CSRF-TOKEN",tk);

    let formData=new FormData();
    formData.append("payerId",payerId);
    formData.append("status",status);
    formData.append("email",email);
    formData.append("paymentId",paymentId);
    formData.append("total",total);
    formData.append("time",time);




    xhr.send(formData);
    xhr.onreadystatechange=function(){
        if(xhr.status==200 && xhr.readyState==4){
            if(xhr.response){
                setTimeout(()=>{
                    window.location.href="/";
                },3000);
            }
       
        }
    }
}