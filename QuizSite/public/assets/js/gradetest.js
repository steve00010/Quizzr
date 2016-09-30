$(function() {
	var url = window.location.href;
	url = url.replace("http://","");
	var length = url.length;
	var pos = url.indexOf("taketest/");
	pos += 9;
	var res = url.substring(pos, length);
	var send = {ID:res};
	$.post( APIURL+"test/checktest",send).done(function( data ) {
		if(data != "false") {
		var obj =$.parseJSON(data);
			  	var score = obj['score'];
			  	$("#finishtest").css('display','none');
			 	$('#resulttext').text("Your score: " +score+"%");
			  	var resa = obj['resa'];
			  	var modelans = obj['modelans'];
			  	var result = obj['result'];
			  	for (var i = resa.length - 1; i >= 0; i--) {
			  		if(resa[i] == false) {
			  			var id = result[i].substring(2);
			  			var def = i+"-"+id;
			  			var mydiv = "#resultbox"+def;
			  			$(mydiv).css("background-color","rgb(165, 39, 39)");
			  			ida = modelans[i].substring(2);
			  			def = i+"-"+ida;
			  			mydiv = "#resultbox"+def;
			  			$(mydiv).css("background-color","rgb(68, 114, 103)");
			  		} else {
			  			var id = result[i].substring(2);
			  			var def = i+"-"+id;
			  			$("#resultbox"+def).css("background-color","rgb(68, 114, 103)");
			  		}
			  	}
			  }

	});

	$("#finishtest").click(function() {
		var result = [];
		$('input[type=radio]').each(function(){
			if($(this).is(':checked')) {
	   			var id = $(this).attr('id');
	   			var def = id.substring(9);
	   			result.push(def);
	   		}
		});
		
		
		var send = {ID:res,result:JSON.stringify(result)};
		console.log(send);
		$.post( APIURL+"test/gradetest", send)
		  .done(function( data ) {
		  	if(data != "false") {
			  	var obj =$.parseJSON(data);
			  	var score = obj['score'];
			  	var resa = obj['resa'];
			  	var modelans = obj['modelans'];
			  	
			  	for (var i = resa.length - 1; i >= 0; i--) {
			  		if(resa[i] == false) {
			  			id = result[i].substring(2);
			  			var def = i+"-"+id;
			  			var mydiv = "#resultbox"+def;
			  			$(mydiv).css("background-color","rgb(165, 39, 39)");
			  			ida = modelans[i].substring(2);
			  			def = i+"-"+ida;
			  			mydiv = "#resultbox"+def;
			  			$(mydiv).css("background-color","rgb(68, 114, 103)");
			  		} else {
			  			id = result[i].substring(2);
			  			var def = i+"-"+id;
			  			$("#resultbox"+def).css("background-color","rgb(68, 114, 103)");
			  		}
			  	}
			  	alert("You scored "+score+"%!");
		  	} else {
		  		alert("You have already taken this test!");
		  	}
		  });
	});
});