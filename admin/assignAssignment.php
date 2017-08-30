<?php
/**
 * Created by PhpStorm.
 * User: sande
 * Date: 30-8-2017
 * Time: 11:05
 */
include '../includes/navbar.php';
include '../includes/adminCheck.php';

if(isset($_GET['id'])){
    $id = $_GET['id'];
}
else{
    header('location: ../404.php');
}

function calculateDistance($from, $to){
    $from = urlencode($from);
    $to = urlencode($to);
    $data = file_get_contents("http://maps.googleapis.com/maps/api/distancematrix/json?origins=$from&destinations=$to&language=en-EN&sensor=false");
    $data = json_decode($data);
    $time = 0;
    $distance = 0;
    foreach($data->rows[0]->elements as $road) {
        $time += $road->duration->value;
        $distance += $road->distance->value;
    }
    $dataArray = array();
    $dataArray['distance'] = round($distance/1000,2);
    $dataArray['time'] = round($time/60, 2);
    return $dataArray;
}

$assignmentQuery = $database->getConnection()->prepare('SELECT * FROM assignments WHERE id =?');
$assignmentQuery->bind_param('i', $id);

$assignment = $database->getData($assignmentQuery);

$customerQuery = $database->getConnection()->prepare('SELECT * FROM customers WHERE id = ?');
$customerQuery->bind_param('i', $assignment['customerId']);

$customer = $database->getData($customerQuery);

$address = $customer['address'] . ', ' . $customer['city'];
//$address = 'sdfjalfld , Barendrecht';

$allUsers = $database->getConnection()->prepare('SELECT * FROM users WHERE approved = 1 AND (banned IS NULL OR banned = 0)');
$users = $database->getDataAsArray($allUsers);


$distanceArray = array();
foreach($users as $user){
    $userAddress = $user['address'] . ', ' . $user['city'];
    $distanceArray[$user['id']] = calculateDistance($userAddress, $address);
}

//Sorts distanceArray based on distance
foreach ($distanceArray as $key => $row) {
    $mid[$key]  = $row['distance'];
}
array_multisort($mid, SORT_ASC, $distanceArray);

print "<pre>";
print_r($distanceArray);
print "</pre>";
