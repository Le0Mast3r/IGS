<?php
include '../db.php';
session_start();

$email = $_SESSION['email'];

$sql = "SELECT * FROM t_client WHERE email='$email' LIMIT 1";
$sql_fetch = mysqli_fetch_assoc(mysqli_query($conn, $sql));


if (!$sql_fetch) {
    header('location:login_client.php');
    exit();
}


?>
<?php include('../template/head.php'); ?>
<?php include('../template/template_client/sidebar.php'); ?>


<h2></h2>
</div>


<?php include('../template/scripts.php'); ?>
</body>
<script type="text/javascript">
    $(document).ready(function() {
        $('#sidebarCollapse').on('click', function() {
            $('#sidebar').toggleClass('active');
        });
    });
</script>

</html>