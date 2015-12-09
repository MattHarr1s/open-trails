<!DOCTYPE html>
<html>
	<head>
		<style>
			#map2 {
				width: 500px;
				height: 400px;
			}
		</style>
		<script src="https://maps.googleapis.com/maps/api/js?=trailquail-1152"></script>
		<script>
			function initialize() {
				var mapCanvas = document.getElementById('map2');
				var mapOptions = {
					center: new google.maps.LatLng(35.1318, -106.6200),
					zoom: 8,
					mapTypeId: google.maps.MapTypeId.TERRAIN
				};
				var map = new google.maps.Map(mapCanvas, mapOptions);
			}
			google.maps.event.addDomListener(window, 'load', initialize);
		</script>
	</head>
	<body>
		<div id="map2"></div>
	</body>
</html>

<!--  https://www.google.com/maps/@35.1318005,-106.5924864,9.92z-->

