			var gauges = [];
			
			function createGauge25(name, label, min, max)
			{
				var config = 
				{
					size: 200,
					label: label,
					min: undefined != min ? min : 0,
					max: undefined != max ? max : 500,
					minorTicks: 10
				}
				
				var range = config.max - config.min;
				config.blueZones = [{ from: 0, to: 12 }];
				config.greenZones = [{ from: 13, to: 25 }];
				config.yellowZones = [{ from: 26, to: 37 }];
				config.orangeZones = [{ from: 38, to: 75 }];
				config.redZones = [{ from: 76, to: 500 }];
				

				
				gauges[name] = new Gauge(name + "GaugeContainer", config);
				gauges[name].render();
			}
			
			function createUSGauge25(name, label, min, max)
			{
				var config = 
				{
					size: 200,
					label: label,
					min: undefined != min ? min : 0,
					max: undefined != max ? max : 500,
					minorTicks: 10
				}
				
				var range = config.max - config.min;
				config.greenZones = [{ from: 0, to: 12 }];
				config.yellowZones = [{ from: 13, to: 35 }];
				config.orangeZones = [{ from: 35, to: 55 }];
				config.redZones = [{ from: 56, to: 150 }];
				config.purpleZones = [{ from: 151, to: 250 }];
				config.bloodZones = [{ from: 251, to: 500 }];

				gauges[name] = new Gauge(name + "GaugeContainer", config);
				gauges[name].render();
			}
			
			function createGauge10(name, label, min, max)
			{
				var config = 
				{
					size: 300,
					label: label,
					min: undefined != min ? min : 0,
					max: undefined != max ? max : 500,
					minorTicks: 10
				}
				
				var range = config.max - config.min;
				config.blueZones = [{ from: 0, to: 25 }];
				config.greenZones = [{ from: 26, to: 50 }];
				config.yellowZones = [{ from: 51, to: 100 }];
				config.orangeZones = [{ from: 101, to: 200 }];
				config.redZones = [{ from: 201, to: 500 }];
				
				gauges[name] = new Gauge(name + "GaugeContainer", config);
				gauges[name].render();
			}
			
			function createUSGauge10(name, label, min, max)
			{
				var config = 
				{
					size: 300,
					label: label,
					min: undefined != min ? min : 0,
					max: undefined != max ? max : 500,
					minorTicks: 10
				}
				
				var range = config.max - config.min;
				config.greenZones = [{ from: 0, to: 50 }];
				config.yellowZones = [{ from: 51, to: 100 }];
				config.orangeZones = [{ from: 100, to: 150 }];
				config.redZones = [{ from: 150, to: 200 }];
				config.purpleZones = [{ from: 200, to: 300 }];
				config.bloodZones = [{ from: 300, to: 500 }];
				
				gauges[name] = new Gauge(name + "GaugeContainer", config);
				gauges[name].render();
			}
			
			function createGauges25()
			{
				createGauge25("PMRealtimeAQI25", "PM2.5");
			}
			
			function createGauges10()
			{
				createGauge10("PMRealtimeAQI10", "PM10");
			}
			
			
			/*-----------*/
			function calculateGauges25()
			{
				createGauge25("CalculateAQI25", "PM2.5");
			}
			
			function calculateGauges10()
			{
				createGauge10("CalculateAQI10", "PM10");
			}
			
			function calculateUSGauges25()
			{
				createUSGauge25("CalculateUSAQI25", "PM2.5");
			}
			
			function calculateUSGauges10()
			{
				createUSGauge10("CalculateUSAQI10", "PM10");
			}
			
			
			
			function getRandomValue(gauge)
			{
				var overflow = 0; //10;
				return gauge.config.min - overflow + (gauge.config.max - gauge.config.min + overflow*2) *  Math.random();
			}
			