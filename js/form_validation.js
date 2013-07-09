function validForm(formId){
	var form = document.getElementById(formId);
	var inputs = form.getElementsByTagName('input');


	var filled = fieldsFilled(inputs);
	//var formed = fieldsWellFormed(inputs);
	
	//html5 browsers guarantee this
	var formed = true;

		$("#message").css("border", "none");
		$("#message").css("text-decoration", "none");

	return filled && formed;
}

function fieldsWellFormed(inputs){
	for(var i = 0; i < inputs.length; i++){
		var item = inputs[i];
		
		alert(item.type);
		if(item.type=="date"){
		//	alert(".");
			if(item.val==null){
				return false;
			}
			var pieces = item.val.split("-");
		//	alert(pieces.length);
			if(pieces.length!=3){
				return false;
			}
			for(var piece in pieces){
				if(parseInt(piece)=="NaN"){
					return false;
				}
				if(parseInt(piece) <= 0){
					return false;
				}
			}
			//contains 3 positive integers
		
			var year = pieces[0];
			var month = pieces[1];
			var day = pieces[2];
			if(year.length!=4){
				return false;
			}
			if(month.length!=2){
				return false;
			}
			if(day.length!=2){
				return false;
			}
			//contains 3 positive integers of the correct lengths
			if(parseInt(month) > 12){
				return false;
			}
			if(!dateExists(month, day, year)){
				return false;
			}
		}
	}
	return true;
}

function leapYear(year){
	return ((year % 4 == 0 && year % 100 != 0) || year % 400 == 0);
}

function dateExists(month, day, year){
	var monthInt = parseInt(month);
	var dayInt = parseInt(day);
	var yearInt = parseInt(year);
	var lastDay;
	switch(monthInt){
		case 1:
		lastDay = 31;
		break;
		case 2:
			if(leapYear(year)){
				lastDay = 29;
			} else {
				lastDay = 28;
			}
		break;
		case 3:
		lastDay = 31;
		break;
		case 4:
		lastDay = 30;
		break;
		case 5:
		lastDay = 31;
		break;
		case 6:
		lastDay = 30;
		break;
		case 7:
		lastDay = 31;		
		break;
		case 8:
		lastDay = 31;		
		break;
		case 9:
		lastDay = 30;
		break;
		case 10:
		lastDay = 31;
		break;
		case 11:
		lastDay = 30;
		break;
		case 12:
		lastDay = 31;
		break;
	}
	return dayInt <= lastDay;
}

function fieldsFilled(inputs){

	//holds all input objects
	var checkboxes = [];
	var radios = [];
	//names of non-empty ones
	var filledCheckboxes = {};
	var filledRadios = {};

	//all empty inputs
	var empty = [];
	//all non-empty inputs
	var filled = [];

	//time considered filled with hours OR minutes
	var timefilled = false;

	//for each input item, determine if filled out
	for(var i = 0; i < inputs.length; i++){

		var item = inputs[i];
	//	alert(item.value);
		if(item.type=="radio"){
			radios.push(item);
			if(item.checked){
				filledRadios[item.name] = true;
			}
		} else if(item.type=="checkbox"){
			checkboxes.push(item);
			if(item.checked){
				filledCheckboxes[item.name] = true;
			}
		} else if(item.type=="submit"){
			//ignore
		} else {
			if(item.value == ""){
				if(item.name!="hours" && item.name!="minutes"){
					empty.push(item);
				}
			//	alert("missing " + item.name);
			} else {
				if(item.name=="hours" || item.name=="minutes"){
					timefilled = true;
				} else {
					filled.push(item);

				}
			}
		}
	}

	//special case for time - considered filled out if EITHER hrs/mins present
	var hrs = document.getElementById("hrs");
	var mins = document.getElementById("mins");

	if(timefilled){
		filled.push(hrs);
		filled.push(mins);
	} else {
		empty.push(hrs);
		empty.push(mins);
	}

	//add radio and checkboxes to empty/filled
	for(var i in radios){
		var r = radios[i];
		if(r.name in filledRadios){
			filled.push(r);
		} else {
			empty.push(r);
		}
	}
	for(var i in checkboxes){
		var c = checkboxes[i];
		if(c.name in filledCheckboxes){
			filled.push(c);
		} else {
			empty.push(c);
		}
	}

	for(var j in filled){
		filled[j].parentNode.style.border = "none";
	}

		//draw borders to alert user of problem
	for(var i in empty){
		//console.log("empty" + empty[i]);
		empty[i].parentNode.style.border = "2px solid red";
	}	


	return (empty.length==0);
}