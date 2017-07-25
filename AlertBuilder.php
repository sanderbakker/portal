<?php
/**
 * Created by PhpStorm.
 * User: sande
 * Date: 25-7-2017
 * Time: 21:11
 */

class AlertBuilder
{
    public function __construct()
    {

    }
    public function createAlert($text, $type){
        if($type == 'succes'){
            return "<div class='alerts mx-auto alert-dismissable'>
                <div class='alert alert-success' role='alert'>
                <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
                    <strong>Success</strong> $text.
                </div>
              </div>";
        }
        elseif($type == 'danger'){
            return "<div class='alerts mx-auto alert-dismissable'>
                <div class='alert alert-danger' role='alert'>
                <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
                    <strong>Failed</strong> $text.
                </div>
              </div>";
        }
    }
}