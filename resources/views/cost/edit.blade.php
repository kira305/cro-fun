
@extends('layouts.app')

@section('content')
@section('breadcrumbs', Breadcrumbs::render('cost/edit'))
     
      <div class="row">
        <div class="col-md-12">
       
          <ul class="timeline">
	          	<li>
	             
	              <div class="timeline-item">
	               
	                <div class="timeline-body">
	                      <div>
				          
				            <div class="box-body">
				            	@if (isset($message))


								   <p class="message" style="text-align: center;color: green">{{ $message }}</p>

					
								@endif
						        <form id="create_cost" method="post" action="{{ url('cost/edit') }}">

								             

						                <div class="row">
						              
								                <div class="col-md-3 offset-md-3">
								                  <label style="float: right;"><b>所属会社</b></label>
								                </div>
								                <div class="col-md-2">
								                	<div class="form-group">
								                		@if($cost->checkIsNull() == 0)
									                    <select class="form-control" id="company_id" name="company_id" >
									               
												          @foreach($companies as $company)
									                    <option 
									                      {{ $cost->company_id == $company->id ? 'selected' : '' }}
									                    value="{{$company->id}}">{{$company->abbreviate_name}}
									                    </option>
									                  
								                          @endforeach
														</select>
													    @else
                                                            <input type="text" readonly 
								                            value="{{ $cost->company->company_name }}" class="form-control">
														@endif
												    </div>
								                </div>
								                @if ($errors->has('company_id'))

                	                               <span class="text-danger">{{ $errors->first('company_id') }}</span>

            	                                @endif
								        </div>
                                        <div class="row">
						              
								                <div class="col-md-3 offset-md-3">
								                  <label style="float: right;"><b>所属本部</b></label>
								                </div>
								                <div class="col-md-2">
								                	<div class="form-group">
								                		@if($cost->checkIsNull() == 0)
										                    <select class="form-control"  id="headquarter_id" name="headquarter_id" >
										                    <option> </option>
													          @foreach($headquarters as $headquarter)
										                    <option class="headquarter_id" 
										                      {{ $cost->headquarter_id == $headquarter->id ? 'selected' : '' }}
										                    data-value="{{ $headquarter->company_id }}"
										                    value="{{$headquarter->id}}">{{$headquarter->headquarters}}
										                    </option>
										                  
									                          @endforeach
															</select>
														@else
                                                            <input type="text" readonly name="headquarter_id" 
								                            value="{{ $cost->headquarter->headquarters }}" class="form-control">
														@endif
												    </div>
								                </div>
								                @if ($errors->has('headquarter_id'))

                	                                 <span class="text-danger">{{ $errors->first('headquarter_id') }}</span>

            	                                @endif
								        </div>
                                        <div class="row">
						              
								                <div class="col-md-3 offset-md-3">
								                  <label style="float: right;">所属部署</label>
								                </div>
								                <div class="col-md-2">
								                	<div class="form-group">
								                		@if($cost->checkIsNull() == 0)
									                    <select class="form-control"  id="department_id" name="department_id" >
									                    	     <option > </option>
												          @foreach($departments as $department)
									                    <option class="department_id" 
									                      {{ $cost->department_id == $department->id ? 'selected' : '' }}
									                    data-value="{{ $department->headquarter()->id }}"
									                    value="{{$department->id}}">{{$department->department_name}}
									                    </option>
									                  
								                          @endforeach
														</select>
														@else
														  @if($cost->checkIsNull() == 3)
														   <input type="text" readonly name="department_id" value="" class="form-control">
														  @else
														    <input type="text" readonly name="department_id" value="{{ $cost->department->department_name }}" class="form-control">
														  @endif
														@endif
												    </div>
								                </div>
								                @if ($errors->has('department_id'))

                	                               <span class="text-danger">{{ $errors->first('department_id') }}</span>

            	                                @endif
								        </div>

								        <div class="row">
						              
								                <div class="col-md-3 offset-md-3">
								                  <label style="float: right;">所属グループ</label>
								                </div>
								                <div class="col-md-2">
								               	<div class="form-group">
								               		    @if($cost->checkIsNull() == 0)
									                    <select class="form-control"  id="group_id" name="group_id" >
									                    	     <option> </option>
												          @foreach($groups as $group)
									                    <option class="group_id" 
									                      {{ $cost->group_id == $group->id ? 'selected' : '' }}
									                    data-value="{{ $group->department()->id }}"
									                    value="{{$group->id}}">{{$group->group_name}}
									                    </option>
									                  
								                          @endforeach
														</select>
														@else

	                                                      @if($cost->checkIsNull() == 3)
														    <input type="text" readonly  value="" class="form-control">
														  @else
													        <input type="text" readonly name="group_id" 
	                                                        value="{{ $cost->group->group_name }}" class="form-control">
														  @endif

														@endif
												 </div>
								                </div>
								           	    @if ($errors->has('group_id'))

                	                               <span class="text-danger">{{ $errors->first('group_id') }}</span>

            	                                @endif
								        </div>

								  
								        <div class="row">
						              
								                <div class="col-md-3 offset-md-3">
								                  <label style="float: right;"><b>販管費/原価</b></label>
								                </div>
								                <div class="col-xs-2">
								                 <div class="form-group">
								                  @if($cost->checkIsNull() == 0)
								                  <select class="form-control" name="type">
                                                   								                  
								                   	   <option value="2" @if ($cost->type == "2") selected @endif >販管費</option>
								                   	   <option value="1" @if ($cost->type == "1") selected @endif >原価</option>
								                 
								                  </select>
								                  @else
								                     @if($cost->type == "2")
									                  	<input type="text" readonly 
		                                                value="販管費" class="form-control">
                                                     @else
                                                        <input type="text" readonly 
		                                                value="原価" class="form-control">
                                                     @endif
								                  @endif
								                </div>
								                </div>
								           		@if ($errors->has('type'))

                	                              <span class="text-danger">{{ $errors->first('type') }}</span>

            	                                @endif
								        </div>
								         <div class="row">
								                <div class="col-md-3 offset-md-3">
								                  <label style="float: right;"><b>コード</b></label>
								                </div>
								                <div class="col-xs-2">
								                	 <div class="form-group">
                                                       @if($cost->checkIsNull() == 0)
								                       <input type="text" name="cost_code" value="{{ $cost->cost_code }}" class="form-control">
								                       <input hidden name="id" value="{{ $cost->id }}">
								                       @else
								                       <input type="text" readonly name="cost_code" value="{{ $cost->cost_code }}" class="form-control">
								                       @endif
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
								                  <label style="float: right;"><b>名称</b></label>
								                </div>
								                <div class="col-xs-2">
								                	 <div class="form-group">
								                	   @if($cost->checkIsNull() == 0)
								                       <input type="text" name="cost_name" value="{{ $cost->cost_name }}" class="form-control">
								                       @else
								                       <input type="text" readonly name="cost_name" value="{{ $cost->cost_name }}" class="form-control">
								                       @endif
								                     </div>
								                </div>
								              @if ($errors->has('cost_name'))

                	                                 <span class="text-danger">{{ $errors->first('cost_name') }}</span>

            	                              @endif
						                </div>

								        <div class="row">
						              
								                <div class="col-md-3 offset-md-3">
								                  <label style="float: right;">非表示</label>
								                </div>
								                <div class="col-xs-2">
								                 <div class="form-group">

                                                    <input type="checkbox" name="status" id="status" 
                                                    @if($cost->checkIsNull() != 0)
                                                      disabled
                                                    @endif
                                                    @if ($cost->status == false) checked @endif

                                                    class="minimal">

								                </div>
								                </div>
								           
								        </div>

						                <div class="row">
						                	　　<br>
						                	   @if($cost->checkIsNull() == 0)
									                <div class="col-sm-5">
									                
									                  <button type="submit" style="float:right;width: 200px;" class="btn btn-primary">変更</button>
									                </div>
	                                                <div class="col-sm-5">
									                
									                 <a style="float: left;width: 200px;" class="btn btn-danger" href="{{ url('cost/index?page='.request()->page) }}" >戻る</a>
									                </div>
								                @else
	                                                <div class="col-sm-2">
									              
									                </div>
	                                                <div class="col-md-5">
									                
									                 <a style="float: left;width: 200px;" class="btn btn-danger" href="{{ url('cost/index?page='.request()->page) }}" >戻る</a>
									                </div>
								                @endif
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
