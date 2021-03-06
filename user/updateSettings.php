<?php
/**
 * Created by PhpStorm.
 * User: sande
 * Date: 27-8-2017
 * Time: 16:45
 */
include '../includes/navbar.php';
include '../classes/AlertBuilder.php';

if(isset($_GET['edit'])){
    switch($_GET['edit']) {
        case 'widgets':
            $title = 'Widgets';
            break;
        default:
            header('location: index.php');
    }
}
else{
    header('location: index.php');
}



if(isset($_POST['save'])){
    $profile = false;
    $contact = false;
    $salary = false;
    $message = false;
    $intro = false;
    $appointment = false;
    if(isset($_POST['profile'])){
        $profile = true;
    }
    if(isset($_POST['contact'])){
        $contact = true;
    }
    if(isset($_POST['salary'])){
        $salary = true;
    }
    if(isset($_POST['intro'])){
        $intro = true;
    }
    if(isset($_POST['appointment'])){
        $appointment = true;
    }
    if(isset($_POST['message'])){
        $message = true;
    }
  
    $updateSettings = $database->getConnection()->prepare('UPDATE settings SET contact_widget = ?, salary_widget = ?
                                                                  ,messages_widget = ?, appointments_widget = ?, intro_widget =?,
                                                                 profile_widget = ? WHERE userId = ?');
    $updateSettings->bind_param('iiiiiii', $contact, $salary, $message, $appointment, $intro, $profile, $_SESSION['id']);
    $database->executeQuery($updateSettings);
    $alertBuilder = new AlertBuilder();
    echo $alertBuilder->createAlert('Successfully saved new widget data', 'success');
}
?>


<div class="container">
    <div class="card">
        <div class="card-header">
            <?php echo $title;?>
        </div>
        <div class="card-block">
            <div class="row">
                <div class="col-md-6">

                </div>
                <div class="col-md-6">
                    <?php if($_GET['edit'] == 'widgets'):?>
                        <form action='' method='post'>
                            <fieldset>
                                <div class='form-group'>
                                    <h5>Select the widgets you want on your dashboard</h5><br>
                                    <?php
                                    $settingsQuery = $database->getConnection()->prepare('SELECT * FROM settings WHERE userId = ?');
                                    $settingsQuery->bind_param('i', $_SESSION['id']);
                                    $settings = $database->getData($settingsQuery);
                                    ?>
                                    <ul class="list-group ">
                                        <li class="list-group-item">
                                            <label>
                                            <?php
                                            if($settings['profile_widget']){
                                               echo '<input type="checkbox" name="profile" checked>';
                                            }
                                            else{
                                                echo '<input type="checkbox" name="profile">';
                                            }
                                            ?>
                                                Profile widget</label>
                                        </li>
                                        <li class="list-group-item">
                                            <label>
                                            <?php
                                            if($settings['salary_widget']){
                                                echo '<input type="checkbox" name="salary" checked>';
                                            }
                                            else{
                                                echo '<input type="checkbox" name="salary" >';
                                            }
                                            ?>
                                                Salary widget
                                            </label>
                                        </li>
                                        <li class="list-group-item">
                                            <label>
                                            <?php
                                            if($settings['intro_widget']){
                                                echo '<input type="checkbox" name="intro" checked>';
                                            }
                                            else{
                                                echo '<input type="checkbox" name="intro">';
                                            }
                                            ?>
                                            Introduction widget
                                            </label>
                                        </li>
                                        <li class="list-group-item">
                                            <label>
                                            <?php
                                              if($settings['appointments_widget']){
                                                  echo '<input type="checkbox" name="appointment" checked>';
                                              }
                                              else{
                                                  echo '<input type="checkbox" name="appointment">';
                                              }
                                            ?>
                                                Appointment widget
                                            </label>
                                        </li>
                                        <li class="list-group-item">
                                            <label>
                                                <?php
                                                if($settings['messages_widget']){
                                                    echo '<input type="checkbox" name="message" checked>';
                                                }
                                                else{
                                                    echo '<input type="checkbox" name="message">';
                                                }
                                                ?>

                                                Message widget
                                            </label>
                                        </li>
                                        <li class="list-group-item">
                                            <label>
                                            <?php
                                                if($settings['contact_widget']) {
                                                    echo '<input type="checkbox" name="contact" checked>';
                                                }
                                                else{
                                                    echo '<input type="checkbox" name="contact">';
                                                }
                                            ?>
                                                Contact widget
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                                <input class='btn btn-success btn-sm' name='save' type='submit' value='Save'>
                            </fieldset>
                        </form>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</div>

