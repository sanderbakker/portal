<?php
/**
 * Created by PhpStorm.
 * User: sande
 * Date: 26-7-2017
 * Time: 21:49
 */

class FormBuilder
{

    public function __construct()
    {

    }
    public function buildEditForm($title, $value, $placeholder, $name, $submitName){
        return "<div class='container'>
            <div class='col-md-4 mx-auto'>
                <div class='panel panel-default'>
                    <div class='panel-header'>
                        <h4>Edit $title</h4>
                    </div>
                    <div class='panel-body'>
                        <form action='' method='post'>
                            <fieldset>
                                <div class='form-group'>
                                    <input class='form-control' placeholder='' name='name' type='text' readonly value='$value'>
                                </div>
                                <div class='form-group'>
                                    <input class='form-control' placeholder='$placeholder' name='$name' type='text'>
                                </div>
                                <input class='btn btn-info btn-block' name='$submitName' type='submit' value='Edit'>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>";
    }
    public function submitEditForm($submitValue, $fieldValue){
        $id = $_SESSION['id'];
        $database = new Database('localhost', 'root', '');
        $alertBuilder = new AlertBuilder();
        if(isset($_POST[$submitValue])){
            $newName = $_POST[$fieldValue];
            if(!empty($newName) && ctype_alpha($newName)) {
                $query = "UPDATE Users
              SET firstname='$newName'
              WHERE id='$id'";
                if($database->insertInTable("portal", $query)) {
                    $_SESSION['name'] = $newName;
                    echo $alertBuilder->createAlert( "Changed name successfully in $newName", 'succes');
                }
                else{
                    echo $alertBuilder->createAlert("Failed to change name", "danger");
                }
            }
            else{
                echo $alertBuilder->createAlert("Name can not be empty or contain numbers", "danger");
            }
        }
    }

}