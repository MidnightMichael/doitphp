<template>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" :style="list.color" >
                <h2>{{ listTitle }}</h2>
                <button v-on:click="showHide">Toggle</button>
            </div>
            <div class="card-body todo-list-body" :style="taskListShown">
                <div class="col-md-12">
                    <task-input v-on:task-saved="addTask" v-bind:list-parent="this.listTitle" v-bind:save-button-enabled="true"></task-input>
                </div>
                <div class="row col-md-12 no-gutters " v-for="task in tasks">
                    <div class="row col-md-12 no-gutters task-row" v-if="task.complete === false">
                        <div class="col-md-10 task-name" v-on:click="toggleOptions(task)">{{ task.name }}</div>
                        <div class="col-md-2"><i class="material-icons" v-on:click="updateTask(task)" >done</i></div>
                        <options-dropdown :task-id="task" :list-id="list"></options-dropdown>
                    </div>
                    <div class="row col-md-12 no-gutters task-row-complete" v-else>
                        <div class="col-md-10"><del><span>{{ task.name }}</span></del></div>
                        <div class="col-md-2"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import OptionsDropdown from "./OptionsDropdown";
    export default {
        components: {OptionsDropdown},
        data: function() {
            return {
                tasks: this.initialTasks,
                listTitle : this.defaultTitle,
                taskListShown: "display:none;",
                taskListOpen: false,
                taskBuffer: [],
                list: this.parent,
                color: this.parent.color
            }
        },
        props: [
            'defaultTitle',
            'initialTasks',
            'parent'
        ],
        methods: {
            updateTask: function(task) {
                var self = this;
                this.$http.post('/tasks/update/', {task_id: task.task_id}, {
                    headers : {
                        'X-CSRF-TOKEN' : document.getElementsByName('csrf-token')[0].content
                    }
                }).then(response => {
                    task.updateTask();
                    self.eventBus.$emit('data-changed', {});
                }, response => {
                    alert("An error occurred during updating of task");
                    if(response.status === 419 || response.status === 401)
                    {
                        window.location.replace("http://doit.test/home");
                    }
                });
            },
            addTask: function(task) {
                if(task.hasOwnProperty('parent') &&task.parent !== this.listTitle) {
                    return false;
                } else {
                    if (task.hasOwnProperty('list') && task.list.name !== this.listTitle) {
                        return false;
                    }
                    else {
                        if(!task.hasOwnProperty("info"))
                        {
                            task["info"] = task.task.info;
                        }
                        if(task["info"] === undefined || task["info"] === 'undefined')
                        {
                            task["info"] = task.task;
                        }
                    }
                }
                var self = this;
                this.$http.post('/lists/add/task', {
                    task_name: task.info,
                    task_owner: self.list.list_id
                }, {
                    headers : {
                        'X-CSRF-TOKEN' : document.getElementsByName('csrf-token')[0].content
                    }
                }).then(response => {
                    console.log(response);
                    this.tasks.push({
                        name: task.info,
                        complete: false,
                        updateTask: function () {
                            this.complete = true;
                        }
                    });
                    self.eventBus.$emit('data-changed', {});
                }, response => {
                    alert("An error occurred during the task saving!");
                    if(response.status === 419 || response.status === 401)
                    {
                        window.location.replace("http://doitphp.test/home");
                    }
                });
            },
            showHide: function() {
                if(this.taskListOpen)
                {
                    this.taskListOpen = false;
                    this.taskListShown = "display:none;";
                }
                else
                {
                    this.taskListOpen = true;
                    this.taskListShown = "display:block;";
                }
            },
            toggleOptions: function(task) {
                for(var i = 0; this.$children.length; i++)
                {
                    if(this.$children[i].$data.hasOwnProperty('task') && this.$children[i].$data.task.task_id === task.task_id)
                    {
                        this.$children[i].toggleOptions();
                        break;
                    }
                }
            }
        },
        mounted: function() {
            var temp = this.initialTasks;
            if (!Array.isArray(temp) && (typeof temp !== 'string'))
            {
                temp = [];
                this.tasks = [];
            }
            else if(typeof temp === 'string')
            {
                this.tasks = JSON.parse(JSON.stringify(temp));
            }

            var self = this;
        }
    }
</script>
