<?php
// Include config file
require_once 'config.php';
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = $usertype = $departamento = $nombre_completo =  "";
$username_err = $password_err = $confirm_password_err = $usertype_err = $departamento_err = $nombre_completo_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Por favor introduce un usuario.";
    } else{
        // preparar la sentencia
        $sql = "SELECT id FROM usuarios WHERE username = ?";
        
        if($stmt = mysqli_prepare($mysqli, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "este usuario ya existe.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Ocurrio un error, intenta después.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Validate password
    if(empty(trim($_POST['password']))){
        $password_err = "Por favor ingresa una contraseña.";     
    } elseif(strlen(trim($_POST['password'])) < 6){
        $password_err = "La contraseña debe tener al menos 6 caracteres.";
    } else{
        $password = trim($_POST['password']);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = 'Por favor confirma el password.';     
    } else{
        $confirm_password = trim($_POST['confirm_password']);
        if($password != $confirm_password){
            $confirm_password_err = 'Las contraseñas no coinciden .';
        }
    }


        // Validate departamento
        if(empty(trim($_POST["departamento"]))){
            $departamento_err = 'Por favor introduce un departamento.';     
        } else{
            $departamento = trim($_POST['departamento']);
        }


                // Validate fullname
        if(empty(trim($_POST["nombre_completo"]))){
            $nombre_completo_err = 'Por favor introduce un nombre completo.';     
        } else{
            $nombre_completo = trim($_POST['nombre_completo']);
        }
    
    //
     // Validate usertype
    
    if(empty(trim($_POST['usertype']))){
        $usertype_err = "Please enter a tipo de usuario 1 ó 2.";     
    } elseif(!ctype_digit($_POST['usertype'])){
        $usertype_err = 'Please enter a positive integer value.';
    } else{
        $usertype = trim($_POST['usertype']);
    }
    
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($usertype_err) && empty($departamento_err) && empty($nombre_completo_err) ){
        
        // Prepare an insert statement
        $sql = "INSERT INTO usuarios (username, password, tipo_usuario, departamento, nombre_completo) VALUES (?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($mysqli, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssss", $param_username, $param_password, $param_usertype, $param_departamento, $param_nombre_completo);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); 
            $param_usertype = $usertype;
            $param_departamento = $departamento;
            $param_nombre_completo = $nombre_completo;
            // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($mysqli);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="bootstrap337/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Registro</h2>
        <p>Llena los datos para poder acceder.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

        <div class="form-group <?php echo (!empty($nombre_completo_err)) ? 'has-error' : ''; ?>">
                <label>Nombre completo</label>
                <input type="text" name="nombre_completo"class="form-control" value="<?php echo $nombre_completo; ?>">
                <span class="help-block"><?php echo $nombre_completo_err; ?></span>
            </div> 
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Nombre de usuario</label>
                <input type="text" name="username"class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Contraseña</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirmar contraseña</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($departamento_err)) ? 'has-error' : ''; ?>">
                <label>Departamento: </label>
                <input type="text" name="departamento" class="form-control" value="<?php echo $departamento; ?>">
                <span class="help-block"><?php echo $departamento_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($usertype_err)) ? 'has-error' : ''; ?>">
                <label>tipo de usuario(1 o 2) </label>
                <input type="text" name="usertype"class="form-control" value="<?php echo $usertype; ?>">
                <span class="help-block"><?php echo $usertype_err; ?></span>
            </div> 
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Registrarse">
                <input type="reset" class="btn btn-default" value="Borrar">
            </div>
            <p>Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a>.</p>
        </form>
    </div>    
</body>
</html>