@extends('layouts.app')


@section('content')
@section('breadcrumbs', Breadcrumbs::render('rule/index'))
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
                              <div class="row">
                              	<div class="row">
                              		<div class="col-sm-1">
                              			
                              		</div>
                                    <div class="col-sm-2">
		                              	@if( Auth::user()->can('create','App\Rule_MST'))
						                 <a href="{{ url('rule/create') }}">
						                 	<button type="submit" style="float: left;margin-left: 10%" class="btn btn-primary btn-sm">新規登録</button>
						                 </a>
						                 @endif  
                              		</div>
                              		<div class="col-sm-6">
                              			
                              		</div>
                              		<div class="col-sm-2">
                              	        @paginate(['item'=> $rules]) @endpaginate
                              		</div>
                              		<div class="col-sm-1">
                              			
                              		</div>
                              	</div>

                              	 <div class="row">
	                              	 <table id="rule_table" style="width: 70%;margin-left: 10%" class="table table-bordered table-hover">
						                <thead>
						                <tr>
						                  <th class="edit_button_with">編集</th>
						                  <th>画面機能ID</th>
						                  <th>画面機能ルール</th>
						                  <th>所属会社参照権限</th>
						                  <th>全会社参照権限</th>
	                                      <th>所属会社名</th>
						                </tr>
						                </thead>
						                <tbody>
	                                    @foreach ($rules as $rule)
							                <tr >
							                  <td class="hfsz">
							              	@if( Auth::user()->getRuleAction(config('constant.RULE_INDEX')))                 	
							                  	<a href="{{route('edit_rule', ['rule_id' => $rule->id])}}" ><button type="submit" style="float: left;" class="btn btn-info btn-sm">編集</button></a>
								            @endif	
							                  </td>
							                  <td class="hfsz">{{  $rule->id }}</td>
							                  <td class="hfsz">{{  $rule->rule }}</td>
							                 
							                  <td class="hfsz">@if($rule->admin_flag == 1) 所属会社参照権限 @endif</td>
							                  <td class="hfsz">@if($rule->superuser_user == 1) 全会社参照権限 @endif</td>
							                  <td class="hfsz">{{  $rule->company->abbreviate_name }}</td>
							                </tr>
	                                    @endforeach
						                </tbody>
						              </table>
					            </div>
                              </div>           
	
	                </div>
	               
	              </div>
					          
	            </li>
	            <li>
	            		             
	            </li>
          </ul>
        </div>
      </div>
@endsection
