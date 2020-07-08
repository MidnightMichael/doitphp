<template>
    <div class="row col-md-12 input-popup" :style="display">
        <div class="row col-md-12">
            <h1>{{ heading }}</h1>
        </div>
        <div class="form-group col-md-12">
            <label>Select a list to {{ action.toLowerCase() }}</label>
            <tasklist-selector v-bind:available-lists="lists" v-on:list-selected="listSelected"></tasklist-selector>
        </div>
        <div class="form-group col-md-12">
            <button class="btn btn-success" v-on:click="doAction">{{ action }}</button>
            <button class="btn btn-error" v-on:click="cancel">Cancel</button>
        </div>
    </div>
</template>
<script>
    export default {
        data: function () {
            return {
                lists: [],
                task : "",
                action : "",
                heading: "",
                list_id: 0,
                display: "display:none",
            }
        },
        props: ['availableLists'],
        methods: {
            cancel: function() {
                this.display = "display:none";
            },
            doAction: function() {
                switch(this.action.toLowerCase())
                {
                    case "copy":
                        this.submitCopyAction();
                        break;
                    case "move":
                        this.submitMoveAction();
                        break;
                }
            },
            setupFormForCopy: function(input) {
                this.heading = "Copy task to another list";
                this.action = "Copy";
                this.display  = "display:block;";
                this.list_id = input.list_id;
                this.task = input.task;
            },
            setupFormForMove: function(input) {
                this.heading = "Move task to another list";
                this.action = "Move";
                this.display  = "display:block;";
                this.list_id = input.list_id;
                this.task = input.task;
            },
            submitMoveAction: function() {
                var self = this;
                this.$http.post('/tasks/move', {
                    task_id: self.task.task_id,
                    list_id: self.list_id
                }, {
                    headers: {
                        'X-CSRF-TOKEN' : document.getElementsByName('csrf-token')[0].content
                    }
                }).then(response => {
                    self.reset();
                    self.eventBus.$emit('data-changed', {});
                },response => {
                    alert("An error occured");
                    self.reset();
                });
            },
            submitCopyAction: function() {
                var self = this;
                this.$http.post('/tasks/copy', {
                    task_id: self.task.task_id,
                    task_name: self.task.name,
                    list_id: self.list_id
                }, {
                    headers: {
                        'X-CSRF-TOKEN' : document.getElementsByName('csrf-token')[0].content
                    }
                }).then(response => {
                    self.reset();
                    self.eventBus.$emit('data-changed', {});
                },response => {
                    alert("An error occured");
                    self.reset();
                });
            },
            reset: function() {
                this.display = "display:none";
            },
            onListsLoaded: function(input) {
                this.lists = Array.from(input);
            },
            listSelected : function(list) {
                //this.$emit('list-selected', { info: this.selectedList, parent: 0 });
                this.list_id = list.info;
                //v-on:click="$emit('task-saved', {info: task, parent: inputParent})"
            }
        },
        mounted: function() {
            this.eventBus.$on('show-copy-task-form', this.setupFormForCopy);
            this.eventBus.$on('show-move-task-form', this.setupFormForMove);
            this.eventBus.$on('lists-loaded', this.onListsLoaded);
        }
    }
</script>
