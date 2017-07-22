<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script><link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css"/>
<link rel="stylesheet" href="../css/style.css" type="text/css">
<style>
    img {
        display: block; !important;
        margin: auto; !important;
    }
    .panel-body {
        margin-top: 75px; !important;
    }
    .information {
        display: none;
    }
</style>
<script>

    document.getElementsByClassName(".information");
    }
</script>
<h2><button class="btn btn-info btn-circle"><i class="fa fa-info"></i></button></h2>
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="information">
            <h5>Additional Information</h5>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur malesuada, magna sed sagittis posuere, nulla massa vulputate erat, sed laoreet mi nisl id quam. Nunc sodales justo quis orci sagittis tincidunt. Aliquam consectetur, metus vel commodo molestie, dui nisl vulputate nunc, sit amet varius ex nisi a ante. Donec vitae semper enim. Nullam vulputate porttitor interdum. Phasellus vel vehicula ligula, sit amet consectetur nunc. Phasellus eget facilisis arcu, sed fringilla neque. Sed urna purus, dictum eu condimentum eu, egestas vitae lacus. Nam ultricies nec ligula quis consectetur. Suspendisse posuere nulla tortor, vel pulvinar nulla fermentum non. Sed quis nulla sed mi congue sollicitudin. Morbi consectetur mi quis mauris egestas commodo. Vivamus rhoncus vestibulum orci, quis aliquam velit convallis eget.
            </p>
        </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <img src="../assets/logo.png">
                </div>
                <div class="panel-body">
                    <form accept-charset="UTF-8" role="form">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="Username or Email" name="username" type="text">
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Password" name="password" type="password">
                            </div>
                            <input class="btn btn-info btn-block" type="submit" value="Login">
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4"></div>
    </div>
</div>
<?php
    require '../database/Database.php';


?>
