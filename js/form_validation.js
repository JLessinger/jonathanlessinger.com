function requireFilled(formId){

	var form = document.getElementById(formId);

	var inputs = form.getElementsByTagName('input');
	
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

	//for each input item, determine if filled out
	for(var i = 0; i < inputs.length; i++){

		var item = inputs[i];
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
				empty.push(item);
			//	alert("missing " + item.name);
			} else {
				filled.push(item);
			}
		}
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

	//allow submission only if form filled
	//console.log(empty.length);
	return (empty.length==0);
}