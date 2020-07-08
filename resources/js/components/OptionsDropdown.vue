<template>
    <div class="col-md-12" :style="show">
        <i class="material-icons" v-on:click="emitCopyActionOnClick">file_copy</i>
        <i class="material-icons" v-on:click="emitMoveActionOnClick">move_to_inbox</i>
        <i class="material-icons" v-on:click="emitRemoveActionOnClick">remove</i>
    </div>
</template>
<script>
    export default {
        data: function () {
            return {
                task: this.taskId,
                list: this.listId,
                show: "display:none;",
                displaying: false,
            }
        },
        props: [ 'taskId', 'listId'],
        methods: {
            toggleOptions: function() {
                if(!this.displaying)
                {
                    this.displaying = true;
                    this.show = "display:block;";
                }
                else
                {
                    this.displaying = false;
                    this.show = "display:none;";
                }
            },
            emitCopyActionOnClick : function() {
                this.eventBus.$emit('show-copy-task-form', {task: this.task, list_id: this.list.list_id} );
            },
            emitMoveActionOnClick : function() {
                this.eventBus.$emit('show-move-task-form', {task: this.task, list_id: this.list.list_id} )
            },
            emitRemoveActionOnClick : function() {
                this.eventBus.$emit('show-remove-task-popup', {task: this.task, list_id: this.list.list_id} )
            }
        },
        mounted: function() {

        }
    }
</script>
