
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .addBtn{
            position: fixed;
            bottom: 75px;
            height: 50px;
            width: 50px;
            right: 75px;
            text-align: center;
            color:white;
            background-color: red;
            border-radius: 50%;
        }
        .toast-container{
            position: fixed;
            top:70px;
            right: 10px;
        }
        .deleteBtn{
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                 Todo App
             </a>
             <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                    @endif
                    @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<main class="py-4">
    @yield('content')
</main>
</div>

@if(Auth::check())
<!-- Trigger the modal with a button -->
<button type="button" class="btn addBtn" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i></button>

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
          <form class="form" id="createTask" action="/create">
            <div class="modal-body">
              @csrf
              <div class="form-group">
                  <input type="text" class="form-control" name="task" id="task" placeholder="Write something here..">
              </div>
          </div>
          <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Add</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
      </form>
  </div>
</div>
</div>
<div class="toast-container">
    <div class="toast" data-autohide="true">
        <div class="toast-body" id="toast-body"></div>
    </div>
</div>

<script>
    // this is the id of the form
    $("#createTask").submit(function(e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.

        var form = $(this);
        var url = form.attr('action');

        $.ajax({
            type: "GET",
            url: url,
            data: form.serialize(),
            success: function(data) {
                $('#toast-body').text(data.message);
                $('.toast').toast('show');

                $('#myModal').modal('hide');
                $('#task').val('');
                $('#openTasks').append('<div class="alert-info alert" data-task-open-id="'+data.task.id+'"><input type="checkbox" onclick="checkboxClicked(this)" class="mycheck mr-2" data-id="'+data.task.id+'" data-status="'+data.task.status+'" >'+data.task.title+'<i class="fa fa-trash-o float-right deleteBtn" onclick="deleteMe(this)" data-id="'+data.task.id+'"></i></div>');
                
            }
        });
    });

    function changeStatus(id,status){
        $.ajax({
            type: "GET",
            url:"{{ url('/') }}"+"/"+status,
            data: { id : id, status : status , '_token':'{{ csrf_token() }}' },
            success: function(data) {
                $('#toast-body').text(data.message);
                $('.toast').toast('show');

                if(data.task.status=='resolve'){
                    $("div[data-task-open-id='" + data.task.id + "']").remove();
                    $('#closedTasks').append('<div class="alert-danger alert" data-task-close-id="'+data.task.id+'"><input type="checkbox" onclick="checkboxClicked(this)" class="mycheck mr-2" data-id="'+data.task.id+'" data-status="'+data.task.status+'" checked="checked"><strike>'+data.task.title+'</strike><i class="fa fa-trash-o float-right deleteBtn" onclick="deleteMe(this)" data-id="'+data.task.id+'"></i></div>');
                }else{
                    $("div[data-task-close-id='" + data.task.id + "']").remove();
                    $('#openTasks').append('<div class="alert-info alert" data-task-open-id="'+data.task.id+'"><input type="checkbox" onclick="checkboxClicked(this)" class="mycheck mr-2" data-id="'+data.task.id+'" data-status="'+data.task.status+'">'+data.task.title+'<i class="fa fa-trash-o float-right deleteBtn" onclick="deleteMe(this)" data-id="'+data.task.id+'"></i></div>');    
                }   
            }
        });
    }

    function checkboxClicked(input){
        var id=$(input).data('id');
        if(input.checked) {
            changeStatus(id,'resolve');
        }
        else{
            changeStatus(id,'open');
        }
    }

    function deleteTask(id){
        $.ajax({
            type: "GET",
            url:"{{ url('/') }}"+"/delete",
            data: { id : id, '_token':'{{ csrf_token() }}' },
            success: function(data) {
                $('#toast-body').text(data.message);
                $('.toast').toast('show');
                if(data.status=='resolve'){
                    $("div[data-task-close-id='" + data.id + "']").remove();
                }else{
                    $("div[data-task-open-id='" + data.id + "']").remove();
                }   
            }
        });
    }

    function deleteMe(input){
        var id=$(input).data('id');
        deleteTask(id);
    }

</script>

@endif

</body>
</html>
