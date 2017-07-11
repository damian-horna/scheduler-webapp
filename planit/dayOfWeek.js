window.onload = day;

function day(){
	var date = new Date();
	var daynr = date.getDate();
	var day = date.getDay();
	var monthNumber = date.getMonth();
	var year = date.getFullYear();

	switch(day){
	case 1:
		day="Monday";
		break;
	case 2: 
		day="Tuesday";
		break;
	case 3:
		day="Wednesday";
		break;
	case 4: 
		day="Thursday";
		break;
	case 5:
		day="Friday";
		break;
	case 6: 
		day="Saturday";
		break;
	case 7:
		day="Sunday";
		break;
    default: 
        day="Unknown";
	}


	switch(monthNumber) {
    case 0:
        month="January";
        break;
    case 1:
        month="Febuary";
        break;
    case 2:
        month="March";
        break;
    case 3:
        month="April";
        break;
    case 4:
        month="May";
        break;
    case 5:
        month="June";
        break;
    case 6:
        month="July";
        break;
    case 7:
        month="August";
        break;
    case 8:
        month="September";
        break;
    case 9:
        month="October";
        break;
    case 10:
        month="November";
        break;
    case 11:
        month="December";
        break;
    default:
        month="Unknown";
}

	document.getElementById("todayyy").innerHTML= day+ ", " + daynr + " " + month + " " + year;
}


