/*
var map = new google.maps.Map(document.getElementById("map"), {
	zoom: 7,
	center: new google.maps.LatLng(36,138),
	mapTypeId: google.maps.MapTypeId.ROADMAP
});
*/

/*
function getLatLng(place) {
	alert(place);
	var geocoder = new google.maps.Geocoder();
	geocoder.geocode({
		address: place,
		region: 'jp'
	}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			var bounds = new google.maps.LatLngBounds();
			for (var r in results) {
				if (results[r].geometry) {
					var latlng = results[r].geometry.location;
					//alert(' latlng: ' + latlng );
					bounds.extend(latlng);
					//alert(results[r].formatted_address);
					var address = results[r].formatted_address.replace(/^日本, /, '');
					new google.maps.InfoWindow({
						content: address + "<br>(Lat, Lng) = " + latlng.toString()
					}).open(map, new google.maps.Marker({
						position: latlng,
						map: map
					}));
				}
			}
			map.fitBounds(bounds);
		} else if (status == google.maps.GeocoderStatus.ERROR) {
			alert("サーバとの通信時に何らかのエラーが発生！");
		} else if (status == google.maps.GeocoderStatus.INVALID_REQUEST) {
			alert("リクエストに問題アリ！geocode()に渡すGeocoderRequestを確認せよ！！");
		} else if (status == google.maps.GeocoderStatus.OVER_QUERY_LIMIT) {
			alert("短時間にクエリを送りすぎ！落ち着いて！！");
		} else if (status == google.maps.GeocoderStatus.REQUEST_DENIED) {
			alert("このページではジオコーダの利用が許可されていない！・・・なぜ！？");
		} else if (status == google.maps.GeocoderStatus.UNKNOWN_ERROR) {
			alert("サーバ側でなんらかのトラブルが発生した模様。再挑戦されたし。");
		} else if (status == google.maps.GeocoderStatus.ZERO_RESULTS) {
			alert("見つかりません");
		} else {
			alert("えぇ～っと・・、バージョンアップ？");
		}
	});
}

*/