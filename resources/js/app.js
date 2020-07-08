/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
//const axios = require('axios').default;

window.Vue = require('vue');
window.VueResource = require('vue-resource');

Vue.use(VueResource);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('TasklistSelector', require('./components/tasklistselector.vue').default);
Vue.component('tasklist', require('./components/tasklist.vue').default);
Vue.component('task-input', require('./components/taskinput.vue').default);
Vue.component('ListCreator', require('./components/listcreator.vue').default);
Vue.component('GeneralTaskInput', require('./components/generaltaskinput.vue').default);
Vue.component('OptionsDropdown', require('./components/OptionsDropdown.vue').default);
Vue.component('CopyOrMoveDialog', require('./components/CopyOrMoveDialog.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.prototype.eventBus = new Vue();

const app = new Vue({
    el: '#app',
    data: {
        message: 'Hello Vue!',
        testList: [],
        listTitle: [

        ],
        showList: false,
        showTask: false,
        buckets: [
            [],
            [],
            []
        ]
    },
    methods: {
        onTaskCreatedFromGeneralInput: function (event) {
            console.log(event);
            for (var i = 0; i < this.$children.length; i++) {
                if (this.$children[i].hasOwnProperty('tasks') && this.$children[i].listTitle === event.list.name) {
                    this.$children[i].addTask(event);
                    this.showTask = false;
                }
            }
        },
        onListSaved: function (event) {
            console.log(event);
            var self = this;
            this.$http.post('/lists/add', {
                list_name: event.info,
                color: event.color,
                deadline: event.deadline
            }, {
                headers : {
                    'X-CSRF-TOKEN' : document.getElementsByName('csrf-token')[0].content
                }
            }).then(response => {
                self.eventBus.$emit('data-changed', {});
            },response => {
                alert("An error occured while saving the list");
                if(response.status === 419 || response.status === 401)
                {
                    window.location.replace("http://doit.test/home");
                }
            });

            this.listTitle.push({
                list_id: this.listTitle.length,
                name: event.info,
                color: event.color,
                deadline: event.deadline
            });
            this.showList = false;
        },
        showListForm: function () {
            this.showList = !this.showList;
        },
        showTaskForm: function () {
            this.showTask = !this.showTask;
        },
        loadTaskListsFromServer: function() {
            this.listTitle = [];
            var self = this;
            this.$http.get('/lists')
                .then(response => {
                    self.listTitle = JSON.parse(response.bodyText);

                    if(!Array.isArray(self.listTitle) && self.listTitle === 0) return;
                    var temp = Array.from(self.listTitle.lists);
                    self.listTitle = [];

                    for(var i = 0; i < temp.length; i++)
                    {
                        var list = {
                            list_id: temp[i].task_list_id,
                            name: temp[i].task_list_name,
                            color: temp[i].task_list_color === null ? "background-color: #00000008 !important;" : "background-color:" + temp[i].task_list_color + "!important;",
                            tasks: []
                        };
                        for(var j = 0; j < temp[i].tasks.length; j++)
                        {
                            list.tasks.push({
                                task_id: temp[i].tasks[j].task_id,
                                name: temp[i].tasks[j].task_name,
                                complete: temp[i].tasks[j].task_status === 1,
                                updateTask: function() {
                                    this.complete = true;
                                }
                            });
                        }
                        self.listTitle.push(list);
                    }
                    self.distributeListsToBuckets();
                    self.eventBus.$emit('lists-loaded', self.listTitle);
                });
        },
        distributeListsToBuckets : function() {
            var totalLists = this.listTitle.length;
            var totalBuckets = 3;
            var bucketIndex = 0;
            var avgListsPerBucket = Math.ceil(totalLists / totalBuckets);
            var listsDistributed = 0;
            this.buckets = [
                [],
                [],
                []
            ];

            while((listsDistributed) !== totalLists)
            {
                for(var i = 0; i < totalBuckets; i++)
                {
                    this.buckets[i].push(this.listTitle[listsDistributed]);
                    listsDistributed++;
                    if(listsDistributed === this.listTitle.length) break;
                }
            }


        }
    },
    mounted: function() {
        this.loadTaskListsFromServer();
        var self = this;

        this.eventBus.$on('data-changed', function(input){
            self.loadTaskListsFromServer();
        });

    }
});
