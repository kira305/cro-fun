@extends('layouts.app')


@section('content')
@section('breadcrumbs', Breadcrumbs::render('user/index'))
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

						        <form id="form" action="{{ url('user/index') }}" method="POST">
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
								                <div class="col-md-1 offset-md-3">
								                  <label class="input_lable">事業本部</label>
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
								                  <label class="input_lable">部署</label>
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
								                  <label class="input_lable">グループ</label>
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
								                <div class="col-md-3 offset-md-3">
								                  <label class="input_lable">社員番号</label>
								                </div>
								                <div class="col-xs-2">
								                  <input type="text" class="form-control input-sm" name="usr_code" id="usr_code" @if(isset($usr_code)) value="{{$usr_code}}"  @endif >
								                </div>

								                <div class="col-md-1 offset-md-3">
								                  <label class="input_lable">社員名</label>
								                </div>
								                <div class="col-xs-2">
								                  <input type="text" @if(isset($usr_name)) value="{{$usr_name}}" id="user_name" @endif class="form-control input-sm" name="usr_name"  >
								                </div>
								              
						                </div>
						                <br>
						                <div class="row">
						              
								                <div class="col-md-3 offset-md-3">
								                  <label class="input_lable">役職</label>
								                </div>
								                <div class="col-xs-2">
								                 <div class="form-group">
								                  <select class="form-control" id="position_id" name="position_id">
									                  	<option value=""> </option>
									                  	@foreach($position_list as $position)
										                <option class="position_id" 
										                data-value="{{ $position->company_id }}"
										                @if(isset($position_id))
										                @if ($position_id == $position->id) selected @endif 
										                @endif
										                value="{{$position->id}}">{{$position->position_name}}</option>
									                     @endforeach
								                  </select>
								                </div>
								                </div>
								                <div class="col-md-1 offset-md-3">
								                  <label class="input_lable">画面機能ルール</label>
								                </div>
								                <div class="col-xs-2">
								                 <div class="form-group">
								                  <select class="form-control" id="rule_id" name="rule_id">
								                    <option value="">
								                  		
								                  	</option>
								                   @foreach($rule_list as $rule)
										                <option class="rule_id" 
										                data-value="{{ $rule->company_id }}"
										                @if(isset($rule_id))
										                @if ($rule_id == $rule->id) selected @endif 
										                @endif
										                value="{{$rule->id}}">{{$rule->rule}}</option>
								                    @endforeach
								                  </select>
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
								                
								                  <button type="button" style="float: left;width: 100px;"  id="clear" class="btn btn-default clear btn-sm">クリア</button>

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
							          <div class="col-sm-1">
							          	
							          </div>
							          <div class="col-sm-2">

							          </div>
							          <div class="col-sm-4">
							          	
							          </div>

				               
				                 </div>
				                 <div class="row">
						          	@if( Auth::user()->can('create','App\User'))
					                 <a style="float: left;margin-left: 10%;margin-top: 2%" class="btn btn-primary btn-sm" href="{{ url('user/create') }}">新規登録
					                 </a>
					                @endif

                                    <div style="float: right" class="col-sm-3">
							        
							          	   @paginate(['item'=> $users]) @endpaginate

							         </div>

					              <table id="user_table" class="table">
					                <thead>
					                <tr>
					                  <th class="edit_button_with">編集</th>
					                  <th>社員番号</th>
					                  <th>社員名</th>
					                  <th>所属会社</th>
					                  <th>所属事業本部</th>
					                  <th>所属部署</th>
					                  <th>所属グループ</th>
					                  <th>役職</th>
					                  <th>画面機能ルール</th>
					                  <th>退職</th>
					                </tr>
					                </thead>
					                <tbody>
                                    @foreach ($users as $user)
						                <tr  id="{{ $user->id }}">
						                  <td>
							             @if( Auth::user()->can('create','App\User'))
						                  	<a href="{{route('edituserinfor', ['id' => $user->id,'page' => request()->page])}}" ><button  style="float: left;" class="btn btn-info btn-sm">編集</button></a>
							             @endif	
						                  </td>
						                  <td class="user_row">{{  $user->usr_code }}</td>
						                  <td class="user_row">{{  $user->usr_name }}</td>
						                  <td class="user_row">{{  $user->company->abbreviate_name }}</td>
						                  <td class="user_row">{{  $user->headquarter->headquarters }}</td>
						                  <td class="user_row">{{  $user->department->department_name }}</td>
						                  <td class="user_row">{{  $user->group->group_name }}</td>
						                  <td class="user_row">{{  $user->position->position_name }}</td>
						                  <td class="user_row">{{  $user->getrole->rule }}</td>  
	                                      <td>@if($user->retire == true) 退職 @endif </td>
						                </tr>
						                 @foreach ($user->concurrently() as $con)
                                            <tr class="concurrent" >
                                              <td></td>
	                                          <td class="user_row"></td>
							                  <td class="user_row">{{  $con->usr_name }}</td>
							                  <td class="user_row">{{  $con->company->abbreviate_name }}</td>
							                  <td class="user_row">{{  $con->headquarter->headquarters }}</td>
							                  <td class="user_row">{{  $con->department->department_name }}</td>
							                  <td class="user_row">{{  $con->group->group_name }}</td>
							                  <td class="user_row">{{  $con->position->position_name }}</td>
							                  <td class="user_row"></td>  
							                  <td>@if($con->status == false) 兼務解除 @endif</td>
                                            </tr>

						                 @endforeach
                                    @endforeach
					                </tbody>
                                 
					              </table>
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
      
       $( document ).ready(function() {
           
                 $('#user_table').DataTable({
		          'paging'      : false,
		          'lengthChange': false,
		          'searching'   : false,
		          'ordering'    : false,
		          'stateSave'   : true,
		          'info'        : false,
		          'autoWidth'   : false,
		           'pageLength': 10,
		          'dom': '<"top"p>',
		        })
       
        });

       $(document).on('click', '#clear', function () {
       
             $('#example2').DataTable().state.clear();
             $('#company_id').prop('selectedIndex',0);
			 $('#headquarter_id').prop('selectedIndex',0);
             $('#department_id').prop('selectedIndex',0);
             $('#group_id').prop('selectedIndex',0);
             $('#position_id').prop('selectedIndex',0);
             $('#rule_id').prop('selectedIndex',0);
             $('#usr_code').val('');
             $('#user_name').val('');
             $( "#form" ).submit();

    });


    $(document).ready(function() {


    	  $( "#headquarter_id" ).prop( "disabled", true );
          $( "#department_id" ).prop( "disabled", true );
          $( "#group_id" ).prop( "disabled", true );
          

         
         $(".user_row").click(function(){

            if($('#flag').val() === '0'){

            	$('.concurrent').show();
            	$('#flag').val('1');

            } else {
                
                $('.concurrent').hide();
            	$('#flag').val('0');

            }
         	

		 });


    });
    

      </script>
@endsection
