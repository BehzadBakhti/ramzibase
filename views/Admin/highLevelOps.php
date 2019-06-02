<h2 class="pt-2"> عملیات سطح بالا</h2>
<div class="container ">
	<div class="row">
	<!-- Operation freezing management -->
		<div class="col-md-3 border ">
			<h4 class="mt-1"> مدیریت و کنترل ارزها</h4>
		<hr style="border-color: white; margin: 0px;">
			<form class="form-group mt-1">
				<div class="form-row">	
					<input type="checkbox" class="form-check-input mx-3" id="irr_frz_check">
					<label for="irr_frz_check" class="form-check-label mx-5"> توقف معاملات ریال</label>
				</div>
				<div class="form-row">	
					<input type="checkbox" class="form-check-input mx-3" id="btc_frz_check">
					<label for="btc_frz_check" class="form-check-label mx-5"> توقف معاملات بیتکوین</label>
				</div>
				
				<div class="form-row">	
					<input type="checkbox" class="form-check-input mx-3" id="eth_frz_check">
					<label for="eth_frz_check" class="form-check-label mx-5"> توقف معاملات اتریوم</label>
				</div>
				<div class="form-row">	
				
					<input type="checkbox" class="form-check-input mx-3" id="bch_frz_check">
					<label for="ltc" class="form-check-label mx-5"> توقف معاملات بیتکوین کش</label>
				</div>

				<div class="form-row">	
				
					<input type="checkbox" class="form-check-input mx-3" id="ltc_frz_check">
					<label for="ltc" class="form-check-label mx-5"> توقف معاملات لایتکوین</label>
				</div>
				<div class="align-center  my-3">
					<input type="button" id="frz_Ufrz" class="btn secondaryBtn w-45" value="اعمال تغییرات"> </input>
				</div>
			</form>

		</div>
	<!-- MarketMaker management -->
		<div class="col-md-4 border">
			<h4 class="mt-1"> مدیریت بازار ساز ها</h4>
			<hr style="border-color: white; margin: 0px;">
  			<h5 >مدیریت موجودی در گردش</h5>
  			<div class="row mx-1">
				<div class="py-1  col-sm-6 border " >
					<h6 class="mt-1">بازار ساز 1</h6>
					<hr style="border-color: white; margin: 0px;">
					<div class="p-1 text-right "><span>  ریال: </span><span id="mm1_irr"> 0.5</span></div>
					<div class="p-1 text-right "><span> بیتکوین: </span><span id="mm1_btc"> 0.5</span></div>
					<div class="p-1 text-right "><span>  اتریوم: </span><span id="mm1_eth"> 0.5</span></div>
					<div class="p-1 text-right "><span>  بیتکوین کش: </span><span id="mm1_bch"> 0.5</span></div>
					<div class="p-1 text-right "><span>  لایتکوین: </span><span id="mm1_ltc"> 0.5</span></div>
				</div>
				<div class="py-1 col-sm-6 border " >
					<h6 class="mt-1">بازار ساز 2</h6>
					<hr style="border-color: white; margin: 0px;">
					<div class="p-1 text-right "><span>  ریال: </span><span id="mm2_irr"> 0.5</span></div>
					<div class="p-1 text-right "><span> بیتکوین: </span><span id="mm2_btc"> 0.5</span></div>
					<div class="p-1 text-right "><span>  اتریوم: </span><span id="mm2_eth"> 0.5</span></div>
					<div class="p-1 text-right "><span>  بیتکوین کش: </span><span id="mm2_bch"> 0.5</span></div>
					<div class="p-1 text-right "><span>  لایتکوین: </span><span id="mm2_ltc"> 0.5</span></div>
				</div>
			</div>
			<div class="py-1 m-1  border mx-1">

				<div class="form-inline form-group my-1">
                  <label for="mmSelect" class="w-25">بازار ساز</label>
                  <select  id="mmSelect" class="form-control w-73" >
                    <option>بازار ساز 1</option>
                    <option> بازار ساز 2</option>
                    
                  </select>
              	</div>
				
                <div class="form-inline form-group my-1">
                  <label for="mmCurrency" class="w-25">واحد پول</label>
                  <select  id="mmCurrency" class="form-control w-73" >
                    <option>ریال</option>
                    <option> بیتکوین</option>
                    <option> اتریوم</option>
                    <option> بیتکوین کش</option>
                    <option> لایتکوین</option>
                  </select>
              	</div>
       

                  <div class="form-group form-inline my-1">
                    <label for="mmFund" class="w-25">مقدار</label>
                    <input type="text" id="mmFund" class="form-control w-73"  placeholder="مقدار را وارد کنید">
                  </div>

                  <button id="addFund" type="button" class="btn secondaryBtn w-45"><span>افزایش موجودی</span></button>
                   <button id="removeFund" type="button" class="btn primaryBtn w-45"><span>کاهش موجودی</span></button>
        
          </div>
		<div class="py-1 m-1  border ">
			<h5 >بازه های زمانی بررسی</h5>
				<div class="form-inline form-group my-1">
                  <label for="mmPair" class="w-25">جفت ارز</label>
                  <select  id="mmPair" class="form-control w-73" >
                    <option>BTC/IRR</option>
                    <option> ETH/IRR</option>
                    <option> LTC/IRR</option>
                    <option> BCH/IRR</option>
                    <option> BTC/ETH</option>
                    <option> BTC/LTC</option>
                    <option> BTC/BCH</option>
                    <option> ETH/BCH</option>
                    <option> ETC/LTC</option>
                    <option> BCH/LTC</option>
                  </select>
              	</div>

		        <div class="form-inline form-group my-1">
          	     
                    <label for="mmInterval" class="w-25">بازه زمانی:</label>
                    <input type="text" id="mmInterval" class="form-control w-73"placeholder="هر چند دقیقه؟">
                 </div>     
                   <button id="mmUpdate" type="button" class="btn secondaryBtn w-45" ><span>اعمال تغییرات</span></button>
		</div>
		
		</div>
	<!-- Income Monitoring  -->		
		<div class="col-md-5 border">
			<h4 class="mt-1"> درآمد و هزینه</h4>
			


              	<div class="row mx-0">
				<div class="col-md-6 border py-1">
					<h6 class="mt-1"> موجودی کل</h6>
					<hr style="border-color : white;margin: 0px;">
					<div class="py-1  mx-1" >
						<div class="p-1 text-right"><span> موجودی ریال: </span><span id="total_irr"> 0.5</span></div>
						<div class="p-1 text-right"><span> موجودی بیتکوین: </span><span id="total_btc"> 0.5</span></div>
						<div class="p-1 text-right"><span> موجودی اتریوم: </span><span id="total_eth"> 0.5</span></div>
						<div class="p-1 text-right"><span> موجودی بیتکوین کش: </span><span id="total_bch"> 0.5</span></div>
						<div class="p-1 text-right"><span> موجودی لایتکوین: </span><span id="total_ltc"> 0.5</span></div>
					</div>

				</div>
				<div class="col-md-6 border py-1">
					<h6 class="mt-1"> موجودی تملیکی</h6>
					<hr style="border-color : white;margin: 0px;">
					<div class="py-1  mx-1" >
						<div class="p-1 text-right"><span> موجودی ریال: </span><span id="net_irr"> 0.5</span></div>
						<div class="p-1 text-right"><span> موجودی بیتکوین: </span><span id="net_btc"> 0.5</span></div>
						<div class="p-1 text-right"><span> موجودی اتریوم: </span><span id="net_eth"> 0.5</span></div>
						<div class="p-1 text-right"><span> موجودی بیتکوین کش: </span><span id="net_bch"> 0.5</span></div>
						<div class="p-1 text-right"><span> موجودی لایتکوین: </span><span id="net_ltc"> 0.5</span></div>
					</div>	

				</div>
				</div>

				<hr style="border-color : white; margin: 0.5rem;">
				<div class="form-inline form-group mt-1">
                  <label for="incomeCurr" class="w-15">ارز:</label>
                  <select  id="incomeCurr" class="form-control w-25" >
                     <option> ریال</option>
                    <option>بیتکوین</option>
                    <option> اتریوم</option>
                    <option> بیتکوین کش</option>
                    <option> لایتکوین</option>
                   
                  </select>
                  <label for="incomeInterval" class="w-20">بازه زمانی:</label>
                  <select  id="incomeInterval" class="form-control w-25" >
                    <option>1 ساعت</option>
                    <option>12 ساعت</option>
                    <option> 24 ساعت</option>
                    <option>1 هفته</option>
                    <option>1 ماه</option>
                    <option>1 سال</option>
                  </select>
                  <button type="button" id="loadIncomeBtn" class=" btn secondaryBtn mr-1" style=" color: #dde; width: 13%"><i class="fas fa-retweet fa-lg  "></i></button>
              	</div>
				<div class="col-md-12 border pb-1 ">
					<h6 class="mt-1"> نمودار تغییرات موجودی</h6>
					<div  id="chart_div" style="width:100%; height:200px; background-color: white;"></div>

				</div>

		</div>
	</div>
	
	
</div>
<script type="text/javascript">
	$(document).ready(function(){
		loadFreezData()
		mmLoadFoundJS()
		netReserveJS()
		totalReserveJS()
		incomeChartJs()
	})


/// EVENTS
	$('#loadIncomeBtn').on('click', function(){

			incomeChartJs()

	})


	$('#frz_Ufrz').on('click', function(){
			var irrCheck= $('#irr_frz_check').is(':checked') ? 0 : 1;
			var btcCheck= $('#btc_frz_check').is(':checked') ? 0 : 1;
			var ethCheck= $('#eth_frz_check').is(':checked') ? 0 : 1;
			var bchCheck= $('#bch_frz_check').is(':checked') ? 0 : 1;
			var ltcCheck= $('#ltc_frz_check').is(':checked') ? 0 : 1;

			$.ajax({
					type:'POST',
					url:"admin/freezCoin",
					data: "btcFreez="+btcCheck +"&ethFreez="+ethCheck+"&bchFreez="+ bchCheck + "&ltcFreez="+ ltcCheck +"&irrFreez="+irrCheck,
					success: function(res){
						alert('freezing executed')

					// return data;
					}
			})

		})
		

	$('#addFund').on('click', function(){
			mmFundingJS('add')
		})

	$('#removeFund').on('click', function(){
			mmFundingJS('remove')
		})
// FUNCTIONS
	function loadFreezData(){

			$.ajax({
					type:'GET',
					url:"admin/getFreezed",
					
					success: function(res){
						arr= JSON.parse(res)

					arr['IRR']=='0'? $('#irr_frz_check').prop('checked',true) : $('#irr_frz_check').prop('checked',false);
					arr['BTC']=='0'? $('#btc_frz_check').prop('checked',true) : $('#btc_frz_check').prop('checked',false);
					arr['ETH']=='0'? $('#eth_frz_check').prop('checked',true) : $('#eth_frz_check').prop('checked',false);
					arr['BCH']=='0'? $('#bch_frz_check').prop('checked',true) : $('#bch_frz_check').prop('checked',false);
					arr['LTC']=='0'? $('#ltc_frz_check').prop('checked',true) : $('#ltc_frz_check').prop('checked',false);	
					// return data;
					}
			})
	}

	function mmFundingJS(fundType){
			var mm= $('#mmSelect option:selected').index();
			var mmCurr= $('#mmCurrency option:selected').index();
			var mmFund=$('#mmFund').val();
		
			$.ajax({
					type:'POST',
					url:"admin/mmFunding",
					data: "mm="+mm +"&currency="+mmCurr + "&amount="+ mmFund +"&fundType="+fundType,
					success: function(res){
						alert(res)

					// return data;
					}
			})
	}

	function mmLoadFoundJS(){

		$.ajax({
					type:'GET',
					url:"admin/mmLoadeFund",
					success: function(res){

						res=JSON.parse(res)
						$("#mm1_irr").html(moneyFormat(1*res['100']['IRR'],2));
						$("#mm1_btc").html(moneyFormat(1*res['100']['BTC'],6));
						$("#mm1_eth").html(moneyFormat(1*res['100']['ETH'],6));
						$("#mm1_bch").html(moneyFormat(1*res['100']['BCH'],6));
						$("#mm1_ltc").html(moneyFormat(1*res['100']['LTC'],6));

						$("#mm2_irr").html(moneyFormat(1*res['101']['IRR'],2));
						$("#mm2_btc").html(moneyFormat(1*res['101']['BTC'],6));
						$("#mm2_eth").html(moneyFormat(1*res['101']['ETH'],6));
						$("#mm2_bch").html(moneyFormat(1*res['100']['BCH'],6));						
						$("#mm2_ltc").html(moneyFormat(1*res['101']['LTC'],6));

					// return data;
					}
			})			
	}

	function netReserveJS(){
		$.ajax({
					type:'GET',
					url:"admin/netReserve",
					success: function(res1){

					//	alert(res1);
						res1=JSON.parse(res1)
						$("#net_irr").html(moneyFormat(1*res1['IRR'],2));
						$("#net_btc").html(moneyFormat(1*res1['BTC'],6));
						$("#net_eth").html(moneyFormat(1*res1['ETH'],6));
						$("#net_bch").html(moneyFormat(1*res1['BCH'],6));						
						$("#net_ltc").html(moneyFormat(1*res1['LTC'],6));

					
					}
			})	
	}

	function totalReserveJS(){
		$.ajax({
					type:'GET',
					url:"admin/totalReserve",
					success: function(res2){
					//	alert(res2);
						res2=JSON.parse(res2)
						$("#total_irr").html(moneyFormat(1*res2['IRR'],2));
						$("#total_btc").html(moneyFormat(1*res2['BTC'],6));
						$("#total_eth").html(moneyFormat(1*res2['ETH'],6));
						$("#total_bch").html(moneyFormat(1*res2['BCH'],6));
						$("#total_ltc").html(moneyFormat(1*res2['LTC'],6));

					// return data;
					}
			})	
	}

	function incomeChartJs(){

		$.ajax({
					type:'POST',
					url:"admin/incomeChartData",
					data: "curr="+ $("#incomeCurr option:selected").index() + "&timeItrvl="+ $("#incomeCurr option:selected").index(),
					success: function(chartdata){
					//alert(chartdata)
			console.log($.parseJSON(chartdata))

					//******** Generate Chart**///

						google.charts.load('current', {'packages':['corechart']});
						google.charts.setOnLoadCallback(drawChart);
						function drawChart() {
						var data = google.visualization.arrayToDataTable($.parseJSON(chartdata),false);
						var options = {
					
							legend:'none',
	 						vAxis: {format: 'short', viewWindowMod: 'pretty', textStyle: {color: 'white'}},
	 						hAxis: {format: 'short', minValue:  0,  gridlines:{ color: '#333', count: 4}, textStyle: {color: 'white'}},
							backgroundColor:{
								strokeWidth:2 ,
								fill:'rgb(10, 40, 70)'
							},
							colors:['rgb(90, 110, 230)'],
							chartArea:{backgroundColor:'rgb(10, 40, 70)', left:'10%',top:'5%',width:'85%',height:'85%'},
							crosshair: { trigger: 'both', color: '#3bc', opacity: 0.5 },
							explorer:{ actions: ['dragToZoom', 'rightClickToReset'], axis: 'horizontal', keepInBounds: true, maxZoomIn: 4.0},
	          
							};

					
							var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
						

						chart.draw(data, options);
						}
					}
			})

	}

/*
function loadPriceChart(){
			$("#chartPreloader").show();
			timeInterval=$("#timePeriod").val();
			chartType=$("#chart_type").val();


		$.ajax({			
			url: 'deals/priceChart',
			type:'post',
			data: "pair="+$('#pair').val() + "&timeInterval="+timeInterval + "&chartType=" + chartType,

			success: function(result){
			



				}
			});

$(document).ajaxComplete(function(){
    $("#chartPreloader").hide();
});

}*/
</script>