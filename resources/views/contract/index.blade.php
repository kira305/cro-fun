@extends('layouts.app')


@section('content')
@section('breadcrumbs', Breadcrumbs::render('contract/index'))
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
      <div class="row">
        <div class="col-md-12">
       
          <ul class="timeline">
          	<li>
	             
             <div class="timeline-item">
               
                <div class="timeline-body">
                      <div>
			            
			            <div class="box-body">

					        <form action="{{ url('contract/index') }}" id="form" method="post">
				        	  	<div class="row">
					                <div class="col-md-3 offset-md-3">
					                  <label style="float: right;">所属会社</label>
					                </div>
					                <div class="col-md-2">
					                	<div class="form-group">
						                    <select class="form-control" id="company_id" name="company_id" >
									        @foreach($companies as $company)
						                    <option 
						                     
						                    @if(session()->has('company_id_cont'))

											   @if(session('company_id_cont') == $company->id) selected  @endif 

											@else 
											       @if(Auth::user()->company_id == $company->id) selected  @endif 
											@endif

						                    value="{{$company->id}}">{{$company->abbreviate_name}}

						                    </option>
						                  
					                          @endforeach
											</select>
									    </div>
					                </div>
					                
						                <div class="col-md-1 offset-md-3">
					                  <label style="float: right;">事業本部</label>
					                </div>
					                <div class="col-xs-2">
					                 <div class="form-group">
					                  <select class="form-control" id="headquarter_id" name="headquarter_id">
						                  	<option value=""> </option>
						                  	@foreach($headquarters as $headquarter)
								                <option class="headquarter_id" 
								                data-value="{{ $headquarter->company_id }}"
								                @if(isset($headquarter_id))
									                @if ($headquarter_id == $headquarter->id) selected @endif 
								                @endif
								                value="{{$headquarter->id}}">{{$headquarter->headquarters}}</option>
						                     @endforeach
					                  </select>
					                </div>
					                </div>

						        </div>

				              <div class="row">
				              
					                <div class="col-md-3 offset-md-3">
					                  <label style="float: right;">部署</label>
					                </div>
					                <div class="col-xs-2">
					                 <div class="form-group">
					                  <select class="form-control" id="department_id" name="department_id">
					                  	<option selected value=""></option>
					                  	@foreach($departments as $department)
						                <option class="department_id" 
						                    data-value="{{ $department->headquarter()->id }}"
						                @if(isset($department_id))
						                @if ($department_id == $department->id) selected @endif 
						                @endif
						                value="{{$department->id}}">{{$department->department_name}}</option>
					                     @endforeach
					                  </select>
					                </div>
					                </div>
					                <div class="col-md-1 offset-md-3">
					                  <label style="float: right;">グループ</label>
					                </div>
					                <div class="col-xs-2">
					                 <div class="form-group">
					                  <select class="form-control" id="group_id" name="group_id">
					                  	<option selected value=""></option>
					                  	@foreach($groups as $group)
						                <option class="group_id" 
						                    data-value="{{ $group->department()->id }}"
						                @if(isset($group_id))
						                	@if ($group_id == $group->id) selected @endif 
						                @endif
						                value="{{$group->id}}">{{$group->group_name}}</option>
					                     @endforeach
					                  </select>
					                </div>
					                </div>
						           
						        </div>

						        <div class="row">
				                  
                                    <div class="col-md-1">
					                  <label style="float: right;">顧客コード</label>
					                </div>
					                <div class="col-md-2">
					                	 <div class="form-group">
					                       <input type="text" value="{{session('client_code_cont')}}" name="client_code" id="client_code"  class="form-control" >
					                     </div>
					                </div>
                                    
                                @csrf
                                    <div class="col-md-1">
					                  <label style="float: right;">法人番号</label>
					                </div>
					                <div class="col-md-2">
					                	 <div class="form-group">
					                       <input type="text" value="{{session('corporation_num_cont')}}" name="corporation_num" id="corporation_num"  class="form-control" >
					                     </div>
					                </div>
					           
						        </div>
						        <!--
						        <div class="row">
				                  
                                         <div class="col-md-1">
						                  <label style="float: right;">顧客名</label>
						                </div>
						                <div class="col-md-2">
						                	 <div class="form-group">
						                       <input type="text" value="{{session('client_name_cont')}}" name="client_name" id="client_name"  class="form-control" >
						                     </div>
						                </div>
						           
						        </div>
								-->
						        <div class="row">
				                  
                                    <div class="col-md-1">
					                  <label style="float: right;">顧客名カナ</label>
					                </div>
					                <div class="col-md-8">
					                	<div class="form-group" style="width: 97%;">
					                       <input id="client_name_kana" value="{{session('client_name_kana_cont')}}" name="client_name_kana" type="text" size="80%"   class="form-control" >
					                     </div>
						                </div>
						           
						        </div>
								<div class="row">
                                	<div class="col-md-1">
					                  <label style="float: right;">プロジェクトコード</label>
					                </div>
					                <div class="col-md-2">
					                	 <div class="form-group">
					                       <input type="text" value="{{session('project_code_cont')}}" name="project_code" id="project_code"  class="form-control" >
					                     </div>
					                </div>

                                    <div class="col-md-1">
					                  <label style="float: right;">プロジェクト名</label>
					                </div>
					                <div class="col-md-2">
					                	 <div class="form-group">
					                       <input type="text" value="{{session('project_name_cont')}}" name="project_name" id="project_name"  class="form-control" >
					                     </div>
					                </div>
					           
						        </div>


						        <div class="row">
				                  
                                    <div class="col-md-1">
					                  <label style="float: right;">登録日</label>
					                </div>
					                <div class="col-md-2">
					                	 <div class="form-group" >
					                       <input type="text" value="{{session('created_at_st_cont')}}" name="created_at_st" id="datepicker" class="form-control" autocomplete="off">
					                     </div>
					                </div>
                                    
                              
                                    <div class="col-md-1">
					                  <label style="float: right;">～</label>
					                </div>
					                <div class="col-md-2">
					                	 <div class="form-group" >
					                       <input type="text" value="{{session('created_at_en_cont')}}" name="created_at_en" id="datepicker2" class="form-control" autocomplete="off">
					                     </div>
					                </div>			           
						        </div>
				                @if ($errors->has('created_at_st') or $errors->has('created_at_en') )
						        <div class="row">

                                    <div class="col-md-1"> </div>
					                @if ($errors->has('created_at_st'))
					                <div class="col-md-2">
					                	<div class="form-group">
	    	                               <span class="text-danger">{{ $errors->first('created_at_st') }}</span>
                               			</div>
					                </div>	
					                @else
					                <div class="col-md-2">
					                	<div class="form-group"></div>
					                </div>
	                                @endif

	                                @if ($errors->has('created_at_en'))
                                    <div class="col-md-1"></div>
					                <div class="col-md-2">
					                	 <div class="form-group">
					                       <span class="text-danger">{{ $errors->first('created_at_en') }}</span>
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
					                
					                  <button type="button" style="float: left;width: 100px;"  id="clear" class="btn btn-default btn-sm">クリア</button>

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
                 <div class="timeline-item">

	                <div class="timeline-body">
			            
			            <div class="box-body">
			              <div class="row">
			              	<div class="col-sm-7">
			              		
			              	</div>
			              	<div class="col-sm-1">
			              		
			              		@if(Crofun::contract_index_return_button() == 1)
				            	 		
				            	 		<a  href="{{route('customer_edit', ['id' => request()->client_id])}}">

				            	 			<button class="btn btn-warning btn-sm"> 戻る</button>
				            	 		 
				            	 		</a>

				            	@endif
				            	@if(Crofun::contract_index_return_button() == 2)
				            	 		
						            	 		<a  href="{{route('customer_view', ['id' => request()->client_id])}}">

						            	 			<button class="btn btn-warning btn-sm"> 戻る</button>
						            	 		 
						            	 		</a>

						        @endif
						        @if(Crofun::contract_index_return_button() == 3)
				            	 		
						            	 		<a  href="{{route('edit_project', ['id' => request()->project_id])}}">

						            	 			<button class="btn btn-warning btn-sm"> 戻る</button>
						            	 		 
						            	 		</a>

						        @endif
						        @if(Crofun::contract_index_return_button() == 4)
				            	 		
				            	 		<a  href="{{route('view_project', ['id' => request()->project_id])}}">

				            	 			<button class="btn btn-warning btn-sm"> 戻る</button>
				            	 		 
				            	 		</a>

				            	@endif
			              	</div>
			              	<div class="col-sm-3">
			              		 @paginate(['item'=>$contract]) @endpaginate
			              	</div>
			              	<div class="col-sm-1">
			              		
			              	</div>
			              </div>
					      <div class="row">
					      	       
			              <table id="contract_table" class="table table-bordered table-hover">
			                <thead>
			                <tr>
			                  <th></th>
			                  <th>顧客コード</th>
			                  <th>顧客名</th>
							  <th>プロジェクト</th>
			                  <th>プロジェクト名</th>
			                  <th>ファイル名</th>
			                  <th>本部</th>
				              <th>部署</th>
							  <th>グループ</th>
			                  <th>登録日</th>
			                </tr>
			                </thead>
			                <tbody>
                            @foreach ($contract as $contract)
				                <tr>

				                  <td>
				                  	@if( Auth::user()->can('display',$contract))
				                  	<a target="_blank" rel="noopener noreferrer" href="{{route('contract_display', ['id' => $contract->id])}}"><button  style="float: left;" class="btn btn-info btn-sm">参照</button>
				                  	</a>
				                  	@endif
				                  </td>

				                  <td>
				                  	@if($contract->customer->client_code_main == null)
					                  	{{  $contract->customer->client_code }}
				                  	@else
				                  		{{  $contract->customer->client_code_main }}
				                  	@endif 
				                  </td>
				                  <td>{{ $contract->customer->client_name }}</td>
				                  <td>@if($contract->project) {{  $contract->project->project_code }} @endif</td>
				                  <td>@if($contract->project) {{  $contract->project->project_name }} @endif</td>
				                  <td>{{ $contract->save_ol_name }}</td>
				                  <td>@if($contract->headquarter) {{  $contract->headquarter->headquarters }} @endif</td>
				                  <td>@if($contract->department) {{  $contract->department->department_name }} @endif</td>
				                  <td>@if($contract->group) {{  $contract->group->group_name }} @endif</td>
				                  <td>{{ date('Y年m月d日',strtotime($contract->created_at)) }}</td>
				                </tr>
                            @endforeach
			                </tbody>

			              </table>
			               </div> 
			            </div>
	
	              </div>				          
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
         $('#headquarter_id').prop('selectedIndex',0);
         $('#department_id').prop('selectedIndex',0);
         $('#group_id').prop('selectedIndex',0);
         $('#client_code').val('');
		 $('#corporation_num').val('');
         $('#client_name_kana').val('');
         $('#project_code').val('');
		 $('#project_name').val('');         
         $('#datepicker').val('');         
         $('#datepicker2').val('');
         $('#form').submit();

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
