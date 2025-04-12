(function() {
    let tasks = [];
    getTasks();
    let filteredTasks = [];

    const states = {
        '0' : 'Pendiente',
        '1' : 'Completa'
    }
    const stateClasses = {
        '0' : 'pending',
        '1' : 'complete'
    }

    const newTaskButton = document.querySelector("#newtask-button");
    newTaskButton.addEventListener('click', function() {
        showTaskForm();
    });

    //Filters
    const filters = document.querySelectorAll('.filters input[type="radio"]');
    addFilterListeners(filters);

    function addFilterListeners(filters) {
        filters.forEach(radio => radio.addEventListener('input', function(e) {
            const filter = e.target.value;
            if (filter === "") {
                filteredTasks = [];
            } else {
                filteredTasks = tasks.filter( task => task.status === filter);
            }
            showTasks();
        }))
    }

    function showTaskForm(update = false, task = {}) {
        const modal = document.createElement('DIV');
        modal.classList.add('modal');
        constructModal(modal, update, task);

        //Js Concurrency Model
        setTimeout(function() {
            const form = document.querySelector('.newtask-form');
            form.classList.add('show');
        }, 0);

        handleModalListeners(modal, update, task);

        document.querySelector('BODY').appendChild(modal);
    }

    function handleModalListeners(modal, update, task) {
        modal.addEventListener('click', function(e) {
            e.preventDefault();
            if(e.target.classList.contains('close-newtask')) {
                closeModalForm(modal);
            }
            
            if(e.target.classList.contains('newtask-submit')) {
                submitTask(update, task);
            }
        });
    }

    function closeModalForm(modal) {
        const form = document.querySelector('.newtask-form');
        form.classList.add('close');
        removeElement(modal, 500);
    }

    function submitTask(update, task) {
        const validation = validateTaskForm();
        if(!validation.result) {
            return;
        }

        if(update) {
            task.name = validation.name;
            updateTask(task);
        } else {
            addTask(validation.name);
        }
    }

    function validateTaskForm() {
        const taskName = document.querySelector('#task').value.trim();

        if (taskName.length < 4 || taskName.length > 60) {
            showAlert('El nombre de la tarea es obligatorio y debe ser válido', 'error', document.querySelector('.newtask-form legend'));
            return {'name': '', 'result': false};
        }
        return {'name': taskName, 'result': true};
    }

    function showAlert(message, type, reference) {
        const previousAlert = document.querySelector('.alert');
        if (previousAlert) previousAlert.remove();

        const alert = document.createElement('DIV');
        alert.textContent = message;
        alert.classList.add('alert', type);
        reference.parentElement.insertBefore(alert, reference.nextElementSibling);

        setTimeout(function() {
            alert.remove();
        }, 3000);
    }

    async function addTask(task) {
        const data = new FormData();
        data.append('name', task);
        data.append('project_id', getProjectId());

        try {
            const url = '/api/tarea';
            const response = await fetch(url, {
                method: 'POST',
                body: data
            });
            const result = await response.json();

            if(result.type === 'success') {
                removeElement(document.querySelector('.modal'), 0);
                Swal.fire('¡Tarea Creada!', result.message, 'success');
                addTaskVirtualDom(result.id, task, result.projectId);
                showTasks();
            }

        } catch (error) {
            console.log(error);
        }
    }

    function getProjectId() {
        const projectParameters = new URLSearchParams(window.location.search);
        const project = Object.fromEntries(projectParameters.entries());
        return project.id;
    }

    function removeElement(element, time) {
        if(element) {
            setTimeout(function() {
                element.remove();
            }, time);
        }
    }

    async function getTasks() {
        try {
            const url = `/api/tareas?id=${getProjectId()}`;
            const response = await fetch(url);
            const result = await response.json();
            tasks = result.tasks;
            showTasks();
        } catch (error) {
            console.log(error);
        }
    }

    function showTasks() {
        const tasksContainer = document.querySelector('#tasks-list')
        cleanContainer(tasksContainer);
        handlePendingFilter();
        handleCompletedFilter();

        const tasksToShow = filteredTasks.length ? filteredTasks : tasks;

        if(tasksToShow.length === 0) {
            const noTasksText = document.createElement('LI');
            noTasksText.textContent = 'No existen tareas para mostrar';
            noTasksText.classList.add('no-tasks');
            tasksContainer.appendChild(noTasksText);
            return;  
        }

        tasksToShow.forEach((task) => {
            const taskContainer = document.createElement('LI');
            taskContainer.dataset.taskId = task.id;
            taskContainer.classList.add('task');

            const taskName = document.createElement('P');
            taskName.textContent = task.name;
            taskName.ondblclick = function() {
                showTaskForm(true, {...task});
            }

            const optionsContainer = document.createElement('DIV');
            optionsContainer.classList.add('tasks-options');

            const taskStatusButton = document.createElement('BUTTON');
            taskStatusButton.type = 'button';
            taskStatusButton.classList.add('status-button');
            taskStatusButton.classList.add(`${stateClasses[task.status]}`.toLowerCase());
            taskStatusButton.textContent = states[task.status];
            taskStatusButton.dataset.taskStatus = task.status;
            taskStatusButton.ondblclick = function() {
                changeTaskStatus({...task});
            }

            const deleteTaskButton = document.createElement('BUTTON');
            deleteTaskButton.type = 'button';
            deleteTaskButton.classList.add('deleteTask-button');
            deleteTaskButton.textContent = 'Eliminar';
            deleteTaskButton.dataset.taskId = task.id;
            deleteTaskButton.ondblclick =  function() {
                confirmTaskDeletion({...task});
            }

            optionsContainer.appendChild(taskStatusButton);
            optionsContainer.appendChild(deleteTaskButton);

            taskContainer.appendChild(taskName);
            taskContainer.appendChild(optionsContainer);
            tasksContainer.appendChild(taskContainer);
        });
    }

    function handlePendingFilter() {
        const pendingTasks = tasks.filter(task => task.status === "0");
        const pendingFilter = document.querySelector('#pending')
        if(pendingTasks.length === 0) {
            pendingFilter.disabled = true;
        } else {
            pendingFilter.disabled = false;
        }
    }

    function handleCompletedFilter() {
        const completedTasks = tasks.filter(task => task.status === "1");
        const completedFilter = document.querySelector('#completed')
        if(completedTasks.length === 0) {
            completedFilter.disabled = true;
        } else {
            completedFilter.disabled = false;
        }
    }

    function addTaskVirtualDom(id, name, projectId) {
        const taskObject = {
            id: String(id),
            name: name,
            status: '0', 
            project_id: projectId
        }

        tasks = [...tasks, taskObject];
    }

    function cleanContainer(container) {
        while(container.firstChild) {
            container.removeChild(container.firstChild)
        }
    }

    function changeTaskStatus(task) {
        const newStatus = task.status === '1' ? '0' : '1';
        task.status = newStatus;
        updateTask(task);
    }

    async function updateTask(task) {
        const {status, id, name} = task;
        const data = new FormData();
        data.append('id', id);
        data.append('status', status);
        data.append('name', name);
        data.append('project_id', getProjectId());

        try {
            const url = `/api/tarea/actualizar`
            const response = await fetch(url, {
                method: 'POST',
                body: data
            })
            const result = await response.json();

            if(result.type === 'success') {
                removeElement(document.querySelector('.modal'), 0);
                Swal.fire('¡Actualizado!', result.message, 'success');
                updateTaskVirtualDom(task);
                showTasks();
            }

        } catch (error) {
            console.log(error);
        }
    }

    function updateTaskVirtualDom(task) {
        tasks = tasks.map( domTask => {
            if(domTask.id === task.id) {
                domTask.status = task.status;
                domTask.name = task.name;
            }

            return domTask;
        })
    }

    function confirmTaskDeletion(task) {
        Swal.fire({
            title: "¿Eliminar tarea?",
            showCancelButton: true,
            confirmButtonText: "Sí",
            cancelButtonText: "No",
          }).then((result) => {
            if (result.isConfirmed) {
                deleteTask(task);
            } 
          });
    }

    async function deleteTask(task) {
        const data = new FormData();
        data.append('id', task.id);
        data.append('status', task.status);
        data.append('name', task.name);
        data.append('project_id', getProjectId());

        try {
            const url = `/api/tarea/eliminar`
            const response = await fetch(url, {
                method: 'POST',
                body: data
            })
            const result = await response.json();

            if(result.type === 'success') {
                Swal.fire('¡Eliminado!', result.message, 'success');
                deleteTaskVirtualDom(task);
                showTasks();
            }

        } catch (error) {
            console.log(error);
        }

    }

    function deleteTaskVirtualDom(task) {
        tasks = tasks.filter( domTask => domTask.id !== task.id);
    }

    function constructModal (modal, update, task) {
        modal.innerHTML = `
            <form class="newtask-form" method='POST'>
                <legend>${update ? 'Editar tarea' : 'Añade una nueva tarea'}</legend>
                <div class="field">
                    <label for="task">Tarea</label>
                    <input
                        type="text"
                        name="name"
                        id="task"
                        placeholder="Nombre de la tarea"
                        value="${task.name ? task.name : ''}"
                    />
                </div>

                <div class="newtask-options">
                    <input
                        type="submit"
                        class="newtask-submit"
                        value="Guardar"
                    />
                    <button type="button" class="close-newtask">Cancelar</button>
                </div>
            </form>
        `
    }

})(); 

