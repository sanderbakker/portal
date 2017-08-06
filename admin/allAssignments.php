<?php
/**
 * Created by PhpStorm.
 * User: sande
 * Date: 6-8-2017
 * Time: 15:38
 */
include '../includes/navbar.php';
include '../includes/adminCheck.php';?>
<style>
    .container{
        margin-top: 15px;
    }

    a {
        color: black;
    }

</style>
<div class="container mx-auto">
    <!--Add class table-responsive for responsive table -->
    <div class="row">
        <div class="col-md-6">
            <form method="post">
                <div class="input-group">
                    <input size='14' type="text" class="form-control" placeholder="Search for..." name="searchValue">
                    <span class="input-group-btn">
                    <button class="btn btn-secondary" name='search' type="submit"><i class="fa fa-search"></i></button>
                </span>
                </div>
            </form>
        </div>
        <div class="col-md-6">
            <div class="dropdown">
                <button class="btn btn-sm btn-secondary dropdown-toggle pull-right" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Filters
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="?filter=completed">Completed</a>
                    <a class="dropdown-item" href="?filter=closed">Closed</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="?filter=none">Remove filter</a>
                </div>
            </div>
        </div>
    </div>


    <table class="table mx-auto" id="'table">
        <thead>
        <tr>
            <th>Number</th>
            <th>Description</th>
            <th>Added At</th>
            <th>State</th>
            <th>Completed</th>
            <th>Closed</th>
            <th>More</th>

        </tr>
        </thead>
        <tbody>
        <?php

        $page_max = 7;
        $entriesInDatabase = $database->getData("SELECT count(id) FROM assignments");
        $numberOfPages = ceil($entriesInDatabase['count(id)']/$page_max);
        $numberOfRecords = $page_max;
        if(isset($_GET['page'])) {
            $page = $_GET['page'];
            $start = $page * $page_max;
        }
        else{
            $page = 0;
            $start = $page * $page_max;

        }
//        if(isset($_GET['filter'])) {
//            $filter = $_GET['filter'];
//            if($filter === 'completed') {
//                $assignments = $database->getDataAsArray("SELECT * FROM assignments WHERE completed = true LIMIT $start, $numberOfRecords");
//            }
//            elseif($filter === 'closed'){
//                $assignments = $database->getDataAsArray("SELECT * FROM assignments WHERE closed = true LIMIT $start, $numberOfRecords");
//            }
//            else{
//                $assignments = $database->getDataAsArray("SELECT * FROM assignments LIMIT $start, $numberOfRecords");
//            }
//        }
//        else{
            $assignments = $database->getDataAsArray("SELECT * FROM assignments LIMIT $start, $numberOfRecords");
//        }

        foreach($assignments as $assignment){
            $description = $assignment['description'];
            $timeAdded = $assignment['time_added'];
            $completed = $assignment['completed'];
            $stateId = $assignment['stateId'];
            $state= $database->getData("SELECT * FROM state WHERE id= $stateId", 'name');
            $closed = $assignment['closed'];
            $id = $assignment['id'];
            echo "<tr>
                    <td>$id</td>
                    <td>$description</td>
                    <td>$timeAdded</td>
                    <td>$state</td>
                    <td>$completed</td>
                    <td>$closed</td>
                    <td><a href='assignmentInfo.php?id=$id' class='btn btn-sm btn-info'><i class='fa fa-info'></i></a></td>
                
                  </tr>";
        }
        ?>
        </tbody>
    </table>
    <ul class="pagination">
        <?php

        if(isset($_GET['page']) && $_GET['page'] > 0){
            $previous = $_GET['page'] - 1;
            echo '<li class="page-item"><a class="page-link" href="?page='. $previous.'">Previous</a></li>';
        }


        for($i = 0; $i < $numberOfPages; $i++){
            echo '<li class="page-item"><a class="page-link" href="?page='. $i . '">'. $i. '</a></li>';
        }
        if(isset($_GET['page']) && $_GET['page'] < $numberOfPages - 1){
            $page = $_GET['page'];
            $next = $page + 1;
            echo '<li class="page-item"><a class="page-link" href="?page='.$next.'">Next</a></li> ';
        }
        elseif(!isset($_GET['page'])){
            echo '<li class="page-item"><a class="page-link" href="?page=1">Next</a></li> ';
        }
        ?>



    </ul>
</div>