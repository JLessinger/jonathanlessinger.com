window.onload = function(){
  setDropDownOnChange();
  getAccounts();
};

function setDropDownOnChange(){
  //initialize 'new' selected
  $("#newAccount").html("<input type='text' name='Account'>");
  $("#accountInput").change(function(){
    var e = document.getElementById("accountInput");
    var val = e.options[e.selectedIndex].value;
    if(val=="new"){
      $("#newAccount").html("<input type='text' name='Account'>");
    } else {
      $("#newAccount").html("");
      //in case border is left from failed submisssion, remove if from now empty div
       $("#newAccount").css("border", "none");
       $("#newAccount").html("");

    }
  }); 
}

function getAccounts(){

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
      $("#accountInput").html(xmlhttp.responseText);
    }
  }
  xmlhttp.open("GET", "./php/select_unique.php?field=Account", true);
  xmlhttp.send();
}

$(function() {

	//console.log("running");  
 // 	$('.error').hide();  
  	$(".viewbutton").click(viewButton);  

  	$(".invoicebutton").click(invoiceButton); 


});  

function viewButton(){
    // validate and process form here  
      //$('.error').hide();  
      $("#view").html("");
      $("#invoiceResponse").html("");


      dataString = $('#viewForm').serialize();
   //   alert(dataString);
    $.ajax({  
      type: "GET",  
         url: "./php/view.php",  
         data: dataString,  
         success: function(response) {
      //  alert("ans: " + response);  
            $("#view").html(response);
      //  alert("success");
    /*  $('#contact_form').html("<div id='message'></div>");  
      $('#message').html("<h2>Contact Form Submitted!</h2>")  
      .append("<p>We will be in touch soon.</p>")  
      .hide()  
      .fadeIn(1500, function() {  
          $('#message').append("<img id='checkmark' src='images/check.png' />");  
      }); */ 
      }  
    });  
    return false;  
}

function invoiceButton(){
      // validate and process form here  
      
      //$('.error').hide();  
        //validate form entry
     $("#view").html("");
     $("#invoiceResponse").html("");

      var acc = $("#viewForm").find('input[name=Account]').val();
      if(!acc || acc.length == 0){
        $("#invoiceResponse").html("Enter account.");
        return false;
      }
      if(document.getElementById('paidradio').checked) {
        $("#invoiceResponse").html("Cannot invoice paid jobs.");
        return false;
      }

        //proceed with form
      dataString = $('#viewForm').serialize();
   //   alert(dataString);
    $.ajax({  
        type: "GET",  
        url: "./php/invoice.php",  
        data: dataString,  
        success: function(response) {
        //  alert("ans: " + response);  
          $("#view").html(response);
        //  alert("success");
        /*  $('#contact_form').html("<div id='message'></div>");  
          $('#message').html("<h2>Contact Form Submitted!</h2>")  
          .append("<p>We will be in touch soon.</p>")  
          .hide()  
          .fadeIn(1500, function() {  
              $('#message').append("<img id='checkmark' src='images/check.png' />");  
          }); */ 
        }  
    });  
    return false;  
}