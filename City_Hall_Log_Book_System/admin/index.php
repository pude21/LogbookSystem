<?php
session_start();

if (!isset($_SESSION['id'])) {
    header('location: ../page/admin_login.php');
    exit();
}

$displayLogout = true;
?>

<?php ob_start() ?>
<i class="fas fa-file"></i>
<span style="margin-left: 10px">Reports</span>
<?php $header = ob_get_clean() ?>

<?php ob_start() ?>
<link href="../assets/css/calendar.css" rel="stylesheet">
<?php $styles = ob_get_clean() ?>

<?php ob_start() ?>
<div id="calendar"></div>
<div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalTitle"></h4>
            </div>
            <div class="modal-body">
                <div style="margin-bottom: 5px">
                    <input type="search" name="search" id="search" class="form-control" placeholder="Search...">
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Purpose</th>
                                <th>Type</th>
                                <th>Office</th>
                                <th>Division</th>
                                <th>Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="modalBody">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $admin_content = ob_get_clean() ?>

<?php ob_start() ?>
<script type="module" src="../assets/js/log.calendar.js"></script>
<script type="module" src="../assets/js/admin.logout.js"></script>
<?php $scripts = ob_get_clean() ?>
<?php require_once "../shared/sidebar.admin.php" ?>