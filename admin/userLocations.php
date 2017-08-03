<?php
/**
 * Created by PhpStorm.
 * User: sande
 * Date: 1-8-2017
 * Time: 19:33
 */

include '../includes/navbar.php';
include '../includes/adminCheck.php';
include '../includes/includes.php';
function getCoordinates($address){

    $address = str_replace(" ", "+", $address); // replace all the white space with "+" sign to match with google search pattern

    $url = "http://maps.google.com/maps/api/geocode/json?sensor=false&address=$address";

    $response = file_get_contents($url);

    $json = json_decode($response,TRUE); //generate array object from the response from the web

    return $json;

}
$userAddresses = $database->getUsers("SELECT * FROM Users");

$address = array();
foreach($userAddresses as $user){
    $lat = getCoordinates($user['address'] .  $user['city'])['results'][0]['geometry']['location']['lat'];
    $long = getCoordinates($user['address'] .  $user['city'])['results'][0]['geometry']['location']['lng'];
    array_push($address, array( "long"=> $long,
                                "lat" => $lat,
                                "name" => $user['name'],
                                "address" => $user['address'],
                                "zipcode" => $user['zipcode'],
                                "surname" => $user['surname']));
}
$locations = array(
            "locations" => $address
);

$jsonLocations = json_encode($locations);


?>
<style>
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
    }
    #map {
        height: calc(100% - 58px);
        position: fixed;
    }
</style>

    <div id="map"></div>
    <script type="text/javascript">
        var address = JSON.parse('<?php echo $jsonLocations ?>');
        var latitude = '52.370216';
        var longitude = '4.895168';

        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 7,
                center: new google.maps.LatLng(latitude, longitude)
            });
            for(var i = 0; i < address.locations.length; i++){
                (function (i){
                    new google.maps.Marker({
                        position: new google.maps.LatLng(address.locations[i]['lat'], address.locations[i]['long']),
                        map: map
                    }).addListener('click', function(){
                        new google.maps.InfoWindow({
                            content: '<div id="content">'+
                            '<div id="siteNotice">'+
                            '</div>'+
                            '<h5>' + address.locations[i]['name'] + ' ' +  address.locations[i]['surname'] +  '</h5>'+
                            '<div id="bodyContent"><ul>'
                                +
                                '<li>Address: ' + address.locations[i]['address'] + '</li>'
                                +
                                '<li>Zipcode: ' + address.locations[i]['zipcode'] + '</li>'
                                +
                            '</ul></div>'+
                            '</div>'
                        }).open(map, this);
                    })
                })(i)
            }
        }

    </script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB1VTyWHAkEkED0tTDRvXRzIxJsTAMitWk&callback=initMap">
    </script>


