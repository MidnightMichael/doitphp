<template>
    <select class="form-control"  v-on:change="listSelected" v-model="selectedList">
        <option v-for="list in lists" :value="list.list_id">{{ list.name }}</option>
    </select>
</template>
<script>
    export default {
        props: [
            'availableLists'
        ],
        data: function() {
            return {
                lists: this.availableLists,
                selectedList: "Select a list"
            }
        },
        methods: {
            listSelected : function(list) {
                this.$emit('list-selected', { info: this.selectedList, parent: 0 });
                //v-on:click="$emit('task-saved', {info: task, parent: inputParent})"
            },
            onListsLoaded: function(input) {
                this.lists = Array.from(input);
            }
        },
        mounted: function() {
            this.eventBus.$on('lists-loaded', this.onListsLoaded);
        }
    }
</script>
