
window.onload = function () {
    
     $.ajax({
      url: APIURL + "admin/UserSignUp/",
      type: 'get',
      success: function(data) {
        data = JSON.parse(data);
        var darray = data;
        var retarray = [];
        for (var key in darray) {
          var a = { x: new Date(parseInt(key)*1000), y: parseInt(darray[key]) };
          retarray.push(a);
        }
        var chart = new CanvasJS.Chart("chartContainer",
      {
        title:{
          text: "User sign up history"
      },
      axisX:{
          title: "timeline",
          valueFormatString: "DD-MMM-YY" ,
          gridThickness: 2
      },
       backgroundColor: "#212121",
      axisY: {
          title: "Number"
      },
      data: [
      {        
          type: "column",
          color: "rgba(0,75,141,0.7)",
          dataPoints: retarray
      }
      ]
    });
      chart.render();
      }
    });
    $.ajax({
      url: APIURL + "admin/TestCreate/",
      type: 'get',
      success: function(data) {
        data = JSON.parse(data);
        var darray = data;
        var retarray = [];
        for (var key in darray) {
          var a = { x: new Date(parseInt(key)*1000), y: parseInt(darray[key]) };
          retarray.push(a);
        }
        var chart = new CanvasJS.Chart("chartContainer1",
      {
        title:{
          text: "Test creation history"
      },
      axisX:{
          title: "timeline",
          valueFormatString: "DD-MMM-YY" ,
          gridThickness: 2
      },
       backgroundColor: "#212121",
      axisY: {
          title: "Number"
      },
      data: [
      {        
          type: "column",
          color: "rgba(0,75,141,0.7)",
          dataPoints: retarray
      }
      ]
    });
      chart.render();
      }
    });
}
