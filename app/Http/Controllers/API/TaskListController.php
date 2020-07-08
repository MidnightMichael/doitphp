<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskList;
use App\TaskLists\TaskListService;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TaskListController extends Controller
{
    /**
     * @var TaskList
     */
    private $taskList;
    /**
     * @var Task
     */
    private $task;

    private $taskListService;
    /**
     * @var Factory
     */
    private $validationFactory;

    public function __construct(TaskListService $taskListService, Factory $validationFactory)
    {
        $this->taskListService = $taskListService;
        $this->validationFactory = $validationFactory;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['lists' => $this->taskListService->allForUser(1)]);
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
            'task_list_name'     => 'required|string|max:255',
            'task_list_deadline' => 'nullable|date_format:Y-m-d',
            'task_list_color'    => 'nullable|string|min:6|max:9',
        ], []);

//        if($validator->fails())
//        {
//            logger()->info(var_export($validator->validate(), true));
//            logger()->info(var_export($validator->failed(), true));
//            abort(500);
//        }

        $listData = [
            'task_list_name'     => $request->input('list_name'),
            'task_list_owner'    => Auth::user()->id,
            'task_list_deadline' => $request->has('deadline') && !empty($request->input('deadline')) ? Carbon::createFromFormat('Y-m-d',
                                                                                                                                $request->input('deadline')) : null,
            'task_list_color'    => $request->has('color') && !empty($request->input('color')) ? $request->input('color') : null
        ];

        return response()->json(['status' => $this->taskListService->addList($listData)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TaskList  $taskList
     * @return \Illuminate\Http\Response
     */
    public function show(TaskList $taskList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TaskList  $taskList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TaskList $taskList)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TaskList  $taskList
     * @return \Illuminate\Http\Response
     */
    public function destroy(TaskList $taskList)
    {
        //
    }
}
