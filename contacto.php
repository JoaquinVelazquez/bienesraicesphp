<?php
    require 'includes/funciones.php';
    incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Contacto</h1>

    <picture>
        <source srcset="build/img/destacada3.webp" type="image/webp">
        <source srcset="build/img/destacada3.jpg" type="image/jpeg">
        <img src="build/img/destacada3.jpg" alt="Imagen contacto">
    </picture>

    <h2>Llene el formulario de contacto</h2>

    <form action="" class="formulario">
        <fieldset>
            <legend>Informacion Personal</legend>

            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" placeholder="Tu Nombre">

            <label for="email">E-Mail</label>
            <input type="email" id="email" placeholder="Tu Email">
            
            <label for="telefono">Telefono</label>
            <input type="tel" id="telefono" placeholder="Tu Telefono">
            
            <label for="mensaje">Mensaje:</label>
            <textarea name="" id="mensaje"></textarea>
        </fieldset>
        <fieldset>
            <legend>Informacion de la propiedad</legend>

            <label for="opciones">Vende o Compra:</label>
            <select name="" id="opciones">
                <option value="" disabled selected>--Seleccione--</option>
                <option value="Compra">Compra</option>
                <option value="Vende">Vende</option>
            </select>

            <label for="presupuesto">Precio o Presupuesto</label>
            <input type="number" min="0" id="presupuesto" placeholder="Inserte presupuesto o precio">
        </fieldset>

        <fieldset>
            <legend>Contacto</legend>

            <p>Como desea ser contactado</p>
            <div class="forma-contacto">
                <label for="contactar-telefono">Telefono</label>
                <input name="contacto" type="radio" value="telefono" id="contactar-telefono">

                <label for="contactar-email">E-mail</label>
                <input name="contacto" type="radio" value="email" id="contactar-email">
            </div>

            <p>Si eligio telefono, elija la fecha y la hora a ser contactado</p>
            <label for="fecha">Fecha</label>
            <input type="date" id="fecha">

            <label for="hora">Hora</label>
            <input type="time" id="hora" min="09:00" max="18:00">
        </fieldset>

        <input type="submit" value="Enviar" class="btn-verde">
    </form>
</main>

<?php
    incluirTemplate('footer');
?>