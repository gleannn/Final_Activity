<?php


    include("config.php");

    $id = $_GET['id'];

    $result = mysqli_query($mysqli, "DELETE FROM birthdays where id=$id");

    header("Location:index.php")

?>