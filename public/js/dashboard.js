var Dashboard = {
	init: function()
	{
		Dashboard.drawItemPercentagesChart();
	},

    drawItemPercentagesChart: function()
    {
    	$.ajax({
	        type: 'get',
	        url : '/stats/item_percentages',
	        success: function(response){
	        	var collection = [];
	        	console.log(response);

	        	$.each(response,function(key,value){
	        		collection.push({label: key,y: value});
	        	});

	        	console.log(collection);

	            var chart = new CanvasJS.Chart("item-percentages", {
				    title:{
				      text: "",
				      fontColor: "rgba(100,149,237)"              
				    },
				    axisY :{
				        lineColor: "#3CB371",
				        gridColor: "#F0FFFF", 
				        },
			        axisX :{
				        lineColor: "#3CB371",
				        gridColor: "#F0FFFF", 
			        },
				    data: [              
					    {
						     // Change type to "doughnut", "line", "splineArea", etc.
						    type: "pie",
						    dataPoints: collection
					    }
				    ]
				});
				chart.render();
			}
		});
    },

	registerEventListeners: function()
	{

	}
};

window.load = Dashboard.init();