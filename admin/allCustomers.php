<?php
/**
 * Created by PhpStorm.
 * User: sande
 * Date: 3-8-2017
 * Time: 21:02
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
                    <button class= "btn btn-secondary" name='search' type="submit"><i class="fa fa-search"></i></button>
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
        $pagination = new Pagination(7);

        $page_max = $pagination->getPageMax();



        $start = $pagination->getStart();
        $numberOfPages = $pagination->numberOfPages($database->getData("SELECT count(id) FROM customers"));
        $customers = $database->getDataAsArray("SELECT * FROM customers LIMIT $start, $page_max");


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

        echo $pagination->previous($numberOfPages);


        for($i = 0; $i < $numberOfPages; $i++){
            echo '<li class="page-item"><a class="page-link" href="?page='. $i . '">'. $i. '</a></li>';
        }

        echo $pagination->next($numberOfPages);
        ?>

    </ul>
</div>