	
/**
 * Esta funci—n se encarga de responder din‡micamente los pedidos que
 * se realizan sobre el gr‡fico para directores.
 * 
 * @author cgajardo
 * @date 2012-02-07
 */      
 function drawChart() {
	var last_data;
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Sede');
    data.addColumn('number', 'Tiempo');
    data.addRows([["text",1],["oro",3]]);

    var options = {
      width: 400, height: 240,
      title: 'Tiempo de uso de la plataforma por sede',
      hAxis: {title: 'Minutos', titleTextStyle: {color: 'blue'}}
    };

    var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
    chart.draw(data, options);
    google.visualization.events.addListener(chart, 'select', loadXMLDoc);

    function loadInstitucion(){
    	
    }
    
    function loadXMLDoc(){
    	var xmlhttp;
    	var id = 0;
    	var selection = chart.getSelection();
    	for (var i = 0; i < selection.length; i++) {
    		var item = selection[i]; 
    	    if (item.row != null && item.column != null) {
    	    	id = 3;
    	    } else if (item.row != null) {
    	    	id = 4;
    	    } else if (item.column != null) {
    	    	id = 3;
    	    }
    	}
    	
    	if (window.XMLHttpRequest){
        	// code for IE7+, Firefox, Chrome, Opera, Safari
      		xmlhttp=new XMLHttpRequest();
      	}
    	else{
        	// code for IE6, IE5
      		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      	}
      	
    	xmlhttp.onreadystatechange=function() { 
      		if (xmlhttp.readyState==4 && xmlhttp.status==200){
      			document.getElementById("myDiv").innerHTML=xmlhttp.responseText;
      			var j = JSON.parse(xmlhttp.responseText);
      			last_data = j;
      			chart.clearChart();
            	//se sobreescribe el gr‡fico 
            	chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));

            	data = new google.visualization.DataTable();
                data.addColumn('string', 'Curso');
                data.addColumn('number', 'Tiempo');
                data.addRows(j);
                options = {
                        width: 800, height: 240,
                        title: 'Tiempo de uso de la plataforma por Curso',
                        hAxis: {title: 'Minutos', titleTextStyle: {color: 'blue'}}
                };
                
                chart.draw(data, options);
                google.visualization.events.addListener(chart, 'select', loadXMLDoc);
        	}
      	}
      	
    	xmlhttp.open("GET","director/data?sede="+id,true);
    	xmlhttp.send();
    }
    
  }