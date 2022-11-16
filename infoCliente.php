<?php
// Initialize the session
session_start();
 
// Check existence of id parameter before processing further

if(isset($_GET["name"]) && !empty(trim($_GET["name"]))){
    // Include config file
    require_once 'config.php';
    
    // Prepare a select statement
    $sql = "SELECT * FROM clientes WHERE name = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_name);
        
        // Set parameters
        $param_name = trim($_GET["name"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                // Retrieve individual field value
                $name = $row["name"];
                $direccion = $row["direccion"]; 
                $fechaN = $row["fechaN"]; 
                $tel = $row["telefono"]; 
                $correo = $row["correo"];
                $foto = $row["foto"];
               
            } else{
                // URL doesn't contain valid id parameter. Redirect to error page
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
    mysqli_close($link);
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
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
                        <h1>Info del cliente</h1>
                    </div>
                    <div class="form-group">
                        <label>Nombre</label>
                        <p class="form-control-static"><?php echo $row["name"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Direccion</label>
                        <p class="form-control-static"><?php echo $row["direccion"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Fecha de nacimiento </label>
                        <p class="form-control-static"><?php echo $row["fechaN"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Teléfono</label>
                        <p class="form-control-static"><?php echo $row["telefono"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Correo</label>
                        <p class="form-control-static"><?php echo $row["correo"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Foto</label>
                        <p class="form-control-static"><?php echo $row["foto"]; ?></p>
                    </div>
                    <p><a href="crud_tamales.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>