window.onload = markToday;

function markToday(){
    var date = new Date();
    var today = date.getDate();
    today =  today;
    document.getElementById("block"+today).style.border = "2px solid #001d4c";
    document.getElementById("block"+today).style.boxShadow = "3px 0px 3px #001d4c";
    document.getElementById("block"+today).style.width = "106px";
}

