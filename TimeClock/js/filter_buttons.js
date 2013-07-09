$(function() {

	//console.log("running");  
 // 	$('.error').hide();  
  	$(".viewbutton").click(function() {  
    // validate and process form here  
      viewed = true;
    	//$('.error').hide();  


     	dataString = $('#viewForm').serialize();
   //  	alert(dataString);
      $.ajax({  
			type: "GET",  
			   url: "./php/view.php",  
			   data: dataString,  
			   success: function(response) {
			//	alert("ans: " + response);  
				    $("#view").html(response);
			//	alert("success");
		/*	$('#contact_form').html("<div id='message'></div>");  
			$('#message').html("<h2>Contact Form Submitted!</h2>")  
			.append("<p>We will be in touch soon.</p>")  
			.hide()  
			.fadeIn(1500, function() {  
  				$('#message').append("<img id='checkmark' src='images/check.png' />");  
			}); */ 
			}  
	    });  
		return false;  
  	});  

  	$(".invoicebutton").click(function() {  
    // validate and process form here  
      
    	//$('.error').hide();  
        //validate form entry
    	var acc = $("#viewForm").find('input[name=Account]').val();
    	if(!acc || acc.length == 0){
    		$("#invoiceResponse").html("Enter account.");
    		return false;
    	}
      if(document.getElementById('paidradio').checked) {
        $("#view").html("Cannot invoice paid jobs.");
        return false;
      }

        //proceed with form
     	dataString = $('#viewForm').serialize();
   //  	alert(dataString);
		$.ajax({  
  			type: "GET",  
  			url: "./php/invoice.php",  
  			data: dataString,  
  			success: function(response) {
  			//	alert("ans: " + response);  
  				$("#view").html(response);
  			//	alert("success");
    		/*	$('#contact_form').html("<div id='message'></div>");  
    			$('#message').html("<h2>Contact Form Submitted!</h2>")  
    			.append("<p>We will be in touch soon.</p>")  
    			.hide()  
    			.fadeIn(1500, function() {  
      				$('#message').append("<img id='checkmark' src='images/check.png' />");  
    			}); */ 
  			}  
		});  
		return false;  
  	}); 
});  