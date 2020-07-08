<template>
    <div class="row col-md-12 input-popup">
        <div class="row col-md-12">
            <h1>Add a task</h1>
        </div>
        <div class="form-group col-md-12">
            <label>Task</label>
            <task-input v-on:task-saved="addTask" v-bind:list-parent="0" v-bind:save-button-enabled="false" v-on:task-input="getTaskInput"></task-input>
        </div>
        <div class="form-group col-md-12">
            <label>Select a list</label>
            <tasklist-selector v-bind:available-lists="lists" v-on:list-selected="onListSelected"></tasklist-selector>
        </div>
        <div class="form-group col-md-12">
            <button class="btn btn-success" v-on:click="addTask">Save task</button>
            <button class="btn btn-error" v-on:click="cancel">Cancel</button>
        </div>
    </div>
</template>
<script>
    export default {
        template: `

    `,
        data: function() {
            return {
                lists : this.availableLists,
                selectedList: "",
                taskInput: "",
            }
        },
        props: [
            'availableLists'
        ],
        methods: {
            addTask : function(task) {
                //this.taskInput = task;

                if(this.selectedList === "")
                {
                    this.selectedList = this.lists[0];
                }

                this.$emit('task-created-from-general-input', {
                    list: this.selectedList,
                    task: this.taskInput
                });
            },
            cancel: function() {
                this.$emit('cancel-task-input', {
                    list: this.selectedList,
                    task: this.taskInput
                });
            },
            onListSelected : function(list) {
                console.log(list);
                for(var i = 0; i < this.lists.length; i++)
                {
                    if(this.lists[i].list_id === list.info)
                    {
                        this.selectedList = this.lists[i];
                    }
                }
            },
            getTaskInput: function(task) {
                console.log(task);
                this.taskInput = task.task;
            }
        }
    }
</script>
