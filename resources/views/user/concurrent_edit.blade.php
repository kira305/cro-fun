@extends('layouts.app')

@section('content')
@section('breadcrumbs', Breadcrumbs::render('user/concurrent/edit',$concurrent->usr_id))
     
      <div class="row">
        <div class="col-md-12">
       
          <ul class="timeline">
          	<li>
             
              <div class="timeline-item">
               
                <div class="timeline-body">
                  <div>
		          
		            <div class="box-body">
	            	    @if (isset($message))

			              <p class="" style="text-align: center;color: green">{{ $message }}</p>

					    @endif
					    @if ($errors->has('unique'))

                             <p class="" style="text-align: center;color: red">{{ $errors->first('unique') }}</p>

	                    @endif
				        <form id="create_user" method="post" action="{{ url('user/concurrent/edit') }}">
        
					        <div class="row">
				                <div class="col-md-3 offset-md-3">
				                  <label style="float: right;">社員番号</label>
				                </div>
				                <div class="col-xs-2">
				                     <div class="form-group">

				                       <input type="text" id="user_code" value="{{$concurrent->usr_code}}" class="form-control">
				                       <input type="hidden" name="usr_code"  value="{{$concurrent->usr_code}}" class="form-control">
				                       <input type="hidden" name="concurrent_id"  value="{{$concurrent->id}}" class="form-control">
				                         @csrf
				                     </div>
				                </div>
				                @if ($errors->has('usr_code'))

	                                <span class="text-danger">{{ trans('validation.user_code') }}</span>

                                @endif
			                </div>
			                 <div class="row">
					                <div class="col-md-3 offset-md-3">
					                  <label style="float: right;">社員名</label>
					                </div>
					                <div class="col-xs-2">
					                	 <div class="form-group">
					                       <input type="text" id="user_name" value="{{$concurrent->usr_name}}" class="form-control">
					                       <input type="hidden" name="usr_name"  value="{{$concurrent->usr_name}}" class="form-control">
					                     </div>
					                </div>
					                @if ($errors->has('usr_name'))

    	                                <span class="text-danger">{{ trans('validation.user_name') }}</span>

	                                @endif
			                </div>
			                <div class="row">
		              
				                <div class="col-md-3 offset-md-3">
				                  <label style="float: right;"><b>所属会社</b></label>
				                </div>
				                <div class="col-md-2">
				                	<div class="form-group">
				                	 @if ($concurrent->checkIsDisable($concurrent->id) == 1) 
                                          
                                           	<input readonly name="company_id"  value="{{$concurrent->company->company_name}}" class="form-control">
				                	 @else
										   @if (Auth::user()->checkCompany($concurrent->company_id) == true)
							                    <select class="form-control"  id="company_id" name="company_id" >
										          @foreach($companies as $company)
							                    <option  
							                    @if ($concurrent->company_id == $company->id) selected @endif
							                    value="{{$company->id}}">{{$company->abbreviate_name}}
							                    </option>
							                  
						                          @endforeach
		             				       @else
												<select class="form-control" name="company_id_N" id="company_id" disabled >
								                    <option 
								                    value="{{$concurrent->id}}">{{$concurrent->company->abbreviate_name}}
								                    </option>
						                    @endif

										</select>
									@endif
								    </div>
				                </div>

				                @if ($errors->has('company_id'))

	                               <span class="text-danger">{{ $errors->first('company_id') }}</span>

                                @endif
					        </div>
					        <div class="row">
				                <div class="col-md-3 offset-md-3">
				                  <label style="float: right;"><b>事業本部名</b></label>
				                </div>
				                <div class="col-xs-2">
				                	 <div class="form-group">
				                	 @if ($concurrent->checkIsDisable($concurrent->id) == 1) 
                                          
                                           	<input readonly name="headquarter_id"  value="{{$concurrent->headquarter->headquarters}}" class="form-control">
				                	 @else
											 @if (Auth::user()->checkCompany($concurrent->company_id) == true)
								                 <select class="form-control" name="headquarter_id" id="headquarter_id">
								                  	@foreach($headquarters as $headquarter)
									                <option class="headquarter_id" 
									                data-value="{{ $headquarter->company_id }}"
									                @if ($concurrent->headquarter_id == $headquarter->id) selected @endif 
									           
									                value="{{$headquarter->id}}">{{$headquarter->headquarters}}</option>
								                     @endforeach
								                  </select>
						                     @else
								                  <input class="form-control" value="{{$concurrent->headquarter->headquarters}}" readonly >
						                   	 @endif
								                 
								      @endif
				                     </div>
				                </div>
				                @if ($errors->has('headquarter_id'))

	                                   <span class="text-danger">{{ $errors->first('headquarter_id') }}</span>

                                @endif
			                </div> 
			                <div class="row">
				                <div class="col-md-3 offset-md-3">
				                  <label style="float: right;"><b>事業部名</b></label>
				                </div>
				                <div class="col-xs-2">
				                	 <div class="form-group">
				                	 @if ($concurrent->checkIsDisable($concurrent->id) == 1) 
                                          
                                           	<input readonly name="department_id"  value="{{$concurrent->department->department_name}}" class="form-control">
				                	 @else
											 @if (Auth::user()->checkCompany($concurrent->company_id) == true)
							                 <select class="form-control" id="department_id" name="department_id">
							                  	<option value=""> </option>
							                  	@foreach($departments as $department)
									                <option class="department_id" 
									                data-value="{{ $department->headquarters_id }}"
									             
									                @if ($concurrent->department_id == $department->id) selected @endif 
									              
									                value="{{$department->id}}">{{$department->department_name}}</option>
							                     @endforeach
						                     @else
								                 <select class="form-control" id="department_id_N" name="department_id" disabled >
							                 	<option value="{{$concurrent->id}}">{{$concurrent->department->department_name}}
							                    </option>
						                    @endif
						             	     </select>
						             @endif
				                     </div>
				                </div>
				                @if ($errors->has('department_id'))

	                               <span class="text-danger">{{ $errors->first('department_id') }}</span>

                                @endif
			                </div>
					        <div class="row">
		              
				                <div class="col-md-3 offset-md-3">
				                  <label style="float: right;"><b>所属グループ</b></label>
				                </div>
				                <div class="col-md-2">
					               	<div class="form-group">
					               	@if ($concurrent->checkIsDisable($concurrent->id) == 1) 
                                          
                                           	<input readonly name="group_id"  value="{{$concurrent->group->group_name}}" class="form-control">
				                	 @else
											 @if (Auth::user()->checkCompany($concurrent->company_id) == true)
							                    	<select class="form-control"  id="group_id" name="group_id" >
							                      <option value=""> </option>
										          @foreach($groups as $group)
							                    <option class="group_id" 
							                    data-value="{{ $group->department_id }}"
							                    @if ($concurrent->group_id == $group->id) selected @endif
							                    value="{{$group->id}}">{{$group->group_name}}
							                    </option>
							                  
						                          @endforeach
						                     @else
								                 <select class="form-control"  id="group_id_N" name="group_id" disabled >
							                 	<option value="{{$concurrent->id}}">{{$concurrent->group->group_name}}
							                    </option>
						                     @endif
												</select>
									 @endif
									 </div>
				                </div>
				           	    @if ($errors->has('group_id'))

	                               <span class="text-danger">{{ $errors->first('group_id') }}</span>

                                @endif
					        </div>
					        <div class="row">
			              
				                <div class="col-md-3 offset-md-3">
				                  <label style="float: right;"><b>役職</b></label>
				                </div>
				                <div class="col-xs-2">
					                 <div class="form-group">
					                 @if ($concurrent->checkIsDisable($concurrent->id) == 1) 
                                          
                                           	<input readonly name="position_id"  value="{{$concurrent->position->position_name}}" class="form-control">
				                	 @else
						                  @if (Auth::user()->checkCompany($concurrent->company_id) == true) 
						                    <select class="form-control"  id="position_id" name="position_id" >
						                      <option value=""> </option>
									          @foreach($position_list as $position)
							                    <option class="position_id" 
							                      data-value="{{ $position->company_id }}"
							                      @if ($concurrent->position_id == $position->id) selected @endif 
							                    value="{{$position->id}}">{{$position->position_name}}
						                    </option>
						                  
					                          @endforeach
						                    @else
							                    <select class="form-control"  id="position_id_N" name="position_id"  disabled >
							                    <option 
							                    value="{{$concurrent->id}}">{{$concurrent->position->position_name}}
							                    </option>
						                    @endif
											</select>
									@endif
								    </div>				                

				                </div>
				           		@if ($errors->has('position_id'))

	                              <span class="text-danger">{{ $errors->first('position_id') }}</span>

                                @endif
					        </div>

			                <div class="row">
		                	　　　<br>
		                	    @if ($concurrent->checkIsDisable($concurrent->id) == 1) 
		                	    <div class="col-sm-2">
				                
				                </div>
                                <div class="col-sm-5">
				                
				                 <a style="float: left;width: 200px;" class="btn btn-danger" href="{{route('edituserinfor', ['id' => $concurrent->usr_id])}}" >戻る</a>
				                 
				                </div>
		                	    @else
				                <div class="col-sm-3">
				                
				                  <button type="submit" style="float:right;width: 200px;" class="btn btn-primary"@if (Auth::user()->checkCompany($concurrent->company_id) == false) disabled @endif>編集</button>
				                </div>
                                <div class="col-sm-5">
				                
				                 <a style="float: left;width: 200px;" class="btn btn-danger" href="{{route('edituserinfor', ['id' => $concurrent->usr_id])}}" >戻る</a>
				                 
				                </div>
				                @endif
				                <div class="col-sm-4">
				                	
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



<script type="text/javascript">
	 
	    $(document).ready(function() {
              
             $( "#user_code" ).prop( "disabled", true );
             $( "#user_name" ).prop( "disabled", true );
         });
</script>

@endsection
