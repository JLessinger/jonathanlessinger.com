function confirmToggle(str){
	//console.log("str" + str);
	if(str.length==0){
		return;
	}

	if(window.XMLHttpRequest){
		//code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	} else {
		// code for IE6, IE5
		//no one cares
	}
	xmlhttp.onreadystatechange = function(){
		//what are these?
		if(xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById("usermessage").innerHTML = xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET", "./php/confirm_toggle.php?id="+str, true);
	xmlhttp.send();
}