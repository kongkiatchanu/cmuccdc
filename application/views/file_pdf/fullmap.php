<?php
    header('Access-Control-Allow-Origin: *');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test-Map</title>
    <!-- <link rel="shortcut icon" type="image/x-icon" href="assets/image/<?= $icon_title ?>"> -->
    <link rel="stylesheet" href="assets/css/bootstrap-4.3.1/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fontawesome/css/all.min.css">
    <link rel='stylesheet' href='https://api.mapbox.com/mapbox-gl-js/v1.4.1/mapbox-gl.css'>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@0.70.0/dist/L.Control.Locate.min.css" />
    <link rel="stylesheet" href="assets/css/fullmap.min.css?v=<?= date('YmdHis'); ?>">
    <?php //include('report.php'); ?>
</head>

<body>
    
    <div id="us_map" class="fade_in_ture anime_delay05">
        <div class="leaflet-top leaflet-right">
            <div class="leaflet-control-layers leaflet-control custom-layout">
                <!-- <a class="leaflet-control-layers-toggle safety-button" data-toggle="tooltip" data-placement="left" title="Safety zone">
                    <img src="assets/image/safety_icon.png" alt="safety zone">
                </a> -->
            </div>
        </div>
    </div>
    
    <script src="assets/js/all/compress_all.min.js?v=<?= date('YmdHis'); ?>"></script>
    <script src="assets/js/fullmap/fullmap.js?v=<?= date('YmdHis'); ?>"></script>
</body>

</html>