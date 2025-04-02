<div class="container login">
    <?php include_once __DIR__ . '/../templates/site-name.php' ?>
    <div class="container-sm">
        <p class="page-description">Iniciar Sesión</p>
        <form action="/" method="POST">
            <div class="field">
                <label for="email">Correo</label>
                <input 
                    id="email"
                    type="email"
                    placeholder="Tu correo"
                    name="email"
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

            <input type="submit" class="button-cyan" value="Iniciar Sesión">
        </form>

        <div class="actions">
            <a href="/crear-cuenta">¿Aún no tienes una cuenta? <span>Crear una</a>
            <a href="/olvide-password">¿Olvidaste tu contraseña?</a>
        </div>
    </div>
</div>