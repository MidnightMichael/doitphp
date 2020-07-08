<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //'task_name',
        //        'task_owner',
        DB::table('tasks')->insert([
           'task_name' => 'Cook dinner',
           'task_owner' => 1
       ]);

        DB::table('tasks')->insert([
                                       'task_name' => 'Do groceries',
                                       'task_owner' => 1
                                   ]);

        DB::table('tasks')->insert([
                                       'task_name' => 'Dust house',
                                       'task_owner' => 1
                                   ]);

        DB::table('tasks')->insert([
                                       'task_name' => 'Eggs',
                                       'task_owner' => 2
                                   ]);

        DB::table('tasks')->insert([
                                       'task_name' => 'Chicken',
                                       'task_owner' => 2
                                   ]);

        DB::table('tasks')->insert([
                                       'task_name' => 'Paint hallway',
                                       'task_owner' => 3
                                   ]);

        DB::table('tasks')->insert([
                                       'task_name' => 'Read Getting to yes',
                                       'task_owner' => 3
                                   ]);

        DB::table('tasks')->insert([
                                       'task_name' => 'Style dashboard',
                                       'task_owner' => 4
                                   ]);
        DB::table('tasks')->insert([
                                       'task_name' => 'Implement api',
                                       'task_owner' => 4
                                   ]);
    }
}
