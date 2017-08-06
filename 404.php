<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script><link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css"/>
<style>
    .error {
        margin: 0 auto;
        text-align: center;
        font-family: 'Roboto', sans-serif;
    }
    h3{
        font-weight: bold;
    }
    .error-code {
        bottom: 60%;
        color: #2d353c;
        font-size: 96px;
        line-height: 100px;
    }

    .error-desc {
        font-size: 12px;
        color: #647788;
    }

    .m-b-10 {
        margin-bottom: 10px!important;
    }

    .m-b-20 {
        margin-bottom: 20px!important;
    }

    .m-t-20 {
        margin-top: 20px!important;
    }
    a{
        margin-top: 15px;
    }
</style>

<div class="error">
    <div class="error-code m-b-10 m-t-20"><img src="assets/logo.png"></div>
    <h3>We couldn't find that specific page..</h3>

    <div class="error-desc">
        Sorry, but the page you are looking for was either not found, does not exist or has been removed. <br>
        Try refreshing the page or click the button below to go back to the Homepage.
        <div>
            <?php
            session_start();
            if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']) {
                echo '
                    <a  class="btn btn-sm btn-secondary" href="user/index.php"><i class="fa fa-arrow-left"></i> 
                        Go back to Homepage
                    </a>';
            }
            else{
                echo '
                <a class="btn btn-sm btn-secondary" href="index.php"><i class="fa fa-arrow-left"></i>
                            Go back to Homepage
                </a>';
            }

            ?>
        </div>
    </div>
</div>

<?php
/**
 * Created by PhpStorm.
 * User: sande
 * Date: 27-7-2017
 * Time: 15:16
 */
?>