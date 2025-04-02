<div class="container signup">
    <?php include_once __DIR__ . '/../templates/site-name.php' ?>

    <div class="container-sm">
        <p class="page-description">Crea tu cuenta</p>

        <?php include_once __DIR__ . '/../templates/alerts.php' ?>

        <form action="/crear-cuenta" method="POST">

            <div class="field">
                <label for="name">Nombre</label>
                <input 
                    id="name"
                    type="text"
                    placeholder="Tu nombre"
                    name="name"
                    value = "<?php echo $user->getName(); ?>";
                    required
                >
            </div>

            <div class="field">
                <label for="lastname">Apellido</label>
                <input 
                    id="lastname"
                    type="text"
                    placeholder="Tu Apellido"
                    name="lastname"
                    value = "<?php echo $user->getLastName(); ?>";
                    required
                >
            </div>

            <div class="field">
                <label for="email">Correo</label>
                <input 
                    id="email"
                    type="email"
                    placeholder="Tu correo"
                    name="email"
                    value = "<?php echo $user->getEmail(); ?>";
                    required
                >
            </div>

            <div class="field">
                <label for="password">Contraseña</label>
                <input 
                    id="password"
                    type="password"
                    placeholder="Tu contraseña"
                    name="password"
                    required
                >
            </div>

            <div class="field">
                <label for="password2">Repetir Contraseña</label>
                <input 
                    id="password2"
                    type="password"
                    placeholder="Repite tu contraseña"
                    name="password"
                    required
                >
            </div>

            <input type="submit" class="button-purple" value="Crear Cuenta">
        </form>

        <div class="actions">
            <a href="/">¿Ya tienes una cuenta? <span>Iniciar Sesión</a>
            <a href="/olvide-password">¿Olvidaste tu contraseña?</a>
        </div>
    </div>
</div>