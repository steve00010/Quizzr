$(function() {
	$("#pwordsubmit").click(function(e) {
   		e.preventDefault();
		$("#pwordfeedback").hide();
   		var npword1 = $("#newpword1").val();
   		var npword2 = $("#newpword2").val();
   		var currpword = $("#currpword").val();
   		if(npword1.length < 1 || npword2.length < 1 || currpword.length < 1) {
	   		$("#pwordfeedback").show();
	   		$("#pwordfeedback .textmsg").text("Please fill out all of the input boxes!");
   		} else {
   			if(currpword != npword1 && currpword != npword2) {
				if(npword1 == npword2) {
		   			var ret = CheckPword(npword1);
		   			if(ret[0]) {
				   		$.ajax({
					      url: APIURL+"/user/settingspword",
					      data: {
					       OldPass: currpword,
					       NewPass: npword1
					      },
					      type: 'post',
					      success: function(data) {
					        if(data == "SUCCESS") {
					        	$("#alertdiv1").removeClass("alert-danger");
					        	$("#alertdiv1").addClass("alert-success");
					        	$("#pwordfeedback .textmsg").text("Your password has been changed!");
					        }
					        if(data == "PSHORT") {
					        	$("#pwordfeedback .textmsg").text("Your password is too short (<6 characters)!");
					        }
					        if(data == "SAMEPASS") {
								$("#pwordfeedback .textmsg").text("Your new password is the same as your old one!");
					        }
					        if(data == "OLDPASS") {
								$("#pwordfeedback .textmsg").text("Your old password is incorrect!");
					        }
					      }
					    });
			   		}else {
			   			$("#pwordfeedback").show();
		   				$("#pwordfeedback .textmsg").text(ret[1]);
			   		}
		   		} else {
		   			$("#pwordfeedback").show();
		   			$("#pwordfeedback .textmsg").text("Please make sure your new passwords match!");
		   		}
   		} else{
   			$("#pwordfeedback").show();
		   	$("#pwordfeedback .textmsg").text("Your new and old password cannot match!");
   		}
   	}
   	});
	$("#emailsubmit").click(function(e) {
   		e.preventDefault();
   		ChangeEmail();
   	});
   	$("#statussubmit").click(function(e) {
   		e.preventDefault();
   	});
   	function CheckPword(pword) {
	    var ret = [];
	    ret[0] = true;
	    if ((pword).length < 6) {
	      ret[0] = false;
	      ret[1] = "Password is too short! (<6 characters)";
	    } else if (pword.search(/\d/) == -1) {
	      ret[0] = false;
	      ret[1] = "A number is required in your password";
	    } else if (pword.search(/[a-zA-Z]/) == -1) {
	      ret[0] = false;
	      ret[1] = "A letter is required in your password";
	    }
	    return ret;
  	}
  	function ChangeEmail() {
		$("#emailfeedback").hide();
   		var re = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
	    if (!re.test($('#newemail').val())) {
			$("#alertdiv2").removeClass("alert-success");
	        $("#alertdiv2").addClass("alert-danger");
	      	$("#emailfeedback .textmsg").text("Please enter a valid email!");
			$("#emailfeedback").show();
	    } else {
		  var user = $("#usernamestorage").text();
	      $.ajax({
	        url: APIURL + "/user/settingsemail",
	        data: {
	          email: $('#newemail').val(),
	        },
	        type: 'post',
	        success: function(data) {
	          if (data == "SUCCESS") {
				$("#alertdiv2").removeClass("alert-danger");
	        	$("#alertdiv2").addClass("alert-success");
	        	$("#emailfeedback .textmsg").text("Your email has been changed!");
	        	$("#emailfeedback").show();
	          } else if(data == "ETAKEN") {
	         	$("#alertdiv2").removeClass("alert-success");
	        	$("#alertdiv2").addClass("alert-danger");
	            $("#emailfeedback .textmsg").text("That email is taken!");
	        	$("#emailfeedback").show();
	          } else if(data == "EINVALID"){
	          	$("#alertdiv2").removeClass("alert-success");
	        	$("#alertdiv2").addClass("alert-danger");
	            $("#emailfeedback .textmsg").text("That email is invalid!");
	        	$("#emailfeedback").show();
	          }
	        }
	      });
	    }
  	}
   	$("#statussubmit").click(function(e) {
   		e.preventDefault();
	     $("#statusfeedback").hide();

   		var pub = true;
   		if($("#radio_prv").is(':checked')) {
   			pub = false;
   		}
   		var user = $("#usernamestorage").text();
	    $.ajax({
	        url: APIURL + "/admin/settingsstatus",
	        data: {
	        	status: pub,
	        	user: user
	        },
	        type: 'post',
	        success: function(data) {
				if (data == "SUCCESS") {
				$("#alertdiv3").removeClass("alert-danger");
	        	$("#alertdiv3").addClass("alert-success");
	        	$("#statusfeedback .textmsg").text("Users status has been changed!");
	        	$("#statusfeedback").show();
	          } else {
	         	$("#alertdiv2").removeClass("alert-success");
	        	$("#alertdiv2").addClass("alert-danger");
	            $("#statusfeedback .textmsg").text("Something went wrong, status hasn't changed!");
	        	$("#statusfeedback").show();
	          }
	        }
	    });
   	}); 	
});