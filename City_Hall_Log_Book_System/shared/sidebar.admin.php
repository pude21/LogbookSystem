<?php

include "../util/Misc.php";
$load = false;
ob_start();
include "../shared/navbar_page.php";
$navbar = ob_get_clean();
$title = "City Hall";
?>

<?php ob_start() ?>

<nav class="navbar navbar-inverse visible-xs" style="margin-top: 11%">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <li <?php echo Misc::url() == Misc::url('admin/') ? 'class="active"' : '' ?>><a
                        href="<?php echo Misc::url('admin/') ?>">Reports</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid" style="margin-top: 5%">
    <div class="row content">
        <div class="col-sm-3 sidenav hidden-xs" style="height: 100vh">
            <div class="card" style="width: 100%; margin-top:25px;">
                <img src="../assets/image/city_logo.svg" alt="Logo" class="card-img-top"
                    style="max-width: 50%; height: auto; margin: 0 auto; display: block;">
            </div>

            <ul class="nav nav-pills nav-stacked mt-3" style="margin-top: 15px">
                <li <?php echo Misc::url() == Misc::url('admin/') ? 'class="active-ch"' : '' ?>><a
                        href="<?php echo Misc::url('admin/') ?>"><i class="fas fa-file"></i> <span
                            style="margin-left: 10px">Reports</span></a></li>
            </ul>
        </div>


        <div class="col-sm-9" style="margin-top: 2%">
            <div class="well">
                <h4><?php echo $header; ?></h4>
                <p id="otherDetails"><?php echo isset($otherDetails) ? $otherDetails : '' ?></p>
            </div>
            <div class="well">
                <?php echo $admin_content; ?>
            </div>
        </div>
    </div>
</div>

<?php $content = ob_get_clean() ?>

<?php require_once "../shared/layout.php" ?>