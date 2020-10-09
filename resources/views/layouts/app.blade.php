<!DOCTYPE html>
<html>

<head>
    <meta name="_token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <meta http-equiv="x-pjax-version" content="v1">
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

    <link href="{{ asset('AdminLTE-master/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}"
        rel="stylesheet">
    <!-- Theme style -->

    <link href="{{ asset('AdminLTE-master/dist/css/skins/_all-skins.min.css') }}" rel="stylesheet">


    <link href="{{ asset('AdminLTE-master/plugins/timepicker/bootstrap-timepicker.min.css') }}" rel="stylesheet">
    <!-- Select2 -->


    <link href="{{ asset('AdminLTE-master/dist/css/AdminLTE.css') }}" rel="stylesheet">

    <link href="{{ asset('css/bootstrap_add.css') }}" rel="stylesheet">

    <link href="{{ asset('css/master.css') }}" rel="stylesheet">
    @if(strcmp(Request::path(),'project/create') != 0 && strcmp(Request::path(),'project/edit') != 0)
    <link href="{{ asset('css/gobal.css') }}" rel="stylesheet">
    @endif

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.pjax/2.0.1/jquery.pjax.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/gobal.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/ajax_setup.js') }}"></script>
    <script type="text/javascript" src="{{ asset('AdminLTE-master/dist/js/adminlte.min.js') }}"></script>
    <link href="{{ asset('datepicker/style.css') }}" rel="stylesheet">
    <link href="{{ asset('datepicker/jquery-ui.min.css') }}" rel="stylesheet">
    <script type="text/javascript" src="{{ asset('datepicker/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/session_timeout.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.ui.datepicker-ja.js') }}"></script>
    <!--  <script type="text/javascript" src="{{ asset('datepicker/jquery-3.0.0.js') }}"></script> -->
    @yield('styles')
    @yield('scripts')


</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        <header class="main-header">
            <a class="logo">
                <span class="logo-lg"> <img onclick="window.location='{{ url("/home") }}'"
                        src="{{ asset('uploads/logo/'.$logo) }}"></span>
            </a>
            <nav class="navbar navbar-static-top">
                <div class="row">
                    <div class="col-lg-2 col-lg-offset-5" style="text-align:left;padding-top: 10px;">
                        <h3 onclick="window.location='{{ url("/home") }}'"
                            style="min-width:150px;color:white; display: inline;float: none; height: 100%">Cro-Fun</h3>
                    </div>
                    <div class="col-lg-3">
                        <ul class="infor" style="margin-top: 15px;float: right;">
                            <li style="display:inline;color: #FFFFFF">{{ Auth::user()->company->abbreviate_name }}</li>
                            <li style="display:inline;color: #FFFFFF">-</li>
                            <li style="display:inline;color: #FFFFFF">{{ Auth::user()->usr_name }}</li>
                        </ul>
                    </div>
                    <div class="col-lg-1">
                        <div style="margin-top: 15px">
                            <a style="display:inline;" class="btn bg-orange" href="{{ url('user/logout') }}">
                                LOGOUT
                            </a>
                        </div>
                    </div>
                </div>
            </nav>

        </header>
        <aside class="main-sidebar">

            <section class="sidebar">

                <ul class="sidebar-menu" data-widget="tree">

                    @php($url_s0 = explode("/",Request::path()))
                    @php($d_ul = "")
                    @php($d_il = "")
                    @foreach( $menu_all_list as $menu_all)
                    @php($menu_s0 = explode("/",$menu_all->link_url))
                    @if ($menu_all['dis_sort'] == 1)
                    {!! $d_ul !!}
                    {!! $d_il !!}
                    <li class="menu_parent treeview @if (strpos($menu_s0[0], $url_s0[0]) !== false) menu-open @endif"
                        data-value="{{ $menu_all->id }}">
                        <a id="menu_title_{{$menu_all->position}}">
                            <i class="fa  fa-folder"></i> <span>{{$menu_all->link_name}} </span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu" @if (strpos($menu_s0[0], $url_s0[0]) !==false) style="display: block;"
                            @endif id="menu_{{$menu_all->position}}">
                            @php($d_ul = "</ul>")
                        @php($d_il = "
                    </li>")
                    @elseif ($menu_all['dis_sort'] === 0)
                    {!! $d_ul !!}
                    {!! $d_il !!}
                    <li class="treeview">
                    <li class="menu_main menuc_{{$loop->iteration}} @if ($menu_s0[0] == $url_s0[0]) label-default @endif"
                        data-value="{{ $menu_all->id }}"><a href="{{url($menu_all->link_url)}}"><i
                                class="{{ $menu_all->icon }}"></i>{{$menu_all->link_name}}</a></li>
                    </li>
                    @php($d_ul = "")
                    @php($d_il = "")
                    @else
                    <li style="padding-left: 20px;" class="menu_child menuc_{{$loop->iteration}}"
                        data-value="{{ $menu_all->id }}"><a href="{{ url($menu_all->link_url) }}"><i
                                class="{{ $menu_all->icon }}"></i>{{ $menu_all->link_name }}</a></li>
                    @endif

                    @endforeach


                </ul>

            </section>

        </aside>

        <div class="content-wrapper">
            <main class="py-4" id="body">

                @yield('breadcrumbs')

                @yield('content')
            </main>
        </div>
        @include('layouts.footer')
        @include('layouts.bind_js')
    </div>

    <script type="text/javascript"
        src="{{ asset('AdminLTE-master/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript"
        src="{{ asset('AdminLTE-master/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/get_headquarter_list.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/get_department_list.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/get_group_list.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/ready_event.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/get_position_list.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/get_rule_list.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/menu_rule.js') }}"></script>

    @if(Request::path() == 'tree/index')
    <script type="text/javascript" src="{{ asset('js/digaram_datepicker.js') }}"></script>
    @endif

    <script>
        $( document ).ready(function() {


  if (window.location.href.split('/').pop() == 'search') {

      $('#example2').DataTable({

          'paging'      : true,
          'lengthChange': false,
          'searching'   : false,
          'ordering'    : false,
          'stateSave'   : true,
          'info'        : false,
          'autoWidth'   : false,
           'pageLength': 4,
          'dom': '<"top"p>',
        })
     }else{

      $('#example2').DataTable({
          'paging'      : true,
          'lengthChange': false,
          'searching'   : false,
          'ordering'    : false,
          'stateSave'   : true,
          'info'        : false,
          'autoWidth'   : false,
           'pageLength': 10,
          'dom': '<"top"p>',
        })
     }
  });

    </script>
</body>

</html>
