<?php
    include 'conexion.php';

    $nombre=$_POST['nombre'];
    $fecha=$_POST['fecha'];
    $ciudad=$_POST['ciudad'];
    $genero=$_POST['genero'];
    $email=$_POST['email'];
    $grado=$_POST['grado'];
    //$grupos=$_POST['grupos'];
    $matriula=$_POST['matricula'];
    $insertar="insert into Alumnos(NombreAl,FechaNac,Matricula,Ciudad,Genero,Grado,IdGrupo) VALUES ('$nombre','$fecha','$matriula','$ciudad','$genero','$grado','$grupos)";
    echo $nombre.$fecha .$ciudad .$genero .$email.$grado .$matriula ;
    /*$resultadp=mysqli_query($conn,$insertar);
    if (!$resultado) {
        # code...
        echo 'error al Registrarse';
    }else{
        echo 'Alumno registrado exitosamente';
    }
    */mysqli_close($conn)
?>
