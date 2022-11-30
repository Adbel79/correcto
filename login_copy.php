<?php
$db = new PDO('mysql:host=pruebas1.cvp0bpkbyxsj.us-east-1.rds.amazonaws.com; dbname=sys','admin','ADBELrene8');
if(isset($_POST['username'])){
    $username = $_POST['username'];
    $password = trim($_POST['password']);
    $query = $db->query("SELECT * FROM usuarios WHERE username='{$username}'");
    if($query->rowCount()){  //si encuentra un usuario el contador será mayor a 1
        header("location: administrador.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Iniciar sesion</h2>
        <p>Introduce los datos para iniciar sesion</p>
        <form action="login_copy.php" method="post" autocomplete="off">
            <div class="form-group">
                <label for="username">Nombre de usuario</label>
                <input type="text" id="username" name="username"class="form-control" value="">
                <span class="help-block"></span>
            </div>    
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Entrar">
            </div>
            <p>no tienes cuenta? <a href="register.php">Registrate</a>.</p>
        </form>
    </div>    
</body>
</html>