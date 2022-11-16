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
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate sabortamal
    $input_sabortamal = trim($_POST["sabortamal"]);
    if(empty($input_sabortamal)){
        $sabortamal_err = "Please enter a sabor tamal.";
    } elseif(!filter_var(trim($_POST["sabortamal"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z'-.\s ]+$/")))){
        $sabortamal_err = 'Please enter a valid sabor tamal.';
    } else{
        $sabortamal = $input_sabortamal;
    }
    
    // Validate tipohoja tipohoja
    $input_tipohoja = trim($_POST["tipohoja"]);
    if(empty($input_tipohoja)){
        $tipohoja_err = 'Please enter an tipohoja.';     
    } else{
        $tipohoja = $input_tipohoja;
    }
    
    // Validate cantidad
    $input_cantidad = trim($_POST["cantidad"]);
    if(empty($input_cantidad)){
        $cantidad_err = "Please enter the cantidad amount.";     
    } elseif(!ctype_digit($input_cantidad)){
        $cantidad_err = 'Please enter a positive integer value.';
    } else{
        $cantidad = $input_cantidad;
    }
    
    // Validate precio
    $input_precio = trim($_POST["precio"]);
    if(empty($input_precio)){
        $precio_err = "Please enter the precio amount.";     
    } elseif(!ctype_digit($input_precio)){
        $precio_err = 'Please enter a positive integer value.';
    } else{
        $precio = $input_precio;
    }
    
    // Validate tamanio
    $input_tamanio = trim($_POST["tamanio"]);
    if(empty($input_tamanio)){
        $tamanio_err = "Please enter the precio amount.";     
    } else{
        $tamanio = $input_tamanio;
    }
    
    // Check input errors before inserting in database
    if(empty($sabortamal_err) && empty($tipohoja_err) && empty($cantidad_err) && empty($precio_err) && empty($tamanio_err)){
        // Prepare an insert statement
        $sql = "UPDATE tamales SET sabortamal=?, tipohoja=?, cantidad=?, precio=?, tamanio=? WHERE id=?";
         
        if($stmt = mysqli_prepare($mysqli, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssi", $param_sabortamal, $param_tipohoja, $param_cantidad, $param_precio, $param_tamanio, $param_id);
            
            // Set parameters
            $param_sabortamal = $sabortamal;
            $param_tipohoja = $tipohoja;
            $param_cantidad = $cantidad;
            $param_precio = $precio;
            $param_tamanio = $tamanio;
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
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
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM tamales WHERE id = ?";
        if($stmt = mysqli_prepare($mysqli, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $sabortamal = $row["sabortamal"];
                    $tipohoja = $row["tipohoja"];
                    $cantidad = $row["cantidad"];
                    $precio = $row["precio"];
                    $tamanio = $row["tamanio"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close connection
        mysqli_close($mysqli);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
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
                        <h2>Editar tamales</h2>
                    </div>
                    <p>or favor, edite los valores de los tamales.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($sabortamal_err)) ? 'has-error' : ''; ?>">
                            <label>sabortamal</label>
                            <input type="text" name="sabortamal" class="form-control" value="<?php echo $sabortamal; ?>">
                            <span class="help-block"><?php echo $sabortamal_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($tipohoja_err)) ? 'has-error' : ''; ?>">
                            <label>tipohoja</label>
                            <input type="text" name="tipohoja" class="form-control" value="<?php echo $tipohoja; ?>">
                            <span class="help-block"><?php echo $tipohoja_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($cantidad_err)) ? 'has-error' : ''; ?>">
                            <label>cantidad</label>
                            <input type="text" name="cantidad" class="form-control" value="<?php echo $cantidad; ?>">
                            <span class="help-block"><?php echo $cantidad_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($precio_err)) ? 'has-error' : ''; ?>">
                            <label>Precio </label>
                            <input type="text" name="precio" class="form-control" value="<?php echo $precio; ?>">
                            <span class="help-block"><?php echo $precio_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($tamanio_err)) ? 'has-error' : ''; ?>">
                            <label>tamanio</label>
                            <input type="text" name="tamanio" class="form-control" value="<?php echo $tamanio; ?>">
                            <span class="help-block"><?php echo $tamanio_err;?></span>
                        </div>
                        
                        
                        
                        
                        
                        
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="crud_tamales.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>