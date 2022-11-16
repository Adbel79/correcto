<?php
// Initialize the session
session_start();
 
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
    //if($_SESSION['usertype'] != 2)
           header("location: login.php");
  exit;
}

// Include config file
require_once 'config.php';
 
// Define variables and initialize with empty values
$sabortamal = $tipohoja = $cantidad = $precio = $tamanio = "";
$sabortamal_err = $tipohoja_err = $cantidad_err = $precio_err = $tamanio_err = "";

 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    // Validate nombre
  

    $input_sabortamal = trim($_POST["sabortamal"]);
    if(empty($input_sabortamal)){
        $sabortamal_err = "Introduce un saborcito ";
    } elseif(!filter_var(trim($_POST["sabortamal"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z'-.\s ]+$/")))){
        $sabortamal_err = 'Introduce un nombre válido';
    } else{
        $sabortamal = $input_sabortamal;
    }
    
    $input_tipohoja = trim($_POST["tipohoja"]);
    if(empty($input_tipohoja)){
        $tipohoja_err = "Introduce un tipo de hoja";
    } elseif(!filter_var(trim($_POST["tipohoja"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z'-.\s ]+$/")))){
        $tipohoja_err = 'Introduce un tipo de hoja válido';
    } else{
        $tipohoja = $input_tipohoja;
    }
    
    // Validar tamal
    $input_cantidad = trim($_POST["cantidad"]);
    if(empty($input_cantidad)){
        $cantidad_err = "Introduce la cantidad de tamalitos";     
    } elseif(!ctype_digit($input_cantidad)){
        $cantidad_err = 'Introduce un valor válido';
    } else{
        
        $cantidad = $input_cantidad;
    }
    
     $input_precio = trim($_POST["precio"]);
    if(empty($input_precio)){
        $precio_err = "Introduce el precio del tamalito";     
    } elseif(!ctype_digit($input_precio)){
        $precio_err = 'Introduce un valor válido';
    } else{
        $precio= $input_precio;
    }
    
     $input_tamanio = trim($_POST["tamanio"]);
    if(empty($input_tamanio)){
        $tamanio_err = "Introduce el tamañito del tamal";
    } else{
       
        $tamanio = $input_tamanio;
    
    }
    
    // Check input errors before inserting in database
    if(empty($sabortamal_err) && empty($tipohoja_err) && empty($cantidad_err)&& empty($precio_err)&& empty($tamanio_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO tamales (sabortamal, tipohoja, cantidad, precio, tamanio) VALUES (?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($mysqli, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssss", $param_sabortamal, $param_tipohoja, $param_cantidad, $param_precio, $param_tamanio );
            
            // Set parameters
            $param_sabortamal = $sabortamal;
            $param_tipohoja = $tipohoja;
            $param_cantidad= $cantidad;
            $param_precio= $precio;
            $param_tamanio= $tamanio;

            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: crud_tamales.php");
                exit();
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
    <title>Agregar tamalillo</title>
    <link rel="stylesheet" href="bootstrap337/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Agregar tamalito</h2>
                    </div>
                    <p>Por favor agrega la orden de los tamales</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($sabortamal_err)) ? 'has-error' : ''; ?>">
                            <label>Tamal</label>
                            <input type="text" name="sabortamal" class="form-control" value="<?php echo $sabortamal; ?>">
                            <span class="help-block"><?php echo $sabortamal_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($tipohoja_err)) ? 'has-error' : ''; ?>">
                            <label>Tipo de hoja </label>
                            <textarea name="tipohoja" class="form-control"><?php echo $tipohoja; ?></textarea>
                            <span class="help-block"><?php echo $tipohoja_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($cantidad_err)) ? 'has-error' : ''; ?>">
                            <label>Cantidad de tamalitos</label>
                            <input type="text" name="cantidad" class="form-control" value="<?php echo $cantidad; ?>">
                            <span class="help-block"><?php echo $cantidad_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($precio_err)) ? 'has-error' : ''; ?>">
                            <label>Precio de tamalitos</label>
                            <input type="text" name="precio" class="form-control" value="<?php echo $precio; ?>">
                            <span class="help-block"><?php echo $precio_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($tamanio_err)) ? 'has-error' : ''; ?>">
                            <label>Tamaño </label>
                            <input type="text" name="tamanio" class="form-control" value="<?php echo $tamanio; ?>">
                            <span class="help-block"><?php echo $tamanio_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit"> 
                        <a href="crud_tamales.php" class="btn btn-default">Cancelar</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>