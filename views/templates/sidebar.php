<aside class="sidebar">
    <h2>UpTask</h2>

    <nav class="sidebar-nav">
        <a class="<?php echo $title === 'Proyectos' ? 'active' : ''; ?>" href="/dashboard">Proyectos</a>
        <a class="<?php echo $title === 'Crear Proyecto' ? 'active' : ''; ?>" href="/crear-proyecto">Crear Proyecto</a>
        <a class="<?php echo $title === 'Perfil' ? 'active' : ''; ?>" href="/perfil">Perfil</a>
        <a class="close-session" href="/logout">Cerrar Sesión</a>

        <div class="close-menu" id="close-menu">
            <img src="/build/img/close.svg" alt="menu-close">
        </div>


    </nav>
</aside>