<?php
/**
 * Created by PhpStorm.
 * User: sande
 * Date: 5-8-2017
 * Time: 21:57
 */
include '../includes/navbar.php';
?>
<style>
    a {
        color: black;
    }
    a:hover{
        color:black;
    }
    .card-block{
        padding: 0; !important;
    }
    .table{
        margin-bottom: 0; !important;
    }
    h5{
        font-size: 20px;
    }
    .card-header{
        padding: 0.75em; !important;
    }


</style>

<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div id="accordion" role="tablist" aria-multiselectable="true">
                <div class="card">
                    <div class="card-header" role="tab" id="headingOne">
                        <h5 class="mb-0">
                            Message options
                        </h5>
                    </div>

                    <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
                        <div class="card-block">
                            <table class="table">
                                <tr>
                                    <td>
                                        <a href="#"><i class="fa fa-inbox"></i> Inbox</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#"><i class="fa fa-envelope"></i> Read</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#"><i class="fa fa-trash"></i> Trash</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    Messages
                </div>
                <div class="card-block">
                    <table class="table mx-auto" id="table">
                        <thead>
                        <tr>
                            <th>Number</th>
                            <th>Subject</th>
                            <th>Time added</th>
                        </tr>
                        </thead>
                </div>
                <?php
                    $id = $_SESSION['id'];
                    $messages = $database->getDataAsArray("SELECT * FROM messages WHERE userId = $id");
                    if(!$messages){
                        echo '<tr>
                                  
                                  <td colspan="3" style="text-align: center">No nothing to show at the moment</td>
                                  
                              </tr>';

                    }
                ?>
            </div>
        </div>
    </div>
</div>
