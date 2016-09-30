window.onload = function () {
	  var code = $("#testcode").text();
	 $("#DeleteTestBtn").click(function(e) {
		    e.preventDefault();
	  	    var x;
    		if (confirm("Are you sure you want to delete this test?") == true) {
    			$.ajax({
				      url: APIURL + "test/deleTetest/" + code,
				      type: 'get',
				      success: function(data) {
				      	if(data == true) {
				      		 $('#editfeedback').append('<div class="alert alert-dismissible alert-success">' +
              '<button type = "button"' +
              'class = "close"' +
              'data-dismiss = "alert"> × </button> <strong> Success! </strong> Your test was deleted, you will now be redirected to the previous page. </div>');
				      	      setTimeout(function(){
				                 window.history.back();
				              }, 1500);
				      	} else {
				      		 $('#editfeedback').append('<div class="alert alert-dismissible alert-danger">' +
              '<button type = "button"' +
              'class = "close"' +
              'data-dismiss = "alert"> × </button> <strong> Deletion failed! </strong> Something went wrong, try again later. </div>');
				      	}
				      }
				  });
    		}
	  });
	  $("#EditTestBtn").click(function(e) {
		    e.preventDefault();
   		var pub;
   		if($("#radio_prv").is(':checked')) {
   			pub = true;
   		}
   		if($("#radio_pub").is(':checked')) {
   			pub = false;
   		}
	  	var name = $("#newtestname").val();
	  	if (typeof pub == 'undefined' && name == "") {
		 $('#editfeedback').append('<div class="alert alert-dismissible alert-danger">' +
              '<button type = "button"' +
              'class = "close"' +
              'data-dismiss = "alert"> × </button> <strong> Edit failed! </strong>Please enter a new name of publicity status. </div>');
		}else {
			var data = {};
			if(typeof pub !== 'undefined') {
				data['status'] = pub;
			}
			if(name != ""){
				data['name'] = name;
			}

			$.ajax({
					      url: APIURL+"test/edittest/"+code,
					      data: data,
					      type: 'post',
					      success: function(data) {
					      	if(data == true){
		 $('#editfeedback').append('<div class="alert alert-dismissible alert-success">' +
              '<button type = "button"' +
              'class = "close"' +
              'data-dismiss = "alert"> × </button> <strong> Edit complete! </strong>The page will now be refreshed for you. </div>');
		 				      	      setTimeout(function(){
				                 window.location.reload(1);
				              }, 1500);
					      	} else {
					      				 $('#editfeedback').append('<div class="alert alert-dismissible alert-danger">' +
              '<button type = "button"' +
              'class = "close"' +
              'data-dismiss = "alert"> × </button> <strong> Edit failed! </strong>Something went wrong, try again later.</div>');
					      	}
					      }
					  });
		}

	});


	$.ajax({
      url: APIURL + "test/testhistory/" + code,
      type: 'get',
      success: function(data) {
      	data = JSON.parse(data);
      	var darray = data[0];
      	var sarray = data[1];
      	var retarray = [];
      	for (var i = darray.length - 1; i >= 0; i--) {
      		var a = { x: new Date(parseInt(darray[i])*1000), y: parseInt(sarray[i]) };
      		retarray.push(a);
      	}
      	var chart = new CanvasJS.Chart("chartContainer",
	    {
	      title:{
	        text: "Test scores over time"
	    },
	    axisX:{
	        title: "timeline",
	        valueFormatString: "DD-MMM-YY" ,
	        gridThickness: 2
	    },
	     backgroundColor: "#212121",
	    axisY: {
	        title: "Score (%)",
	        maximum:100
	    },
	    data: [
	    {        
	        type: "area",
	        color: "rgba(0,75,141,0.7)",
	        dataPoints: retarray
	    }
	    ]
		});
    	chart.render();
      }
    });
    $.ajax({
      url: APIURL + "test/teststats/" + code,
      type: 'get',
      success: function(data) {
      	data = JSON.parse(data);
      	var darray = data[0];
      	var sarray = data[1];
      	var retarray = [];
      	for (var i = 0; i <= sarray.length - 1; i++) {
      		var a = { x: (i+1), y: parseInt(sarray[i]) };
      		retarray.push(a);
      	}
      	var chart = new CanvasJS.Chart("chartContainer1",
	    {
	      title:{
	        text: "Answer correct percentage"
	    },
	    responsive: true,

	    axisX:{
	        title: "Question number",
	    },
	     backgroundColor: "#212121",
	    axisY: {
	        title: "Number (%)",
	        maximum:100
	    },
	    data: [
	    {        
	        type: "bar",
	        dataPoints: retarray
	    }
	    ]
		});
    	chart.render();

      }
    });

}