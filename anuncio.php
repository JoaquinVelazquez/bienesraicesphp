<?php
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if(!$id) {
        header('Location: /');
    }

    //Importar la conexion
    require 'includes/config/database.php';
    $db = conectarDB();

    //Consultar
    $query = "SELECT * FROM propiedades WHERE id = ${id}";


    //Obtener resultado
    $resultado = mysqli_query($db, $query);

    if(!$resultado->num_rows) {
        header('Location: /');
    }

    $propiedad = mysqli_fetch_assoc($resultado);

    require 'includes/funciones.php';
    incluirTemplate('header');
?>

<main class="contenedor seccion contenido-centrado">
    <h1><?php echo $propiedad['titulo']; ?></h1>


        <source srcset="build/img/destacada.webp" type="imagen/webp">
        <source srcset="build/img/destacada.jpg" type="imagen/jpeg">
        <img src="/imagenes/<?php echo $propiedad['imagen']; ?>" alt="Anuncio" loading="lazy">


    <div class="resumen-propiedad">
        <p class="precio">$<?php echo $propiedad['precio']; ?>0</p>

        <ul class="iconos-caracteristicas">
            <li>
                <img class="icono" src="build/img/icono_wc.svg" alt="Icono Baños">
                <p><?php echo $propiedad['baños']; ?></p>
            </li>
            <li>
                <img class="icono" src="build/img/icono_estacionamiento.svg" alt="Icono Estacionamiento">
                <p><?php echo $propiedad['estacionamientos']; ?></p>
            </li>
            <li>
                <img class="icono" src="build/img/icono_dormitorio.svg" alt="Icono Dormitorios">
                <p><?php echo $propiedad['habitaciones']; ?></p>
            </li>
        </ul>

        <p><?php echo $propiedad['descripcion']; ?></p>
    </div>
</main>

<?php
    mysqli_close($db);
    incluirTemplate('footer');
?>