<?php include_once __DIR__ . '/header.php' ?>

<div class="container-sm">
    <a href="/cambiar-password" class="button-purple button-link">Cambiar Contraseña</a>
    <?php include_once __DIR__ . '/../templates/alerts.php' ?>
    <form action="/perfil" method="POST">
        <div class="field">
            <label for="name">Nombre</label>
            <input 
                type="text"
                id="name"
                name="name"
                value = "<?php echo s($user->getName()); ?>";
                placeholder="Tu nombre"
                required
            >
        </div>

        <div class="field">
            <label for="lastname">Apellido</label>
            <input 
                type="text"
                id="lastname"
                name="lastname"
                value = "<?php echo s($user->getLastName()); ?>";
                placeholder="Tu apellido"
                required
            >
        </div>

        <div class="field">
            <label for="email">Email</label>
            <input 
                type="email"
                id="email"
                name="email"
                value = "<?php echo s($user->getEmail()); ?>";
                placeholder="Tu email"
                required
            >
        </div>

        <input type="submit" value="Guardar Cambios" class="button-indigo">
    </form>
</div>

<?php include_once __DIR__ . '/footer.php' ?>