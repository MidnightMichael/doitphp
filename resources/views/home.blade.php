@extends('layouts.app')
@section('content')
    <div class="container">
        <div id="app" class="row col-md-12">
            <div class="row col-md-12">
                <div class="col-md-12" v-if="showTask">
                    <general-task-input v-bind:available-lists="listTitle"
                                        v-on:task-created-from-general-input="onTaskCreatedFromGeneralInput" v-on:cancel-task-input="showTaskForm"></general-task-input>
                </div>
                <div class="col-md-12" v-else>
                    <button v-on:click="showTaskForm">New task</button>
                </div>
                <div class="col-md-12" v-if="showList">
                    <list-creator v-on:list-saved="onListSaved" v-on:cancel-list-input="showListForm"></list-creator>
                </div>
                <div class="col-md-12" v-else>
                    <button v-on:click="showListForm">New list</button>
                </div>
                <copy-or-move-dialog v-bind:available-lists="listTitle"></copy-or-move-dialog>
            </div>
            <div class="row col-md-12 no-gutters">
                <div class="col-md-4 no-gutters">
                    <tasklist v-for="list in buckets[0]" v-bind:initial-tasks="list.tasks"  v-bind:default-title="list.name" v-bind:parent="list"></tasklist>
                </div>
                <div class="col-md-4 no-gutters">
                    <tasklist v-for="list in buckets[1]" v-bind:initial-tasks="list.tasks"  v-bind:default-title="list.name" v-bind:parent="list"></tasklist>
                </div>
                <div class="col-md-4 no-gutters">
                    <tasklist v-for="list in buckets[2]" v-bind:initial-tasks="list.tasks"  v-bind:default-title="list.name" v-bind:parent="list"></tasklist>
                </div>
            </div>
        </div>
    </div>
@endsection
