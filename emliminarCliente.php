<?php
// Initialize the session

// Process delete operation after confirmation
if(isset($_POST["name"]) && !empty($_POST["name"])){
    // Include config file
    require_once 'config.php';
    
    // Prepare a select statement
    $sql = "DELETE FROM clientes WHERE name = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_name);
        
        // Set parameters
        $param_name = trim($_POST["name"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            // Records deleted successfully. Redirect to landing page
            header("location: tablaclientes.php");
            exit();
        } else{
            echo "Oops! Algo anda mal, por favor intentalo mas tarde.";
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
    // Close connection
    mysqli_close($link);
} else{
    // Check existence of id parameter
    if(empty(trim($_GET["name"]))){
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
    <title>Eliminar Tamal</title>
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
                        <h1>Eliminar Tamal</h1>
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger fade in">
                            <input type="hidden" name="name" value="<?php echo trim($_GET["name"]); ?>"/>
                            <p>Estas segur@ de eliminar esto?</p><br>
                            <p>
                                <input type="submit" value="Sí" class="btn btn-dark">
                                <a href="tablaclientes.php" class="btn btn-default">No</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>