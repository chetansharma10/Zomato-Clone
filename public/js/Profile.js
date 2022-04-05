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


var itemImg1=document.getElementById("itemImg1");
var itemImg=document.getElementById("itemImg");
var formX=document.querySelector(".itemArea");
var ress=document.getElementById("ress");
var selectRes=document.querySelectorAll(".selectRes");
var myToken=document.querySelector(".itemArea").children[0].value;



var itemRes=document.getElementById("itemRes");
var id=-1;
var file=undefined;
formX.addEventListener("submit",(e)=>{
    e.preventDefault();
})
itemImg.addEventListener("click",()=>{

    itemImg1.click();
})
itemImg1.addEventListener("change",(e)=>{
    file=e.target.files[0];
})

selectRes.forEach((elm)=>{
    elm.addEventListener("click",()=>{
        id=elm.getAttribute("id");
    })
})



itemRes.addEventListener("click",()=>{
    var itemName=document.getElementById("itemName").value;
    var itemType=document.getElementById("itemType").value;
    var itemPrice=document.getElementById("itemPrice").value;
    var itemDesc=document.getElementById("itemDesc").value;



    if(itemName.length==0 || itemType.length==0|| itemPrice.length==0 ||itemDesc.length==0||id==-1||file==undefined){
        
        callToast("Something went wrong..");
    }
    else{
        var xhr=new XMLHttpRequest();
        xhr.open("POST","/addItem");
        xhr.setRequestHeader("X-CSRF-TOKEN",myToken);
        var formData=new FormData();
        formData.append("itemName",itemName);
        formData.append("itemType",itemType);
        formData.append("itemPrice",itemPrice);
        formData.append("itemDesc",itemDesc);
        formData.append("id",id);
        formData.append("image",file);

        xhr.send(formData);
        xhr.onreadystatechange=function(){
            if(xhr.readyState==4 && xhr.status==200){
                console.log(xhr.response)
            }
        }
        callToast("Success Wait To Redirect..","green");
        window.location.pathname="/";

    }

    

})


