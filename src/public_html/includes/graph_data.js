$(function() {
 
    function getQueryVariable(variable)
	{
	    var query = window.location.search.substring(1);
	    var vars = query.split("&");
	    for (var i=0;i<vars.length;i++) {
	  	    var pair = vars[i].split("=");
		    if(pair[0] == variable){return pair[1];}
		}
	        return(false);
	}
    var name = getQueryVariable("name")
    var count = getQueryVariable("count")
    var typecount = count
    var type = getQueryVariable("type")
    var dbtype = getQueryVariable("dbtype")
    var x_values = [];
    var y_values = [];
    var z_values = [];
    var stage = 1;
    if (type != "readings")
    {
	dbtype = "archive";
    }
    if (type == "hours")
    {
	count = (count * 7);
    }
    else if (type == "days")
    {
	count = (count * 156);        
    }

    if (type == "weeks")
    {
       count = (count * 1095);
    }
    else if (type == "months")
    {
        count = (count * 4380);
    }
    else if (type == "years")
    {
        count = (count * 52560);
    }
    else if (type == "readings")
    {
        count = (count);        
    }

    $.get('../includes/get_readings.php?name=' + name + '&dbtype=' + dbtype +'&count=' + count, function(data) {
 
        data = data.split('|');
        for (var i in data)
        {
            if (stage == 1)
            {
                x_values.push(data[i]);
		stage = 2;
            }
            else if (stage == 2)
            {
                y_values.push(parseFloat(data[i]));
                stage = 3;
            }
	    else if (stage == 3)
            {
                z_values.push(parseFloat(data[i]));
                stage = 1;
            }
 
        }
        x_values.pop();
 
        $('#chart').highcharts({
            chart : {
	        backgroundColor: '#343434',
		type : 'spline'
            },	
            title : {
                text : name + ' ' + typecount + ' ' + type,
                style:{color:"#d9d9d9"}
            },
            subtitle : {
                text : 'Temperature & Humidity',
                style:{color:"#d9d9d9"}
            },
            legend: {
                itemStyle: {
                    color: '#d9d9d9',
                    fontWeight: 'bold'
                }
            },
            xAxis : {
                title : {
                    text : 'Time',
                    style:{color:"#d9d9d9"}
                },
                categories : x_values,
                labels: {
                    style: {
                        color: "#d9d9d9"
                    }
            }
            },
            yAxis : {
                title : {
                    text : 'Temperature / Humidity',
                    style:{color:"#d9d9d9"}
                },
                labels : {
                    style: {color: "#d9d9d9"},
                    formatter : function() {
                        return this.value + ' '
                    }
                }
            },
            tooltip : {
                crosshairs : true,
                shared : true,
                valueSuffix : ''
            },
            plotOptions : {
                spline : {
                    marker : {
                        radius : 4,
                        lineColor : '#e60000',
                        lineWidth : 1
                    }
                }
            },
            series : [{
 
                name : 'Temperature (C)',
		lineColor: '#f45c1a',
                data : y_values
            }, {

		name : 'Humidity (%)',
		lineColor: '#14e8a5',
		data : z_values
	    }]
        });
    });
});
