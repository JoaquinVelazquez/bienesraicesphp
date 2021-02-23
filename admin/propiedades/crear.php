<?php
require '../../includes/funciones.php';
$auth = Autenticado();
if(!$auth) {
    header('Location: /');
}

//Base de datos
require '../../includes/config/database.php';
$db = conectarDB();

//Consultar para obtener vendedores
$consulta = " SELECT * FROM vendedores ";
$resultado = mysqli_query($db,$consulta);

//Arreglo con mensajes de errores
$errores = [];

$titulo = '';
$precio = '';
$descripcion = '';
$habitaciones = '';
$baños = '';
$estacionamientos = '';
$vendedorId = '';


//Ejecutar el codigo despues de que el usuario envia el formulario
if($_SERVER['REQUEST_METHOD'] === 'POST') {

    // echo "<pre>";
    // var_dump($_POST);
    // echo "</pre>";

    // echo "<pre>";
    // var_dump($_FILES);
    // echo "</pre>";

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

    var_dump($imagen['name']);


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
    if(!$imagen['name'] || $imagen['error']) {
        $errores[] = "Sube una foto de la propiedad";
    }

    //Validad por tamaño (1mb max)
    $medida = 1000 * 1000;

    if($imagen['size'] > $medida) {
        $errores[] = "La imagen es muy pesada";
    }

    // echo "<pre>";
    // var_dump($errores);
    // echo "</pre>";

    //Revisar que el arreglo de errores esté vacio
    if(empty($errores)) {

        //SUBIDA DE ARCHIVOS
        //Crear carpeta
        $carpetaImagenes = '../../imagenes/';

        if(!is_dir($carpetaImagenes)) {
            mkdir($carpetaImagenes);
        }

        
        $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

        //Subir la imagen
        move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);

        //Insertar en la BD
        $query = "INSERT INTO propiedades(titulo, precio, imagen, descripcion, habitaciones, baños, estacionamientos, creado, vendedorId ) VALUES ('$titulo', '$precio', '$nombreImagen', '$descripcion', '$habitaciones', '$baños', '$estacionamientos', '$creado', '$vendedorId')";
        
        $resultado = mysqli_query($db,$query);

        if($resultado) {
            //Redireccionar al usuario
            header('Location: /admin?resultado=1');
        }
    }
}
    incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Crear</h1>

    <a href="/admin" class="btn btn-verde">Volver</a>

    <?php foreach($errores as $error): ?>

    <div class="alerta error">
        <?php echo $error; ?>
    </div>

    <?php endforeach; ?>

<!--Get guarda los datos el Name en la URL SIRVE PARA OBTENER DATOS DEL SERVIDOR-->
<!--Post los maneja internamente en el archivo SIRVE PARA ENVIAR DATOS DEL SERVIDOR-->
    <form class="formulario" method="POST" action="/admin/propiedades/crear.php" enctype="multipart/form-data">
        <fieldset>
            <legend>Informacion General</legend>

            <label for="titulo">Titulo:</label>
            <input name="titulo" type="text" id="titulo" placeholder="Titulo Propiedad" value="<?php echo $titulo; ?>">
            
            <label for="precio">Precio:</label>
            <input name="precio" type="number" id="precio" placeholder="Precio Propiedad" value="<?php echo $precio; ?>">

            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" accept="image/jpeg, imagen/png" name="imagen">

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
            <input type="submit" value="Crear Propiedad" class="btn btn-verde">
        </div>
    </form>
</main>

<?php
    incluirTemplate('footer');
?>