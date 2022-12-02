<?php
// Initialize the session
session_start();
 
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
    //if($_SESSION['usertype'] != 2)
           header("location: login.php");
  exit;
}

// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
    //if($_SESSION['usertype'] != 1)
           header("location: login.php");
  exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido</title>
    <link rel="stylesheet" href="bootstrap337/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <div class="page-header">
        <h1>Hola, <b><?php echo htmlspecialchars($_SESSION['username']); ?></b>. Bienvenido a tu sitio, administrador. Tu usuario es de tipo <b><?php echo htmlspecialchars($_SESSION['usertype']); ?></b></h1>
    </div>
    <p><a href="https://6f56-148-226-28-247.ngrok.io/login.html.php" class="btn btn-success">Ir a los tamales</a></p>
</body>
</html>