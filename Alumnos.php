
<?php
    include 'encabezado.php';
    include 'conexion.php';
?>

<?php
    if (isset($_GET['del'])) {
        $idb=$_GET['del'];
        $borrar="DELETE FROM Alumnos where IdAlumnos='$idb'";
        $eliminar=$conn->query($borrar);
        header('location:Alumnos.php');
    }
    if (isset($_POST['ingreso'])) {
        # code...
        
        $nombre=$_POST['nombre'];
        $fecha=$_POST['fecha'];
        $ciudad=$_POST['ciudad'];
        $email=$_POST['email'];
        $genero=$_POST['genero'];
        $matriula=$_POST['matricula'];
        $grado=$_POST['grado'];
        $grupos=$_POST['grupos'];
        $insertar="INSERT INTO Alumnos(NombreAl,FechaNac,Matricula,Ciudad,Genero,Correo,Grado,IdGrupo) VALUES ('$nombre','$fecha','$matriula','$ciudad','$genero','$email','$grado','$grupos')";
        
        $resultadp=$conn->query($insertar);
        if (!$resultadp) {
            
            echo 'error al Registrarse '.$conn->error;
        }else{
        
        }
    }

    if (isset($_POST['cambio'])) {
        # code...

        $idca=$_POST['idca'];
        $nombre=$_POST['nombre'];
        $fecha=$_POST['fecha'];
        $ciudad=$_POST['ciudad'];
        $email=$_POST['email'];
        $genero=$_POST['genero'];
        $matriula=$_POST['matricula'];
        $grado=$_POST['grado'];
        $grupos=$_POST['grupos'];

        $Cambiar="UPDATE Alumnos SET NombreAl='$nombre',FechaNac='$fecha',Matricula='$matriula',Ciudad='$ciudad',Genero='$genero',Correo='$email',Grado='$grado',IdGrupo='$grupos' WHERE IdAlumnos='$idca'";
        
        $resultado2=$conn->query($Cambiar);
        
        if (!$resultado2) {
            
            echo 'error al Registrarse '.$conn->error;
        }else{
        }
    }
?>

<section class='container mb-5 mt-5'>
    <h2 class='mt-5'>Alumnos Registrados</h2>
    <?php
        $coman='SELECT * FROM Alumnos';
        $datos=$conn->query($coman);
    ?>
    <table class='table mb-5 mt-5'>
        
        <thead>
            <th>TODOS LOS ALUMNOS</th>
               <td colspan="6" class='d-flex justify-content-start'> <button class='w3-green w3-button w3-round' title="Agregar Alumno" onclick='document.getElementById("modalAlta").style.display="block"'><i class="fas fa-plus"></i></button></td>
               
        </thead>
            
        <tbody>
            <?php
                $sql="SELECT * FROM Alumnos";
                $re=$conn->query($sql);
                if ($re->num_rows >0){
                    ?>
                    <tr>
                        <th>Id</th>
                        <th>Matricula</th>
                        <th>Nombre</th>
                        <th>Fecha de Nacimiento</th>
                        <th>Ciudad</th>
                        <th>Genero</th>
                        <th>Correo</th>
                        <th>Grado</th>
                        <th>Id de Grado</th>
                        <th colspan="2">Acciones</th>
                    </tr>
                    
                    <?php
                    while ($filal=$re->fetch_array()) {
                        include 'RAlumnos/BorrarAL.php';
                        echo '
                        <tr>
                        <td>'.$filal["IdAlumnos"].'</td>
                        <td>'.$filal["Matricula"].'</td>
                        <td>'.$filal["NombreAl"].'</td>
                        <td>'.$filal["FechaNac"].'</td>   
                        <td>'.$filal["Ciudad"].'</td>
                        <td>'.$filal["Genero"].'</td>
                        <td>'.$filal["Correo"].'</td>
                        <td>'.$filal["Grado"].'</td>
                        <td>'.$filal["IdGrupo"].'</td>
                        <td><button type="button" id="editbtn" class="editbtn w3-blue w3-button w3-round" data-bs-toggle="modal" data-bs-target="#ModalEditar"><i class="far fa-edit"></i></button></td>';
                        echo "<td><button onclick='preguntar(".$filal['IdAlumnos'].")' class='w3-button w3-round w3-red' title='Borrar Elemento'><i class='far fa-trash-alt'></i></button></td>
                        </tr>
                        ";
                    }
                    
                } else {
                    echo "<td ROWSPAN='8'>No hay Alumnos registrados</td>";
                }
            ?>
        </tbody>

    </table>

</section>
<div class="c modal" tabindex="-1" id='modalAlta'>
    <style>
        .c{
            background-color: rgba(0, 0, 0,0.6);
        }
    </style>
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Añadir Alumno</h5>
        <button type="button" onclick="document.getElementById('modalAlta').style.display='none'" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h4 class='mb-4'>Porfavor, ingrese los datos solicitados.</h4>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <label for="">Nombre Completo del alumno: </label> 
                    <input class='w3-input' name='nombre' type="text" placeholder="Nombre Completo" required>
                    <label for="">Fecha de Nacimiento: </label>
                    <input class='w3-input' name='fecha' type="date" required>
                    <label for="">Ciudad: </label>
                    <input class='w3-input' name='ciudad' type="text" placeholder="Ciudad" required>
                    <label for="">Genero: </label>
                    <select class='w3-select' name="genero" id="Genero" required>
                        <option value="Mujer" selected>Fenenino</option>
                        <option value="Hombre">Masculino</option>
                        <option value="Indefinido">Otro</option>
                    </select>
                    <label for="email">Correo: </label>
                    <input class='w3-input' type="email" name='email' id='email' placeholder="Correo Electronico" required>
                    <label for="">Grado: </label>
                    <input class='w3-input' name='grado' type="text" min='1' max='8' maxlength="1" pattern="[1-8]{1}" step="1" required>
                    <label for="">Grupo: </label>
                    <select class='w3-select' name="grupos" id="grupos" required>
                        <?php            
                            $grupoal='SELECT * FROM Grupos';
                            $grupf=$conn->query($grupoal);
                            if ($grupf->num_rows >0) {
                                while ($fila=$grupf->fetch_array()) {
                                    ?>
                                    <option value="<?php echo $fila['IdGrupos'];?>"><?php echo $fila['NombreGru'].' '.$fila['PeriodoGrup'];?></option>
                                    <?php
                                }
                            }else{
                                ?>
                                    
                                <?php
                            }
                            
                            
                           
                        ?>
                    </select>
                    <label for="">Matricula</label>
                    <input type="text" name='matricula' class="w3-input" placeholder="Matricula">
            
        
      <div class="modal-footer">
        <button type="button" onclick="document.getElementById('modalAlta').style.display='none'" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <input type="submit" name='ingreso' class='btn btn-primary' value="Guardar">
      </div>
      </form>
    </div>
  </div>
</div>
</div>


<script>
    function preguntar(IdAlumnos){
        if(confirm('¿Estas seguro que quieres Eliminar este alumno?.')){
            window.location.href='Alumnos.php?del='+IdAlumnos;
        }
    }
</script>




<!-- Modal para editar-->
<div class="modal fade" id="ModalEditar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Datos del Alumno</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <div class="modal-body">
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <input type="hidden" name='idca' id='update_id'>
                    <label for="">Nombre Completo del alumno: </label> 
                    <input class='w3-input' id='nombre' name='nombre' type="text" placeholder="Nombre Completo" required>
                    <label for="">Fecha de Nacimiento: </label>
                    <input class='w3-input' id='fecha' name='fecha' type="date" required>
                    <label for="">Ciudad: </label>
                    <input class='w3-input' id='ciudad' name='ciudad' type="text" placeholder="Ciudad" required>
                    <label for="">Genero: </label>
                    <select class='w3-select' name="genero" id="Genero" required>
                        <option value="Mujer">Fenenino</option>
                        <option value="Hombre">Masculino</option>
                        <option value="Indefinido">Otro</option>
                    </select>
                    <label for="">Correo: </label>
                    <input class='w3-input' type="text" name='email' id='emeil' placeholder="Correo Electronico" required>
                    <label for="">Grado: </label>
                    <input class='w3-input' id='grado' name='grado' type="text" min='1' max='8' maxlength="1" pattern="[1-8]{1}" step="1" required>
                    <label for="">Grupo: </label>
                    <select class='w3-select' name="grupos" id="grupos" required>
                        <?php            
                            $grupoal='SELECT * FROM Grupos';
                            $grupf=$conn->query($grupoal);
                            if ($grupf->num_rows >0) {
                                while ($fila=$grupf->fetch_array()) {
                                    ?>
                                    <option value="<?php echo $fila['IdGrupos'];?>"><?php echo $fila['NombreGru'].' '.$fila['PeriodoGrup'];?></option>
                                    <?php
                                }
                            }else{
                                ?>
                                    
                                <?php
                            }
                            
                            
                           
                        ?>
                    </select>
                    <label for="">Matricula</label>
                    <input type="text" name='matricula' id='matricula' class="w3-input" placeholder="Matricula">
            
        
      <div class="modal-footer">
        <button type="button" class="w3-button w3-round w3-border" data-bs-dismiss="modal">Cerrar</button>
        <input type="submit" name='cambio' class='w3-button w3-blue w3-round w3-border' value="Guardar Cambios">
      </div>
      </form>
      </div>
    </div>
  </div>
</div>

<!--script para el modal editar-->
<script>
    $('.editbtn').on('click',function(){
        $tr=$(this).closest('tr');
        var datos=$tr.children("td").map(function(){
            return $(this).text();
        });

        $('#update_id').val(datos[0]);
        $('#matricula').val(datos[1]);
        $('#nombre').val(datos[2]);
        $('#fecha').val(datos[3]);
        $('#ciudad').val(datos[4]);
        $('#Genero').val(datos[5]);
        $('#emeil').val(datos[6]);
        $('#grado').val(datos[7]);
        $('#grupos').val(datos[8]);
    })
</script>
                    

<?php
    include 'pie.php';
?>
<!--
    Lineas de respaldo
    <button class='w3-button w3-round'><i class="fas fa-trash"></i></button>
-->