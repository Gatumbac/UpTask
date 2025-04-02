<div class="container forgot-password">
    <?php include_once __DIR__ . '/../templates/site-name.php' ?>
    <div class="container-sm">
        <p class="page-description">Recupera tu acceso a UpTask</p>

        <?php include_once __DIR__ . '/../templates/alerts.php' ?>
        
        <form action="/olvide-password" method="POST">
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

            <input type="submit" class="button-pink" value="Enviar Instrucciones">
        </form>

        <div class="actions">
            <a href="/">¿Ya tienes una cuenta? <span>Iniciar Sesión</a>
            <a href="/crear-cuenta">¿Aún no tienes una cuenta? <span>Crear una</a>
        </div>
    </div>
</div>