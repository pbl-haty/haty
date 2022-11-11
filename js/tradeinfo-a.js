p0.style.display ="block";
p1.style.display ="none";
p2.style.display = "none";
b0.style.color ="black";
b1.style.color ="gray";
b2.style.color = "gray";
b0.style.border ="2px black solid";
b1.style.border ="2px gray solid";
b2.style.border ="2px gray solid";
// {
//     const btn = document.getElementById('btn');
//             btn.addEventListener('click', () => {
//                 btn.textContent = "完了しました";
//             })
// }
function click_list_event(i) {
    if(i == 0) {
        p0.style.display ="block";
        p1.style.display ="none";
        p2.style.display = "none";
        b0.style.color ="black";
        b1.style.color ="gray";
        p2.style.color = "gray";
        b0.style.border = "2px black solid";
        b1.style.border = "2px gray solid";
        b2.style.border = "2px gray solid";
    } else if(i == 1) {
        p0.style.display ="none";
        p1.style.display ="block";
        p2.style.display = "none";
        b0.style.color ="gray";
        b1.style.color ="black";
        b2.style.color = "gray";
        b0.style.border ="2px gray solid";
        b1.style.border ="2px black solid";
        b2.style.border = "2px glay solid";
    } else if(i == 2){
        p0.style.display = "none";
        p1.style.display = "none";
        p2.style.display = "block";
        b0.style.color ="gray";
        b1.style.color ="gray";
        b2.style.color = "black";
        b0.style.border ="2px gray solid";
        b1.style.border ="2px gray solid";
        b2.style.border ="2px black solid";
    }
}