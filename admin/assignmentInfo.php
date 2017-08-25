<?php
/**
 * Created by PhpStorm.
 * User: sande
 * Date: 6-8-2017
 * Time: 15:45
 */
include '../includes/navbar.php';
include '../includes/includes.php';



if(isset($_GET['id']) && $_GET['id'] != ''){
    $id = mysqli_real_escape_string($database->getConnection(), $_GET['id']);
    $userId = mysqli_real_escape_string($database->getConnection(), $_SESSION['id']);
    $assignment = $database->getAssignment($id, 'id');

    $customerId = $assignment['customerId'];
    $customerInfo = $database->getCustomer($customerId, "id");
    if($_SESSION['role'] != 'admin'){
        $checkAssignment = $database->getConnection()->prepare('SELECT * FROM assignments WHERE userId = ? AND customerId = ? AND completed = 0 AND closed = 0');
        $checkAssignment->bind_param('ii', $userId, $customerId);

        if(!$database->check($checkAssignment)){
            header('location: ../404.php');
        }
    }
}
else{
    $assignment = null;
    header('location: ../404.php');
}

function getCoordinates($address){

    $address = str_replace(" ", "+", $address); // replace all the white space with "+" sign to match with google search pattern

    $url = "https://maps.google.com/maps/api/geocode/json?sensor=false&address=$address";

    $response = file_get_contents($url);


    $json = json_decode($response,TRUE); //generate array object from the response from the web

    return $json;

}
$stateId = $assignment['stateId'];
$state = $database->getState($stateId, 'id');

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
                    <h5>Assignment Information | <?php echo $assignment['description']?></h5>
                    <table class="table">
                        <tr>
                            <th scope="row">Customer:</th>
                            <td><?php echo $customerInfo['name'] . ' ' . $customerInfo['surname']?></td>
                        </tr>
                        <tr>
                            <th scope="row">Address:</th>
                            <td><?php echo $customerInfo['address']; ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Description:</th>
                            <td><?php echo $assignment['description']; ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">State:</th>
                            <td><?php echo $state['name']?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Added at:</th>
                            <td><?php echo $assignment['time_added'];?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Actions:</th>
                            <td>
                                <?php
                                $stateCode = $state['code'];
                                if($stateCode == '120'){
                                    $salary = "<a title='Register hours' href='#' class='btn btn-sm btn-success'><i class='fa fa-money'></i></a>";
                                    $close = "<a  title='Close assignment'  href='../user/closeAssignment.php?id=$id' class='btn btn-sm btn-danger'><i class='fa fa-times'></i></a>";
                                    $update = "<a title='Update assignment' href='#' class='btn btn-sm btn-info'><i class='fa fa-refresh'></i></a>";
                                }
                                elseif ($stateCode == '300'){
                                    $salary = '';
                                    $close = '';
                                    $update = '';
                                }
                                else{
                                    $close = "<a  title='Close assignment'  href='../user/closeAssignment.php?id=$id' class='btn btn-sm btn-danger'><i class='fa fa-times'></i></a>";
                                    $salary = '';
                                    $update =  "<a title='Update assignment' href='#' class='btn btn-sm btn-info'><i class='fa fa-refresh'></i></a>";
                                }
                                if($update == '' && $close == '' && $salary == ''){
                                    echo "No actions to execute, assignment is pending for closure or already closed";
                                }
                                else{
                                    echo "
                                        $update
                                        $salary
                                        $close";
                                }
                                ?>
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