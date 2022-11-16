<?php
// Include config file
require_once 'config.php';
 
// Define variables and initialize with empty values
$name = $direccion = $fechaN = $tel = $correo = $foto = "";
$name_err = $direccion_err = $fechaN_err = $tel_err = $correo_err = $foto_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if username is empty
    if(empty(trim($_POST["name"]))){
        $name_err = 'Please enter name.';
    } else{
        $name = trim($_POST["name"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST['direccion']))){
        $direccion_err = 'Please enter your direccion.';
    } else{
        $direccion = trim($_POST['direccion']);
    }
    
    if(empty(trim($_POST['FechaNa']))){
        $fechaN_err = 'Please enter your born date.';
    } else{
        $fechaN = trim($_POST['FechaNa']);
    }
    
    $input_tel = trim($_POST["telefono"]);
    if(empty($input_tel)){
        $tel_err = "Please enter your number phone.";     
    } elseif(!ctype_digit($input_tel)){
        $tel_err = 'Please enter a number phone.';
    } else{
        $tel = $input_tel;
    }
    
    if(empty(trim($_POST["correo"]))){
        $correo_err = 'Please enter your email.';
    } else{
        $correo = trim($_POST["correo"]);
    }
    
    if(empty(trim($_POST["photo"]))){
        $foto_err = 'Please enter your photo.';
    } else{
        $foto = trim($_POST["photo"]);
    }
    
     
    if(empty($name_err) && empty($direccion_err) && empty($fechaN_err)&& empty($tel_err)&& empty($correo_err)&& empty($foto_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO clientes (name, direccion, fechaN, telefono, correo, foto) VALUES (?, ?, ?, ?, ?,?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssss", $param_name, $param_direccion, $param_fechaN, $param_tel, $param_correo, $param_foto );
            
            // Set parameters
            $param_name = $name;
            $param_direccion = $direccion;
            $param_fechaN = $fechaN;
            $param_tel = $tel;
            $param_correo = $correo;
            $param_foto = $foto;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    
    // Close connection
    mysqli_close($link);
}
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <link rel="stylesheet" type="text/css" href="bootstrap337/css/bootstrap.min.css">
    </head>
    <body>
        <div class="card col-xs-12 col-sm-10 col-md-8 col-lg-3" style="width: 18rem;">
        <div class="card-body"> 
        <fieldset style="border:1px solid black " align="center">
            <legend>Ingresa tus datos</legend>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            Nombre<input type="text" name="name" class="form-control" value="<?php echo $name; ?>"><br>
            Dirección<input type="text" name="direccion" class="form-control" value="<?php echo $direccion; ?>"><br>
            Fecha de nacimiento<input type="text"  name="FechaNa" class="form-control" value="<?php echo $fechaN; ?>"><br>
            Teléfono<input type="tel" name="telefono" class="form-control" value="<?php echo $tel; ?>"><br>
            Correo<input type="email" name="correo" class="form-control" value="<?php echo $correo; ?>"><br>
            Foto<input type="file" name="photo" class="form-control" value="<?php echo $foto; ?>"><br>
            
            
            <input type="submit" class="btn btn-primary" value="Submit">
            <a href="index.php" class="btn btn-default">Cancel</a>
            </form>
        </fieldset>
        <script src="bootstrap337/js/bootstrap.min.js"></script>
        <script src="bootstrap337/js/jqueryv1.12.4.min.js"></script>
        </div>
        </div>
    </body>
</html>