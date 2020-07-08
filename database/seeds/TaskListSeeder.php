<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('task_lists')->insert([
            'task_list_name' => 'Todo',
            'task_list_owner' => 1
        ]);

        DB::table('task_lists')->insert([
           'task_list_name' => 'Groceries',
           'task_list_owner' => 1
        ]);

        DB::table('task_lists')->insert([
           'task_list_name' => 'Long list',
           'task_list_owner' => 1
        ]);

        DB::table('task_lists')->insert([
           'task_list_name' => 'Do It application',
           'task_list_owner' => 1
        ]);
    }
}
