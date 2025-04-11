<?php include_once __DIR__ . '/header.php' ?>

    <?php if(empty($projects)) { ?>  
        <p class="no-projects">No tienes proyectos aún. <a href="/crear-proyecto">Comienza creando uno</a>.</p>
    <?php } else { ?>
        <ul class="project-list">
            <?php foreach ($projects as $project): ?>
                <li class="project">
                    <a href="/proyecto?id=<?php echo $project->getUrl()?>"><?php echo $project->getName() ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php
        }
    ?>

<?php include_once __DIR__ . '/footer.php' ?>

