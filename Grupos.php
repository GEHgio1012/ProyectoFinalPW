<?php
    include 'conexion.php';
    include 'encabezado.php';
?>

<?php
    if (isset($_POST['ingreso'])) {
        # code...
        $nombre=$_POST['nombre'];
        $year1=$_POST['year1'];
        $year2=$_POST['year2'];
        $insertar="INSERT INTO Grupos(NombreGru,PeriodoGrup)VALUES('$nombre','$year1-$year2')";
        $resultadp=$conn->query($insertar);
        if (!$resultadp) {
            # code...
            echo 'error al Registrarse';
        }else{
            echo 'Alumno registrado exitosamente';
        }
    }

    if (isset($_POST['cambio'])) {
        # code...

        $idca=$_POST['idca'];
        $nombre=$_POST['nombre'];
        $year=$_POST['year1'];

        $Cambiar="UPDATE Grupos SET NombreGru='$nombre',PeriodoGrup='$year' WHERE IdGrupos='$idca'";
        
        $resultado2=$conn->query($Cambiar);
        
        if (!$resultado2) {
            
            echo 'error al Registrarse '.$conn->error;
        }else{
        }
    }

    if (isset($_GET['del'])) {
        $idb=$_GET['del'];
        $borrar="DELETE FROM Grupos where IdGrupos='$idb'";
        $eliminar=$conn->query($borrar);
        header('location:Grupos.php');
    }
?>

<section class='container mb-5 mt-5'>
    <h2>Lista de grupos</h2>
    <?php
        $grupos='SELECT *FROM Grupos';
        $congrupos=$conn->query($grupos);
    ?>

    <table class='table'>
        <thead>
            <th>Todos Los Grupos</th>
            <td clas='d-flex flex-row-reverse'> <button class='w3-button w3-green w3-round' title="Agregar Grupo Nuevo" onclick='document.getElementById("modalAltagrupo").style.display="block"'><i class="fas fa-plus"></i></button></td>
        </thead>
        
        <tbody>
            <?php
                $re=$conn->query($grupos);
                if ($re->num_rows >0){
                    ?>
                    <tr>
                        <th>id de grupo</th>
                        <th>Nombre del Grupo</th>
                        <th>Periodo del Grupo</th>
                        <th colspan="2">Acciones</th>
                    </tr>
                    <?php
                    while ($filal=$re->fetch_array()) {
                        echo '
                        <tr>
                        <td>'.$filal["IdGrupos"].'</td>
                        <td>'.$filal["NombreGru"].'</td>
                        <td>'.$filal["PeriodoGrup"].'</td>
                        <td><button class="editbtn w3-blue w3-button w3-round" data-bs-toggle="modal" data-bs-target="#ModalEditar" title="Editar Elemento"><i class="far fa-edit"></i></button></td>
                        <td><button onclick="preguntar('.$filal["IdGrupos"].')" class="w3-red w3-button w3-round" title="Borrar Elemento"><i class="far fa-trash-alt"></i></button></td>
                        </tr>
                        ';
                    }
                    
                    
                    
                } else {
                    echo "<td ROWSPAN='8'>No hay Grupos registrados</td>";
                }
            ?>
        </tbody>
    </table>
    </section>

<div class="c modal" tabindex="-1" id='modalAltagrupo'>
    <style>
        .c{
            background-color: rgba(0, 0, 0,0.6);
        }
    </style>
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Añadir Nuevo Grupo</h5>
        <button type="button" onclick="document.getElementById('modalAltagrupo').style.display='none'" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h4 class='mb-4'>Porfavor, ingrese los datos solicitados.</h4>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <label for="nombre">Nombre del Grupo</label>
            <input type="text" class='w3-input' name='nombre' placeholder="Nombre del Grupo" required>
            <label for="periodo">Periodo del grupo</label>
            <div class='d-flex col-sm-4 mt-1 mb-1'>
            <input class='w3-input w3-border w3-round' name='year1' type="text" min='0' max='9999' maxlength="4" placeholder="yyyy" pattern="[0-9]{4}" step="1" required> <input class='w3-input w3-border w3-round' placeholder="yyyy" name='year2' type="text" min='0' max='9999' maxlength="4" pattern="[0-9]{4}" step="1" required>
            </div>
            <div class="modal-footer">
        <button type="button" onclick="document.getElementById('modalAltagrupo').style.display='none'" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <input type="submit" name='ingreso' class='btn btn-primary' value="Guardar">
      </div>
      </form>
    </div>
  </div>
</div>
</div>

<!-- Modal para editar-->
<div class="modal fade" id="ModalEditar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Datos del Alumno</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
        <div class="modal-body">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <input type="hidden" name='idca' id='update_id'>
            <label for="nombre">Nombre del Grupo</label>
            <input type="text" class='w3-input' name='nombre' id='nombre' placeholder="Nombre del Grupo" required>
            <label for="periodo">Periodo del grupo</label>
            <div class='d-flex col-sm-4 mt-1 mb-1'>
            <input class='w3-input w3-border w3-round' id='year1' name='year1' type="text" required>
            </div>
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
        $('#nombre').val(datos[1]);
        $('#year1').val(datos[2]);
    })
</script>
                    

<!--Comando para confirmar el borrado de un registro y posteriormente borrarlo-->
<script>
    function preguntar(IdGrupos){
        if(confirm('¿Estas seguro que quieres Eliminar este alumno?.')){
            window.location.href='Grupos.php?del='+IdGrupos;
        }
    }
</script>

<?php
    include 'pie.php';
?>