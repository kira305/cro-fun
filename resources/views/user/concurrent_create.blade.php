@extends('layouts.app')

@section('content')
@section('breadcrumbs', Breadcrumbs::render('user/concurrent/create',$user->id))
     
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
			        <form id="create_user" method="post" action="{{ url('user/concurrent/create') }}">

					             
					        <div class="row">
				                <div class="col-md-3 offset-md-3">
				                  <label style="float: right;">社員番号</label>
				                </div>
				                <div class="col-xs-2">
				                     <div class="form-group">
				                       <input type="text"  value="{{$user->usr_code}}" id="user_code" class="form-control">
				                       <input type="hidden" value="{{$user->id}}" name="usr_id">
				                       <input type="hidden" name="usr_code" value="{{$user->usr_code}}"  class="form-control">
				                         @csrf
				                     </div>
				                </div>

                               @if ($errors->has('usr_code'))

	                                <span class="text-danger">{{ $errors->first('usr_code') }}</span>

                               @endif
			                </div>
			                 <div class="row">
				                <div class="col-md-3 offset-md-3">
				                  <label style="float: right;">社員名</label>
				                </div>
				                <div class="col-xs-2">
				                	 <div class="form-group">
				                       <input type="text"  id="user_name" value="{{$user->usr_name}}" class="form-control">
				                       <input type="hidden" name="usr_name"  value="{{$user->usr_name}}" class="form-control">
				                     </div>
				                </div>
				                @if ($errors->has('usr_name'))

	                                  <span class="text-danger">{{ $errors->first('usr_name') }}</span>

                                @endif
			                </div>
			                <div class="row">
		              
				                <div class="col-md-3 offset-md-3">
				                  <label style="float: right;"><b>所属会社</b></label>
				                </div>
				                <div class="col-md-2">
				                	<div class="form-group">
					                    <select class="form-control"  name="company_id_c" id="company_id">
					                    	<option value=""></option>
								          @foreach($companies as $company)
					                    <option 
					                         {{ old('company_id_c') == $company->id ? 'selected' : '' }}
					        		         value="{{$company->id}}">{{$company->abbreviate_name}}
					                    </option>
					                  
				                          @endforeach
										</select>
								    </div>
				                </div>
				                @if ($errors->has('company_id_c'))

	                               <span class="text-danger">{{ $errors->first('company_id_c') }}</span>

                                @endif
					        </div>
					        <div class="row">
				                <div class="col-md-3 offset-md-3">
				                  <label style="float: right;"><b>事業本部名</b></label>
				                </div>
				                <div class="col-xs-2">
				                	 <div class="form-group">
						                 <select class="form-control" id="headquarter_id" name="headquarter_id_c">
						                  	<option value=""> </option>
						                  	@foreach($headquarters as $headquarter)
								                <option class="headquarter_id" 
								                 {{ old('headquarter_id_c') == $headquarter->id ? 'selected' : '' }}
	                                             data-value="{{ $headquarter->company()->id }}"
								                 value="{{$headquarter->id}}">{{$headquarter->headquarters}}</option>
						                     @endforeach
						                  </select>
				                     </div>
				                </div>
				                @if ($errors->has('headquarter_id_c'))

	                                   <span class="text-danger">{{ $errors->first('headquarter_id_c') }}</span>

                                @endif
			                </div>  
					        <div class="row">
				                <div class="col-md-3 offset-md-3">
				                  <label style="float: right;"><b>事業部名</b></label>
				                </div>
				                <div class="col-xs-2">
				                	 <div class="form-group">
						                 <select class="form-control" id="department_id" name="department_id_c">
						                  	<option value=""> </option>
						                  	@foreach($departments as $department)
								                <option  class="department_id" 
								                {{ old('department_id_c') == $department->id ? 'selected' : '' }}
								                data-value="{{ $department->headquarter()->id }}"
								                value="{{$department->id}}">{{$department->department_name}}</option>
						                     @endforeach
						                  </select>
				                     </div>
				                </div>

				                @if ($errors->has('department_id_c'))

	                               <span class="text-danger">{{ $errors->first('department_id_c') }}</span>

                                @endif
			                </div>
					        <div class="row">
		              
				                <div class="col-md-3 offset-md-3">
				                  <label style="float: right;"><b>所属グループ</b></label>
				                </div>
				                <div class="col-md-2">
					               	<div class="form-group">
					                    <select class="form-control"  name="group_id_c" id="group_id">
					                    	<option value=""></option>
					                    	
								            @foreach($groups as $group)
							                    <option class="group_id" 
							                    {{ old('group_id_c') == $group->id ? 'selected' : '' }}
							                    data-value="{{ $group->department()->id }}"
							                    value="{{$group->id}}">{{$group->group_name}}
							                    </option>
						                  
				                            @endforeach
										</select>
									 </div>
				                </div>
				           	    @if ($errors->has('group_id_c'))

	                               <span class="text-danger">{{ $errors->first('group_id_c') }}</span>

                                @endif
					        </div>

					        <div class="row">
		              
				                <div class="col-md-3 offset-md-3">
				                  <label style="float: right;"><b>役職</b></label>
				                </div>
				                <div class="col-xs-2">
				                 <div class="form-group">
				                  <select class="form-control" id="position_id" name="position_id_c">
				                   		<option value=""></option>
				                   @foreach($position_list as $position)
					                    <option class="position_id"
					                      {{ old('position_id_c') == $position->id ? 'selected' : '' }}
					                    data-value="{{ $position->company_id }}"
					                    value="{{$position->id}}">{{$position->position_name}}
					                    </option>
				                    @endforeach
				                  </select>
				                </div>

				                </div>
				           		@if ($errors->has('position_id_c'))

	                              <span class="text-danger">{{ $errors->first('position_id_c') }}</span>

                                @endif
					        </div>


			                <div class="row">
		                	　　　<br>
				                <div class="col-sm-3">
				                
				                  <button type="submit" style="float:right;width: 200px;" class="btn btn-primary">登録</button>
				                </div>
                                <div class="col-sm-5">

				                   <a style="float: left;width: 200px;" class="btn btn-danger" href="{{route('edituserinfor', ['id' => $user->id])}}" >戻る</a>

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

    $(document).ready(function() {
          
         
          $( "#user_code" ).prop( "disabled", true );
          $( "#user_name" ).prop( "disabled", true );
          $( "#headquarter_id" ).prop( "disabled", true );
          $( "#department_id" ).prop( "disabled", true );
          $( "#group_id" ).prop( "disabled", true );


          if($( "#company_id" ).val() != ""){
            
            $( "#headquarter_id" ).prop( "disabled", false );
            
                     var company_id = $("#company_id").val();

			         $( ".headquarter_id" ).each(function() {

					       $(this).show();
					 
					       if($(this).attr('data-value') !== company_id){
			                     
					       	     $(this).hide();
			 
					       }

					   });


          }
          
          if($( "#headquarter_id" ).val() != ""){
            
            $( "#department_id" ).prop( "disabled", false );
            
                     var headquarter_id = $("#headquarter_id").val();

			         $( ".department_id" ).each(function() {

					       $(this).show();
					 
					       if($(this).attr('data-value') !== headquarter_id){
			                     
					       	     $(this).hide();
			 
					       }

					   });


          }

          if($( "#departmen_id" ).val() != ""){
            
            $( "#group_id" ).prop( "disabled", false );
            
                     var department_id= $("#department_id").val();

			         $( ".group_id" ).each(function() {

					       $(this).show();
					 
					       if($(this).attr('data-value') !== department_id){
			                     
					       	     $(this).hide();
			 
					       }

					   });


          }




    });

     $(document).on('change', '#company_id', function () {
        
        $('#headquarter_id').prop('selectedIndex',0);
        $('#department_id').prop('selectedIndex',0);
        $('#group_id').prop('selectedIndex',0);
        $( "#headquarter_id" ).prop( "disabled", false );
        var company_id = $("#company_id").val();

         $( ".headquarter_id" ).each(function() {

		       $(this).show();
		       if($(this).attr('data-value') !== company_id){

		       	     $(this).hide();
 
		       }

		   });

         


    });

     $(document).on('change', '#headquarter_id', function () {
        
        $('#department_id').prop('selectedIndex',0);
        $( "#department_id" ).prop( "disabled", false );

        var headquarter_id = $("#headquarter_id").val();

         $( ".department_id" ).each(function() {

		       $(this).show();
		       if($(this).attr('data-value') !== headquarter_id){

		       	     $(this).hide();
 
		       }

		   });

    });

     $(document).on('change', '#department_id', function () {
        
        $('#group_id').prop('selectedIndex',0);
        $( "#group_id" ).prop( "disabled", false );

        var department_id = $("#department_id").val();

         $( ".group_id" ).each(function() {

		       $(this).show();
		       if($(this).attr('data-value') !== department_id){

		       	     $(this).hide();
 
		       }

		   });

    });

</script>

@endsection
