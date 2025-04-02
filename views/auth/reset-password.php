<div class="container reset-password">
    <?php include_once __DIR__ . '/../templates/site-name.php' ?>
    <div class="container-sm">
        <p class="page-description">Coloca tu nueva contraseña</p>
        <form action="/resetear-password" method="POST">
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

            <input type="submit" class="button-blue" value="Guardar Contraseña">
        </form>

        <div class="actions">
            <a href="/">¿Ya tienes una cuenta? <span>Iniciar Sesión</a>
            <a href="/crear-cuenta">¿Aún no tienes una cuenta? <span>Crear una</a>
        </div>
    </div>
</div>