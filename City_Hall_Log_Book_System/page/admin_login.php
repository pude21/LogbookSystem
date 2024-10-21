<?php
session_start();

if (isset($_SESSION['id'])) {
  header('location: ../admin/');
  exit();
}

$title = "City Hall";

ob_start();
include "../shared/navbar_page.php";
$navbar = ob_get_clean();
?>

<?php ob_start() ?>
<link rel="stylesheet" href="../assets/css/admin.login.css">
<?php $styles = ob_get_clean() ?>

<?php ob_start() ?>

<div class="background-image"></div>

<div class="form-container">
  <form id="admin_login">
    <div class="form-group">
      <label for="username">Username</label>
      <input type="text" class="form-control" name="username" id="username" placeholder="Enter Your Username">
      <div class="form-text text-danger" id="usernameError"></div>
    </div>
    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" class="form-control" name="password" id="password" placeholder="Enter Your Password">
      <div class="form-text text-danger" id="passwordError"></div>
    </div>
    <div class="form-group">
    <button type="submit" class="btn btn-block btn-submit">Submit</button>
    </div>
  </form>
</div>

<?php $content = ob_get_clean() ?>

<?php ob_start() ?>
<script type="module" src="../assets/js/admin.login.js"></script>
<?php $scripts = ob_get_clean() ?>

<?php require_once "../shared/layout.php" ?>