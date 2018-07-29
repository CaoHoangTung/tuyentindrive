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

    @section('content');
    <div class="container body">
      <div class="main_container selectpicker">
        <div class='form-group'>
          <select value='7' class='form-control' id='filter' name='filter'>
            <option value='1'>1 ngày gần nhất</option>
            <option value='7'>Tuần này</option>
            <option value='30'>Tháng này</option>
            <option value='9999'>Tất cả</option>
          </select>
        </div>
        <script>
          var val = {{$daylimit}};
          var sel = document.getElementById('filter');
          var opts = sel.options;
          for (var opt, j = 0; opt = opts[j]; j++) {
            if (opt.value == val) {
              sel.selectedIndex = j;
              break;
            }
          }
        </script>
          <div role="main">
              <br />
              <span id='priorities' style='display:none'>{{$priorities}}</span>
              <span id='ips' style='display:none'>{{$ips}}</span>
              <div class="row">
                  <div class="col-md-4 col-sm-4 col-xs-12">
                      <div class="x_panel tile fixed_height_320">
                          <div class="x_title">
                              <h2>Total Ticket</h2>
                              <ul class="nav navbar-right panel_toolbox">
                                  <li>
                                      <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                  </li>
                              </ul>
                              <div class="clearfix"></div>
                          </div>
                          <div class="x_content" align="center">
                              <h1 style="font-size: 100px; margin-top: 45px">{{$totalTicket}}</h1>

                          </div>
                      </div>
                  </div>

                  <div class="col-md-4 col-sm-4 col-xs-12">
                      <div class="x_panel tile fixed_height_320 overflow_hidden">
                          <div class="x_title">
                              <h2>Ticket Priority</h2>
                              <ul class="nav navbar-right panel_toolbox">
                                  <li>
                                      <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                  </li>
                              </ul>
                              <div class="clearfix"></div>
                          </div>
                          <div class="x_content">
                              <table style="width:100%">
                                  <tr>
                                      <th style="width:37%;">
                                      </th>
                                      <th>
                                          <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                              <p class="">Priority</p>
                                          </div>
                                          <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                              <p class="">Occurrence</p>
                                          </div>
                                      </th>
                                  </tr>
                                  <tr>
                                      <td>
                                          <canvas class="canvasDoughnut1" height="140" width="140" style="margin: 15px 10px 10px 0"></canvas>
                                      </td>
                                      <td>
                                          <table class="tile_info">
                                            @foreach($priorities as $key=>$priority)
                                              <tr>
                                                  <td>
                                                      <p><i class="fa fa-square {{$color[$key]}}"></i>
                                                        {{$priority->priority}}
                                                      </p>
                                                  </td>
                                                  <td>{{$priority->occurence}}</td>
                                              </tr>
                                            @endforeach

                                          </table>
                                      </td>
                                  </tr>
                              </table>
                          </div>
                      </div>
                  </div>

                  <div class="col-md-4 col-sm-4 col-xs-12">
                      <div class="x_panel tile fixed_height_320 overflow_hidden">
                          <div class="x_title">
                              <h2>Top Attack IP</h2>
                              <ul class="nav navbar-right panel_toolbox">
                                  <li>
                                      <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                  </li>
                              </ul>
                              <div class="clearfix"></div>
                          </div>
                          <div class="x_content">
                              <table style="width:100%">
                                  <tr>
                                      <th style="width:37%;">
                                      </th>
                                      <th>
                                          <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                              <p class="">Ip</p>
                                          </div>
                                          <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                              <p class="">Occurrence</p>
                                          </div>
                                      </th>
                                  </tr>
                                  <tr>
                                      <td>
                                          <canvas class="canvasDoughnut2" height="140" width="140" style="margin: 15px 10px 10px 0"></canvas>
                                      </td>
                                      <td>
                                          <table class="tile_info">
                                            @foreach($ips as $key=>$ip)
                                              <tr>
                                                  <td>
                                                      <p><i class="fa fa-square {{$color[$key]}}"></i>{{$ip->src_ips}}</p>
                                                  </td>
                                                  <td>{{$ip->count}}</td>
                                              </tr>
                                            @endforeach

                                          </table>
                                      </td>
                                  </tr>
                              </table>
                          </div>
                      </div>
                  </div>


              </div>

              <div class="row">

                  <div class="col-md-12">
                      <div class="x_panel tile fixed_height_320 overflow_hidden" style="height: 100vh; overflow: scroll">
                          <div class="x_title">
                              <h2>Tickets</h2>
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
                                     <td>
                                       <span
                                        @if ($ticket->status=='Closed')
                                          class='sclosed'
                                        @elseif ($ticket->status=='Open')
                                          class='sopen'
                                        @endif
                                        >{{$ticket->status}}
                                        </span>
                                      </td>
                                     <td>{{$ticket->date}}</td>
                                     <td>view</td>
                                  </tr>
                                @endforeach
                               </tbody>
                            </table>

                              <!-- <table border="0" cellspacing="0" cellpadding="0">
                                 <tbody>
                                    <tr>
                                       <td class="gutter">
                                          <div class="line number1 index0 alt2" style="display: none;">1</div>
                                       </td>
                                       <td class="code">
                                          <div class="container" style="display: none;">
                                             <div class="line number1 index0 alt2" style="display: none;">&nbsp;</div>
                                          </div>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table> -->
                          </div>
                      </div>
                  </div>
              </div>

          </div>
        <!-- /page content -->
      </div>
    </div>
    @endsection

    @section('adminfooter')
    <script>
    $('#filter').change(function(){
      var limit = $('#filter').val();
      console.log(limit);
      location.assign('/admin?limit='+limit);
    });

    </script>
    @endsection
