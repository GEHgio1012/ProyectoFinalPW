<?php
    include 'encabezado.php';
    include 'conexion.php';
?>

    <?php
        if (isset($_POST['newma'])) {
            # code...
            $nombreg=$_POST['nombre'];
            $clave=$_POST['clave'];
            $grado=$_POST['grado'];

            $coninsert="INSERT INTO Materias(Nombre,Clave,Grado) VALUES('$nombreg','$clave','$grado') ";
            $insert=$conn->query($coninsert);
            if (!$insert) {
                # code...
                echo '
                <div class="container">
                <div class="w3-panel w3-pale-red w3-round w3-leftbar w3-rightbar w3-border-red">
                <h2>ERROR FATAL!</h2>
                <p>No puedes poner una matricula similar a otra materia</p>
                </div> 
                </div>
                ';           
            }
        }

        if (isset($_POST['addmagup'])) {
            # code...
            $magru3='SELECT * FROM Materias';
            $conmg3=$conn->query($magru3);
            while ($filag3=$conmg3->fetch_array()) {
                if ($fila3['Id']) {
                    # code...
                }
            }
            
            $coninsert="INSERT INTO MateriasGrupo(Nombre,Clave,Grado) VALUES('$nombreg','$clave','$grado') ";
            $insert=$conn->query($coninsert);
            if (!$insert) {
                # code...
                echo '
                <div class="container">
                <div class="w3-panel w3-pale-red w3-round w3-leftbar w3-rightbar w3-border-red">
                <h2>ERROR FATAL!</h2>
                <p>No puedes poner una matricula similar a otra materia</p>
                </div> 
                </div>
                ';           
            }
        }


        if (isset($_POST['edicion'])) {
            # code...
    
            $idca=$_POST['id'];
            $nombre=$_POST['nombre'];
            $clave=$_POST['clave'];
            $grado=$_POST['grado'];
    
            $Cambiar="UPDATE Materias SET Nombre='$nombre',Clave='$clave',Grado='$grado' WHERE IdMateria='$idca'";
            
            $resultado2=$conn->query($Cambiar);
            
            if (!$resultado2) {
                
                echo 'error al Registrarse '.$conn->error;
            }else{
            }
        }

        if (isset($_GET['del'])) {
            $idb=$_GET['del'];
            $borrar="DELETE FROM Materias where IdMateria='$idb'";
            $eliminar=$conn->query($borrar);
            header('location:Materias.php');
        }
    ?>
    
    <section class='container mb-5 mt-5'>
    <h2>Lista de materias</h2>
    <?php
        $conmateria='SELECT * FROM Materias';
        $conexionm=$conn->query($conmateria);
    ?>
    
    <table class='mt-5 mb-5 table'>
        <thead>
            <th>Todas Las materias</th>
            <th><button class='w3-button w3-round w3-green' name='new' data-bs-toggle="modal" data-bs-target="#addmateria" title='Agregar Nueva Matera'><i class="fas fa-plus"></i></button></th>
        </thead>

        <tbody>
            <?php
                if ($conexionm->num_rows >0){
                    ?>
                    <tr>
                        <th>Id de Materia</th>
                        <th>Nombre</th>
                        <th>Clave</th>
                        <th>Grado</th>
                        <th colspan="2">Acciones</th>
                    </tr>
                    
                    <?php
                    while ($fila=$conexionm->fetch_array()) {
                        # code...
                        echo "
                        <tr>
                            <td>".$fila['IdMateria']."</td>
                            <td>".$fila['Nombre']."</td>
                            <td>".$fila['Clave']."</td>
                            <td>".$fila['Grado']."</td>
                            <td><button class='editma w3-blue w3-button w3-round' data-bs-toggle='modal' data-bs-target='#modalEditar' title='Editar Elemento'><i class='far fa-edit'></i></button></td>
                            <td><button onclick='preguntar(".$fila['IdMateria'].")' class='w3-red w3-button w3-round' title='Borrar Elemento'><i class='far fa-trash-alt'></i></button></td>

                        </tr>
                        ";
                    }
                }else{
                    ?>
                       
                    <td colspan="5">no hay ninguna materia registrada</td>
                    <?php
                }
            ?>
        </tbody>
    </table>
    </section>

    

<section class='container mt-5 mb-5'>
<h2>Grupos disponibles</h2>

<?php

    $gruposc='SELECT * FROM Grupos';
    $congrup=$conn->query($gruposc);

    $magru='SELECT * FROM MateriasGrupo';
    $conmg=$conn->query($magru);
    if ($congrup->num_rows >0) {
        # code...
        while (($filag=$congrup->fetch_array())||($filamg=$conmg->fetch_array())) {
            echo '
            <p class="d-grid gap-1 mb-4">
                <button class="w3-button w3-round w3-border " type="button" data-bs-toggle="collapse" data-bs-target="#collapse'.$filag['IdGrupos'].'" aria-expanded="false" aria-controls="collapseExample">
                    '.$filag['NombreGru'].' '.$filag['PeriodoGrup'].'
                </button>
            </p>
            <div class="collapse mb-5" id="collapse'.$filag['IdGrupos'].'">
               '; 
                    if ($filamg['IdGrupo']==$filag['IdGrupos']) {
                        # code...
                    }else{
                        echo'Aun no hay materias enlazadas a este grupo <br><br><br><button name="addmg" data-bs-toggle="modal" data-bs-target="#addmagu" class="w3-button w3-round w3-green">Agregar Materias</button>';
                    }
               
            echo '</div>
            ';
        }
    }else{
        echo 'No hay Grupos registrados';
    }

    
?>
</section>
<div class="card card-body">
                    Prueba de que si sirven los collapse
                </div>
<!-- Modal  que inserta materias-->
<div class="modal fade" id="addmateria" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nueva Materia</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method='POST'>
            <label for="">Materia:</label> 
            <input class='w3-input' name='nombre' type="text" placeholder="Nombre de Materia" required>
            <label for="">Clave:</label>
            <input class='w3-input' name='clave' placeholder="Clave de materia" type="text" required>
            <label for="">Grado: </label>
            <select name="grado" class='w3-select' id="grado" required>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>

            </select>
            
      </div>
      <div class="modal-footer">
        <button type="button" class="w3-button w3-border w3-round" data-bs-dismiss="modal">Cancelar</button>
        <input type="submit" name='newma' class="w3-button w3-blue w3-round" value='Añadir materia'>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- Modal  que edita materias-->
<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modificar Materia</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method='POST'>
            <input type="hidden" id='update_id' name='id'>
            <label for="">Materia:</label> 
            <input class='w3-input' id='nombre' name='nombre' type="text" placeholder="Nombre de Materia" required>
            <label for="">Clave:</label>
            <input class='w3-input' id='clave' name='clave' placeholder="Clave de materia" type="text" required>
            <label for="">Grado: </label>
            <select name="grado" class='w3-select' id="grado" required>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>

            </select>
            
      </div>
      <div class="modal-footer">
        <button type="button" class="w3-button w3-border w3-round" data-bs-dismiss="modal">Cancelar</button>
        <input type="submit" name='edicion' class="w3-button w3-blue w3-round" value='Añadir materia'>
        </form>
      </div>
    </div>
  </div>
</div>

<!--script para el modal editar-->
<script>
    $('.editma').on('click',function(){
        $tr=$(this).closest('tr');
        var datos=$tr.children("td").map(function(){
            return $(this).text();
        });

        $('#update_id').val(datos[0]);
        $('#nombre').val(datos[1]);
        $('#clave').val(datos[2]);
        $('#grado').val(datos[3]);
    })
</script>

<!--Comando para confirmar el borrado de un registro y posteriormente borrarlo-->
<script>
    function preguntar(IdMateria){
        if(confirm('¿Estas seguro que quieres Eliminar este alumno?.')){
            window.location.href='Materias.php?del='+IdMateria;
        }
    }
</script>
<!--Modal para agregar materias a un grupo-->
<div class="modal fade" id="addmagu" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Materias Disponibles</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method='POST'>
        <?php
            $magru2='SELECT * FROM Materias';
            $conmg2=$conn->query($magru2);
            $grupos2='SELECT * FROM Grupos';

            while ($filagm=$conmg2->fetch_array()) {
                echo '
                <div class="form-check">
                    <input class="form-check-input" name="'.$filagm['IdMateria'].'" type="checkbox" value="'.$filagm['IdMateria'].'" id="defaultCheck'.$filagm['IdMateria'].'">
                    <label class="form-check-label" for="defaultCheck'.$filagm['IdMateria'].'">
                        '.$filagm['Nombre'].'
                    </label>
                </div>
                ';
            }
        ?>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="w3-button w3-border w3-round" data-bs-dismiss="modal">Cancelar</button>
        <input type="submit" name='addmagup' class="w3-button w3-blue w3-round" value='Añadir materia'>
        </form>
      </div>
    </div>
  </div>
</div>

<?php
    include 'pie.php';
?>