<?php include_once __DIR__ . '/header.php' ?>

<div class="container-sm">
    <a href="/perfil" class="button-purple button-link">Volver a Perfil</a>
    <?php include_once __DIR__ . '/../templates/alerts.php' ?>
    <form action="/cambiar-password" method="POST">
        <div class="field">
            <label for="currentPassword">Contraseña Actual</label>
            <input 
                id="currentPassword"
                type="password"
                placeholder="Tu contraseña actual"
                name="currentPassword"
                required
            >
        </div>

        <div class="field">
                <label for="password">Nueva Contraseña</label>
                <input 
                    id="password"
                    type="password"
                    placeholder="Tu nueva contraseña"
                    name="password"
                    required
                >
            </div>

            <div class="field">
                <label for="password2">Repetir Contraseña</label>
                <input 
                    id="password2"
                    type="password"
                    placeholder="Repite tu nueva contraseña"
                    name="password2"
                    required
                >
            </div>
        <input type="submit" value="Guardar Cambios" class="button-indigo">
    </form>
</div>

<?php include_once __DIR__ . '/footer.php' ?>