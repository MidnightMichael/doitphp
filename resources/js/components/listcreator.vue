<template>
    <div class="row col-md-12 input-popup">
        <div class="row col-md-12">
            <h1>Add a list</h1>
        </div>
        <div class="row col-md-12 form-group">
            <label>List name</label><br>
            <input type="text" name="list-name" class="form-control col-md-10" v-model="list">
        </div>
        <div class="row col-md-12 form-group">
            <label>List deadline(optional, format[2020-04-15])</label>
            <input type="text" name="list-deadline" class="form-control col-md-10" v-model="deadline">
        </div>
        <div class="row col-md-12 form-group">
            <label>List color(optional, format[#ffffff])</label>
            <input type="text" name="list-color" class="form-control col-md-10" v-model="color">
        </div>
        <div class="row col-md-12 form-group">
            <button class="btn btn-success col-md-2" v-on:click="$emit('list-saved', {info: list, deadline: deadline, color: color})"><i class="material-icons">add</i></button>
            <button class="btn btn-error" v-on:click="cancel">Cancel</button>
        </div>
    </div>
</template>
<script>
    export default {
        data: function() {
            return {
                list: "",
                color: "",
                deadline: ""
            }
        },
        methods: {
            cancel: function() {
                this.$emit('cancel-list-input', {});
            }
        }
    }
</script>


