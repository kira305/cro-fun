@extends('layouts.app')
@section('content')
@section('breadcrumbs', Breadcrumbs::render('importlog/index'))
<style type="text/css">
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<div class="row">
    <div class="col-md-12">
        <ul class="timeline">
            <li>
                <div class="timeline-item">
                    <div class="timeline-body">
                        <div>
                            <div class="box-body">
                                <form id="form" action="{{ url('importlog/index') }}" method="POST">
                                    {{-- row 1 --}}
                                    <div class="col-lg-10 col-lg-offset-1 col-md-12">
                                        <div class="row search-row">
                                            <div class="col-md-12 col-lg-6 search-form">
                                                <div class="search-title col-lg-3 col-sm-3">
                                                    <span class="">所属会社</span>
                                                </div>
                                                <div class="col-lg-9 col-sm-9 search-item">
                                                    <select class="form-control" id="company_id" name="company_id">
                                                        @foreach($companies as $company)
                                                        <option
                                                            {{ session('company_id') == $company->id ? 'selected' : '' }}
                                                            value="{{$company->id}}">
                                                            {{$company->abbreviate_name}}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-lg-6 search-form">
                                                <div class="search-title col-lg-3 col-sm-3">
                                                    <span class="">取込データ</span>
                                                </div>
                                                <div class="col-lg-9 col-sm-9 search-item">
                                                    <select class="form-control" id="import_type" name="import_type">
                                                        <option value=""></option>
                                                        <option {{ session('import_type') == 1 ? 'selected' : '' }}
                                                            value="1">売上</option>
                                                        <option {{ session('import_type') == 2 ? 'selected' : '' }}
                                                            value="2">売上金残</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- row 2 --}}
                                    <div class="col-lg-10 col-lg-offset-1 col-md-12">
                                        <div class="row search-row">
                                            <div class="col-md-12 col-lg-6 search-form">
                                                <div class="search-title col-lg-3 col-sm-3">
                                                    <span class="">ユーザー名</span>
                                                </div>
                                                <div class="col-lg-9 col-sm-9 search-item">
                                                    <input type="text" id="user_name" value="{{ session('user_name') }}"
                                                        class="form-control" autocomplete="off" name="user_name">
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-lg-6 search-form">
                                                <div class="search-title col-lg-3 col-sm-3">
                                                    <span class="">ステータス</span>
                                                </div>
                                                <div class="col-lg-9 col-sm-9 search-item">
                                                    <select class="form-control" id="status" name="status">
                                                        <option value=""> </option>
                                                        <option {{ session('status_l') == '1' ? 'selected' : '' }}
                                                            value=1>
                                                            正常取込</option>
                                                        <option {{ session('status_l') == '0' ? 'selected' : '' }}
                                                            value=0>
                                                            取込エラー</option>
                                                        <option {{ session('status_l') == '2' ? 'selected' : '' }}
                                                            value=2>
                                                            削除済</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- row 3 --}}
                                    <div class="col-lg-10 col-lg-offset-1 col-md-12">
                                        <div class="row search-row">
                                            <div class="col-md-12 col-lg-6 search-form">
                                                <div class="search-title col-lg-3 col-sm-3">
                                                    <span class="">取込日</span>
                                                </div>
                                                <div class="col-lg-4 col-sm-4 search-item">
                                                    <input id="start_time" value="{{ session('start_time') }}"
                                                        autocomplete="off" name="start_time" type="text"
                                                        class="form-control">
                                                </div>
                                                <div class="search-title col-lg-1 col-sm-1">
                                                    <span class="">~</span>
                                                </div>
                                                <div class="col-lg-4 col-sm-4 search-item">
                                                    <input type="text" id="end_time" value="{{ session('end_time') }}"
                                                        class="form-control" autocomplete="off" name="end_time">
                                                </div>
                                                <div class="text-danger">{{ $errors->has('start_time') ? $errors->first('start_time') : ''}}</div>
                                                <div class="text-danger">{{ $errors->has('end_time') ? $errors->first('end_time') : ''}}</div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- end --}}
                                    @csrf
                                    <div class="col-lg-12 ">
                                        <div class="col-lg-3 col-sm-3 col-lg-offset-3 col-sm-offset-3">
                                            <button type="submit" id="search" class="search-button btn btn-primary btn-sm">検索</button>
                                        </div>
                                        <div class="col-lg-3 col-sm-3">
                                            <button type="button" id="clear" class="clear-button btn btn-default btn-sm">クリア</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>

                </div>
            </li>
            <li>


                <!--               <h4 class="text-red" style="text-align: center;">検索要件を入力してください</h4> -->


            </li>
            <li>

                <div class="timeline-item">
                    <div class="timeline-body">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-lg-3 col-lg-offset-8">
                                    @paginate(['item'=>$logs]) @endpaginate
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-10 col-lg-offset-1">
                                    <table id="import_log_table" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>ユーザー名</th>
                                                <th>データ件数</th>
                                                <th>ステータス</th>
                                                <th>取込日</th>
                                                <th>取込ファイル名</th>
                                                <th>エラーファイル名</th>
                                                <th>エラーデータダウンロード</th>
                                                <th>削除</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($logs as $log)
                                            <tr>
                                                <td>{{ $log->user->usr_name}}</td>
                                                <td>{{ $log->data_total}}</td>
                                                <td>@if($log->status == 1) 正常取込 @elseif($log->status == 2) 削除済 @else 取込エラー
                                                    @endif</td>
                                                <td>{{  date('Y年m月d日',strtotime($log->created_at))}}</td>
                                                <td>{{ $log->file_name}}</td>
                                                <td>{{ $log->file_name_err}}</td>
                                                <td>
                                                    @if($log->status == 0)
                                                    <button onclick="dowload_log({{$log->id}})"
                                                        class="btn btn-waring btn-sm">Dowload</button>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($log->status == 1)
                                                    <button data-value="{{$log->id}}"
                                                        class="btn btn-danger delete btn-sm">削除</button>
                                                    @endif
                                                </td>

                                            </tr>

                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" id="flag" value="0">
                    </div>

                </div>
            </li>
        </ul>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {


      $("#start_time").datepicker({
                    dateFormat: 'yy-mm-dd'
      });

      $("#end_time").datepicker({
                    dateFormat: 'yy-mm-dd'
      });

    //   $( "#csv1" ).click(function(event) {
    //                alert(123);
    //             document.location.href = "/importlog/csv";

	   // });

    });


     $(document).on('click', '#clear', function () {

             $('#example2').DataTable().state.clear();
             $('#company_id').prop('selectedIndex',0);
			 $('#import_type').prop('selectedIndex',0);
             $('#status').val('');
             $('#user_name').val('');
             $('#start_time').val('');
             $('#end_time').val('');
             $( "#form" ).submit();

    });


	$(".delete").click(function(){

		var id    = $(this).data('value');
		$.confirm({
		    title: 'このデータを削除しますか',
		    content: '',
		    type: 'red',
		    typeAnimated: true,
		    buttons: {
		        delete: {
		            text: 'YES',
		            btnClass: 'btn-blue',
		            with :'100px',
		            action: function(){

			            document.location.href = "/importlog/delete?id="+id+"&token="+"{{ $token }}";
		            }
		        },
		        cancel: {
		            text: 'NO',
		            btnClass: 'btn-red',
		            action: function(){
		            }
		        }
		    }
		});



	});


    function dowload_log(id){

                document.location.href = "/importlog/csv?file_id="+id;

    }

    function delete_log(id){



     }


</script>
@endsection
