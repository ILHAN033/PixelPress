<?php 

    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Form</title>
<style>
  body {
    font-family: Arial, sans-serif;
    background-color: #f3f3f3;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
  }

  .login-container {
    background-color: #ffffff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    max-width: 400px;
    width: 100%;
  }

  .heading {
    text-align: center;
    margin-bottom: 30px;
  }

  .heading h1 {
    font-size: 36px;
    color: #333333;
    margin: 0;
    padding: 0;
    font-weight: bold;
  }

  .heading p {
    color: #666666;
    font-size: 18px;
    margin-top: 5px;
  }

  h2 {
    text-align: center;
    color: #333333;
  }

  input[type="text"],
  input[type="password"] {
    width: 100%;
    padding: 10px;
    margin-top: 15px;
    border: 1px solid #cccccc;
    border-radius: 5px;
    box-sizing: border-box;
    font-size: 16px;
  }

  input[type="submit"] {
    width: 100%;
    padding: 10px;
    margin-top: 20px;
    border: none;
    border-radius: 5px;
    background-color: #4caf50;
    color: #ffffff;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }

  input[type="submit"]:hover {
    background-color: #45a049;
  }

  .form-footer {
    margin-top: 15px;
    text-align: center;
  }

  .form-footer a {
    color: #333333;
    text-decoration: none;
  }

  .form-footer a:hover {
    text-decoration: underline;
  }
</style>
</head>
<body>

<div class="login-container">
  <div class="heading">
    <h1>PixelPress</h1>
  </div>
  <h2>Login</h2>
  <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
    <input type="text" name="username" placeholder="Username">
    <input type="password" name="password" placeholder="Password">
    <input type="submit" value="Login" name="login">
  </form>
</div>

</body>
</html>


<?php 
    if(isset($_POST["login"])) {
        $_SESSION["user"] = $_POST["username"];
        $_SESSION["password"] = $_POST["password"];

        if(empty($_POST["username"])){
            echo "<script> alert('Username is missing')</script>";

        }
        if(empty($_POST["password"])){
            echo "<script>alert('Password is missing')</script>";
        }

        if(!empty($_POST["username"]) && !empty($_POST["password"])){
            header("Location: upload.php");
     
        }
    }

?>