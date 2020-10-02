@extends('layouts.app')


@section('content')
@section('breadcrumbs', Breadcrumbs::render('department/index'))
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

						        <form id="form" action="{{ url('department/index') }}" method="POST">
						        	  	<div class="row">
							                <div class="col-md-3 offset-md-3">
							                  <label class="input_lable">所属会社</label>
							                </div>
							                <div class="col-md-2">
							                	<div class="form-group">
								                    <select class="form-control" id="company_id" name="company_id" >
								                    <option selected value=""> </option>
											          @foreach($companies as $company)
								                    <option 
								                     @if(isset($company_id))
										                @if ($company_id == $company->id) selected @endif 
										             @endif
								                    value="{{$company->id}}">{{$company->abbreviate_name}}
								                    </option>
								                  
							                          @endforeach
													</select>
											    </div>
							                </div>

							                <div class="col-md-3 offset-md-3">
							                  <label class="input_lable">事業本部名</label>
							                </div>
							                <div class="col-xs-2">
								                 <div class="form-group">
									                  <select class="form-control" name="headquarter_id" id="headquarter_id">
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
								                <div class="col-md-1">
								                  <label class="input_lable">部署名</label>
								                </div>
								                <div class="col-xs-2">
								                  <input type="text" class="form-control" id="department_name" name="department_name" @if(isset($department_name)) 
								                   value = "{{ $department_name }}"  @endif >
								                </div>

								                <div class="col-md-3 offset-md-3">
								                  <label class="input_lable">非表示</label>
								                </div>
								                <div class="col-xs-2">
								                 <div class="form-group">
                                                    <input type="checkbox" id="check" name="status"  @if(isset($status)) @if ($status == 'on') checked @endif @endif
                                                    class="minimal">
								                </div>
								                </div>
								           
								        </div>
						                 @csrf
						                <div class="row">
						                	　　　<br>
								                <div class="col-md-5">
								                
								                  <button type="submit"  class="btn btn-primary kensaku_button btn-sm">検索</button>

								                </div>
								                <div class="col-md-5">
								                
								                  <button type="button"   id="clear" class="btn btn-default clear btn-sm">クリア</button>

								                </div>

								              
						                </div>
						        </form>
				            </div>
				            <!-- /.box-body -->
				          </div>
	                </div>
	               
	              </div>
	            <li>
	            		             
	              <div class="timeline-item">

	                <div class="timeline-body">
				            <div class="box-body">
				              <div class="row">
				            		<div class="col-sm-1"></div>
				            		<div class="col-sm-2">
		                                @if( Auth::user()->can('create','App\Department_MST'))
							                 <a href="{{ url('department/create') }}">
							                 	<button type="submit" style="float: left;margin-left: 10%" class="btn btn-primary btn-sm">新規登録
							                 	</button>
							                 </a>
							            @endif  	
				            		</div>
				            		<div class="col-sm-5"></div>
				            		<div style="float: right" class="col-sm-3">
							        
							          	   @paginate(['item'=> $departments]) @endpaginate

							        </div>
							        <div class="col-sm-1"></div>
				              </div>
                              <div class="row">

					              <table id="department_table" class="table table-bordered table-hover">
					                <thead>
					                <tr>
					                  <th style="width: 100px;">編集</th>
					                  <th>表示コード</th>
					                  <th>部署コード</th>
					                  <th>部署名</th>
					                  <th>事業本部名</th>
					                  <th>所属会社名</th>
					                  <th>非表示</th>
					                </tr>
					                </thead>
					                <tbody>
                                    @foreach ($departments as $department)
						                <tr>
						                  <td>
	                  		              	@if( Auth::user()->can('update','App\Department_MST'))
						                  	<a href="{{route('editdepartment', ['id' => $department->id,'page'=>request()->page])}}" ><button type="submit" style="float: left;" class="btn btn-info btn-sm">編集</button></a>
						                  	@endif
						                  </td>
						                  <td>{{  $department->department_code }}</td>
						                  <td>{{  $department->department_list_code }}</td>
						                  <td>{{  $department->department_name }}</td>
						                  <td>{{  $department->headquarter()->headquarters }}</td>
 						                  <td>{{  $department->company()->abbreviate_name }}</td>
						                  <td>@if($department->status == false) 非表示 @endif </td>
						                </tr>
                                    @endforeach
					                </tbody>

					              </table>
					            </div>
				            </div>
				            <!-- /.box-body -->
				         
	                </div>
	               
	              </div>
	            </li>
          </ul>
        </div>
      </div>
      <script type="text/javascript">
      	$( document ).ready(function() {
		    
	         $("#clear").click(function(){
	             $('#company_id').prop('selectedIndex',0);
	             $('#example2').DataTable().state.clear();
				 $('#headquarter_id').prop('selectedIndex',0);
				 $('#department_name').val('');
	             $( "#check" ).prop( "checked", false );
	             $( "#form" ).submit();

			 });

		});
      </script>
@endsection
