<?php 


?>

	
	<div class=" row mx-0" >
		<div class="col-sm-10">
			<div class="btn-group interval   justify-content-start mb-1 " style="display: flex;">
			    <button type="button" class="btn primaryBtn rtl">1 ساعت</button>
			    <button type="button" class="btn primaryBtn rtl d-none d-md-block">12 ساعت</button>
			    <button type="button" class="btn secondaryBtn rtl">24 ساعت</button>
			    <button type="button" class="btn primaryBtn rtl">1 هفته</button>
			    <button type="button" class="btn primaryBtn rtl">1 ماه</button>
			    <button type="button" class="btn primaryBtn rtl d-none d-md-block">3 ماه</button>
			    <button type="button" class="btn primaryBtn rtl">1 سال</button>
			    <button type="button" class="btn primaryBtn rtl d-none d-md-block">از ابتدا</button>
			</div>
					
		</div>
		<div class="col-sm-2">
			<div class="btn-group chartType  justify-content-end " style=" display: flex;" >
			    <button type="button" class="btn secondaryBtn">line</button>
			    <button type="button" class="btn primaryBtn">OHLC</button>

			</div>

					<input type="hidden" id="chart_type" value="line">
					<input type="hidden" id="timePeriod" value="2">
	</div>	
</div>
	<div class="col-sm-12 ">
		 <div  id="chart_div" style="width:100%; height:400px; "></div>

		 <div id="chartPreloader" class="baseLoader" type="hidden" >
    	 <div class="spinner"></div> 
   		 </div>
	</div>


<hr>
<script type="text/javascript">

$(".interval button").click(function () {
	
	$("#timePeriod").val($(this).index());
	
	$(".interval button").removeClass("secondaryBtn");
		$(".interval button").addClass("primaryBtn");
		$(this).removeClass("primaryBtn");
		$(this).addClass("secondaryBtn");
			

		loadPriceChart();
});

$(".chartType button").click(function () {
		$("#chart_type").val($(this).html());
		$(".chartType button").removeClass("secondaryBtn");
		$(".chartType button").addClass("primaryBtn");
		$(this).removeClass("primaryBtn");
		$(this).addClass("secondaryBtn");

			
		loadPriceChart();
});



function loadPriceChart(){
			$("#chartPreloader").show();
			timeInterval=$("#timePeriod").val();
			chartType=$("#chart_type").val();


		$.ajax({			
			url: 'deals/priceChart',
			type:'post',
			data: "pair="+$('#pair').val() + "&timeInterval="+timeInterval + "&chartType=" + chartType,

			success: function(result){
			
//console.log($.parseJSON(result))
//******** Generate Chart**///

					google.charts.load('current', {'packages':['corechart']});
					google.charts.setOnLoadCallback(drawChart);
					function drawChart() {
					var data = google.visualization.arrayToDataTable($.parseJSON(result),false);
					var options = {
						 candlestick:{
									    fallingColor:{
									      fill:'#EE1C49',
									      stroke:'#EE1C49',
									    },
									    risingColor:{
									      fill:'#2266DD',
									      stroke:'#2266DD',
									    },
									  },
						legend:'none',
 						vAxis: {format: 'short', viewWindowMod: 'pretty', textStyle: {color: '#555'}},
 						hAxis: {format: 'short', minValue:  0,  gridlines:{ color: '#333', count: 4}, textStyle: {color: '#555'}},
						backgroundColor:{
							strokeWidth:2 ,
							fill:'#CBCBCC'
						},
						colors:['rgb(90, 110, 230)'],
						chartArea:{backgroundColor:'#DDD', left:'10%',top:'5%',width:'85%',height:'85%'},
						crosshair: { trigger: 'both', color: '#3bc', opacity: 0.5 },
						explorer:{ actions: ['dragToZoom', 'rightClickToReset'], axis: 'horizontal', keepInBounds: true, maxZoomIn: 4.0},
          
						};

					if(chartType=='line'){
						var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
					}else{
						var chart = new google.visualization.CandlestickChart(document.getElementById('chart_div'));

					}

					chart.draw(data, options);
					}

				}
			});

$(document).ajaxComplete(function(){
    $("#chartPreloader").hide();
});

}
</script>