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
        $this->database = new Database('localhost', 'root', '');
        $this->alertBuilder = new AlertBuilder();
    }
    public function buildCommentForm($title, $value, $placeholder, $name, $submitName){
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
                                    <label>Old $title:</label>
                                    <textarea class='form-control' rows='5' id='comment' name='name' readonly >$value</textarea>
                                    <!--<input class='form-control' placeholder='' name='name' type='text' readonly value='$value'>-->
                                </div>
                                <div class='form-group'>
                                    <label>New $title:</label>
                                    <textarea class='form-control' rows='5' id='comment' placeholder='$placeholder' name='$name'>$value</textarea>
                                </div>
                                <input class='btn btn-info btn-block' name='$submitName' type='submit' value='Edit'>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>";
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
                                    <label>Old $title:</label>
                                    <input class='form-control' placeholder='' name='name' type='text' readonly value='$value'>
                                </div>
                                <div class='form-group'>
                                    <label>New $title:</label>
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

    public function submitUserInfo($submitValue, $fieldValue, $name){
        $id = $_SESSION['id'];
        if(isset($_POST[$submitValue])) {
            $newValue = $_POST[$fieldValue];
            if($this->database->check("SELECT * FROM user_info WHERE userId = $id")){
                $query = "UPDATE user_info
                          SET $name='$newValue'
                          WHERE userId=$id";
            }
            else{
                $query = "INSERT INTO user_info
                          (userId, $name) VALUES ($id, '$newValue')";
            }
            if($this->database->insertInTable("portal", $query)) {
                $_SESSION[$name]=$newValue;

                echo $this->alertBuilder->createAlert( "Changed $name successfully in $newValue", 'succes');
            }
            else{
                echo $this->alertBuilder->createAlert("Failed to change $name", "danger");
            }
        }

    }
    public function submitEditForm($submitValue, $fieldValue, $name){
        $id = $_SESSION['id'];


        if(isset($_POST[$submitValue])){
            $newValue = $_POST[$fieldValue];
            if(!empty($newValue)) {
                $query = "UPDATE Users
                          SET $name='$newValue'
                          WHERE id='$id'";
                if($this->database->insertInTable("portal", $query)) {
                    $_SESSION[$name]=$newValue;

                    echo $this->alertBuilder->createAlert( "Changed $name successfully in $newValue", 'succes');
                }
                else{
                    echo $this->alertBuilder->createAlert("Failed to change $name", "danger");
                }
            }
            else{
                echo $this->alertBuilder->createAlert("$name can not be empty", "danger");
            }
        }
    }
    public function submitUsername($submitValue, $fieldValue){
        $id = $_SESSION['id'];
        $database = new Database('localhost', 'root', '');
        $alertBuilder = new AlertBuilder();
        if(isset($_POST[$submitValue])){
            $newValue = $_POST[$fieldValue];
            if(!empty($newValue) && !$database->check("SELECT username FROM Users WHERE username='$newValue'")) {
                $query = "UPDATE Users
                          SET username='$newValue'
                          WHERE id='$id'";
                if($database->insertInTable("portal", $query)) {
                    $_SESSION['username'] = $newValue;
                    echo $alertBuilder->createAlert( "Changed username successfully in $newValue", 'succes');
                }
                else{
                    echo $alertBuilder->createAlert("Failed to change username", "danger");
                }
            }
            else{
                echo $alertBuilder->createAlert("Username can not be empty or is already in use", "danger");
            }
        }
    }


}