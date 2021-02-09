<?php 

require_once 'db.php';



$name = '' ;
$email = '';
$password = '';
$confirm_password = '';

if( $_SERVER['REQUEST_METHOD'] == 'POST')
{

  $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

  $name = trim($_POST['name']);
  $email = trim($_POST['email']);
  $password = trim($_POST['password']);
  $confirm_password = trim($_POST['confirm_password']);


  if(empty($name))
  {
    $name_err = 'Please enter your name';
  }

  if(empty($email))
  {
    $email_err = 'Please enter email address';
  } else {
    $sql = 'SELECT id FROM users WHERE email = :email';

    if( $stmt = $pdo->prepare($sql))
    {
      $stmt->bindParam(':email', $email, PDO::PARAM_STR);

      if($stmt->execute()){
        if($stmt->rowCount() === 1)
        {
          $email_err = 'Email is already taken';
        }
      }else{
        die('Something went wrong'); 
      }
    }
    unset($stmt);
  }

  if(empty($password))
  {
    $password_err = 'Please enter a password';
  } elseif(strlen($password) < 6)
  {
    $password_err = 'Password must be at least 6 characters';
  }

  if(empty($confirm_password))
  {
    $confirm_password_err = 'Please confirm password';
  } else {
    if( $password !== $confirm_password){
      $confirm_password_err = 'Passwords do not match';
    }
  }

  //inputs are okay to be saved to the database
  if( empty($name_err) &&
      empty($email_err) &&
      empty($password_err) &&
      empty($confirm_password_err)
    )
    {
      $password = password_hash($password, PASSWORD_DEFAULT);
      $sql = 'INSERT INTO users (name, email, password) VALUES (:name, :email, :password)';

      if( $stmt = $pdo->prepare($sql)){
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);

        if( $stmt->execute())
        {
          header('location: login.php');
        } else {
          die('Something went wrong');
        }
      }

      unset($stmt);
    }
    unset($pdo);
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Create An Account</title>
  </head>
  <body>
  <div class="container">
    <div class="row">
      <div class="col-md-6 mx-auto">
        <div class="card card-body bg-light mt-5">
          <h4 class="head text-center">Create Account</h4>
          <p class="text-center"> Welcome, Sign Up Now</p>
            <form action="<?php echo $_SERVER[ 'PHP_SELF']; ?>" method="post">
              <div class="form-group">
                  <label>Name:<sup>*</sup></label>
                  <input type="text" name="name" class="form-control form-control-lg <?php echo (!empty($name_err)) ? 'is-invalid' : '';?> " value="<?php echo $name;?>">
                  <span class="invalid-feedback"><?php echo $name_err;?></span>
              </div> 
              <div class="form-group">
                  <label>Email Address:<sup>*</sup></label>
                  <input type="email" name="email" class="form-control form-control-lg <?php echo (!empty($email_err)) ? 'is-invalid' : '';?> " value="<?php echo $email;?>">
                  <span class="invalid-feedback"><?php echo $email_err;?></span>
              </div>    
              <div class="form-group">
                  <label>Password:<sup>*</sup></label>
                  <input type="password" name="password" class="form-control form-control-lg <?php echo (!empty($password_err)) ? 'is-invalid' : '';?> " value="<?php echo $password;?>">
                  <span class="invalid-feedback"><?php echo $password_err;?></span>
              </div>
              <div class="form-group">
                  <label>Confirm Password:<sup>*</sup></label>
                  <input type="password" name="confirm_password" class="form-control form-control-lg <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : '';?> " value="<?php echo $confirm_password;?>">
                  <span class="invalid-feedback"><?php echo $confirm_password_err;?></span>
              </div>

              <div class="form-row">
                <div class="col">
                  <input type="submit" class="btn btn-light bg-secondary btn-block" value="Register">
                </div>
                <div class="col">
                  <a href="login.php" class="btn btn-light bg-secondary btn-block">Have an account? Login</a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
  </div>    
  </body>
</html>