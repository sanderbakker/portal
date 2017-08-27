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

            $checkUserInfoStatement = $this->database->getConnection()->prepare('SELECT * FROM user_info WHERE userId = ?');
            $checkUserInfoStatement->bind_param('i', $id);
            if($this->database->check($checkUserInfoStatement)){
                $query = $this->database->getConnection()->prepare("UPDATE user_info
                          SET $name = ?
                          WHERE userId=?");
                $query->bind_param('si', $newValue, $id);
            }
            else{
                $query = $this->database->getConnection()->prepare("INSERT INTO user_info
                          (userId, $name) VALUES (?, ?)");
                $query->bind_param('is', $id, $newValue);
            }
            if($this->database->executeQuery($query)) {
                $_SESSION[$name]=$newValue;

                echo $this->alertBuilder->createAlert( "Changed $name successfully in $newValue", 'success');
            }
            else{
                echo $this->alertBuilder->createAlert("Failed to change $name", "danger");
            }
        }

    }
    public function submitEditForm($submitValue, $fieldValue, $name, $values = null){
        $id = $_SESSION['id'];


        if(isset($_POST[$submitValue])){
            $newValue = $_POST[$fieldValue];
            if(!empty($newValue)) {
                $query = $this->database->getConnection()->prepare("UPDATE Users
                          SET $name=?
                          WHERE id=?");
                if($values = null) {
                    $query->bind_param('si', $newValue, $id);
                }

                if($this->database->executeQuery($query)) {
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

            $checkUsernameStatement = $database->getConnection()->prepare('SELECT username FROM users WHERE username ?');
            $checkUsernameStatement->bind_param('s', $newValue);

            if(!empty($newValue) && !$database->check($checkUsernameStatement)) {
                $query = $this->database->getConnection()->prepare("UPDATE Users
                          SET username=?
                          WHERE id=?");
                $query->bind_param('si', $newValue, $id);
                if($database->executeQuery($query)) {
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

            $getPassword = $this->database->getUserById($id)['password'];
            $encryptedPassword = explode('||', $getPassword);
            $decryptedPassword = $this->database->decryptSSL($encryptedPassword[0], $encryptedPassword[1]);
            if(!empty($_POST['oldPassword']) && !empty($_POST['newPassword']) && !empty($_POST['rNewPassword'])){
                if($decryptedPassword == $_POST['oldPassword'] && $_POST['newPassword'] == $_POST['rNewPassword']){
                    $newEncryptedPassword = $this->database->encryptSSL($_POST['newPassword']);

                    $query = $this->database->getConnection()->prepare("UPDATE Users SET password=? WHERE id=?");
                    $query->bind_param('si', $newEncryptedPassword, $id);
                    $this->database->executeQuery($query);
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
    public function buildStateForm($stateName, $stateCode){

        return "<div class='container'>
            <div class='col-md-4 mx-auto'>
                <div class='panel panel-default'>
                    <div class='panel-header'>
                        <h4>Change state</h4>
                    </div>
                    <div class='panel-body'>
                        <form action='' method='post'>
                            <fieldset>
                                <div class='form-group'>
                                    <label>Old state name</label>
                                    <input class='form-control' value='$stateName' name='oldStateName'  readonly type='text'>
                                </div>
                                <div class='form-group'>
                                    <label>Old state code</label>
                                    <input class='form-control' value='$stateCode' name='oldStateCode' readonly type='text'>
                                </div>
                                
                                <div class='form-group'>
                                    <label>New state name:</label>
                                    <input class='form-control' placeholder='New State Name' name='newStateName' type='text'>
                                </div>
                                
                                <div class='form-group'>
                                    <label>New state code:</label>
                                    <input class='form-control' placeholder='New State Code' name='newStateCode' type='text'>
                                </div>
                                
                                <input class='btn btn-info btn-block' name='submitState' type='submit' value='Change'>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>";

    }



}