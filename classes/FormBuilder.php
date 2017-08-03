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
        $this->database = new Database('localhost', 'root', '', openssl_random_pseudo_bytes(16));
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
                                </div>
                                <div class='form-group'>
                                    <label>New $title:</label>
                                    <textarea class='form-control' rows='5' id='comment' placeholder='$placeholder' name='$name'></textarea>
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
            if($this->database->executeQuery("portal", $query)) {
                $_SESSION[$name]=$newValue;

                echo $this->alertBuilder->createAlert( "Changed $name successfully in $newValue", 'success');
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
                if($this->database->executeQuery("portal", $query)) {
                    $_SESSION[$name]=$newValue;

                    echo $this->alertBuilder->createAlert( "Changed $name successfully in $newValue", 'success');
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
        $database = new Database('localhost', 'root', '', openssl_random_pseudo_bytes(16));
        $alertBuilder = new AlertBuilder();
        if(isset($_POST[$submitValue])){
            $newValue = $_POST[$fieldValue];
            if(!empty($newValue) && !$database->check("SELECT username FROM Users WHERE username='$newValue'")) {
                $query = "UPDATE Users
                          SET username='$newValue'
                          WHERE id='$id'";
                if($database->executeQuery("portal", $query)) {
                    $_SESSION['username'] = $newValue;
                    echo $alertBuilder->createAlert( "Changed username successfully in $newValue", 'success');
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

    public function submitPassword(){
        $id = $_SESSION['id'];
        if(isset($_POST['submitPassword'])){
            $getPassword = $this->database->getPassword("SELECT password FROM users WHERE id=$id");
            $encryptedPassword = explode('||', $getPassword);
            $decryptedPassword = $this->database->decryptSSL($encryptedPassword[0], $encryptedPassword[1]);
            if(!empty($_POST['oldPassword']) && !empty($_POST['newPassword']) && !empty($_POST['rNewPassword'])){
                if($decryptedPassword == $_POST['oldPassword'] && $_POST['newPassword'] == $_POST['rNewPassword']){
                    $newEncryptedPassword = $this->database->encryptSSL($_POST['newPassword']);
                    $this->database->executeQuery('portal', "UPDATE Users SET password='$newEncryptedPassword' WHERE id='$id'");
                    echo $this->alertBuilder->createAlert("Changed password", "success");
                }
                else{
                    echo $this->alertBuilder->createAlert("Failed to change password, try again", "danger");
                }
            }
            else{
                echo $this->alertBuilder->createAlert("Fields can not be empty", "danger");
            }
        }

    }
    public function buildPasswordForm(){
        return "<div class='container'>
            <div class='col-md-4 mx-auto'>
                <div class='panel panel-default'>
                    <div class='panel-header'>
                        <h4>Change password</h4>
                    </div>
                    <div class='panel-body'>
                        <form action='' method='post'>
                            <fieldset>
                                <div class='form-group'>
                                    <label>Old password</label>
                                    <input class='form-control' placeholder='Old Password' name='oldPassword' type='password'>
                                </div>
                                <div class='form-group'>
                                    <label>New password:</label>
                                    <input class='form-control' placeholder='New Password' name='newPassword' type='password'>
                                </div>
                                <div class='form-group'>
                                    <label>Repeat new password:</label>
                                    <input class='form-control' placeholder='New Password' name='rNewPassword' type='password'>
                                </div>
                                <input class='btn btn-info btn-block' name='submitPassword' type='submit' value='Change'>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>";

    }


}