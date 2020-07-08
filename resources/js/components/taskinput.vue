<template>
    <div class="row col-md-12">
        <input type="text" name="task-name" class="form-control col-md-10" v-model="task" v-on:change="$emit('task-input', {task : task})"><button class="btn btn-success col-md-2"  v-if="this.saveButtonEnabled"v-on:click="saveTask(task)"><i class="material-icons">add</i></button>
    </div>
</template>
<script>
    export default {
        data: function() {
            return {
                task: "",
                inputParent: this.listParent,
                saveEnabled : true
            }
        },
        props: ['listParent', 'saveButtonEnabled'],
        methods: {
            saveTask : function(task) {
                if(!this.saveEnabled)
                {
                    this.$emit('task-saved', { info: task, parent: this.inputParent });
                }
                else
                {
                    this.$emit('task-saved', { info: this.task, parent: this.inputParent });
                }

                this.task = "";
            }
        },
        mounted: function() {
            if(this.saveButtonEnabled === "false")
            {
                this.saveEnabled = false;
            }
            else
            {
                this.saveEnabled = true;
            }
        }
    }
</script>
