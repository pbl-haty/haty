var drop_all = document.querySelectorAll('.ul-block');

function click_list_event(i) {
    var text = "drop"+String(i);
    var drop = document.getElementById(text);
    if(drop.style.display == "none") {
        drop_all.forEach((element)=>{
            element.style.display="none";
        });
        drop.style.display="block";
    } else {
        drop.style.display="none";
    } 
}