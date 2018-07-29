<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #000;
                font-family: 'Raleway', sans-serif;
                font-weight: 1000;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>


    </head>

    <body>
        <script src='/js/jquery-3.3.1.js'></script>
        <link rel='stylesheet' href='/css/jquery.dataTables.min.css'>

        <script src='/js/jquery.dataTables.min.js'></script>
        <script>
          $(document).ready(function() {
            $('#example').DataTable();
          } );
        </script>
        <table class="display" id="example" style="width:100%">
           <thead>
              <tr>
                 <th>Id</th>
                 <th>Title</th>
                 <th>Priority</th>
                 <th>Status</th>
                 <th>Time</th>
                 <th>Action</th>
              </tr>
           </thead>
           <tbody>
             @foreach ($tickets as $ticket)
              <tr>
                 <td>{{$ticket->id}}</td>
                 <td>{{$ticket->title}}</td>
                 <td>{{$ticket->priority}}</td>
                 <td>{{$ticket->status}}</td>
                 <td>{{$ticket->date}}</td>
                 <td>view</td>
              </tr>
            @endforeach

           </tbody>
        </table>

    </body>
</html>
