			var gauges = [];
			
			function createGauge25(name, label, min, max)
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
				config.blueZones = [{ from: 0, to: 50 }];
				config.greenZones = [{ from: 51, to: 100 }];
				config.yellowZones = [{ from: 101, to: 200 }];
				config.orangeZones = [{ from: 201, to: 300 }];
				config.redZones = [{ from: 301, to: 500 }];
				

				
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
				config.blueZones = [{ from: 0, to: 50 }];
				config.greenZones = [{ from: 51, to: 100 }];
				config.yellowZones = [{ from: 101, to: 200 }];
				config.orangeZones = [{ from: 201, to: 300 }];
				config.redZones = [{ from: 301, to: 500 }];
				
				gauges[name] = new Gauge(name + "GaugeContainer", config);
				gauges[name].render();
			}
			
			function createGauges25()
			{
				createGauge25("PMRealtimeAQI25", "PM2.5 AQI");
			}
			
			function createGauges10()
			{
				createGauge10("PMRealtimeAQI10", "PM10 AQI");
			}
	
			function getRandomValue(gauge)
			{
				var overflow = 0; //10;
				return gauge.config.min - overflow + (gauge.config.max - gauge.config.min + overflow*2) *  Math.random();
			}
			