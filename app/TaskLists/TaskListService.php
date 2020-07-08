<?php


namespace App\TaskLists;


use App\Models\Task;
use App\Models\TaskList;
use Carbon\Carbon;

class TaskListService
{
    /**
     * @var TaskList
     */
    private $taskList;
    /**
     * @var Task
     */
    private $task;

    public function __construct(TaskList $taskList, Task $task)
    {
        $this->taskList = $taskList;
        $this->task = $task;
    }

    public function all()
    {
        return $this->taskList->with(['tasks'])->orderBy('task_list_id', 'desc')->get();
    }

    public function allForUser($userID)
    {
        return $this->taskList->with(['tasks'])->where('task_list_owner', '=', $userID)->orderBy('task_list_id', 'desc')->get();
    }

    public function getSingleList($taskListID, $userID)
    {
        return $this->taskList->with(['tasks'])->where('task_list_owner', '=', $userID)->where(['task_list_id', '=', $taskListID])->get()->first();
    }

    public function addList($listData = [])
    {
        $listData['task_list_uniform_name'] = strtolower($listData['task_list_name']);
        $list = $this->taskList->create($listData);
        $list->save();
        return true;
    }

    public function generateDailyList()
    {
        $today = Carbon::now()->format("Y-m-d");

        //todo: scale to multi user job
        $dailyList = $this->taskList->create([
            'task_list_name' => 'Todo: '.$today,
            'task_list_uniform_name' => strtolower('Todo: '.$today),
            'task_list_owner' => 1,
            'task_list_deadline' => Carbon::createFromFormat("Y-m-d", $today)
         ]);

        $dailyList->save();

        return;
    }

    public function removeOldDailyLists()
    {
        $yesterday = Carbon::now()->subDays(1);
        $yesterday->minute(59);
        $yesterday->second(59);
        $yesterday->hour(23);
        logger()->info($yesterday);

        $oldDailyLists = $this->taskList
            ->where('task_list_name', 'like', 'Todo: %')
            ->where('created_at', '<=', $yesterday)
            ->get();

        foreach ($oldDailyLists as $oldDailyList)
        {
            $oldDailyList->delete();
        }
    }
}
