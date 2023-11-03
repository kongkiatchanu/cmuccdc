		<?php $rsProfile = (array)$rsProfile;?>
		<?php 
		function report_typePM25R($val){
			if($val>0){
				if($val<=25){
					$txt = '0-25';
				}else if($val>25 && $val<=37){
					$txt = '26-37';
				}else if($val>37 && $val<=50){
					$txt = '28-50';
				}else if($val>50 && $val<=90){
					$txt = '51-90';
				}else if($val>90 && $val<=600){
					$txt = '>90';
				}else{
					$txt = '>90';
				}
			}else{
				$txt = '';
			}
			return $txt;
		}
		
		function report_typePM25RUS($val){
			if($val>0){
				if($val<=12){
					$txt = '0-12';
				}else if($val>13 && $val<=35){
					$txt = '13-35';
				}else if($val>36 && $val<=55){
					$txt = '36-55';
				}else if($val>56 && $val<=150){
					$txt = '56-150';
				}else if($val>151 && $val<=250){
					$txt = '151-250';
				}else if($val>250){
					$txt = '>250';
				}
			}else{
				$txt = '';
			}
			return $txt;
		}
		
		?>
		<style>
			.db_profile{background-color: #f9f6f6;}
			.db_profile .nav-tabs{border:none;}
			.db_profile .nav-tabs .nav-link.active{border-color: #fff;border-radius: 0;color:#99bf3d}
			.db_profile .nav-tabs .nav-link{color:#333}
			#myTabContent {background-color: #fff;}
			#th_map{height:300px;width:100%}
			.sub-section{border-bottom: 2px solid #99bf3d;padding-bottom: 10px;}
			#airDetail .forus{color:rgb(<?=$rsProfile['value']->us_color?>);}
			#airDetail .forth{margin: 30px 0 0 0;color:rgb(<?=$rsProfile['value']->th_color?>);}
			#airDetail .number{margin: 30px 0 0 0;}
			#airDetail .number div#pm{font-size: 50px;border-radius: 50%;border: 3px solid;padding: 7px 7px;width:110px; margin:0 auto;}
			#airDetail .number div#pm span{display: block;font-size: x-small;}
			#airDetail .number div#detail p{margin:0;}
			#airDetail .number div#detail p.des{margin:0 0 10px 0;font-size:20px;}
			#airDetail .number div#detail p.unit{color:#666;font-size:small}
			#airDetail .number div#detail span.timer{color:#666;font-size:small;display: block;}
			.table td, .table th {padding:3px;}
			.chart-title{font-size:16px;}
			h3.aqi-title{text-shadow: 2px 2px #C5C5C5;}
			@media (max-width: 575.98px) {
				#th_map{height:250px;width:100%}
				#airDetail .number {margin: 20px 0 0 0;}
				#airDetail .number div#detail{text-align: center;}
				#airDetail .number div#detail span.timer{display: unset;}
				h3.aqi-title{text-shadow: 2px 2px #C5C5C5;font-size:20px;}
			}
		</style>
		
		<div class="db_profile">
		<input type="hidden" id="db_lat" value="<?=$rsProfile['dustboy_lat']?>">
		<input type="hidden" id="db_lng" value="<?=$rsProfile['dustboy_lng']?>">
		<input type="hidden" id="db_name" value="<?=$rsProfile['dustboy_name_th']?>">
		</div>
		
		
		