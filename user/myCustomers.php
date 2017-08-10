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
        $pagination = new Pagination(7);

        $page_max = $pagination->getPageMax();

        $numberOfPages = $pagination->numberOfPages($database->getData("SELECT count(id) FROM customers WHERE id = (SELECT customerId FROM assignments WHERE userId = $id) "));

        $start = $pagination->getStart();

        $customers = $database->getDataAsArray("SELECT * FROM customers WHERE id = (SELECT customerId FROM assignments WHERE userId = $id) LIMIT $start, $page_max");

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
                    <td><a href='../admin/customerInfo.php?id=$id' class='btn btn-sm btn-info'><i class='fa fa-info'></i></a></td>
                  

                    
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
