<!DOCTYPE html>
<html>
<head>
  <meta name="_token" content="{{ csrf_token() }}">
  <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
  <title>Cro-Fun</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
   
   <link href="{{ asset('AdminLTE-master/bower_components/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
  <!-- Font Awesome -->
 
   <link href="{{ asset('AdminLTE-master/bower_components/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
  <!-- Ionicons -->
 
   <link href="{{ asset('AdminLTE-master/bower_components/Ionicons/css/ionicons.min.css') }}" rel="stylesheet">
  <!-- DataTables -->
  
   <link href="{{ asset('AdminLTE-master/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
  <!-- Theme style -->
 
  <link href="{{ asset('AdminLTE-master/dist/css/skins/_all-skins.min.css') }}" rel="stylesheet">


  <link href="{{ asset('AdminLTE-master/plugins/timepicker/bootstrap-timepicker.min.css') }}" rel="stylesheet">
  <!-- Select2 -->

  
  <link href="{{ asset('AdminLTE-master/dist/css/AdminLTE.min.css') }}" rel="stylesheet">

  <link href="{{ asset('css/bootstrap_add.css') }}" rel="stylesheet">
  <link href="{{ asset('css/MonthPicker.css') }}" rel="stylesheet">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

  <script type="text/javascript" src="{{ asset('AdminLTE-master/dist/js/adminlte.min.js') }}"></script>
  <link href="{{ asset('datepicker/style.css') }}" rel="stylesheet">
  <link href="{{ asset('datepicker/jquery-ui.min.css') }}" rel="stylesheet">
  <script type="text/javascript" src="{{ asset('datepicker/jquery-3.0.0.js') }}"></script>
  <script type="text/javascript" src="{{ asset('datepicker/jquery-ui.min.js') }}"></script>
  <style type="text/css">
    .title {
       text-align: center;
    }
    .highlight a{
        background-color: #FFFF00 !important;
        color:  #191970 !important;
    }
    .concurrent {

       background-color:  #FFE4E1;
    }
    .slide_bar {

      display: block !important;

    }


  </style>
        <script type='text/javascript'>
            
            // An array of dates ( 'dd-mm-yyyy' )
            var highlight_dates = [

                    @foreach($days as $day)
                       
                       "{{ $day }}",
                       
                    @endforeach

                ];
            
            $(document).ready(function(){
                
                // Initialize datepicker
                $('#datepicker').datepicker({
                    beforeShowDay: function(date){
                        
                        var month = date.getMonth()+1;
                        var year = date.getFullYear();
                        var day = date.getDate();
                        
                        // Change format of date
                        if(month < 10){ month = '0' + month;}
                        if(day < 10){ day = '0' + day}
                        var newdate = year+"-"+month+'-'+day;
                        
                        // Set tooltip text when mouse over date
                        var tooltip_text = "New event on "+newdate;

                        // Check date in Array
                        if(jQuery.inArray(newdate, highlight_dates) != -1){
                            return [true, "highlight" ];
                        }
                        return [false];
                    },
                    dateFormat: 'yy-mm-dd'
                });

                $('#start_date').datepicker({
                    beforeShowDay: function(date){
                        
                        var month = date.getMonth()+1;
                        var year = date.getFullYear();
                        var day = date.getDate();
                        
                        // Change format of date
                        if(month < 10){ month = '0' + month;}
                        if(day < 10){ day = '0' + day}
                        var newdate = year+"-"+month+'-'+day;

                        // Set tooltip text when mouse over date
                        var tooltip_text = "New event on "+newdate;

                        // Check date in Array
                        if(jQuery.inArray(newdate, highlight_dates) != -1){
                            return [true, "highlight", tooltip_text ];
                        }
                        return [false];
                    },
                    dateFormat: 'yy-mm-dd'
                });

                $('#end_date').datepicker({
                    beforeShowDay: function(date){
                        
                        var month = date.getMonth()+1;
                        var year = date.getFullYear();
                        var day = date.getDate();
                        
                        // Change format of date
                        if(month < 10){ month = '0' + month;}
                        if(day < 10){ day = '0' + day}
                        var newdate = year+"-"+month+'-'+day;

                        // Set tooltip text when mouse over date
                        var tooltip_text = "New event on "+newdate;

                        // Check date in Array
                        if(jQuery.inArray(newdate, highlight_dates) != -1){
                            return [true, "highlight", tooltip_text ];
                        }
                        return [false];
                    },
                    dateFormat: 'yy-mm-dd'
                });

            });
        </script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a  class="logo">

      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"> <img src="{{ asset('uploads/'.$logo) }}" ></span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!--  <div class="navbar-custom-menu">
         <ul class="nav navbar-nav">
           <li> -->
              <div class="pull-center" style="float:left;margin-left: 40%">
                      
                        <img src="{{ asset('img/NOCchan_2_basic.jpg') }}" alt="" height="50px" width="50px">

              </div>
              <div style="float:left;margin-left: 1%;height: 50px;">
                <h3 class="text-white" style="color: white;font-size: 150%;margin-bottom:3px;text-align: center;">CRO-FUN</h3>
              </div>
              
               <div> 
                    
                    <a href="{{ url('user/logout') }}" style="float:right;margin-right: 50px;">
                    <button style="margin-right:5%;margin-top:3px;width: 100px;height: 40px" type="button" class="btn bg-orange margin">LOGOUT</button>
                    </a>
                    <div style="margin-top: 10px;float: right;">
                        <h4 style="color: white;text-align: center;font-size: 14px;">{{ Auth::user()->usr_name }}</h4>
                    </div>
                  

               </div>
          
  
    </nav>
     
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">

       @php($url_s0 = explode("/",Request::path()))
       @php($d_ul = "") 
       @php($d_il = "") 
       @foreach( $menu_all_list as $menu_all)
              @php($menu_s0 = explode("/",$menu_all->link_url))
        @if ($menu_all['dis_sort'] == 1)
          {!! $d_ul !!}
          {!! $d_il !!}
          <li class="treeview @if (strpos($menu_s0[0], $url_s0[0]) !== false) menu-open @endif">
          <a id="menu_title_{{$menu_all->position}}">
          <i class="fa  fa-folder"></i> <span>{{$menu_all->link_name}}</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
          </a>
                <ul class="treeview-menu" @if (strpos($menu_s0[0], $url_s0[0]) !== false)  style="display: block;" @endif id="menu_{{$menu_all->position}}">
            @php($d_ul = "</ul>")
            @php($d_il = "</il>")
        @elseif ($menu_all['dis_sort'] === 0)
          {!! $d_ul !!}
          {!! $d_il !!}
              <li class="treeview">
                  <li class="menuc_{{$loop->iteration}} @if ($menu_s0[0] == $url_s0[0]) label-default @endif"><a href="{{url($menu_all->link_url)}}"><i class="{{ $menu_all->icon }}"></i>{{$menu_all->link_name}}</a></li>
              </li>
            @php($d_ul = "")  
            @php($d_il = "")  
        @else
                  <li class="menuc_{{$loop->iteration}}"><a href="{{ url($menu_all->link_url) }}"><i class="{{ $menu_all->icon }}"></i>{{ $menu_all->link_name }}</a></li>
        @endif

         @endforeach
  

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
        <main class="py-4">
          
            @yield('breadcrumbs')
 
            @yield('content')
        </main>
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer" style="height: 60px;">
      <div class="col-md-3"></div>
      <div class="col-md-6">
        <img src="{{ asset('img/NOCchan_2_Flight.jpg') }}" style="height: 40px;width: 45px;margin-bottom:10px;float: left;">
        <img src="{{ asset('img/NOCchan_1_basic.jpg') }}" style="height: 40px;width: 45px;margin-bottom:10px;float: left;">
        <h4 style="float: left;margin-left: 20px;">
         Copyright <strong>2019</strong> NOC Outsourcing & Consulting Inc.
        </h4>
        <img src="{{ asset('img/NOCchan_1_basic.jpg') }}" style="height: 40px;width: 45px;margin-bottom:10px;float: left;margin-left: 20px;">
        <img src="{{ asset('img/NOCchan_2_Flight.jpg') }}" style="height: 40px;width: 45px;margin-bottom:10px;float: left;">

      </div>
      <div class="col-md-3"></div>
    <div class="pull-right hidden-xs">
      
    </div>
  </footer>

</div>


<script type="text/javascript" src="{{ asset('src/jquery.multi-select.js') }}"></script>
<script type="text/javascript" src="{{ asset('AdminLTE-master/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('AdminLTE-master/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/get_headquarter_list.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/get_department_list.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/get_group_list.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/ready_event.js') }}"></script>
<script>
  $( document ).ready(function() {
    
     datatable = $('#example2').DataTable({
          'paging'      : true,
          'lengthChange': false,
          'searching'   : false,
          'ordering'    : false,
          'stateSave'   : true,
          'info'        : false,
          'autoWidth'   : false,
          'pageLength'  : 10,
          'dom': '<"top"p>',
        })
     
    


  });

</script>
</body>
</html>
