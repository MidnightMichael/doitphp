<?php


namespace App\Tasks;


use App\Models\Task;
use App\Models\TaskList;

class TaskService
{

    /**
     * @var Task
     */
    private $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function addTaskToList($listID, $taskData = [])
    {
        $task = $this->task->create([
            'task_name' => $taskData['task_name'],
            'task_status' => 0,
            'task_owner' => $listID
        ]);

        $task->save();

        return true;
    }

    public function updateTask(Task $task)
    {
        $task = $this->task->where('task_id', '=', $task->task_id);
        $task->task_status = 1;
        $task->update(['task_status' => 1]);
        return true;
    }

    public function copyTask($task = [], $targetTaskList = 0)
    {
        return $this->addTaskToList($targetTaskList, $task);
    }

    public function moveTaskToList($task = [], $targetTaskList = 0)
    {
        $task = $this->task->where('task_id', '=', $task)->first();
        logger()->info(var_export($task, true));
        logger()->info(var_export($targetTaskList, true));
        if($task->task_owner === $targetTaskList)
        {
            return false;
        }

        $task->update(['task_owner' => $targetTaskList]);

        return true;
    }

}
