@extends('layouts.app')

@section('admin')
<!-- Bootstrap -->
<!-- <link href="/css/bootstrap.min.css" rel="stylesheet"> -->
<!-- Font Awesome -->
<link href="/css/font-awesome.min.css" rel="stylesheet">
<!-- Custom Theme Style -->
<link href="/css/custom.min.css" rel="stylesheet">
<link href="/css/custom.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="/js/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="/js/bootstrap.min.js"></script>
    <!-- Chart.js -->
    <script src="/js/Chart.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="/js/bootstrap-progressbar.min.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="/js/custom.min.js"></script>

    <!-- <script src='js/jquery-3.3.1.js'></script> -->
    <link rel='stylesheet' href='/css/jquery.dataTables.min.css'>

    <script src='js/jquery.dataTables.min.js'></script>
    <script>
      $(document).ready(function() {
        $('#example').DataTable();
      });

    </script>
    <style>

    </style>
@endsection

@section('content')

<div class="row">

    <div class="col-md-12">
        <div class="x_panel tile fixed_height_320 overflow_hidden" style="height: 100vh; overflow: scroll">
            <div class="x_title">
                <h2>Sysadmin dashboard</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

              <table class="display" id="example" style="width:100%">
                 <thead>
                    <tr>
                       <th>Id</th>
                       <th>Name</th>
                       <th>Email</th>
                       <th>Created at</th>
                       <th>Action</th>
                    </tr>
                 </thead>
                 <tbody>
                   @foreach ($users as $user)
                    <tr>
                       <td>{{$user->id}}</td>
                       <td>{{$user->name}}</td>
                       <td>{{$user->email}}</td>
                       <td>{{$user->created_at}}</td>
                       <td><a href='/sysadmin/settings/{{$user->id}}'>View</a></td>
                    </tr>
                  @endforeach
                 </tbody>
              </table>
            </div>
        </div>
    </div>
</div>

@endsection
