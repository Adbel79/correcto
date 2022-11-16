<?php
// Initialize the session
session_start();
 
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
    //if($_SESSION['usertype'] != 2)
           header("location: login.php");
  exit;
}

// Check existence of id parameter before processing further

if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Include config file
    require_once 'config.php';
    
    // Prepare a select statement
    $sql = "SELECT * FROM tamales WHERE id = ?";
    
    if($stmt = mysqli_prepare($mysqli, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Set parameters
        $param_id = trim($_GET["id"]);
        
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
    mysqli_close($mysqli);
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
                        <h1>View Record</h1>
                    </div>
                    <div class="form-group">
                        <label>Sabor del tamal</label>
                        <p class="form-control-static"><?php echo $row["sabortamal"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Tipo hoja</label>
                        <p class="form-control-static"><?php echo $row["tipohoja"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Cantidad </label>
                        <p class="form-control-static"><?php echo $row["cantidad"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Precio</label>
                        <p class="form-control-static"><?php echo $row["precio"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Tamaño</label>
                        <p class="form-control-static"><?php echo $row["tamanio"]; ?></p>
                    </div>
                    <p><a href="crud_tamales.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>