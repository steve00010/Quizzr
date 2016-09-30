$(function() {
	var send = {ID:$("#testid").text(),user:$("#uniqid").text()};
	$.post( APIURL+"test/checktest",send).done(function( data ) {
		if(data != "false") {
		var obj =$.parseJSON(data);
			  	var score = obj['score'];
			  	$("#finishtest").css('display','none');
			 	$('#resulttext').text("Score: " +score+"%");
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
});