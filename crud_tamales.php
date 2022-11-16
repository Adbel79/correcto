<?php
// Initialize the session
session_start();
 
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
    //if($_SESSION['usertype'] != 2)
           header("location: login.php");
  exit;
}
// Initialize the session
 $username = "";
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: login.php");
  exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="bootstrap337/css/bootstrap.css">
    <script src="bootstrap337/js/jqueryv1.12.4.min.js"></script>
    <script src="bootstrap337/js/bootstrap.js"></script>
    <style type="text/css">
        .wrapper{
            width: 650px;
            margin: 0 auto;
        }
        .page-header h2{
            margin-top: 0;
        }
        table tr td:last-child a{
            margin-right: 15px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <h2 class="pull-left">Detalles de los tamales</h2>
                        <a href="create.php" class="btn btn-success pull-right">Agregar una nueva orden</a>
                       
                    </div>
                    <?php
                    // Include config file
                    require_once 'config.php';
                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM tamales";
                    if($result = mysqli_query($mysqli, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th>Sabor tamal</th>";
                                        echo "<th>Tipo de hoja</th>";
                                        echo "<th>Cantidad</th>";
                                        echo "<th>Precio</th>";
                                        echo "<th>Tamaño</th>";
                                        echo "<th>Opciones</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . $row['sabortamal'] . "</td>";
                                        echo "<td>" . $row['tipohoja'] . "</td>";
                                        echo "<td>" . $row['cantidad'] . "</td>";
                                         echo "<td>" . $row['precio'] . "</td>";
                                        echo "<td>" . $row['tamanio'] . "</td>"; 
                                        echo "<td>";
                                            echo "<a href='read_tamal.php?id=". $row['id'] ."' title='Ver tamal ' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                                            echo "<a href='update_tamal.php?id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                            echo "<a href='delete.php?id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($mysqli);
                    }
 
                    // Close connection
                    mysqli_close($mysqli);
                    ?>
                      <a href="logout.php" class="btn btn-danger">Salir sesion</a>
     
                </div>
            </div>        
        </div>
    </div>
</body>
</html>