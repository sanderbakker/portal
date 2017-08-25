<?php
/**
 * Created by PhpStorm.
 * User: sande
 * Date: 4-8-2017
 * Time: 10:57
 */
include '../includes/navbar.php';
include '../includes/includes.php';

if(isset($_GET['id']) && $_GET['id'] != ''){
    $id = mysqli_real_escape_string($database->getConnection(), $_GET['id']);
    $userId = mysqli_real_escape_string($database->getConnection(), $_SESSION['id']);
    if($_SESSION['role'] != 'admin'){
        $checkCustomerStatement = $database->getConnection()->prepare("SELECT * FROM assignments WHERE userId= ? AND customerId = ?");
        $checkCustomerStatement->bind_param('ii', $userId, $id);

        if(!$database->check($checkCustomerStatement)){
            header('location: ../404.php');
        }
    }
}
else{
    header('location: ../404.php');
}

function getCoordinates($address){

    $address = str_replace(" ", "+", $address); // replace all the white space with "+" sign to match with google search pattern

    $url = "https://maps.google.com/maps/api/geocode/json?sensor=false&address=$address";

    $response = file_get_contents($url);


    $json = json_decode($response,TRUE); //generate array object from the response from the web

    return $json;

}
$id = $_GET['id'];
$customerInfo = $database->getCustomer($id, 'id');

$statement = $database->getConnection()->prepare("SELECT count(id) assignments FROM assignments WHERE customerId = ?");
$statement->bind_param('i', $id);

$numberOfAssignments = $database->getData($statement);
$address = $customerInfo['address'];
$city = $customerInfo['city'];

if(isset(getCoordinates($address .  $city)['results'][0]['geometry']['location']['lat'])) {
    $lat = getCoordinates($address . $city)['results'][0]['geometry']['location']['lat'];
    $long = getCoordinates($address . $city)['results'][0]['geometry']['location']['lng'];
}
else{
    $lat = getCoordinates($address)['results'][0]['geometry']['location']['lat'];
    $long = getCoordinates($address)['results'][0]['geometry']['location']['lng'];
}

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
                    <h5>Customer Information | <?php echo $customerInfo['name'] . ' ' . $customerInfo['surname']  ?></h5>
                    <table class="table">
                        <tr>
                            <th scope="row">Address:</th>
                            <td><?php echo $customerInfo['address']?></td>
                        </tr>
                        <tr>
                            <th scope="row">Number of assignments:</th>
                            <td><?php echo $numberOfAssignments['assignments']?>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5>Location</h5>
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