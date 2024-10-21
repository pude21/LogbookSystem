<?php
session_start();

$title = "City Hall";
$load = false;
ob_start();
include "../shared/navbar_page.php";
$navbar = ob_get_clean();
?>

<?php ob_start() ?>
<link rel="stylesheet" href="../assets/css/page.index.css">
<?php $styles = ob_get_clean() ?>

<?php ob_start() ?>

<div class="w3-center" style="margin-top:13%;">
    <div class="reverse-flex margin-top-20" style="display:flex; justify-content: space-around; align-items: center;">
        <div>
            <img src="../assets/image/city_logo.svg" alt="City Hall Logo" width="300px">
        </div>
        <div class="margin-top-5">
            <div style="font-size: 30px;margin-bottom: 20px">
                <div style="display:inline-block">
                    <div class="text">Welcome To City Hall!</div>
                </div>
            </div>
            <div style="display:flex;justify-content:space-around;align-items:center">
                <div class="w3-padding" style="margin-left:10px;">
                    <a href="../page/admin_login.php" class="btn ch-green btn-lg">Admin</a>

                </div>
                <div class="w3-padding" style="margin-left:10px;">
                    <a href="../page/log.php" class="btn ch-green btn-lg">Log Now</a>

                </div>
            </div>
        </div>
    </div>
</div>


<?php $content = ob_get_clean() ?>

<?php require_once "../shared/layout.php" ?>