<?php include_once __DIR__ . '/header.php' ?>

    <div class="container-sm">
        <div class="newtask-container">
            <button type="button" class="newtask-button" id="newtask-button">&#43; Nueva Tarea</button>
        </div>

        <div id="filters" class="filters">
            <p>Filtros:</p>
            <div class="filter-inputs">
                <div class="field">
                    <label for="all">Todas</label>
                    <input 
                        type="radio"
                        id="all"
                        name="filter"
                        value=""
                        checked
                    >
                </div>

                <div class="field">
                    <label for="completed">Completadas</label>
                    <input 
                        type="radio"
                        id="completed"
                        name="filter"
                        value="1"
                    >
                </div>

                <div class="field">
                    <label for="pending">Pendientes</label>
                    <input 
                        type="radio"
                        id="pending"
                        name="filter"
                        value="0"
                    >
                </div>
            </div>
        </div>

        <ul id='tasks-list'></ul>

    </div>

<?php include_once __DIR__ . '/footer.php' ?>

<?php
$script = '
    <script src="/build/js/tasks.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
';
?>