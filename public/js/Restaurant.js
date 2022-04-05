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





var dropBtn=document.querySelector(".userDrops");
var dropBox=document.querySelector(".dropDown");
var isShowing=false;
if(dropBtn!=undefined){
    dropBtn.addEventListener('click',()=>{
       
        if(isShowing){
            dropBox.style.display="none";
            dropBtn.innerHTML=`
            <i class="material-icons">menu</i>
            `;

            isShowing=false;
        }
        else{
            dropBox.style.display="flex";
      
            dropBtn.innerHTML=`
            <i class="material-icons">close</i>
            `;
            isShowing=true;
        }
    });
}
var lat2=document.getElementById("lati");
var longi2=document.getElementById("longi");
var map =undefined;
if(window.location.pathname==="/addRestaurant"){
    var navi=navigator.geolocation.getCurrentPosition((position)=>{
        var lati=position.coords.latitude;
        var longi=position.coords.longitude;
        lat2.value=lati;
        longi2.value=longi;
        setupMap(lati,longi)
    })
    
}

var marker=undefined;

function setupMap(lati,longi){
    map= L.map('map');
    map.setView([lati, longi], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    marker=L.marker([lati,longi]);
    marker.addTo(map)
}

var manual=document.querySelector(".manual");
if(manual!=undefined){
    manual.addEventListener("click",(e)=>{
        e.preventDefault()
        let newLat=lat2.value;
        let newLong=longi2.value;
        var newPost=new L.LatLng(newLat,newLong)
        map.setView(newPost);
        marker.setLatLng(newPost)

    })
}




var createRest=document.getElementById('createRest');
var formx=document.getElementById("formx");
if(createRest!=undefined){
    createRest.addEventListener('click',(e)=>{
        e.preventDefault()
        var resName,resAdd,ownerName,mobileNumber,openTime,closeTime;

        for(let i=0;i<formx.children.length;i++){
            if(formx.children[i].getAttribute("type")!=null){
                var value=formx.children[i].getAttribute("name");
                var value2=formx.children[i].value;
                if(value=="resName"){
                    resName=value2;
                }
                if(value=="resAdd"){
                    resAdd=value2;

                }
                if(value=="ownerName"){
                    ownerName=value2;
                }
                if(value=="mobileNumber"){
                    mobileNumber=value2
                }
                if(value=="openTime"){
                    openTime=value2
                }
                if(value=="closeTime"){
                    closeTime=value2
                }

               
            }
        }


        if(resAdd!=undefined || resName!=undefined|| ownerName!=undefined || mobileNumber!=undefined
            || openTime!=undefined || closeTime!=undefined 
            )
        {

            var xhr=new XMLHttpRequest()
            xhr.open("POST","/addRestaurantDB");
            var token=formx.children[0].value;
            xhr.setRequestHeader("X-CSRF-TOKEN",token);
    

            var resData=new FormData();
            resData.append("Address",resAdd);
            resData.append("RestName",resName);
            resData.append("OwnerName",ownerName);
            resData.append("mobile",mobileNumber);
            resData.append("openTime",openTime);
            resData.append("closeTime",closeTime);
            var location=`${lat2.value}#${longi2.value}`;
            resData.append("Location",location);
            xhr.send(resData);
            xhr.onreadystatechange=function(){
                if(xhr.readyState==4 && xhr.status==200){
                    console.log(xhr.response)
                    if(xhr.response.includes("200")){
                        callToast("Done,Now Go to Profile and customize your restaurant","green");
                        window.location.pathname="/";
                    }
                    else{
                        var data=JSON.parse(xhr.responseText.split(1)[0]);
                        var keys=Object.keys(data);
                        keys.forEach((e)=>{
                           var vals=data[e][0];
                           callToast(vals);
                        })
                    }
                }
            }

            }







    })
}