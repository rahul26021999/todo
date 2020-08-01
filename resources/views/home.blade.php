@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="btn btn-primary mb-2" data-toggle="modal" data-target="#myModal">Add Task</div>
            <div class="">    
                <div class="card-body">
                    <div id="openTasks">                
                        @foreach ($openTasks as $task)
                            <div class="alert-info alert" data-task-open-id="{{$task->id}}"><input type="checkbox" onclick="checkboxClicked(this)" class="mycheck mr-2" data-id="{{$task->id}}" data-status="{{$task->status}}">{{ $task->title }}<i class="fa fa-trash-o float-right deleteBtn" onclick="deleteMe(this)" data-id="{{$task->id}}"></i></div>
                        @endforeach
                    </div>
                    <div id="closedTasks">
                        <div class="">{{ __('Completed') }}</div>

                        @foreach ($closedTasks as $task)
                            <div class="alert-danger alert" data-task-close-id="{{$task->id}}"><input type="checkbox" onclick="checkboxClicked(this)"class="mycheck bg-danger mr-2" data-id="{{$task->id}}" data-status="{{$task->status}}" checked="checked"><strike>{{ $task->title }}</strike><i class="fa fa-trash-o float-right deleteBtn" onclick="deleteMe(this)" data-id="{{$task->id}}"></i></div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
