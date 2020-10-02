@extends('layouts.app')

@section('content')
@section('breadcrumbs', Breadcrumbs::render('group/edit'))
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>       
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
						        <form id="group_form" method="post" action="{{ url('group/edit') }}" enctype="multipart/form-data">

						                <div class="row">
						              
								                <div class="col-md-3 offset-md-3">
								                  <label class="input_lable">所属会社</label>
								                </div>
								                <div class="col-xs-2" >
												<div class = "form-control" disabled>
													{{$group->headquarter()->abbreviate_name}}
												</div>

								                </div>

								        </div>
								        <br>
								        @if($group->department()->status == false || $group->headquarter()->status == false)
								        <div class="row">
							                <div class="col-md-1">
							                  <label class="input_lable"><b>事業本部名</b></label>
							                </div>
							                <div class="col-xs-2">
							                   <div class="form-group">
                                                   <input  type="text"  name="cost_code" readonly value="{{ $group->headquarter()->headquarters }}" class="form-control">	                       
							                    </div>
							                </div>
						                </div>

								        <div class="row">
								                <div class="col-md-3 offset-md-3">
								                  <label class="input_lable"><b>部署名</b></label>
								                </div>
								                <div class="col-xs-2">
								                	 <div class="form-group">
                                                   <input  type="text"  name="cost_code" readonly 
                                                   value="{{ $group->department()->department_name }}" class="form-control">
								                     </div>
								                </div>
								                @if ($errors->has('department_id'))

                	                                <span class="text-danger" style="margin-right: 100px;">{{ $errors->first('department_id') }}</span>

            	                                @endif

						                </div>
						             @else 
						             <!--   ------------------------------------  -->
								        <div class="row">
							                <div class="col-md-1">
							                  <label class="input_lable"><b>事業本部名</b></label>
							                </div>
							                <div class="col-xs-2">
							                	 <div class="form-group">
   									                    <select class="form-control"  id="headquarter_id" name="headquarter_id" >
									                    <option　> </option>
											                @foreach($headquarters as $headquarter)
											                <option class="headquarter_id" 
											                 data-id = "{{ $headquarter->company_id }}"
											                @if(!isset($headquarter_id))

												                @if ($group->headquarter()->headquarters_id == $headquarter->id) 

												                    selected

												                @endif 
											                
											                @else 
                                                                 
                                                                 @if ($headquarter_id == $headquarter->id)

                                                                     selected

                                                                 @endif

											                @endif

											                value="{{$headquarter->id}}">{{$headquarter->headquarters}}</option>
										                     @endforeach
														</select>		                       
							                     </div>
							                </div>
						                </div>

								        <div class="row">
								                <div class="col-md-3 offset-md-3">
								                  <label class="input_lable"><b>部署名</b></label>
								                </div>
								                <div class="col-xs-2">
								                	 <div class="form-group">
										                 <select class="form-control" id="department_id" name="department_id">
										                  	<option value=""> </option>
										                  	@foreach($departments as $department)
											                <option class="department_id"    
											                @if ($group->department_id == $department->id) selected @endif 
  										                    data-value="{{ $department->headquarters_id }}"
											                value="{{$department->id}}">{{$department->department_name}}</option>
										                     @endforeach
										                  </select>
								                     </div>
								                </div>
								                @if ($errors->has('department_id'))

                	                                <span class="text-danger" style="margin-right: 100px;">{{ $errors->first('department_id') }}</span>

            	                                @endif

						                </div>
						                @endif
								        <div class="row">
								                <div class="col-md-3 offset-md-3">
								                  <label class="input_lable"><b>表示コード</b></label>
								                </div>
								                <div class="col-xs-2">
								                     <div class="form-group">
								                       <input type="text" 
								                       	@if($group->department()->status == false || $group->headquarter()->status == false)
                                                          readonly
								                        @endif
								                       name="group_code" value="{{$group->group_code}}" class="form-control">
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
								                       <input type="text" 
								                       	@if($group->department()->status == false || $group->headquarter()->status == false)
                                                          readonly
								                        @endif
								                       name="group_list_code"  value="{{$group->group_list_code}}" class="form-control">
								                       <input type="hidden" id="group_id" name="id" value="{{$group->id}}">
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
								                       <input type="text" name="group_name"  
								                       	@if($group->department()->status == false || $group->headquarter()->status == false)
                                                          readonly
								                        @endif
								                       value="{{$group->group_name}}" class="form-control">
								                     </div>
								                </div>
								                @if ($errors->has('group_name'))

                	                                <span class="text-danger">{{ $errors->first('group_name') }}</span>

            	                                @endif
						                </div>



						                <div class="row">
								                <div class="col-md-3 ">
								                  <label class="input_lable">原価コード</label>
								                </div>
								                <div class="col-xs-2">
								                	 <div class="form-group">
										                 <input  type="text"  
										                @if($group->department()->status == false || $group->headquarter()->status == false)
                                                          readonly
								                        @endif
										                 name="cost_code"  value="{{ $group->cost_code }}" class="form-control">
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
								                       <input  type="text" 
								                       	@if($group->department()->status == false || $group->headquarter()->status == false)
                                                          readonly
								                        @endif
								                        value="{{ $group->cost_name }}" name="cost_name" class="form-control">
								                     </div>
								                </div>
								           		@if ($errors->has('cost_name'))

                	                                <span class="text-danger">{{ $errors->first('cost_name') }}</span>

            	                                @endif

						                </div>
						                <div class="row" id="change_reason" >
                                        	  <div class="col-md-3 offset-md-3">
                                                   <label class="input_lable">変更理由</label>
                                        	  </div>
                                        	  <div class="col-xs-2">
								                	<textarea rows="5" cols="63" name="note">{{ $group->note }}</textarea>
								               </div>
                                        </div>
						                <div class="row">
						              
								                <div class="col-md-3 offset-md-3">
								                  <label class="input_lable hidden_lable">非表示</label>
								                </div>
								                <div class="col-xs-2">
								                 <div class="form-group">
                                                    <input type="checkbox" 
                                                    name="status" id="status" @if ($group->status == false) checked @endif
                                                     @if($group->department()->status == false || $group->headquarter()->status == false)
                                                     disabled
                                                     @endif
                                                    class="minimal">
								                </div>
								                </div>
								           
								        </div>
								        <div class="row" id="change_group" hidden>
								                <div class="col-md-3 offset-md-3">
								                  <label class="input_lable">移行先グループ</label>
								                </div>
								                <div class="col-xs-2">
								                	 <div class="form-group">
								                      <select class="form-control" name="group_id" id="change_id">
										                  	<option value=""> </option>
										                  	@foreach($group_list as $groups)
											                <option class="group_id_chose"
											                @if ($group->id == $groups->id) hidden @endif  
                                                            data-value = "{{$groups->headquarter()->company_id}}"
											                value="{{$groups->id}}">{{$groups->group_name}}</option>"{{$groups->headquarter()->company_id}}"
										                    @endforeach
										               </select>
								                     </div>
								                </div>

						                </div>
						                <div class="row">
						                	　　　<br>
						                	    @if($group->department()->status != false && $group->headquarter()->status != false)
								                <div class="col-sm-3">
								               
								                  <button type="button" id="change" style="float:right;width: 200px;" class="btn btn-primary">更新</button>
								                
								                </div>
                                                <div class="col-sm-5">
                                                   <a style="float: left;width: 200px;" class="btn btn-danger" href="{{ url('group/index?page='.request()->page) }}" >戻る</a>
								                </div>
                                                @else
                                                <div class="col-sm-2">
								                
								                </div>
                                                <div class="col-sm-5">
                                                   <a style="float: left;width: 200px;" class="btn btn-danger" href="{{ url('group/index?page='.request()->page) }}" >戻る</a>
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

<script src="{{ asset('select/icontains.js') }}" ></script>

<script src="{{ asset('select/comboTreePlugin.js') }}" ></script>
<script type="text/javascript">
     $(document).ready(function() { 

	            $("#change").click(function() { 
	      
	            if($('#status').is(':checked') == true && $("#change_id").val() == ""){

	               	var form  = new FormData();

	                form.append('group_id', $("#group_id").val());
                         
		            $.ajax({
					    url: '/group/check',
					    data: form,
					    cache: false,
					    contentType: false,
					    processData: false,
					    type: 'POST',
					    success:function(response) {
				            // console.log(response.status);
				            	
		                    if(response.status == 1){
		                          
									$.confirm({
									    title: response.message,
									    content: '',
									    type: 'red',
									    typeAnimated: true,
									    buttons: {
									        delete: {
									            text: 'YES',
									            btnClass: 'btn-blue',
									            with :'100px',
									            action: function(){
										            
										            $( "#group_form" ).submit();
									            }
									        },
									        cancel: {
									            text: 'NO',
									            btnClass: 'btn-red',
									            action: function(){
	                                                
	                                                     $('#change_group').hide();
									            }
									        }
									    }
									});
		                        
		                        $('#status').prop('selectedIndex', 0);

		                    }else {

		                    	 $( "#group_form" ).submit();
		                    }




					    },

					    error: function (exception) {
		                        
		                        alert(exception.responseText);
								

						}
					});
	              
	               }else {

	               	   $( "#group_form" ).submit();
	               }

  

	            }); 

	     }); 
     $(document).ready(function(){

     	      var headquarter = $("#department_id").find(':selected').attr('data-value');
         
     	      $("#fake_name").text(headquarter);
          
		//	  $("#department_id").change(function(){
			       
			       // alert($(this).children("option:selected").data("value"));
		//	       var headquarter_name = $(this).children("option:selected").data("value");

          //         $("#fake_name").text(headquarter_name);
            //       $("#headquarter_name").val(headquarter_name);
             

			  //});
     	      var headquarter = $("#department_id").find(':selected').attr('data-value');
              var company_id  = $("#headquarter_id").find(':selected').attr('data-id');//ログインしている人の会社ID
             // var headquarter_id  = $("#department_id").find(':selected').attr('data-id');
             var headquarter_id = $("#headquarter_id").val();

              
              $( ".headquarter_id" ).each(function() {
                    
                 if($(this).attr('data-id') != company_id){

                    $(this).remove();

                 }
                   
              });

               $( ".department_id" ).each(function() {
                    
                 if($(this).attr('data-value') != headquarter_id){

                    $(this).remove();

                 }
                   
              });

               $( ".group_id_chose" ).each(function() {
                    
                 if($(this).attr('data-value') != company_id){
                 	//alert (company_id);
                    $(this).remove();

                 }
                   
              });

     });

     $(document).on('change', '#status', function () {
         
         ckb = $("#status").is(':checked');

         if(ckb == true){
           
                    $('#change_group').show();
                  

         }else {
                    
                    $('#change_group').hide();
                 

         }
         


     });
</script>

@endsection
