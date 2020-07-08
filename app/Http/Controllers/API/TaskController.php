<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Tasks\TaskService;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * @var TaskService
     */
    private $taskService;
    /**
     * @var Factory
     */
    private $validationFactory;

    public function __construct(TaskService $taskService, Factory $validationFactory)
    {
        $this->taskService = $taskService;
        $this->validationFactory = $validationFactory;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validationFactory->make($request->all(), [
            'task_owner' => 'nullable|numeric',
            'task_name' => 'required|min:2|max:255',
        ], []);

        if($validator->fails())
        {
            abort(500);
        }

        //
        $listID = $request->input('task_owner');
        $task = $request->input('task_name');

        return response()->json(['status' => $this->taskService->addTaskToList($listID, [
            'task_name' => $task,
        ])]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        //
        $validator = $this->validationFactory->make($request->all(), [
            'task_id' => 'required|numeric',
        ], []);

        if($validator->fails())
        {
            abort(500);
        }

        $task->task_id = $request->input('task_id');
        return response()->json(['status' => $this->taskService->updateTask($task)]);
    }

    public function copyTask(Request $request)
    {
        $validator = $this->validationFactory->make($request->all(), [
            'task_id' => 'required|numeric|exists:tasks,task_id',
            'list_id' => 'required|numeric|exists:task_lists,task_list_id'
        ]);

        if($validator->fails())
        {
            abort(500);
        }

        $this->taskService->copyTask($request->all(), $request->input('list_id'));

        return response()->json(['status' => "copied"]);
    }

    public function moveTask(Request $request)
    {
        $validator = $this->validationFactory->make($request->all(), [
            'task_id' => 'required|numeric|exists:tasks,task_id',
            'list_id' => 'required|numeric|exists:task_lists,task_list_id'
        ]);

        if($validator->fails())
        {
            abort(500);
        }

        if(!$this->taskService->moveTaskToList($request->input('task_id'), $request->input('list_id')))
        {
            return response()->json(['status' => "error with moving, cannot move task to same list"]);
        }

        return response()->json(['status' => "moved"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //
    }
}
