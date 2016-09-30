$(function() {
  var qNumb;
  var qQs = [];
  var qAns = [];
  var qRet = [];
  var currentQ;
  var percDone;
  var fin = false;
  $("#GenQuestions").click(function(e) { //on add input button click

    e.preventDefault();
    if($('#testnameinput').val().length ==0) {
      $('#nameerror').css('display','inherit');
      $('#nameerror').append('<div class="alert alert-dismissible alert-danger">' +
        '<button type = "button"' +
        'class = "close"' +
        'data-dismiss = "alert"> × </button> <strong> Oh dear! </strong> Please fill out the test\'s name! </div>');

    } else {
      $('#nameerror').css('display','none');
      qNumb = $('#qNumb').val();
      $('#questionlist').html("");
      $('.qanswersinput').html("");
      $('#qAnsCorrect').css("display", "none");
      $('#qAnsCorrectLabel').css("display", "none");
      $('#nextQuest').css("display", "none");
      percDone = 10;
      updateProgressbar();
      for (var i = 0; i < qNumb; i++) {

        $('#questionlist').append('<input type="text" required class="form-control" placeholder="Question ' + (i + 1) + '" id="genQ' + i + '"><br />')

      }
      $('#GenAnswers').css("display", "block");
  }
  });
  function updateProgressbar(){ 
    $('.progress-bar').css("width",percDone+'%');
  }
  $("#GenAnswers").click(function(e) {
    e.preventDefault();
    var cont = true;
    for (var i = 0; i < qNumb; i++) {
      if($('#genQ' + i).val() == "") {
        cont = false;
        qQs = [];
        $('#questionlist').append('<div class="alert alert-dismissible alert-danger">' +
        '<button type = "button"' +
        'class = "close"' +
        'data-dismiss = "alert"> × </button> <strong> Oh dear! </strong> Please fill out the all the questions! </div>');
      $('#genQ' + i).focus();
        break;
      } 
      qQs[i] = $('#genQ' + i).val();
    }
    if(cont) {
      $('#questionlist').html("");
      $('#GenAnswers').css("display", "none");
      $('#qAnsCorrect').css("display", "inline");
      $('#qAnsCorrectLabel').css("display", "inline");
      $('#nextQuest').css("display", "inline");
      $('#Qtooltip').css("display", "inline");
      $('#questionlist').append('<h3 id="aQuestionTitle">Question 1: ' + qQs[0] + '</h3>');
      currentQ = 0;
      if (qQs.length == (currentQ + 1)) {
        $('#nextQuest').text("Finish");
      }
      for (var i = 0; i < 5; i++) {
        $('#questionlist').append('<input type="text" class="form-control qanswersinput" placeholder="Answer ' + (i + 1) + '" id="ansQ_0_' + i + '"><br />');
      }
    }
  });
  $("#nextQuest").click(function(e) {
    e.preventDefault();
    ansBuffer = [];
    anstotal = 0;
    for (var i = 0; i < 5; i++) {
      if ($('#ansQ_' + currentQ + '_' + i).length >0 && $('#ansQ_' + currentQ + '_' + i).val().length != 0) {
        anstotal++;
      }
    }
    checkfilledout = true;
    for (var i = 0; i < anstotal; i++) {
      if ($('#ansQ_' + currentQ + '_' + i).val().length == 0) {
        checkfilledout = false;
      }
    }
    if (!checkfilledout) {
      $('#questionlist').append('<div class="alert alert-dismissible alert-danger">' +
        '<button type = "button"' +
        'class = "close"' +
        'data-dismiss = "alert"> × </button> <strong> Oh dear! </strong> Please fill out the questions in order! </div>');
      $('#qAnsCorrect').focus();
    } else {
      chosenans = parseInt($('#qAnsCorrect').val()) -1;
      if ($('#ansQ_' + currentQ + '_' + chosenans).val().length == 0) {
        $('#questionlist').append('<div class="alert alert-dismissible alert-danger">' +
          '<button type = "button"' +
          'class = "close"' +
          'data-dismiss = "alert"> × </button> <strong> Oh dear! </strong> Your chosen answer is not filled out! </div>');
        $('#qAnsCorrect').focus();
      } else {
        ansBuffer[0] = qQs[currentQ];
        ansBuffer[1] = anstotal;
        ansBuffer[2] = (parseInt($('#qAnsCorrect').val())-1);
        for (var i = 0; i < anstotal; i++) {
          ansBuffer[(3 + i)] = $('#ansQ_' + currentQ + '_' + i).val();
        }
        qAns[currentQ] = ansBuffer;
        currentQ++;
        if (qQs.length == (currentQ + 1)) {
          $('#nextQuest').text("Finish");
        }
        if (qQs.length > currentQ) {
          percDone += (90/qQs.length);
          updateProgressbar();
          
          $('#questionlist').html("");
          $('#questionlist').append('<h3 id="aQuestionTitle">Question ' + (currentQ + 1) + ': ' + qQs[currentQ] + '</h3>');
          for (var i = 0; i < 5; i++) {
            $('#questionlist').append('<input type="text" class="form-control qanswersinput" placeholder="Answer ' + (i + 1) + '" id="ansQ_' + currentQ + '_' + i + '"><br />');
          }
        } else {
          if ($('#testnameinput').val().length < 1) {
            $('#questionlist').append('<div class="alert alert-dismissible alert-danger">' +
              '<button type = "button"' +
              'class = "close"' +
              'data-dismiss = "alert"> × </button> <strong> Oh dear! </strong> Please fill out the test name! </div>');
            $('#testnameinput').focus();
          } else {
            percDone = 100;
            updateProgressbar();
            qRet[0] = $('#testnameinput').val();
            $('.progress-bar').css("background-color","#2cc939");
            qRet[1] = qQs.length;
            qRet.push(qAns);
            if(!fin){
              $('#questionlist').html("");
              $('.removeAtEnd').hide();
              sendTest(JSON.stringify(qRet));
              fin = true;

            }
          }
        }
      }
    }
  });

  function sendTest(Json1) {
    Json1 = JSON.parse(Json1);
    $.ajax({
      url: APIURL+"test/create",
      data: {
        Json: Json1,
        status: $('#oStatus').val()
      },
      type: 'post',
      success: function(data) {
        data= JSON.parse(data);
        if(data[0] == "success") {
           $('#questionlist').append('<div class="alert alert-dismissible alert-success">' +
              '<button type = "button"' +
              'class = "close"' +
              'data-dismiss = "alert"> × </button> <strong> Finished! </strong> Your test has been created! <br>You will now be redirected to its admin page. </div>');
            $('#testnameinput').focus();
              setTimeout(function(){
                 window.location = APIURL+'test/admintest/'+data[1];
              }, 1500);
        } else  {
           $('#questionlist').append('<div class="alert alert-dismissible alert-danger">' +
              '<button type = "button"' +
              'class = "close"' +
              'data-dismiss = "alert"> × </button> <strong> Error! </strong> Something went wrong! Code: '+data[1]+' </div>');
        }
      }
    });
  }
});
