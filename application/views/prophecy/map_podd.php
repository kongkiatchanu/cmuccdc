<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    include_once('assets/prophecy/pdf/Thaidate/Thaidate.php');
	include_once('assets/prophecy/pdf/Thaidate/thaidate-functions.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- <title><?=$siteInfo['pre_title']?> | <?=$siteInfo['site_title']?></title> -->
	<!-- <meta name="description" content="<?=$siteInfo['site_des']?>"> -->
	<!-- <meta name="keywords" content="<?=$siteInfo['site_keyword']?>"> -->
    <title>ค่าพยากรณ์ PM2.5 ล่วงหน้า | CCDC : Climate Change Data Center</title>    
    <link rel="shortcut icon" type="image/x-icon" href="<?=base_url()?>template/image/icon_ccdc.ico">
    <link rel="stylesheet" href="<?=base_url('assets/prophecy/assets/css/bootstrap-4.3.1/bootstrap.min.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/prophecy/assets/fontawesome/css/all.min.css');?>">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <link rel='stylesheet' href='https://api.mapbox.com/mapbox-gl-js/v1.4.1/mapbox-gl.css'>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@0.70.0/dist/L.Control.Locate.min.css" />
    <!-- <link rel="stylesheet" href="https://pasichnykvasyl.github.io/Leaflet.BigImage/src/Leaflet.BigImage.css"> -->
    <link rel="stylesheet" href="<?=base_url('assets/prophecy/assets/css/style_podd.min.css?v=').date('YmdHis');?>">
    <script src="<?=base_url()?>template/js/jquery/jquery.min.js"></script>
	<?php $this->load->view('main/analytics');?>
    <style>
        .easyPrintHolder .a3CssClass {
            background-image: url(data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTguMS4xLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDQ0NC44MzMgNDQ0LjgzMyIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNDQ0LjgzMyA0NDQuODMzOyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgd2lkdGg9IjUxMnB4IiBoZWlnaHQ9IjUxMnB4Ij4KPGc+Cgk8Zz4KCQk8cGF0aCBkPSJNNTUuMjUsNDQ0LjgzM2gzMzQuMzMzYzkuMzUsMCwxNy03LjY1LDE3LTE3VjEzOS4xMTdjMC00LjgxNy0xLjk4My05LjM1LTUuMzgzLTEyLjQ2N0wyNjkuNzMzLDQuNTMzICAgIEMyNjYuNjE3LDEuNywyNjIuMzY3LDAsMjU4LjExNywwSDU1LjI1Yy05LjM1LDAtMTcsNy42NS0xNywxN3Y0MTAuODMzQzM4LjI1LDQzNy4xODMsNDUuOSw0NDQuODMzLDU1LjI1LDQ0NC44MzN6ICAgICBNMzcyLjU4MywxNDYuNDgzdjAuODVIMjU2LjQxN3YtMTA4LjhMMzcyLjU4MywxNDYuNDgzeiBNNzIuMjUsMzRoMTUwLjE2N3YxMzAuMzMzYzAsOS4zNSw3LjY1LDE3LDE3LDE3aDEzMy4xNjd2MjI5LjVINzIuMjVWMzR6ICAgICIgZmlsbD0iIzAwMDAwMCIvPgoJPC9nPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+Cjwvc3ZnPgo=);
            transform: rotate(-90deg);
        }
    </style>
</head>

<body>
    <div id="map_podd" class="map" data-area='<?=$area?>'></div>
    <script src="<?=base_url('assets/prophecy/assets/js/all/compress.min.js?v=').date('YmdHis');?>"></script>
    <script src="<?=base_url('assets/prophecy/assets/js/map/leaflet-providers.js');?>"></script>
    <!-- <script src="<?=base_url('assets/prophecy/assets/js/map/html2canvas.min.js');?>"></script> -->
    <script src="<?=base_url('assets/prophecy/assets/js/map/Leaflet-easyPrint.js');?>"></script>
    <!-- <script src="https://pasichnykvasyl.github.io/Leaflet.BigImage/src/Leaflet.BigImage.js"></script> -->

    <script src="<?=base_url('assets/prophecy/assets/js/map_podd.js?v=').date('YmdHis');?>"></script>
</body>

</html>