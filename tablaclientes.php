
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <link rel="stylesheet" type="text/css" href="bootstrap337/css/bootstrap.min.css">
    </head>
    <body>
        <div class="table responsive">
             <?php
                    // Include config file
                    require_once 'config.php';
                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM clientes";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>Nombre</th>";
                                        echo "<th>Dirección</th>";
                                        echo "<th>Fecha de nacimiento</th>";
                                        echo "<th>Teléfono</th>";
                                        echo "<th>Correo</th>";
                                        echo "<th>Foto</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['name'] . "</td>";
                                        echo "<td>" . $row['direccion'] . "</td>";
                                        echo "<td>" . $row['fechaN'] . "</td>";
                                        echo "<td>" . $row['telefono'] . "</td>";
                                         echo "<td>" . $row['correo'] . "</td>";
                                        echo "<td>" . $row['foto'] . "</td>"; 
                                        echo "<td>";
                                            echo "<a href='infoCliente.php?name=". $row['name'] ."' title='Ver tamal ' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                                            echo "<a href='modificarCliente.php?name=". $row['name'] ."' title='Modificar Datos' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                            echo "<a href='emliminarCliente.php?name=". $row['name'] ."' title='Eliminar Cliente' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
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
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                    }
 
                    // Close connection
                    mysqli_close($link);
                    ?>
        </div>
        <script src="bootstrap337/js/bootstrap.min.js"></script>
        <script src="bootstrap337/js/jqueryv1.12.4.min.js"></script>
    </body>
</html>