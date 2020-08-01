<?php

namespace App\Http\Controllers;

use App\Tasks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TasksController extends Controller
{
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $task=Tasks::create([
            'user_id'=>Auth::id(),
            'title'=>$request['task'],
            'status'=>'open'
        ])->fresh();

        return response()->json(['message'=>'"'.$task->title.'" added to your list','error_code'=>0,'task'=>$task]);
    }

    public function openTask(Request $request)
    {
        $task=Tasks::find($request['id']);
        $task->status='open';
        $task->save();

        return response()->json(['message'=>'"'.$task->title.'" marked as open','error_code'=>0,'task'=>$task]);
    }

    public function closeTask(Request $request)
    {
        $task=Tasks::find($request['id']);
        $task->status='resolve';
        $task->save();
        return response()->json(['message'=>'"'.$task->title.'" marked as completed','error_code'=>0,'task'=>$task]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tasks  $tasks
     * @return \Illuminate\Http\Response
     */
    public function show(Tasks $tasks)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tasks  $tasks
     * @return \Illuminate\Http\Response
     */
    public function edit(Tasks $tasks)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tasks  $tasks
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tasks $tasks)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tasks  $tasks
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $tasks=Tasks::find($request['id']);
        Tasks::find($request['id'])->delete();

        return response()->json(['message'=>'Successfully removed "'.$tasks->title.'" from list','error_code'=>0,'id'=>$tasks->id,'status'=>$tasks->status]);
    }
}
