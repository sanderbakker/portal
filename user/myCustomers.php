<?php
/**
 * Created by PhpStorm.
 * User: sande
 * Date: 10-8-2017
 * Time: 11:15
 */
include '../includes/navbar.php';
?>
<style>
    .container {
        margin-top: 15px;
    }
    .row{
        margin-top: 15px;
    }
</style>
<div class="container">
    <h3>My Customers</h3>
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
    </div>

    <table class="table mx-auto" id="'table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Surname</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Company</th>
            <th>More</th>

        </tr>
        </thead>
        <tbody>
        <?php

        $page_max = 7;
        $entriesInDatabase = $database->getData("SELECT count(id) FROM customers WHERE id = (SELECT customerId FROM assignments WHERE userId = $id) ");
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

        $customers = $database->getDataAsArray("SELECT * FROM customers WHERE id = (SELECT customerId FROM assignments WHERE userId = $id) LIMIT $start, $numberOfRecords");

        foreach($customers as $customer){
            $name = $customer ['name'];
            $surname = $customer['surname'];
            $email = $customer['email'];
            $phone = $customer['phone'];
            $company = $customer['company'];
            $id = $customer['id'];
            echo "<tr>
                    <td>$name</td>
                    <td>$surname</td>
                    <td>$email</td>
                    <td>$phone</td>
                    <td>$company</td>
                    <td><a href='customerInfo.php?id=$id' class='btn btn-sm btn-info'><i class='fa fa-info'></i></a></td>
                  

                    
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

</div>
