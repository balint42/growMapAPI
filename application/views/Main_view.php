<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>growMap</title>

    <!-- google font -->
    <link href='http://fonts.googleapis.com/css?family=Gochi+Hand' rel='stylesheet' type='text/css'>
    <!-- jquery -->
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    <!-- map related stuff -->
    <link rel="stylesheet" type="text/css" href="/growmap/js/leaflet/leaflet.css" />
    <script type="text/javascript" src="/growmap/js/leaflet/leaflet.js"></script>
    <script type="text/javascript" src="http://maps.stamen.com/js/tile.stamen.js?v1.3.0"></script>
    <script type="text/javascript" src="/growmap/js/heatmapjs/build/heatmap.min.js"></script>
    <script type="text/javascript" src="/growmap/js/heatmapjs/plugins/leaflet-heatmap.js"></script>
    <link rel="stylesheet" type="text/css" href="/growmap/js/markercluster/MarkerCluster.css" />
    <link rel="stylesheet" type="text/css" href="/growmap/js/markercluster/MarkerCluster.Default.css" />
    <script type="text/javascript" src="/growmap/js/markercluster/leaflet.markercluster.js"></script>
    <!-- core -->
    <link rel="stylesheet" type="text/css" href="/growmap/css/misc.css">
    <link rel="stylesheet" type="text/css" href="/growmap/css/growmap.css">
    <script type="text/javascript" src="/growmap/js/growmap.js"></script>


    <script type="text/javascript">
        // on body load
        var onLoad = function() {
            var container = $('div#container')[0];
            growMap.apiUrl = '/growmap/index.php/main/';
            growMap.baseUrl = '/growmap/';
            growMap.extendedAPI = true;
            growMap.init(container);
        }
        window.addEventListener('load', onLoad);
    </script>
</head>
<body>
<div id="navbar">
    growMap | <p>powered by&#8199;</p><a href="http://growstuff.org/" target="_blank">GROWSTUFF</a>
    <p style="float:right">
        data provided by <a href="http://growstuff.org/" target="_blank">GROWSTUFF</a> under
        <a href="http://creativecommons.org/licenses/by-sa/3.0/" target="_blank">CC-BY-SA</a>
    </p>
</div>
<div id="center">
    <div id="container"></div>
</div>
</body>
</html>
