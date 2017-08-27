<?php
/**
 * Created by PhpStorm.
 * User: sande
 * Date: 25-8-2017
 * Time: 20:46
 */

include '../includes/navbar.php';

?>
<style>

    a, a:hover, a:active, a:visited, a:focus {
        text-decoration:none;
        color: #000;
    }
    .card-block{
        padding: 0; !important;
    }
    .table{
        margin-bottom: 0; !important;
    }

    #table_wrapper{
        margin-top: 15px;
        margin-bottom: 15px;
    }
    .dropdown-item{
        width: auto;
    }
    h5{
        font-size: 20px;
    }
    .card-header{
        padding: 0.75em; !important;
    }

    a:visited{
        color:black;
        text-decoration: none;
    }
    .table td{
        border-top: none;
    }

</style>

<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div id="accordion" role="tablist" aria-multiselectable="true">
                <div class="card">
                    <div class="card-header" role="tab" id="headingOne">
                        <h5 class="mb-0">
                            Settings
                        </h5>
                    </div>
                    <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
                        <div class="card-block">
                            <table class="table">
                                <tr>
                                    <td>
                                        <a href="#"><i class="fa fa-inbox"></i> Cat 1</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#"><i class="fa fa-trash"></i> Cat 2</a>
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
                    Settings
                </div>
                <div class="card-block">
                    <table class="table">
                        <tr>
                            <td><b>Widgets</b><br><div style="font-size: 10px">Dashboard widgets can be selected here, these are widget like <b>salary, appointments, messages etc.</b></div></td>
                            <td style="float:right; margin-top:6px"><button class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></button> <br></td>
                        </tr>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
