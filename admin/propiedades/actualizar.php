<?php

require '../../includes/funciones.php';
$auth = Autenticado();
if(!$auth) {
    header('Location: /');
}

//Validar que el GET reciba unicamente un ID
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

if(!$id) {
    header('Location: /admin');
}

//Base de datos
require '../../includes/config/database.php';
$db = conectarDB();

//Consulta para obtener los datos de la propiedad
$consulta = "SELECT * FROM propiedades WHERE id = ${id}";
$resultado = mysqli_query($db,$consulta);
$propiedad = mysqli_fetch_assoc($resultado);

//Consultar para obtener vendedores
$consulta = " SELECT * FROM vendedores ";
$resultado = mysqli_query($db,$consulta);

//Arreglo con mensajes de errores
$errores = [];

$titulo = $propiedad['titulo'];
$precio = $propiedad['precio'];
$descripcion = $propiedad['descripcion'];
$habitaciones = $propiedad['habitaciones'];
$baños = $propiedad['baños'];
$estacionamientos = $propiedad['estacionamientos'];
$vendedorId = $propiedad['vendedorId'];
$imagenPropiedad = $propiedad['imagen'];


//Ejecutar el codigo despues de que el usuario envia el formulario
if($_SERVER['REQUEST_METHOD'] === 'POST') {

    $titulo = mysqli_real_escape_string($db, $_POST['titulo']);
    $precio = mysqli_real_escape_string($db, $_POST['precio']);
    $descripcion = mysqli_real_escape_string($db, $_POST['descripcion']);
    $habitaciones = mysqli_real_escape_string($db, $_POST['habitaciones']);
    $baños = mysqli_real_escape_string($db, $_POST['baños']);
    $estacionamientos = mysqli_real_escape_string($db, $_POST['estacionamientos']);
    $vendedorId = mysqli_real_escape_string($db, $_POST['vendedor']);
    $creado = date("Y/m/d");

    //Asignar files a una variable
    $imagen = $_FILES['imagen'];

    if(!$titulo) {
        $errores[] = "Debes añadir un titulo";
    }
    if(!$precio) {
        $errores[] = "Debes añadir un precio";
    }
    if(strlen($descripcion) < 50) {
        $errores[] = "Debes añadir una descripcion que contenga, al menos, 50 caracteres";
    }
    if(!$habitaciones) {
        $errores[] = "Debes añadir un numero de habitaciones";
    }
    if(!$baños) {
        $errores[] = "Debes añadir un numero de baños";
    }
    if(!$estacionamientos) {
        $errores[] = "Debes añadir un numero de estacionamientos";
    }
    if(!$vendedorId) {
        $errores[] = "Elije un vendedor";
    }

    //Validad por tamaño (1mb max)
    $medida = 1000 * 1000;

    if($imagen['size'] > $medida) {
        $errores[] = "La imagen es muy pesada";
    }

    //Revisar que el arreglo de errores esté vacio
    if(empty($errores)) {
        //Crear carpeta
        $carpetaImagenes = '../../imagenes/';

        if(!is_dir($carpetaImagenes)) {
            mkdir($carpetaImagenes);
        }

        $nombreImagen = '';

        //ACTUALIZAR IMAGENE
        if($imagen['name']) {
            //Eliminar la imagen previa
            unlink($carpetaImagenes . $propiedad['imagen']);
            
            //Generar nombre unico
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

            //Subir la imagen
            move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);
        } else {
            $nombreImagen = $propiedad['imagen'];
        }

        //ACTUALIZAR la BD
        $query = "UPDATE propiedades SET titulo = '${titulo}', precio = ${precio}, imagen = '${nombreImagen}', descripcion = '${descripcion}', habitaciones = ${habitaciones}, baños = ${baños}, estacionamientos = ${estacionamientos}, vendedorId = ${vendedorId} WHERE id = ${id} ";

        $resultado = mysqli_query($db,$query);

        if($resultado) {
            //Redireccionar al usuario
            header('Location: /admin?resultado=2');
        }
    }
}

    incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Actualizar</h1>

    <a href="/admin" class="btn btn-verde">Volver</a>

    <?php foreach($errores as $error): ?>

    <div class="alerta error">
        <?php echo $error; ?>
    </div>

    <?php endforeach; ?>

<!--Get guarda los datos el Name en la URL SIRVE PARA OBTENER DATOS DEL SERVIDOR-->
<!--Post los maneja internamente en el archivo SIRVE PARA ENVIAR DATOS DEL SERVIDOR-->
    <form class="formulario" method="POST" enctype="multipart/form-data">
        <fieldset>
            <legend>Informacion General</legend>

            <label for="titulo">Titulo:</label>
            <input name="titulo" type="text" id="titulo" placeholder="Titulo Propiedad" value="<?php echo $titulo; ?>">
            
            <label for="precio">Precio:</label>
            <input name="precio" type="number" id="precio" placeholder="Precio Propiedad" value="<?php echo $precio; ?>">

            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" accept="image/jpeg, imagen/png" name="imagen">
            <img src="/imagenes/<?php echo $propiedad['imagen']; ?>" class="imagen-small" alt="Imagen propiedad">

            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" id="descripcion"><?php echo $descripcion; ?></textarea>
        </fieldset>

        <fieldset>
            <legend>Información Propiedad</legend>

            <label for="habitaciones">Habitaciones:</label>
            <input name="habitaciones" type="number" id="habitaciones" placeholder="Cantidad de habitaciones" min="1" max="10" value="<?php echo $habitaciones; ?>">
            
            <label for="baños">Baños:</label>
            <input name="baños" type="number" id="baños" placeholder="Cantidad de baños" min="1" max="10" value="<?php echo $baños; ?>">

            <label for="estacionamientos">Estacionamientos:</label>
            <input name="estacionamientos" type="number" id="estacionamiento" placeholder="Cantidad de estacionamientos" min="1" max="10" value="<?php echo $estacionamientos; ?>">
        </fieldset>

        <fieldset>
            <legend>Vendedor</legend>

            <select name="vendedor">
                <option value="" selected>--Seleccione un vendedor--</option>
                <?php while($vendedor = mysqli_fetch_assoc($resultado)): ?>

                    <option <?php echo $vendedorId === $vendedor['id'] ? 'selected' : ''; ?> value="<?php echo $vendedor['id']; ?>"> <?php echo $vendedor['nombre'] . " " . $vendedor['apellido']; ?></option>

                <?php endwhile; ?>
            </select>
        </fieldset>

        <div class="alinear-derecha">
            <input name="" type="submit" value="Actualizar Propiedad" class="btn btn-verde">
        </div>
    </form>
</main>

<?php
    incluirTemplate('footer');
?>