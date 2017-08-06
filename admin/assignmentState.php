<?php
/**
 * Created by PhpStorm.
 * User: sande
 * Date: 4-8-2017
 * Time: 19:52
 */

include '../includes/navbar.php';
include '../includes/adminCheck.php';
include '../classes/AlertBuilder.php';

$alertBuilder = new AlertBuilder();
?>
<style>
    h3{
        font-family: 'Roboto', sans-serif;
        margin-top: 15px;
    }
    .card{
        margin-top: 15px; !important;
    }
    #addForm{
        float: right;
        margin-bottom: 0;
    }
    .lastCard{
        margin-bottom: 15px;
    }
</style>
<?php
if(isset($_POST['submitState'])){
    $name = $_POST['stateName'];
    $code = $_POST['stateCode'];
    if($name != '' && $code != '') {
        if(!$database->check("SELECT code FROM state WHERE code='$code'")) {
            $database->executeQuery('portal', "INSERT INTO state (name, code) VALUES('$name','$code' )");
            echo $alertBuilder->createAlert("Added state " . $name, "success");
        }
        else{
            echo $alertBuilder->createAlert("Code " . $code . " already exists", "danger");
        }
    }
    else{
        echo $alertBuilder->createAlert("Failed to add state", "danger");
    }

}
?>
<div class="container">
    <div class="row">
        <div class="col-md-6">
                <h3>States</h3>
                <p>As admin you can add & edit states here</p>
                <ul>
                    <li>All fields are required</li>
                    <li>When you create a state other users can directly use this state on their assignments</li>
                    <li>State can be added or edited but not removed</li>
                    <li>Assignments use these states</li>
                </ul>
        </div>
        <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Current available states
                    </div>
                    <div class="card-block">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Code</th>
                                <th>Name</th>
                                <th></th>

                            </tr>
                            </thead>
                            <tbody>

                        <?php
                        $page_max = 4;
                        $entriesInDatabase = $database->getData("SELECT count(id) FROM state");
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

                        $states = $database->getDataAsArray("SELECT * FROM state ORDER BY id LIMIT $start, $numberOfRecords");
                        //$states = $database->getDataAsArray("SELECT * FROM state");

                        foreach ($states as $state){
                            $id = $state['id'];
                            $name = $state['name'];
                            $code = $state['code'];
                            echo '<tr>
                                    <td>'. $code .'</td>
                                    <td>'. $name .'</td>
                                    <td><a class="btn btn-info btn-sm" href="../user/edit.php?edit=state&id='.$id.'"><i class="fa fa-edit"></i></a></td>
                                  </tr>';
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
                </div>
        </div>
    </div>
    <div class="row justify-content-end">

        <div class="col-md-6 align-self-end">
            <div class="card lastCard">
                <div class="card-header">
                    Create new state
                    <form method="post" id="addForm">
                        <button class="btn btn-success btn-sm" name='addState' type="submit"><i class="fa fa-plus"></i></button>
                    </form>
                </div>

                <div class="card-block">
                    <script>
                            $('button #testing').click(function(e){
                                $(e.target).remove();
                            });
                    </script>

                    <?php
                    if(isset($_POST['addState'])){
                        echo '<form action="" method="post">
                        <fieldset>
                            <div class="form-group">
                                <label>State code</label>
                                <input size="14" class="form-control" placeholder="State Code" name="stateCode" type="number">
                            </div>
                            <div class="form-group">
                                <label>State name</label>
                                <input class="form-control" placeholder="State Name" name="stateName" type="text">
                            </div>
                            <div class="text-center">
                            <input class="btn btn-info" id="submitState" name="submitState" type="submit" value="Add">
                            </div>
                        </fieldset>
                    </form>';
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>
