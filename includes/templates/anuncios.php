<?php
//Importar la conexion
require __DIR__ . '/../config/database.php';
$db = conectarDB();

//Consultar
$query = "SELECT * FROM propiedades LIMIT ${limite}";


//Obtener resultado
$resultado = mysqli_query($db, $query);

?>

<div class="contenedor-anuncios">
    <?php while($propiedad = mysqli_fetch_assoc($resultado)): ?>
        <div class="anuncio">
            <img src="/imagenes/<?php echo $propiedad['imagen']; ?>" alt="Anuncio" loading="lazy">
            <div class="contenido-anuncio">
                <h3><?php echo $propiedad['titulo']; ?></h3>
                <p><?php echo $propiedad['descripcion']; ?></p>
                <p class="precio">$<?php echo $propiedad['precio']; ?></p>

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

                <a href="anuncio.php?id=<?php echo $propiedad['id']; ?>" class="btn-amarillo-block">
                    Ver Propiedad
                </a>
            </div> <!--.contenido-anuncio-->
        </div><!--.anuncio-->
    <?php endwhile; ?>
</div><!--.contenedor-anuncios-->

<?php
//Cerrar la conexion
    mysqli_close($db);
?>