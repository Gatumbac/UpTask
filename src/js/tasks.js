(function() {
    let tasks = [];
    getTasks();

    const newTaskButton = document.querySelector("#newtask-button");
    newTaskButton.addEventListener('click', showTaskForm);

    function showTaskForm() {
        const modal = document.createElement('DIV');
        modal.classList.add('modal');
        modal.innerHTML = `
            <form class="newtask-form" method='POST'>
                <legend>Añade una nueva tarea</legend>
                <div class="field">
                    <label for="task">Tarea</label>
                    <input
                        type="text"
                        name="name"
                        id="task"
                        placeholder="Nombre de la tarea"
                    />
                </div>

                <div class="newtask-options">
                    <input
                        type="submit"
                        class="newtask-submit"
                        value="Añadir Tarea"
                    />
                    <button type="button" class="close-newtask">Cancelar</button>
                </div>
            </form>
        `
        setTimeout(function() {
            const form = document.querySelector('.newtask-form');
            form.classList.add('show');
        }, 0);

        
        modal.addEventListener('click', function(e) {
            e.preventDefault();
            if(e.target.classList.contains('close-newtask')) {
                const form = document.querySelector('.newtask-form');
                form.classList.add('close');
                removeElement(modal, 500);
            }
            
            if(e.target.classList.contains('newtask-submit')) {
                submitTaskForm();
            }
        });

        document.querySelector('BODY').appendChild(modal);
    }

    function submitTaskForm() {
        const taskName = document.querySelector('#task').value.trim();

        if (taskName.length < 4 || taskName.length > 60) {
            showAlert('El nombre de la tarea es obligatorio y debe ser válido', 'error', document.querySelector('.newtask-form legend'));
            return;
        }

        addTask(taskName);
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
        }, 5000);
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

            showAlert(result.message, result.type, document.querySelector('.newtask-form legend'));

            if(result.type === 'success') {
                removeElement(document.querySelector('.modal'), 1000)
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
        setTimeout(function() {
            element.remove();
        }, time);
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

        if(tasks.length === 0) {
            const noTasksText = document.createElement('LI');
            noTasksText.textContent = 'No existen tareas en el proyecto';
            noTasksText.classList.add('no-tasks');
            tasksContainer.appendChild(noTasksText);
            return;
        }

        const states = {
            '0' : 'Pendiente',
            '1' : 'Completa'
        }

        const stateClasses = {
            '0' : 'pending',
            '1' : 'complete'
        }

        tasks.forEach((task) => {
            const taskContainer = document.createElement('LI');
            taskContainer.dataset.taskId = task.id;
            taskContainer.classList.add('task');

            const taskName = document.createElement('P');
            taskName.textContent = task.name;

            const optionsContainer = document.createElement('DIV');
            optionsContainer.classList.add('tasks-options');

            const taskStatusButton = document.createElement('BUTTON');
            taskStatusButton.type = 'button';
            taskStatusButton.classList.add('status-button');
            taskStatusButton.classList.add(`${stateClasses[task.status]}`.toLowerCase());
            taskStatusButton.textContent = states[task.status];
            taskStatusButton.dataset.taskStatus = task.status;

            const deleteTaskButton = document.createElement('BUTTON');
            deleteTaskButton.type = 'button';
            deleteTaskButton.classList.add('deleteTask-button');
            deleteTaskButton.textContent = 'Eliminar';
            deleteTaskButton.dataset.taskId = task.id;

            optionsContainer.appendChild(taskStatusButton);
            optionsContainer.appendChild(deleteTaskButton);

            taskContainer.appendChild(taskName);
            taskContainer.appendChild(optionsContainer);
            console.log(taskContainer);
            tasksContainer.appendChild(taskContainer);
        });
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
})(); 

