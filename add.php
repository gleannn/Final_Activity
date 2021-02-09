<?php
    include_once("config.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <title>Add Script</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>


<?php 
   if( isset($_POST['Submit']))
   {
        $birthday = mysqli_real_escape_string($mysqli, $_POST['birthday']);
        $Name = mysqli_real_escape_string($mysqli, $_POST['Name']);
       

        if( empty($birthday) | empty($Name)){
            if(empty($birthday))
            {
                echo "<font color='red'> Birthday field is empty. </font> <br>";
            }

            if(empty($Name))
            {
                echo "<font color='red'> Name field is empty. </font> <br>";
            } 

            echo "<br><a href ='javascript:self.history.back();'>Go Back </a>";
        }
        else
        {
            $result = mysqli_query($mysqli, "INSERT INTO birthdays(birthday, Name) VALUES ('$birthday', '$Name')");
            echo "<font color='green'> Data Added Successfully.";
            echo "<br> <a href='index.php'> View Result </a>"; 

        }
   }
?> 
</body>
</html>