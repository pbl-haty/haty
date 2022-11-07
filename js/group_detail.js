let select = document.querySelector('[name="example"]');
let select_all = document.querySelectorAll(".detail_display");
var text;
var category;

select.onchange = event => { 
    if(select.selectedIndex == 0) {
        select_all.forEach((element) => {
            element.style.display = "block";
        });
        console.log("all");
    } else {
        console.log(select.selectedIndex);
        select_all.forEach((element) => {
            element.style.display = "none";
        });
        text = ".p" + String(select.selectedIndex - 1);
        category = document.querySelectorAll(text);
        category.forEach((element) => {
            element.style.display = "block";
        });
    }
}
