function initDemoMap(){
	var Esri_landing = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');
	
    var Esri_WorldImagery = L.tileLayer('http://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, ' +
        'AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'
    });

    var Esri_DarkGreyCanvas = L.tileLayer(
        "http://{s}.sm.mapstack.stamen.com/" +
        "(toner-lite,$fff[difference],$fff[@23],$fff[hsl-saturation@20])/" +
        "{z}/{x}/{y}.png",
        {
            attribution: 'Tiles &copy; Esri &mdash; Esri, DeLorme, NAVTEQ, TomTom, Intermap, iPC, USGS, FAO, ' +
            'NPS, NRCAN, GeoBase, Kadaster NL, Ordnance Survey, Esri Japan, METI, Esri China (Hong Kong), and the GIS User Community'
        }
    );
	
    var baseLayers = {
        "Satellite": Esri_WorldImagery,
        "Landscape": Esri_landing,
        "Grey Canvas": Esri_DarkGreyCanvas
    };
	
    var map = L.map('us_map', {
        layers: [ Esri_WorldImagery ],
		attributionControl: false,
		maxZoom:14,minZoom:5
    });

	
    var layerControl = L.control.layers(baseLayers);
    layerControl.addTo(map);
    map.setView([13.9120, 100.5270061], 5);
	
	var lc = L.control.locate({
		position: 'topleft',
		strings: {
			title: "Show My Location"
		}
	}).addTo(map);
	
    return {
        map: map,
        layerControl: layerControl
    };
}

// demo map
var mapStuff = initDemoMap();
var map = mapStuff.map;
var layerControl = mapStuff.layerControl;
var handleError = function(err){
    console.log('handleError...');
    console.log(err);
};

var windJSLeaflet = new WindJSLeaflet.init({
	localMode: true,
	map: map,
	layerControl: layerControl,
	useNearest: false,
	timeISO: null,
	nearestDaysLimit: 7,
	displayValues: false,
	displayOptions: {
		displayPosition: 'bottomleft',
		displayEmptyString: 'No wind data'
	},
	overlayName: 'wind',
	pingUrl: 'http://localhost:7000/alive',        // url to check service availability
	latestUrl: 'http://localhost:7000/latest',     // url to get latest data with no required params   
	nearestUrl: 'http://localhost:7000/nearest',
	errorCallback: handleError
});