@extends('layouts.app')

@section('content')
@section('breadcrumbs', Breadcrumbs::render('user/create'))
     
      <div class="row">
        <div class="col-md-12">
       
          <ul class="timeline">
	          	<li>
	             
	              <div class="timeline-item">
	               
	                <div class="timeline-body">
                      <div>
			          
			            <div class="box-body">
		            	    @if ($message = Session::get('success'))


				              <p class="message" >{{ $message }}</p>

			
						    @endif
					        <form id="create_user" method="post" action="{{ url('user/create') }}">

							             
						        <div class="row">
					                <div class="col-md-3 offset-md-3">
					                  <label class="input_lable"><b>社員番号</b></label>
					                </div>
					                <div class="col-xs-2">
					                     <div class="form-group">
					                       <input type="text" name="usr_code" value="{{ old('usr_code') }}" class="form-control">
					                     </div>
					                </div>
					                @if ($errors->has('usr_code'))

    	                                <span class="text-danger">{{ $errors->first('usr_code') }}</span>


	                                @endif
	                                @if ($errors->has('unique'))

    	                                <span class="text-danger" >{{ $errors->first('unique') }}</span>

	                                @endif
				                </div>
				                 <div class="row">
					                <div class="col-md-3 offset-md-3">
					                  <label class="input_lable"><b>社員名</b></label>
					                </div>
					                <div class="col-xs-2">
					                	 <div class="form-group">
					                       <input type="text" name="usr_name" value="{{ old('usr_name') }}" class="form-control">
					                     </div>
					                </div>
					                @if ($errors->has('usr_name'))

    	                     
    	                                 <span class="text-danger">{{ $errors->first('usr_name') }}</span>

	                                @endif
				                </div>
				                <div class="row">
				              
					                <div class="col-md-3 offset-md-3">
					                  <label class="input_lable"><b>所属会社</b></label>
					                </div>
					                <div class="col-md-2">
					                	<div class="form-group">
						                    <select class="form-control" id="company_id" name="company_id" >
						               
									          @foreach($companies as $company)
							                    <option 
							                      {{ old('company_id') == $company->id ? 'selected' : '' }}
							                    value="{{$company->id}}">{{$company->abbreviate_name}}
							                    </option>
							                  
					                          @endforeach
											</select>
									    </div>
					                </div>
					                @if ($errors->has('company_id'))

    	                               <span class="text-danger">{{ $errors->first('company_id') }}</span>

	                                @endif
						        </div>

						        <div class="row">
				              
					                <div class="col-md-3 offset-md-3">
					                  <label class="input_lable"><b>所属本部</b></label>
					                </div>
					                <div class="col-md-2">
					                	<div class="form-group">
						                    <select class="form-control"  id="headquarter_id" name="headquarter_id" >
						                    <option> </option>
									          @foreach($headquarters as $headquarter)
							                    <option class="headquarter_id" 
							                      {{ old('headquarter_id') == $headquarter->id ? 'selected' : '' }}
							                    data-value="{{ $headquarter->company_id }}"
							                    value="{{$headquarter->id}}">{{$headquarter->headquarters}}
							                    </option>
							                  
					                          @endforeach
											</select>
									    </div>
					                </div>
					                @if ($errors->has('headquarter_id'))

    	                                   <span class="text-danger">{{ $errors->first('headquarter_id') }}</span>

	                                @endif
						        </div>
                                
                                <div class="row">
				              
					                <div class="col-md-3 offset-md-3">
					                  <label class="input_lable"><b>所属部署</b></label>
					                </div>
					                <div class="col-md-2">
					                	<div class="form-group">
						                    <select class="form-control"  id="department_id" name="department_id" >
						                    <option > </option>
									          @foreach($departments as $department)
							                    <option class="department_id" 
							                      {{ old('department_id') == $department->id ? 'selected' : '' }}
							                    data-value="{{ $department->headquarter()->id }}"
							                    value="{{$department->id}}">{{$department->department_name}}
							                    </option>
						                  
					                          @endforeach
											</select>
									    </div>
					                </div>
					                @if ($errors->has('department_id'))

    	                               <span class="text-danger">{{ $errors->first('department_id') }}</span>

	                                @endif
						        </div>

						        <div class="row">
			              
					                <div class="col-md-3 offset-md-3">
					                  <label class="input_lable"><b>所属グループ</b></label>
					                </div>
					                <div class="col-md-2">
						               	<div class="form-group">
						                    <select class="form-control"  id="group_id" name="group_id" >
						                    	     <option> </option>
									          @foreach($groups as $group)
							                    <option class="group_id" 
							                      {{ old('group_id') == $group->id ? 'selected' : '' }}
							                    data-value="{{ $group->department()->id }}"
							                    value="{{$group->id}}">{{$group->group_name}}
							                    </option>
							                  
					                          @endforeach
											</select>
										 </div>
						                </div>
					           	    @if ($errors->has('group_id'))

    	                               <span class="text-danger">{{ $errors->first('group_id') }}</span>

	                                @endif
					        </div>
						        <div class="row">
			              
					                <div class="col-md-3 offset-md-3">
					                  <label class="input_lable"><b>役職</b></label>
					                </div>

					                <div class="col-md-2">
					                	<div class="form-group">
						                    <select class="form-control"  id="position_id" name="position_id" >
						                    <option> </option>
									          @foreach($position_list as $position)
							                    <option class="position_id" 
							                      {{ old('position_id') == $position->id ? 'selected' : '' }}
							                    data-value="{{ $position->company_id }}"
							                    value="{{$position->id}}">{{$position->position_name}}
							                    </option>
						                  
					                          @endforeach
											</select>
									    </div>
					                </div>
					           	    @if ($errors->has('position_id'))

    	                               <span class="text-danger">{{ $errors->first('position_id') }}</span>

	                                @endif


						        </div>
						         <div class="row">
					                <div class="col-md-3 offset-md-3">
					                  <label class="input_lable"><b>メールアドレス</b></label>
					                </div>
					                <div class="col-xs-2">
					                	 <div class="form-group">
					                       <input type="email" name="mail_address" value="{{ old('mail_address') }}" class="form-control">
					                        @csrf
					                     </div>
					                </div>
					              @if ($errors->has('mail_address'))

    	                                 <span class="text-danger">{{ $errors->first('mail_address') }}</span>

	                              @endif
				                </div>
				                <div class="row">
				              
					                <div class="col-md-3 offset-md-3">
					                  <label class="input_lable"><b>画面機能ルール</b></label>
					                </div>

									<div class="col-md-2">
										<div class="form-group">
											<select class="form-control" id="rule_id" name="rule_id" >
												<option> </option>
												@foreach($rule_list as $rule)
													<option class="rule_id" 
														{{ old('rule_id') == $rule->id ? 'selected' : '' }}
														data-value="{{ $rule->company_id }}"
														value="{{$rule->id}}">{{$rule->rule}}
													</option>
												@endforeach
											</select>
										</div>
									</div>

					                @if ($errors->has('rule_id'))

    	                                <span class="text-danger">{{ $errors->first('rule_id') }}</span>

	                                @endif
						           
						        </div>


				                <div class="row">
			                	　　　<br>
					                <div class="col-sm-3">
					                
					                  <button type="submit" style="float:right;width: 200px;" class="btn btn-primary">登録</button>
					                </div>
                                    <div class="col-sm-4">
					                
					                 <a style="float: left;width: 200px;" class="btn btn-danger" href="{{ url('user/index') }}" >戻る</a>
					                </div>
						            <div class="col-sm-5">
						            	
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
	           
          </ul>
        </div>
      </div>
<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
<script type="text/javascript">

</script>
<script src="{{ asset('select/icontains.js') }}" ></script>

<script src="{{ asset('select/comboTreePlugin.js') }}" ></script>



@endsection
