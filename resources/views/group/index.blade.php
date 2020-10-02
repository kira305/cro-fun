@extends('layouts.app')


@section('content')
@section('breadcrumbs', Breadcrumbs::render('group/index'))
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

						        <form action="{{ url('group/index') }}" id="form" method="POST">
						        	  	<div class="row">
						              
							                <div class="col-md-3 offset-md-3">
							                  <label style="float: right;">所属会社</label>
							                </div>
							                <div class="col-xs-2">
								                 <div class="form-group">
									                  <select class="form-control" id="company_id" name="company_id">
										                  	<option value=""> </option>
										                  	@foreach($companies as $company)
											                <option 
											                @if(isset($company_id))
											                @if ($company_id == $company->id) selected @endif 
											                @endif
											                value="{{$company->id}}">{{$company->abbreviate_name}}</option>
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
								                <div class="col-md-1">
								                  <label style="float: right;">部署名</label>
								                </div>
								                <div class="col-xs-2">
									                 <div class="form-group">
									                  <select class="form-control" style="float: left;" id="department_id" name="department_id">
										                  	<option value=""></option>
										                  	@foreach($departments as $department)
												                <option class="department_id" id="{{ $department->headquarter()->id }}" 
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
							                  <label style="float: right;">グループ名</label>
							                </div>
							                <div class="col-xs-2">
								                 <div class="form-group">

							                       <input type="text" name="group_name" id="group_name" @if(isset($group_name))  value="{{ $group_name }}" @endif class="form-control" >
							                     </div>
							                </div>
								        </div>

								           
								        <div class="row">
							                <div class="col-md-3 offset-md-3">
							                  <label style="float: right;">非表示</label>
							                </div>
							                <div class="col-xs-2">
								                 <div class="form-group">
			                                        <input type="checkbox" id="check" name="status" @if(isset($status)) @if ($status == 'on') checked @endif @endif
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
								                
								                  <button type="button"  id="clear" class="btn btn-default clear btn-sm">クリア</button>

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
	                      <div>
				          
				            <div class="box-body">
                                 <div class="row">
				            		<div class="col-sm-1"></div>
				            		<div class="col-sm-2">
	                                   @if( Auth::user()->can('create','App\Group_MST'))
							                 <a href="{{ url('group/create') }}">
							                 	<button type="submit" style="float: left;margin-left: 10%" class="btn btn-primary btn-sm">新規登録</button>
							                 </a>
							            @endif		
				            		</div>
				            		<div class="col-sm-5"></div>
				            		<div style="float: right" class="col-sm-3">
							        
							          	   @paginate(['item'=> $groups]) @endpaginate

							        </div>
							        <div class="col-sm-1"></div>
				                  </div>
						          <div class="row">
 
	                				<table id="group_table" class="table table-bordered table-hover">
							                <thead>
							                <tr>
							                  <th style="width: 100px;">編集</th>
							                  <th>表示コード</th>
							                  <th>グループコード</th>
							                  <th>グループ名</th>
							                  <th>部署名</th>
							                  <th>事業本部名</th>
							                  <th>所属会社名</th>
							                  <th>非表示</th>
							                </tr>
							                </thead>
							                <tbody>
		                                    @foreach ($groups as $group)
								                <tr>
								                  <td>
								                  @if( Auth::user()->can('update','App\Group_MST'))
								                  <a href="{{route('editgroup', ['id' => $group->id,'page'=>request()->page])}}" ><button type="submit" style="float: left;" class="btn btn-info btn-sm">編集</button></a>
								                  @endif
								                  </td>
								                  <td>{{  $group->group_code }}</td>
								                  <td>{{  $group->group_list_code }}</td>
								                  <td>{{  $group->group_name }}</td>
								                  <td>{{  $group->department()->department_name }}</td>
								                  <td>{{  $group->headquarter()->headquarters }}</td>
								                  <td>{{  $group->headquarter()->abbreviate_name }}</td>
								                  <td>@if($group->status == false) 非表示 @endif </td>
								                </tr>
		                                    @endforeach
							                </tbody>

							              </table>
						          </div>

					          
				            </div>
				            <!-- /.box-body -->
				          </div>
	                </div>
	               
	              </div>
	            </li>
          </ul>
        </div>
      </div>

 <script type="text/javascript">


   
    $(document).ready(function() {
      
          $( "#department_id" ).prop( "disabled", true );

          if($( "#headquarter_id" ).val() != ""){
            
            $( "#department_id" ).prop( "disabled", false );
            
                     var headquarter_id = $("#headquarter_id").val();

			         $( ".department_id" ).each(function() {

					       $(this).show();
					     
					       if($(this).attr('data-value') !== headquarter_id){
			                     
					       	   $(this).remove();
			 
					       }

					   });


          }

         $("#clear").click(function(){
             
             $('#example2').DataTable().state.clear();
			 $('#company_id').prop('selectedIndex',0);
			 $('#headquarter_id').prop('selectedIndex',0);
             $('#department_id').prop('selectedIndex',0);
             $('#group_name').val('');
             $( "#check" ).prop( "checked", false );
             $( "#form" ).submit();

		 });

		

    });
 </script>
@endsection
