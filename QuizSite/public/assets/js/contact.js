var APIURL = "http://178.62.75.39/";
if(window.location.href.indexOf("quiz") > -1) {
  APIURL = "http://quiz.dev/";
}
$(function() {
  var bodyheight = $(document).height();
  var vwptHeight = $(window).height();
  if(bodyheight > vwptHeight){
    $("footer").css("position","absolute").css("top",bodyheight-80+"px");
  } else {
    $("footer").css("position","absolute").css("top",vwptHeight-80+"px");
  }
  var onClass = "on";
  var showClass = "show";
  $("#registerform").hide();
  $("#signinform").hide();

  $("input").bind("checkval", function() {
    var label = $(this).prev("label");
    if (this.value !== "") {
      label.addClass(showClass);
    } else {
      label.removeClass(showClass);
    }
  }).on("keyup", function() {
    $(this).trigger("checkval");
  }).on("focus", function() {
    $(this).prev("label").addClass(onClass);
  }).on("blur", function() {
    $(this).prev("label").removeClass(onClass);
  }).trigger("checkval");
  $("#ShowReg").click(function() {
    $(".auth-wrapper").toggle("slow");
  });
  $("#Register").click(function() {
    $("#Register").hide();
    $("#Signin").show();
    $("#registerform").show();
    $("#signinform").hide();
    $("#LogInHeader").text("Register");
    $("#logininfo").html("<p>Register here to create an account!</p>");

  });
  $("#Signin").click(function() {
    $("#Signin").hide();
    $("#Register").show();
    $("#registerform").hide();
    $("#signinform").show();
    $("#LogInHeader").text("Log in");
    $("#logininfo").html("<p>Sign in here to access your account!</p>");
  });
  var typingTimer, typingTimer1, typingTimer2; 
  var doneTypingInterval = 1000; 
  $('#uname1').keyup(function() {
    clearTimeout(typingTimer);
    if ($('#uname1').val) { typingTimer = setTimeout(CheckNameAvailable, doneTypingInterval); }
  });
  $('#email1').keyup(function() {
    clearTimeout(typingTimer1);
    if ($('#email1').val) { typingTimer1 = setTimeout(CheckEmailAvailable, doneTypingInterval); }
  });
  $('#pword1').keyup(function() {
    clearTimeout(typingTimer2);
    if ($('#pword1').val) { typingTimer2 = setTimeout(doneTypingPword, doneTypingInterval); }
  });

  function regFeedBack(id, text, color) {
    $('#' + id + '1label').text(text);
    $('#' + id + '1label').css("color", color);
    $('#' + id + '1').css("border-top-color", color);
    $('#' + id + '1').css("border-right-color", color);
    $('#' + id + '1').css("border-bottom-color", color);
    $('#' + id + '1').css("border-left-color", color);
    $('#' + id + '1').css("box-shadow", "box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.075) inset, 0px 0px 8px rgba(102, 175, 233, 0.6);");
  }

  function LogFeedBack(id, text, color) {
    $('#' + id + 'label').text(text);
    $('#' + id + 'label').css("color", color);
    $('#' + id).css("border-top-color", color);
    $('#' + id).css("border-right-color", color);
    $('#' + id).css("border-bottom-color", color);
    $('#' + id).css("border-left-color", color);
    $('#' + id).css("box-shadow", "box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.075) inset, 0px 0px 8px rgba(102, 175, 233, 0.6);");
  }

  function doneTypingPword() {
    ret = CheckPword($('#pword1').val());
    if (!ret[0]) {
      regFeedBack('pword', ret[1], '#D9534F');
    } else {
      regFeedBack('pword', "Password is good!", "#28b363");
    }
  }

  function CheckPword(pword) {
    var ret = [];
    ret[0] = true;
    if ((pword).length < 6) {
      ret[0] = false;
      ret[1] = "Password is too short! (<6 characters)";
    } else if (pword.search(/\d/) == -1) {
      ret[0] = false;
      ret[1] = "A number is required";
    } else if (pword.search(/[a-zA-Z]/) == -1) {
      ret[0] = false;
      ret[1] = "A letter is required";
    }
    return ret;
  }

  function CheckNameAvailable() {

    $.ajax({
      url: APIURL + "auth/check/user",
      data: {
        user: $('#uname1').val()
      },
      type: 'post',
      success: function(data) {
        if (data == "1") {
          regFeedBack('uname', "Username available!", "#28b363");
        } else {
          regFeedBack('uname', "Username taken!", "#D9534F");
        }
      }
    });


  }

  function CheckEmailAvailable() {
    var re = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
    if (!re.test($('#email1').val())) {
      regFeedBack('email', "Please enter a valid email!", "#D9534F");
    } else {
      $.ajax({
        url: APIURL + "auth/check/email",
        data: {
          email: $('#email1').val()
        },
        type: 'post',
        success: function(data) {
          if (data == "1") {
            regFeedBack('email', "Email available!", "#28b363");
          } else {
            regFeedBack('email', "Email taken!", "#D9534F");
          }
        }
      });
    }
  }
  $("#RegBut").click(function() {
    Register();
  });
  $("#SigninBut").click(function() {
    Login();
  });
  /*
  * Gather data from form and send to register API
  *
  * Get username, password and email from the input boxes
  * Send data via Ajax to the API
  * Check the response and give feedback
  */
  function Register() {
    var user1 = $('#uname1').val();
    var pword1 = $('#pword1').val();
    var email1 = $('#email1').val();
    if ($('#email1label').text() == "Email taken!") {
      $('#email1label').focus();
    } else if ($('#uname1label').text() == "Username taken!") {
      $('#uname1label').focus();
    } else if ($('#pword1label').text() != "Password is good!") {
      $('#pword1label').focus();
    } else {
      $.ajax({
        url: APIURL + "auth/register",
        data: {
          user: user1,
          email: email1,
          pword: pword1
        },
        type: 'post',
        success: function(data) {
          console.log(data);
          if (data == "UTAKEN") {
            $('#uname1').focus();
            regFeedBack('uname', "Username taken!", "#D9534F");
          } else if (data == "ETAKEN") {
            $('#email1').focus();
            regFeedBack('email', "Please enter a valid email!", "#D9534F");
          } else if (data == "RSUC") {
            location.reload();
          } else if (data == "PSHORT") {
            regFeedBack('pword', "Password is too short! (<6 characters)", "#D9534F");
          }
        }
      });
    }
  }
  /*
  * Gather data from form and send to login API
  *
  * Get username and password from the input boxes
  * Send data via Ajax to the API
  * Check the response and give feedback
  */
  function Login() {
    var user1 = $('#uname').val();
    var pword1 = $('#pword').val();
    if (user1 != "" && pword1 != "") {
      $.ajax({
        url: APIURL + "auth/login",
        data: {
          user: user1,
          pword: pword1
        },
        type: 'post',
        success: function(data) {
          if (data == "LFAILUNAME") {
            $('#uname').focus();
            LogFeedBack('uname', "Username is incorrect.", "#D9534F");
          } else if (data == "LSUC") {
            location.reload();
          } else if (data == "LFAILPWORD") {
            LogFeedBack('pword', "Password is incorrect!", "#D9534F");
          } else if (data == "FAIL") {
            LogFeedBack('uname', "Something went wrong, try again later!", "#D9534F");
            LogFeedBack('pword', "Something went wrong, try again later!", "#D9534F");
          }
        }
      });
    } else {
      if (pword == "") {
        $('#pword').focus();
        LogFeedBack('email', "Please fill out your password.", "#D9534F");
      } else {
        $('#uname').focus();
        LogFeedBack('uname', "Please fill out your username.", "#D9534F");
      }
    }

  }
  

});
