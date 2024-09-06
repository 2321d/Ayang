<?php
if(isset($_POST['submit'])) {
    $nama   = $_POST['nama'];
    $email   = $_POST['email'];
    $no_hp   = $_POST['noHp'];
    $no_wa   = $_POST['noWa'];
    header("location:https://api.whatsapp.com/send?phone=$no_wa");
}else {
    echo"
        <script>
        window.location=history.go(-1)
        </script>
    ";
}
?>