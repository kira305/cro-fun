@extends('layouts.app')


@section('content')
@section('breadcrumbs', Breadcrumbs::render('loxg/index'))
<style type="text/css">
	table{
		width: 100%;
		word-break: break-word;
		word-wrap: break-word;
		margin-bottom : 0px!important;;
	}
	.panel-body{
		padding : 5px!important; 
	}
	.panel{
		padding : 5px!important;
		margin-bottom : 5px;
	}
	.col-lg-6{
		padding-right:1px!important;
		padding-left:1px!important;
	}
	.breadcrumb{
		margin-bottom : 0px;
	}
	td { 
		padding : 3px!important; 
		word-wrap: break-word;
		overflow-wrap: break-word;
		white-space: normal;
	}
</style>
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
				        	  	<div class="row">
					                <div class="col-md-3 offset-md-3">
					                  <label style="float: right;">所属会社</label>
					                </div>
					                <div class="col-md-2">
					                	<div class="form-group">
						                    <select class="form-control" id="company_id" name="company_id" >
						                    	<option></option>
									        @foreach($companies as $company)
						                    <option 
						                     
						                    @if(session()->has('company_id_log'))

											   @if(session('company_id_log') == $company->id) selected  @endif 

											@else 
										       @if(Auth::user()->company_id == $company->id) selected  @endif 
											@endif

						                    value="{{$company->id}}">{{$company->abbreviate_name}}

						                    </option>
						                  
					                          @endforeach
											</select>
									    </div>
					                </div>
					                <div class="col-md-3 offset-md-3">
					                  <label style="float: right;">変更テーブル</label>
					                </div>
   					                <div class="col-md-2">
					                	<div class="form-group">
						                    <select class="form-control" id="table_id" name="table_id" >
						                    	<option></option>
									        @foreach($tables as $tabledate)
						                    <option 
						                     
						                    @if(session()->has('table_id_log'))

												@if(session('table_id_log') == $tabledate->id) selected  @endif 

											@endif

						                    value="{{$tabledate->id}}">{{$tabledate->table_name}}

						                    </option>
						                  
					                          @endforeach
											</select>
									    </div>
					                </div>
						        </div>


                                    
                                @csrf


						        <div class="row">
				                  
                                     <div class="col-md-1">
					                  <label style="float: right;">操作画面</label>
					                </div>
					                <div class="col-md-2">
					                	 <div class="form-group">

						                    <select class="form-control" id="form_id" name="form_id" >
						                    <option></option>
									        @foreach($formes as $form)
						                    <option 
						                     
						                    @if(session()->has('form_id_log'))

												@if(session('form_id_log') == $form->id) selected  @endif 

											@endif

						                    value="{{$form->id}}">{{$form->link_name}}

						                    </option>
						                  
					                          @endforeach
											</select>					                       
					                     </div>
					                </div>

                                    <div class="col-md-1">
					                  <label style="float: right;">処理区分</label>
					                </div>
					                <div class="col-md-2">
					                	<div class="form-group">
					                       <select id="process" name="process" class="form-control" >
						                       <option></option>
									        @foreach($arrprocess as $process)
						                    <option 
						                     
						                    @if(session()->has('process_log'))

												@if(session('process_log') == $process) selected  @endif 

											@endif

						                    value="{{ $process }}">{{$process}}

						                    </option>
						                  
					                          @endforeach

    									  
	    									</select>
					                     </div>
					                </div>
					           
						        </div>

						        <div class="row">
				                  
                                    <div class="col-md-1">
					                  <label style="float: right;">UPDATEコード</label>
					                </div>
					                <div class="col-md-2">
					                	<div class="form-group">
					                       <input id="update_code" value="{{session('update_code_log')}}" name="update_code" type="text" class="form-control" >
					                     </div>
					                </div>
						           
                                    <div class="col-md-1">
					                  <label style="float: right;">UPDATE名称</label>
					                </div>
					                <div class="col-md-2">
					                	<div class="form-group">
					                       <input id="update_name" value="{{session('update_name_log')}}" name="update_name" type="text" class="form-control" >
					                     </div>
					                </div>
					           
						        </div>

						        <div class="row">
				                  
                                    <div class="col-md-1">
					                  <label style="float: right;">操作日</label>
					                </div>
					                <div class="col-md-2">
				                	 <div class="form-group">
				                       <input type="text" value="{{session('update_data_st_log')}}" name="update_data_st" id="datepicker" autocomplete="off" class="form-control" >
				                     </div>
					                </div>

                                    <div class="col-md-1">
					                  <label style="float: right;">～</label>
					                </div>
					                <div class="col-md-2">
					                	 <div class="form-group">
					                       <input type="text" value="{{session('update_data_en_log')}}" name="update_data_en" id="datepicker2" autocomplete="off" class="form-control" >
					                     </div>
					                </div>
					           
						        </div>

				                @if ($errors->has('update_data_st') or $errors->has('update_data_en') )
						        <div class="row">

                                    <div class="col-md-1"> </div>
					                @if ($errors->has('update_data_st'))
					                <div class="col-md-2">
					                	<div class="form-group">
	    	                               <span class="text-danger">{{ $errors->first('update_data_st') }}</span>
                               			</div>
					                </div>	
					                @else
					                <div class="col-md-2">
					                	<div class="form-group"></div>
					                </div>
	                                @endif

	                                @if ($errors->has('update_data_en'))
                                    <div class="col-md-1"></div>
					                <div class="col-md-2">
					                	 <div class="form-group">
					                       <span class="text-danger">{{ $errors->first('update_data_en') }}</span>
					                     </div>
					                </div>
					                @endif
								</div>
                                @endif

						        <br>
				                <div class="row">
			                	　　　<br>
					                <div class="col-md-5">
					                
					                  <button type="submit" id="search" style="float: right;width: 100px;" class="btn btn-primary btn-sm">検索</button>

					                </div>
					                <div class="col-md-5">
					                
					                  <button type="button" style="float: left;width: 100px;" name="clear" id="clear" class="btn btn-default btn-sm">クリア</button>

					                  <input name="clear1" id="clear1" hidden>

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
            @if (isset($log))    	

             <div class="timeline-item">

                <div class="timeline-body">
			            
			            <div class="box-body">
					      <div class="row">
					      	 <div class="col-sm-8">
					      	 	
					      	 </div>
					         <div class="col-sm-3">

                                @paginate(['item'=>$log]) @endpaginate

					      	 </div>
					      	 <div class="col-sm-1">
					      	 	
					      	 </div>
					      </div> 
					      <div class="row">
							<table id="log_table" class="table table-bordered table-hover">
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
						                  	<a href="{{route('LOG_VIEW', ['id' => $log->id,'page' => request()->page])}}"><button style="float: left;" class="btn btn-info btn-sm">詳細</button></a>
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
	            <li>
	            		             
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
