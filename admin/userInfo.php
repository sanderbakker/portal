<?php
/**
 * Created by PhpStorm.
 * User: sande
 * Date: 27-7-2017
 * Time: 21:53
 */
include '../includes/navbar.php';
include_once '../includes/includeDatabase.php';
include '../includes/includes.php';
include "../includes/adminCheck.php";

function getCoordinates($address){

    $address = str_replace(" ", "+", $address); // replace all the white space with "+" sign to match with google search pattern

    $url = "http://maps.google.com/maps/api/geocode/json?sensor=false&address=$address";

    $response = file_get_contents($url);

    $json = json_decode($response,TRUE); //generate array object from the response from the web

    return $json;

}
$id = $_GET['id'];
$userInfo = $database->getData("SELECT * FROM user_info WHERE userId='$id'");
$userData = $database->getData("SELECT * FROM users WHERE id='$id'");
$address = $userData['address'];
$city = $userData['city'];
$lat = getCoordinates($address .  $city)['results'][0]['geometry']['location']['lat'];
$long = getCoordinates($address . $city)['results'][0]['geometry']['location']['lng'];


?>
<style>
    .card{
        margin-top: 15px;
    }

     #map {
         height: 280px;
         width: 100%;
     }
    .table > tbody > tr:first-child > td {
        border: none;
    }
    .table > tbody > tr:first-child > th {
        border: none;
    }
    .table{
        margin-top: 15px;
    }

</style>
<div class="container">
    <div class="card">
        <div class="card-header">
            Information
        </div>
        <div class="card-block">
            <div class="row">
                <div class="col-md-6">
                    <h3>Additional Information | <?php echo $userData['name']?></h3>
                    <table class="table">
                    <tr>
                        <th scope="row">Availability:</th>
                        <td><?php echo $userInfo['availability']?></td>
                    </tr>
                    <tr>
                        <th scope="row">Skills:</th>
                        <td><?php echo $userInfo['skills']?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Region:</th>
                        <td><?php echo $userInfo['region']?></td>
                    </tr>
                    <tr>
                        <th scope="row">Other:</th>
                        <td><?php echo $userInfo['other']?></td>
                    </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h3>Location</h3>
                    <div id="map"></div>
                    <script type="text/javascript">
                        var latitude = "<?php echo $lat ?>";
                        var longitude = "<?php echo $long ?>";
                        var address = "<?php echo $address ?>";
                        function initMap() {
                            var map = new google.maps.Map(document.getElementById('map'), {
                                zoom: 12,
                                center: new google.maps.LatLng(latitude, longitude)
                            });
                            var marker = new google.maps.Marker({
                                position: new google.maps.LatLng(latitude, longitude),
                                map: map

                            });
                            var contentString = '<div id="content">'+
                                '<div id="siteNotice">'+
                                '</div>'+
                                '<h5>'+ address+ '</h5>'+
                                '<div id="bodyContent">'+
                                '</div>'+
                                '</div>';

                            var infowindow = new google.maps.InfoWindow({
                                content: contentString
                            });
                            marker.addListener('click', function() {
                                infowindow.open(map, marker);
                            });
                        }

                    </script>
                    <script async defer
                            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB1VTyWHAkEkED0tTDRvXRzIxJsTAMitWk&callback=initMap">
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>