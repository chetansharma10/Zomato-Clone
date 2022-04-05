// Drop Down Code
var dropBtn=document.querySelector(".nav-profile");
var dropList=document.querySelector(".dropList");
var showDrop=false;
if(dropBtn!=undefined){
    dropBtn.addEventListener("click",(e)=>{
        showDrop=!showDrop;
        if(showDrop){
            dropList.style.height="auto";
            dropList.style.opacity="1";
        }
        else{
            dropList.style.opacity="0";
            dropList.style.height="0px";
        }
        
    });

   
}





// Login And Sign Up Dialogs
var signUpBtn=document.querySelector(".nav-signup");
var loginBtn=document.querySelector(".nav-login");
var dialogBox=document.querySelector(".dialogBox");
var dialogBox2=document.querySelector(".dialogBox2");

var closeBtn=document.querySelector(".dialogClose");
var closeBtn2=document.querySelector(".dialogClose2");

var showDialog=false;
var showDialog2=false;

if(signUpBtn!=undefined){
    signUpBtn.addEventListener("click",()=>{
        showDialog=true;
        if(showDialog){
            dialogBox.style.display="flex";
            showDialog=false;

        }
        else{
            dialogBox.style.display="none";

        }
    })
}

if(loginBtn!=undefined){
    loginBtn.addEventListener("click",()=>{
        showDialog2=true;
        if(showDialog2){
            dialogBox2.style.display="flex";
            showDialog2=false;
    
        }
        else{
            dialogBox2.style.display="none";
    
        }
    })
    
}






// Login And Sign Up Switch
var loginSwitch=document.querySelector(".loginSwitch");
var signUpSwitch=document.querySelector(".signUpSwitch");
loginSwitch.addEventListener("click",(e)=>{
    dialogBox.style.display="none";
    dialogBox2.style.display="flex";
    
})
signUpSwitch.addEventListener("click",(e)=>{
    dialogBox.style.display="flex";
    dialogBox2.style.display="none";
})

closeBtn.addEventListener("click",(e)=>{
    dialogBox.style.display="none";
})

closeBtn2.addEventListener("click",(e)=>{
    dialogBox2.style.display="none";
})



// Call Toast on Window
function callToast(value,colorCode="#EF4C63"){
    Toastify({
        text: value,
        className: "info",
        offset: {
            x: 50,
            y: 30 
          },
        style: {
          background: colorCode,
          borderRadius:"5px",
          fontWeight:"bolder",
        }
      }).showToast();
}




// Sign Out 
function signOut(){
    var xhr=new XMLHttpRequest();
    var token=document.querySelector(".dropList").children[0].value

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







// Change Avatar
var avatarBtn=document.querySelector(".imgBtn");
var imageForm=document.getElementById("imageForm");
if(avatarBtn!=undefined){
    avatarBtn.addEventListener("click",(e)=>{
        var hiddenImg=document.getElementById("chooseImg");
        
        hiddenImg.click();
        hiddenImg.addEventListener("change",(e)=>{
            var file=e.target.files[0];
            var xhr=new XMLHttpRequest();

            xhr.open("POST","/updateImage");
            xhr.setRequestHeader("X-CSRF-TOKEN",imageForm.children[0].value);
            let formData=new FormData();
           
            formData.append("image",file);
            xhr.send(formData)
            xhr.onreadystatechange=function(){
                if(xhr.readyState==4 && xhr.status==200){
                    
                        var x=window.location.origin+'/getImage/'+xhr.response;
                        document.getElementById('userImage').src=window.location.origin+'/getImage/'+xhr.response;
                        callToast("Profile Image Successfully Updated","green");
                   
                }
            }
        })
    })
}






// Add Items
var itemsBox=document.querySelector(".itemsBox");
var xhr=new XMLHttpRequest();
var x="";
xhr.open("GET","/allItems");
xhr.send();
xhr.onreadystatechange=function()
{
    if(xhr.readyState==4 && xhr.status==200){
       var data=JSON.parse(xhr.response) ;
       for(let i=0;i<data.length;i++){
           x+=`
           
           <div class="itemBase">

                <img src="${window.location.protocol}//${window.location.hostname}:${window.location.port}/getItemImage/${data[i].itemImg}" />
                <div class="sepr">
                    <h3>${data[i].itemName}</h3>
                    <button class="addToCart" onclick="addOrder(event)" >
                        <i class="material-icons" id="${data[i].itemId}">add</i>
                    </div>

                    <div class="rateBox">
                        <span>4.5</span>&nbsp;
                        DINNING
                    </div>
    
                </div>
                
                
        
            </div>
           
           
           `;
       }      
       
       itemsBox.innerHTML=x;
    }
}


// Add To addToCart
getCartValue()
function addOrder(event){

    var fd=document.querySelector(".foodItems");
    var tk=fd.children[0].value;

    var id=event.target.getAttribute("id");
    var xhr=new XMLHttpRequest();

    xhr.open("POST","/addToCart");
    xhr.setRequestHeader("X-CSRF-TOKEN",tk);
    let formData=new FormData();                        
    formData.append("itemId",id);
    xhr.send(formData)
    xhr.onreadystatechange=function(){
        if(xhr.readyState==4 && xhr.status==200){
            if(xhr.response){
                getCartValue();
                callToast("Added To Cart","green");
            }
            else{
                callToast("Already In Cart");

            }
         
        }
    }
 

}


function getCartValue(){
    var xhr=new XMLHttpRequest();

    xhr.open("GET","/getCartValue");
    xhr.send()
    xhr.onreadystatechange=function(){
        if(xhr.readyState==4 && xhr.status==200){
            
           var cartValue=document.getElementById("cartValue");
           cartValue.innerHTML=xhr.response;
           
        }
    }
}