@extends('layouts.app')


@section('content')
@section('breadcrumbs', Breadcrumbs::render('cost/index'))
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

				        <form id="form" action="{{ url('cost/index') }}" method="POST">
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
			                                    {{ session('company_id_c') == $company->id ? 'selected' : '' }}
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
					                  	<option selected value=""></option>
					                  	@foreach($headquarters as $headquarter)
							                <option class="headquarter_id" 
								                data-value="{{ $headquarter->company_id }}"
					                            {{ session('headquarter_id_c') == $headquarter->id ? 'selected' : '' }}
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
										    <option class="department_id" data-value="{{ $department->headquarter()->id }}" {{ session('department_id_c') == $department->id ? 'selected' : '' }} value="{{$department->id}}">
								                {{$department->department_name}}
										    </option>
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
								                <option class="group_id" data-value="{{ $group->department()->id }}" {{ session('group_id_c') == $group->id ? 'selected' : '' }} value="{{$group->id}}">
							                	{{$group->group_name}}
								                </option>
						                     @endforeach
						                  </select>
					                </div>
				                </div>
						           
					        </div>

					        <div class="row">
				                <div class="col-md-3 offset-md-3">
				                  <label class="input_lable">販管費/原価</label>
				                </div>
				                <div class="col-xs-2">
				                   <select class="form-control" id="type" name = "type" >
                                       
                                       <option value=""> </option>
				                   	   <option 
				                       {{ session('type_c') == 2 ? 'selected' : '' }}
				                   	   value="2">販管費</option>
				                   	   <option 
				                   	   {{ session('type_c') == 1 ? 'selected' : '' }}
				                   	   value="1">原価</option>

				                    </select>
				                </div>
				                <div class="col-md-1">
				                  <label style="float: right;min-width: 70px;">非表示</label>
				                </div>
				                <div class="col-md-1">
				                 <div class="form-group">
                                    <input type="checkbox" id="check" name="status" @if(isset($status)) @if ($status == 'on') checked @endif @endif
                                    class="minimal">
				                </div>
				                </div>
					              
			                </div>
			                <br>
                            <div class="row">
				                <div class="col-md-3 offset-md-3">
				                  <label class="input_lable">ツリー図コード</label>
				                </div>
				                <div class="col-xs-2">
				                  <input type="text" id="cost_code" value="{{ session('cost_code_c') }}" class="form-control" name="cost_code" >
				                </div>

				                <div class="col-md-1 offset-md-3">
				                  <label class="input_lable">ツリー図名称</label>
				                </div>
				                <div class="col-xs-2">
				                  <input type="text" id="cost_name" value="{{ session('cost_name_c') }}" class="form-control" name="cost_name"  >
				                </div>
					              
			                </div>
			                 @csrf
			                <div class="row">
		                	　　　<br>
				                <div class="col-md-5">
				                
				                  <button type="submit" class="btn btn-primary kensaku_button btn-sm">検索</button>

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
            </li>
            <li>

				           
				<!--               <h4 class="text-red" style="text-align: center;">検索要件を入力してください</h4> -->

				          
            </li>
            <li>
            		             
              <div class="timeline-item">
                <div class="timeline-body">
             
		            <div class="box-body">
		            	<div class="row">
		            		        <div class="col-sm-1"></div>
				            		<div class="col-sm-2">
						              	@if( Auth::user()->can('create','App\Cost_MST'))
						              	 <a href="{{ url('cost/create') }}">
						                 	<button type="submit" style="float: left;margin-left: 10%" class="btn btn-primary btn-sm">新規登録</button>
						                 </a>
						                @endif	
				            		</div>
				            		<div class="col-sm-5"></div>
				            		<div style="float: right" class="col-sm-3">
							        
							          	   @paginate(['item'=>$costs]) @endpaginate

							        </div>
							        <div class="col-sm-1"></div>
		            	</div>
				         <div class="row">

			              <table id="cost_index_table" class="table-bordered table-hover">
			                <thead>
				                <tr>
				                  <th class="edit_button_with">編集</th>
				                  <th>所属会社</th>
				                  <th>所属事業本部</th>
				                  <th>所属部署</th>
				                  <th>所属グループ</th>
				                  <th>販管費/原価</th>
				                  <th>コード</th>
				                  <th>名称</th>
				                  <th>ステータス</th>
				                </tr>
			                </thead>
			                <tbody>
                            @foreach ($costs as $cost)
				                <tr>
				                  <td>
				              	@if( Auth::user()->can('update','App\Cost_MST'))
				                  	<a href="{{route('edit_cost', ['id' => $cost->id,'page'=>request()->page])}}" >
				                  		<button  style="float: left;" class="btn btn-info btn-sm">編集
				                  		</button>
				                  	</a>
			                    @endif	
			                     </td>

				                  <td class="user_row">{{  $cost->company->abbreviate_name }}</td>
				                  <td class="user_row">{{  $cost->headquarter->headquarters }}</td>
				                  <td class="user_row">
				                  	@if($cost->department) {{  $cost->department->department_name }} @endif
				                  </td>
				                  <td class="user_row">
				                  	@if($cost->group) {{  $cost->group->group_name }} @endif</td>
                                  <td>
                                  	@if($cost->type == 2) 販管費 @endif @if($cost->type == 1) 原価 @endif
                                  </td>
				                  <td class="user_row">{{  $cost->cost_code }}</td>
				                  <td class="user_row">{{  $cost->cost_name }}</td>
						          <td>@if($cost->status == false) 非表示 @endif </td>

				                </tr>

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
     

       $(document).on('click', '#clear', function () {
       
             $('#example2').DataTable().state.clear();
             $('#company_id').prop('selectedIndex',0);
			 $('#headquarter_id').prop('selectedIndex',0);
             $('#department_id').prop('selectedIndex',0);
             $('#group_id').prop('selectedIndex',0);
             $('#type').prop('selectedIndex',0);
             $('#cost_code').val('');
             $('#cost_name').val('');
             $( "#check" ).prop( "checked", false );
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
