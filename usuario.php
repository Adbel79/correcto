<?php
// Initialize the session
session_start();
 
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
    //if($_SESSION['usertype'] != 2)
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
        <h1>hola, <b><?php echo htmlspecialchars($_SESSION['username']); ?></b>.Por el momento estamos construyendo la pagina. el tipo es: <b><?php echo htmlspecialchars($_SESSION['usertype']); ?></b></h1>
    </div>
    <p><a href="logout.php" class="btn btn-danger">salir</a></p>
</body>
</html>