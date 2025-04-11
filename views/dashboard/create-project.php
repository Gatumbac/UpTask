<?php include_once __DIR__ . '/header.php' ?>
<div class="container-sm">
    <?php include_once __DIR__ . '/../templates/alerts.php'; ?>

    <form action="/crear-proyecto" method="POST">
        <?php include_once __DIR__ . '/project-form.php' ?>
        <input type="submit" value="Crear Proyecto">
    </form>

</div>
<?php include_once __DIR__ . '/footer.php' ?>