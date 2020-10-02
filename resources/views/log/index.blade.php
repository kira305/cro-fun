@extends('layouts.app')
@section('content')
@section('breadcrumbs', Breadcrumbs::render('loxg/index'))
<script type="text/javascript" src="{{ asset('js/MonthPicker.js') }}"></script>
<div class="row">
    <div class="col-md-12">
        <ul class="timeline">
            <li>
                <div class="timeline-item">
                    <div class="timeline-body">
                        <div>
                            <div class="box-body">
                                <form action="{{ url('loxg/index') }}" id="form" method="post">
                                    {{-- row 1 --}}
                                    <div class="col-lg-12 col-md-12">
                                        <div class="row search-row">
                                            <div class="col-md-12 col-lg-6 search-form">
                                                <div class="search-title col-lg-3 col-sm-3">
                                                    <span class="">所属会社</span>
                                                </div>
                                                <div class="col-lg-9 col-sm-9 search-item">
                                                    <select class="form-control" id="company_id" name="company_id">
                                                        <option></option>
                                                        @foreach($companies as $company)
                                                        <option @if(session()->has('company_id_log'))
                                                            @if(session('company_id_log') == $company->id) selected @endif
                                                            @else
                                                            @if(Auth::user()->company_id == $company->id) selected @endif
                                                            @endif
                                                            value="{{$company->id}}">{{$company->abbreviate_name}}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-lg-6 search-form">
                                                <div class="search-title col-lg-3 col-sm-3">
                                                    <span class="">変更テーブル</span>
                                                </div>
                                                <div class="col-lg-9 col-sm-9 search-item">
                                                    <select class="form-control" id="table_id" name="table_id">
                                                        <option></option>
                                                        @foreach($tables as $tabledate)
                                                        <option @if(session()->has('table_id_log'))
                                                            @if(session('table_id_log') == $tabledate->id) selected @endif
                                                            @endif
                                                            value="{{$tabledate->id}}">{{$tabledate->table_name}}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- row 2 --}}
                                    <div class="col-lg-12 col-md-12">
                                        <div class="row search-row">
                                            <div class="col-md-12 col-lg-6 search-form">
                                                <div class="search-title col-lg-3 col-sm-3">
                                                    <span class="">操作画面</span>
                                                </div>
                                                <div class="col-lg-9 col-sm-9 search-item">
                                                    <select class="form-control" id="form_id" name="form_id">
                                                        <option></option>
                                                        @foreach($formes as $form)
                                                        <option @if(session()->has('form_id_log'))
                                                            @if(session('form_id_log') == $form->id) selected @endif
                                                            @endif
                                                            value="{{$form->id}}">{{$form->link_name}}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-lg-6 search-form">
                                                <div class="search-title col-lg-3 col-sm-3">
                                                    <span class="">処理区分</span>
                                                </div>
                                                <div class="col-lg-9 col-sm-9 search-item">
                                                    <select id="process" name="process" class="form-control">
                                                        <option></option>
                                                        @foreach($arrprocess as $process)
                                                        <option @if(session()->has('process_log'))
                                                            @if(session('process_log') == $process) selected @endif
                                                            @endif
                                                            value="{{ $process }}">{{$process}}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- row 3 --}}
                                    <div class="col-lg-12 col-md-12">
                                        <div class="row search-row">
                                            <div class="col-md-12 col-lg-6 search-form">
                                                <div class="search-title col-lg-3 col-sm-3">
                                                    <span class="">UPDATEコード</span>
                                                </div>
                                                <div class="col-lg-9 col-sm-9 search-item">
                                                    <input id="update_code" value="{{session('update_code_log')}}"
                                                    name="update_code" type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-lg-6 search-form">
                                                <div class="search-title col-lg-3 col-sm-3">
                                                    <span class="">UPDATE名称</span>
                                                </div>
                                                <div class="col-lg-9 col-sm-9 search-item">
                                                    <input id="update_name" value="{{session('update_name_log')}}"
                                                    name="update_name" type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- row 4 --}}
                                    <div class="col-lg-12 col-md-12">
                                        <div class="row search-row">
                                            <div class="col-md-12 col-lg-6 search-form">
                                                <div class="search-title col-lg-3 col-sm-3">
                                                    <span class="">操作日</span>
                                                </div>
                                                <div class="col-lg-4 col-sm-4 search-item">
                                                    <input type="text" value="{{session('update_data_st_log')}}"
                                                    name="update_data_st" id="datepicker" autocomplete="off"
                                                    class="form-control">
                                                </div>
                                                <div class="search-title col-lg-1 col-sm-1">
                                                    <span class="">~</span>
                                                </div>
                                                <div class="col-lg-4 col-sm-4 search-item">
                                                    <input type="text" value="{{session('update_data_en_log')}}"
                                                    name="update_data_en" id="datepicker2" autocomplete="off"
                                                    class="form-control">
                                                </div>
                                                <div class="text-danger">{{ $errors->has('update_data_st') ? $errors->first('update_data_st') : ''}}</div>
                                                <div class="text-danger">{{ $errors->has('update_data_en') ? $errors->first('update_data_en') : ''}}</div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- end --}}
                                    @csrf
                                    <div class="col-lg-12 ">
                                        <div class="col-lg-3 col-sm-3 col-lg-offset-3 col-sm-offset-3">
                                            <button type="submit" id="search"
                                                class="search-button btn btn-primary btn-sm">検索</button>
                                        </div>
                                        <div class="col-lg-3 col-sm-3">
                                            <button type="button" id="clear"
                                                class="clear-button btn btn-default btn-sm">クリア</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li>
                @if (isset($log))
                <div class="timeline-item">
                    <div class="timeline-body">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-lg-3 col-lg-offset-9">
                                    @paginate(['item'=>$log]) @endpaginate
                                </div>
                            </div>
                            <div class="row">
                                <table id="log_table" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>詳細</th>
                                            <th>処理区分</th>
                                            <th>操作画面</th>
                                            <th>変更テーブル</th>
                                            <th>コード</th>
                                            <th>名称</th>
                                            <th>操作ユーザー</th>
                                            <th>操作日</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($log as $log)
                                        <tr>
                                            <td>
                                                <a
                                                    href="{{route('LOG_VIEW', ['id' => $log->id,'page' => request()->page])}}"><button
                                                        style="float: left;" class="btn btn-info btn-sm">詳細</button></a>
                                            <td>{{  $log->process }}</td>
                                            <td>@if($log->menu) {{  $log->menu->link_name }} @endif</td>
                                            <td>@if($log->table) {{ $log->table->table_name }} @endif</td>
                                            <td>{{  $log->code }}</td>
                                            <td>{{  $log->name }}</td>
                                            <td>{{  $log->user->usr_name }}</td>
                                            <td>{{  date('Y/m/d',strtotime($log->updated_at)) }}</td>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </li>
        </ul>
    </div>
</div>
<script type="text/javascript">
    $(document).on('click', '#clear', function () {
		//1ページに移動
         $('#example2').DataTable().state.clear();
         $('#company_id').prop('selectedIndex',0);
         $('#table_id').val('');
         $('#form_id').val('');
         $('#process').val('');
         $('#update_code').val('');
         $('#update_name').val('');
         $( "#datepicker" ).val('');
         $( "#datepicker2" ).val('');
         $( "#clear1" ).val('1');
         $( "#form" ).submit();
	});

	$('#datepicker').datepicker({
	    autoclose: true,
	    todayHighlight: true,
	});

	$('#datepicker2').datepicker({
	    autoclose: true,
	    todayHighlight: true,
	});

</script>
@endsection
