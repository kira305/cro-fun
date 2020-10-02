@extends('layouts.app')

@section('content')
@section('breadcrumbs', Breadcrumbs::render('group/create'))
     
      <div class="row">
        <div class="col-md-12">
       
          <ul class="timeline">
	          	<li>
	             
	              <div class="timeline-item">
	               
	                <div class="timeline-body">
	                      <div>
				          
				            <div class="box-body">
				            	    @if (isset($message))


								    <p class="message" >{{ $message }}</p>

					
								    @endif
						        <form id="create_user" method="post" action="{{ url('group/create') }}" enctype="multipart/form-data">

						                <div class="row">
						              
								                <div class="col-md-3 offset-md-3">
								                  <label class="input_lable">所属会社</label>
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
								                  <label class="input_lable"><b>事業本部名</b></label>
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
							                  <label class="input_lable"><b>部署名</b></label>
							                </div>
							                <div class="col-xs-2">
							                	 <div class="form-group">
									                 <select class="form-control" id="department_id" name="department_id">
									                  	<option value=""></option>
									                  	@foreach($departments as $department)
											                <option class="department_id" id="{{ $department->headquarter()->id }}" 
									                      {{ old('department_id') == $department->id ? 'selected' : '' }} 
  										                    data-value="{{ $department->headquarter()->id }}"
											                @if(isset($department_id))
											                @if ($department_id == $department->id) selected @endif 
											                @endif
											                value="{{$department->id}}">{{$department->department_name}}</option>
									                     @endforeach

									                  </select>

							                     </div>
							                </div>
							                @if ($errors->has('department_id'))

            	                                <span class="text-danger" >{{ $errors->first('department_id') }}</span>

        	                                @endif						                
        	                            </div>

								        <div class="row">
								                <div class="col-md-3 offset-md-3">
								                  <label class="input_lable"><b>表示コード</b></label>
								                </div>
								                <div class="col-xs-2">
								                     <div class="form-group">
								                       <input type="text" name="group_code"  value="{{ old('group_code') }}" class="form-control">
								                       @csrf
								                     </div>
								                </div>
								                @if ($errors->has('group_code'))

                	                                <span class="text-danger" >{{ $errors->first('group_code') }}</span>

            	                                @endif
            	                                @if ($errors->has('unique'))

                	                                <span class="text-danger" >{{ $errors->first('unique') }}</span>

            	                                @endif
            	                                @if (isset($unique))

                                                              <span class="text-danger" >{{ $unique }}</span>

                                                @endif
						                </div>
						                <div class="row">
								                <div class="col-md-3 offset-md-3">
								                  <label class="input_lable"><b>グループコード</b></label>
								                </div>
								                <div class="col-xs-2">
								                	 <div class="form-group">
								                       <input type="text" name="group_list_code"  value="{{ old('group_list_code') }}" class="form-control">
								                     </div>
								                </div>
								                @if ($errors->has('group_list_code'))

                	                                <span class="text-danger">{{ $errors->first('group_list_code') }}</span>

            	                                @endif
						                </div>
						                 <div class="row">
								                <div class="col-md-3 offset-md-3">
								                  <label class="input_lable"><b>グループ名</b></label>
								                </div>
								                <div class="col-xs-2">
								                	 <div class="form-group">
								                       <input type="text" name="group_name" value="{{ old('group_name') }}"  class="form-control">
								                     </div>
								                </div>
								                @if ($errors->has('group_name'))

                	                                <span class="text-danger" >{{ $errors->first('group_name') }}</span>

            	                                @endif
						                </div>


						                <div class="row">
								                <div class="col-md-3 offset-md-3">
								                  <label class="input_lable">原価コード</label>
								                </div>
								                <div class="col-xs-2">
								                	 <div class="form-group">
										                 <input  type="text"  id="cost_code"  value="{{ old('cost_code') }}" name = "cost_code" class="form-control">
								                     </div>
								                </div>
								                @if ($errors->has('cost_code'))

                	                                <span class="text-danger">{{ $errors->first('cost_code') }}</span>

            	                                @endif

						                </div>
                                        <div class="row">
						                	    <div class="col-md-3 offset-md-3">
								                  <label class="input_lable">原価名</label>
								                </div>
								                <div class="col-xs-2">
								                	 <div class="form-group">
								                       <input  type="text"   name="cost_name"  value="{{ old('cost_name') }}" class="form-control">
								                     </div>
								                </div>
								                @if ($errors->has('cost_name'))

                	                                <span class="text-danger" >{{ $errors->first('cost_name') }}</span>

            	                                @endif
						                </div>
						                <div class="row">
						                	　　　<br>
								                <div class="col-sm-3">
								                
								                  <button type="submit" style="float:right;width: 200px;" class="btn btn-primary">登録</button>
								                </div>
                                                <div class="col-sm-5">
								             
								                   <a style="float: left;width: 200px;" class="btn btn-danger" href="{{ url('group/index') }}" >戻る</a>
								                </div>
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
<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
<script type="text/javascript">

</script>
<script src="{{ asset('select/icontains.js') }}" ></script>

<script src="{{ asset('select/comboTreePlugin.js') }}" ></script>
<script type="text/javascript">

     $(document).ready(function(){
          
			  $("#department_id").change(function(){
			       
			       // alert($(this).children("option:selected").data("value"));
			       var headquarter_name = $(this).children("option:selected").data("value");
			      
                   $("#headquarter_name").val(headquarter_name);
                   $("#fake_name").text(headquarter_name);

			  });
               
            
               // var jobs = JSON.parse("{{ json_encode(old('headquarter_name')) }}");
               // alert(jobs);
               // $( "#headquarter_name" ).text("{{ old('headquarter_name') }}");
			  
               
			  

			   
     });
    



    $(document).on('submit','#create_user',function(){
           
            var headquarter_name = $("#department_id").children("option:selected").data("value");
			      
           $("#headquarter_name").val(headquarter_name);

    });

</script>

@endsection
