var osmUrl = "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
    osmAttrib = 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors',
    opacity = 1,
    OpenStreetMap = new L.tileLayer(osmUrl, {
        maxZoom: 18,
        attribution: osmAttrib,
        opacity: opacity
    }),
    Topographic = new L.esri.basemapLayer("Topographic", {
        opacity: opacity
    }),
    Streets = new L.esri.basemapLayer("Streets", {
        opacity: opacity
    }),
    NationalGeographic = new L.esri.basemapLayer("NationalGeographic", {
        opacity: opacity
    }),
    Oceans = new L.esri.basemapLayer("Oceans", {
        opacity: opacity
    }),
    Gray = new L.esri.basemapLayer("Gray", {
        opacity: opacity
    }),
    DarkGray = new L.esri.basemapLayer("DarkGray"),
    Imagery = new L.esri.basemapLayer("Imagery"),
    ShadedRelief = new L.esri.basemapLayer("ShadedRelief", {
        opacity: opacity
    }),
    startTimeGFS = new Date(Date.UTC(GFS_server_year, GFS_server_month - 1, GFS_server_day, GFS_server_hour)),
    actualTimeGFS = new Date(Date.UTC(GFS_server_year, GFS_server_month - 1, GFS_server_day, GFS_server_hour + 6)),
    endTimeGFS = new Date(Date.UTC(GFS_server_year, GFS_server_month - 1, GFS_server_day, GFS_server_hour + (GFS_timesteps - 1) * GFS_interval)),
    dataTimeIntervalGFS = startTimeGFS.toISOString() + "/" + endTimeGFS.toISOString(),
    actualIntervalGFS = 2 * GFS_interval,
    baseIndexGFS = 1,
    dataPeriodGFS = "PT" + actualIntervalGFS + "H",
    wind10mBaseURL = "/weather/wind10m/",
    wind10mBaseName = "wind10m_{h}h",
    wind10mName = "",
    wind10mArray = [],
    startTimeRTOFS = new Date(Date.UTC(RTOFS_server_year, RTOFS_server_month - 1, RTOFS_server_day, RTOFS_server_hour)),
    actualTimeRTOFS = new Date(Date.UTC(RTOFS_server_year, RTOFS_server_month - 1, RTOFS_server_day, RTOFS_server_hour + 6)),
    endTimeRTOFS = new Date(Date.UTC(RTOFS_server_year, RTOFS_server_month - 1, RTOFS_server_day, RTOFS_server_hour + (RTOFS_timesteps - 1) * RTOFS_interval)),
    dataTimeIntervalRTOFS = startTimeRTOFS.toISOString() + "/" + endTimeRTOFS.toISOString(),
    actualIntervalRTOFS = 2 * RTOFS_interval,
    baseIndexRTOFS = 1,
    dataPeriodRTOFS = "PT" + actualIntervalRTOFS + "H",
    seaSurfaceCurrentBaseURL = "weather/sea_surface_current/",
    seaSurfaceCurrentBaseName = "sea_surface_current_{h}h",
    seaSurfaceCurrentName = "",
    seaSurfaceCurrentArray = [];
let actualModel, startTime, actualTime, endTime, dataTimeInterval, actualInterval, baseIndex, dataPeriod, actualLayerBaseURL, actualLayerBaseName, angleConventionValue, speedUnitValue, colorScale, initDisplayValues, initVelocityType, initEmptyString, initAngleConvention, initSpeedUnit, initMinVelocity, initMaxVelocity, initVelocityScale, initParticleAge, initLineWidth, initParticleMultiplier, initFrameRate, initColorScale, actualLayer = "Wind",
    actualLayerName = "",
    actualLayerArray = [],
    parameter = "wind10m",
    displayValues = document.getElementById("displayValues");
displayValues.addEventListener("change", function() {
    updateLayer(actualLayerArray[actualTimeIndex])
}), switchParameter(actualLayer);
var map = new L.map("us_map", {
        center: [13.912, 100.5270061],
        zoom: 5,
        attributionControl: !1,
        maxZoom: 14,
        minZoom: 5,
        layers: [OpenStreetMap],
        timeDimension: !0,
        timeDimensionOptions: {
            timeInterval: dataTimeInterval,
            period: dataPeriod,
            currentTime: actualTime
        },
        timeDimensionControl: !1,
        timeDimensionControlOptions: {
            loopButton: !1,
            speedStep: .1,
            minSpeed: .2,
            maxSpeed: .3,
            limitSliders: !1,
            limitMinimumRange: 24 / GFS_interval,
            playButton: !1,
            speedSlider: !1
        }
    }),
    lc = L.control.locate({
        position: "topleft",
        strings: {
            title: "Show My Location"
        }
    }).addTo(map),
    baseMaps = {
        OpenStreetMap: OpenStreetMap,
        Topographic: Topographic,
        Streets: Streets,
        NationalGeographic: NationalGeographic,
        "<span style='color: gray'>Gray</span>": Gray,
        DarkGray: DarkGray,
        Imagery: Imagery,
        ShadedRelief: ShadedRelief,
        Oceans: Oceans
    },
    layerControl = new L.control.layers(baseMaps);
layerControl.addTo(map);
var actualLayerGroup = new L.layerGroup([], {});
actualLayerArray.length = map.timeDimension._availableTimes.length;
var actualTimeIndex = map.timeDimension._currentTimeIndex;

function initializeLayer(e) {
    actualLayerGroup.clearLayers(), actualLayerName = actualLayerBaseName.replace(/{h}/g, (actualTimeIndex - baseIndex) * actualInterval), actualLayerName = "wind10m_0h", document.getElementById("displayValues").checked = initDisplayValues, $.getJSON(actualLayerBaseURL + actualLayerName + ".json", function(e) {
        this[actualLayerName] = L.velocityLayer({
            displayValues: document.getElementById("displayValues").checked,
            displayOptions: {
                velocityType: "Wind",
                emptyString: "No wind data",
                angleConvention: "meteoCW",
                speedUnit: "km/h"
            },
            data: e,
            minVelocity: parseFloat(0),
            maxVelocity: parseFloat(30),
            velocityScale: parseFloat(.001),
            particleAge: parseInt(90),
            lineWidth: parseInt(1),
            particleMultiplier: parseFloat(.0033),
            frameRate: parseInt(15)
        }), actualLayerGroup.addLayer(this[actualLayerName]), actualLayerArray[actualTimeIndex] = actualLayerGroup.getLayer(actualLayerGroup.getLayerId(this[actualLayerName])), actualLayerGroup.addTo(map)
    })
}

function updateLayer(e) {
    map.timeDimension.options.timeInterval = dataTimeInterval, map.timeDimension.options.period = dataPeriod, map.timeDimension.options.currentTime = actualTime, actualLayerGroup.clearLayers(), actualLayerName = actualLayerBaseName.replace(/{h}/g, (actualTimeIndex - baseIndex) * actualInterval), actualLayerName = "wind10m_0h", $.getJSON(actualLayerBaseURL + actualLayerName + ".json", function(e) {
        this[actualLayerName] = L.velocityLayer({
            displayValues: document.getElementById("displayValues").checked,
            displayOptions: {
                velocityType: "Wind",
                emptyString: "No wind data",
                angleConvention: "meteoCW",
                speedUnit: "km/h"
            },
            data: e,
            minVelocity: parseFloat(0),
            maxVelocity: parseFloat(30),
            velocityScale: parseFloat(.001),
            particleAge: parseInt(90),
            lineWidth: parseInt(1),
            particleMultiplier: parseFloat(.0033),
            frameRate: parseInt(15)
        }), actualLayerGroup.addLayer(this[actualLayerName]), actualLayerArray[actualTimeIndex] = actualLayerGroup.getLayer(actualLayerGroup.getLayerId(this[actualLayerName])), actualLayerGroup.addTo(map)
    })
}

function switchParameter(e) {
    switch (e) {
        case "Wind":
            actualModel = "GFS", actualLayerBaseURL = wind10mBaseURL, actualLayerBaseName = wind10mBaseName, initDisplayValues = !0, initVelocityType = "Wind", initEmptyString = "No wind data", initAngleConvention = "bearingCW", initSpeedUnit = "Bft", initMinVelocity = 0, initMaxVelocity = 30, initVelocityScale = .001, initParticleAge = 90, initLineWidth = 1, initParticleMultiplier = .0033, initFrameRate = 15, initColorScale = ["#2468b4", "#3c9dc2", "#80cdc1", "#97daa8", "#c6e7b5", "#eef7d9", "#ffee9f", "#fcd97d", "#ffb664", "#fc964b", "#fa7034", "#f54020", "#ed2d1c", "#dc1820", "#b40023"]
    }
}
layerControl.addOverlay(actualLayerGroup, actualLayer), initializeLayer(actualLayerArray[actualTimeIndex]), window.setInterval(function() {
    actualTimeIndex != map.timeDimension._currentTimeIndex && (actualTimeIndex = map.timeDimension._currentTimeIndex, updateLayer(actualLayerArray[actualTimeIndex]))
}, 100);