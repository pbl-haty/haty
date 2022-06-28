p0.style.display ="flex";
p1.style.display ="none";

function click_list_event(i) {
    if(i == 0) {
        p0.style.display ="flex";
        p1.style.display ="none";
    } else if(i == 1) {
        p0.style.display ="none";
        p1.style.display ="flex";
    }
}
