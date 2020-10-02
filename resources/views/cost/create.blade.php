@extends('layouts.app')

@section('content')
@section('breadcrumbs', Breadcrumbs::render('cost/create'))
     
      <div class="row">
        <div class="col-md-12">
       
          <ul class="timeline">
	          	<li>
	             
	              <div class="timeline-item">
	               
	                <div class="timeline-body">
	                      <div>
				          
				            <div class="box-body">
				            	@if (isset($message))


								 <p class="message">{{ $message }}</p>

					
								@endif
						        <form id="create_cost" method="post" action="{{ url('cost/create') }}">

								             

						                <div class="row">
						              
								                <div class="col-md-3 offset-md-3">
								                  <label class="input_lable"><b>所属会社</b></label>
								                </div>
								                <div class="col-md-2">
								                	<div class="form-group">
									                    <select class="form-control" id="company_id" name="company_id" >
									                    <option value=""> </option>
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
								                  <label class="input_lable">所属部署</label>
								                </div>
								                <div class="col-md-2">
								                	<div class="form-group">
									                    <select class="form-control"  id="department_id" name="department_id" >
									                    <option value=""> </option>
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
								                  <label class="input_lable">所属グループ</label>
								                </div>
								                <div class="col-md-2">
								               	<div class="form-group">
									                    <select class="form-control"  id="group_id" name="group_id" >
									                    <option value=""> </option>
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
								                  <label class="input_lable"><b>販管費/原価</b></label>
								                </div>
								                <div class="col-xs-2">
								                 <div class="form-group">
								                  <select class="form-control" name="type">
                                                   								                  
								                   	   <option 
								                   	     {{ old('type') == 2 ? 'selected' : '' }}
								                   	     value="2">販管費</option>
								                   	   <option 
								                   	     {{ old('type') == 1 ? 'selected' : '' }}
								                   	   value="1">原価</option>
								                 
								                  </select>
								                </div>
								                </div>
								           		@if ($errors->has('type'))

                	                              <span class="text-danger">{{ $errors->first('type') }}</span>

            	                                @endif
								        </div>
								         <div class="row">
								                <div class="col-md-3 offset-md-3">
								                  <label class="input_lable"><b>コード</b></label>
								                </div>
								                <div class="col-xs-2">
								                	 <div class="form-group">

								                       <input type="text" name="cost_code" value="{{ old('cost_code') }}" class="form-control">
								                       
								                     </div>
								                </div>
								              @if ($errors->has('cost_code'))

                	                                 <span class="text-danger">{{ $errors->first('cost_code') }}</span>

            	                              @endif
            	                              @if ($errors->has('unique'))

                	                                <span class="text-danger" >{{ $errors->first('unique') }}</span>

            	                               @endif
            	                               @csrf
						                </div>
                                        <div class="row">
								                <div class="col-md-3 offset-md-3">
								                  <label class="input_lable"><b>名称</b></label>
								                </div>
								                <div class="col-xs-2">
								                	 <div class="form-group">
								                       <input type="text" name="cost_name" value="{{ old('cost_name') }}" class="form-control">
								                       
								                     </div>
								                </div>
								              @if ($errors->has('cost_name'))

                	                                 <span class="text-danger">{{ $errors->first('cost_name') }}</span>

            	                              @endif
						                </div>

						                <div class="row">
						                	　　　<br>
								                <div class="col-md-5">
								                
								                  <button type="submit" style="float:right;width: 200px;" class="btn btn-primary">登録</button>
								                </div>
                                                <div class="col-md-5">
								                
								                 <a style="float: left;width: 200px;" class="btn btn-danger" href="{{ url('cost/index') }}" >戻る</a>
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
