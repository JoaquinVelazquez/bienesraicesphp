<?php
    require 'includes/funciones.php';
    incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Conoce sobre Nosotros</h1>

    <div class="contenido-nosotros">
        <div class="imagen">
            <picture>
                <source srcset="build/img/nosotros.webp" type="image/webp">
                <source srcset="build/img/nosotros.jpg" type="image/jpeg">
                <img src="build/img/nosotros.jpg" alt="Nosotros.jpg" loading="lazy">
            </picture>
        </div>
        <div class="texto-nosotros">
            <blockquote>
                25 Años de experiencia
            </blockquote>

            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Perferendis ratione provident recusandae quibusdam quisquam, quaerat quam doloribus, quod sapiente quas totam sint mollitia nesciunt cupiditate fugiat. Temporibus dolore ratione dolorem. Lorem ipsum dolor sit amet consectetur adipisicing elit. Iste inventore non alias reiciendis iure asperiores excepturi accusamus nobis deserunt. Minima repellendus commodi rerum quidem necessitatibus? Quis aliquid aut hic quas! Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolor ex sunt placeat consequuntur adipisci temporibus at aperiam dicta pariatur itaque rem hic vel, voluptates amet exercitationem ad nulla, sequi nemo!</p>
        </div>
    </div>
</main>

<section class="contenedor seccion">
    <h1>Más sobre Nosotros</h1>

    <div class="iconos-nosotros">
        <div class="icono">
            <img src="build/img/icono1.svg" alt="Icono Seguridad" loading="lazy">
            <h3>Seguridad</h3>
            <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Consectetur officia debitis similique illo iusto qui eveniet nemo reprehenderit corrupti vero eius minima vel</p>
        </div>
        <div class="icono">
            <img src="build/img/icono2.svg" alt="Icono Precio" loading="lazy">
            <h3>Precio</h3>
            <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Consectetur officia debitis similique illo iusto qui eveniet nemo reprehenderit corrupti vero eius minima vel</p>
        </div>
        <div class="icono">
            <img src="build/img/icono3.svg" alt="Icono Tiempo" loading="lazy">
            <h3>Tiempo</h3>
            <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Consectetur officia debitis similique illo iusto qui eveniet nemo reprehenderit corrupti vero eius minima vel</p>
        </div>

    </div>
</section>

<?php
    incluirTemplate('footer');
?>