@extends('layouts.app')

@section('content')
@section('breadcrumbs', Breadcrumbs::render('department/edit'))
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
						        <form id="department_form" method="post" action="{{ url('department/edit') }}" enctype="multipart/form-data">

						                <div class="row">
						              
								                <div class="col-md-3 offset-md-3">
								                  <label class="input_lable">所属会社</label>
								                </div>
								                <div class="col-xs-2">
												<p class = "form-control">
													{{$department->company()->abbreviate_name}}
												</p>

								                </div>

								        </div>
                                       @if($department->headquarter()->status == false)
								       <div class="row">
								                <div class="col-md-3 offset-md-3">
								                  <label class="input_lable"><b>事業本部名</b></label>
								                </div>
								                <div class="col-xs-2">
								                	 <div class="form-group">
                                                        <input  type="text"  name="cost_code"
                                                         readonly value="{{ $department->headquarter()->headquarters }}" class="form-control">	
								                     </div>
								                </div>
								                @if ($errors->has('headquarter_id'))

                	                                <span class="text-danger">{{ $errors->first('headquarter_id') }}</span>

            	                                @endif
						                </div> 
                                        @else
						                <div class="row">
								                <div class="col-md-3 offset-md-3">
								                  <label class="input_lable"><b>事業本部名</b></label>
								                </div>
								                <div class="col-xs-2">
								                	 <div class="form-group">
								                      <select class="form-control" id="headquarter_id" name="headquarter_id">
										                  	
										                  	@foreach($headquarters as $headquarter)
											                <option class="headquarter_id_chose" 
											                 data-id = "{{ $headquarter->company_id }}"
											                @if ($department->headquarters_id == $headquarter->id) selected @endif 
											                
											                value="{{$headquarter->id}}">{{$headquarter->headquarters}}</option>
										                     @endforeach
										               </select>
								                     </div>
								                </div>
								                @if ($errors->has('headquarter_id'))

                	                                <span class="text-danger">{{ $errors->first('headquarter_id') }}</span>

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
								                        @if($department->headquarter()->status == false)
								                          readonly
								                        @endif
								                       name="department_code" value="{{$department->department_code}}" class="form-control">
								                       @csrf
								                     </div>
								                </div>
								                @if ($errors->has('department_code'))

                	                                <span class="text-danger">{{ $errors->first('department_code') }}</span>

            	                                @endif
            	                                @if ($errors->has('unique'))

                	                                <span class="text-danger" >{{ $errors->first('unique') }}</span>

            	                                @endif
						                </div>
						                <div class="row">
								                <div class="col-md-3 offset-md-3">
								                  <label class="input_lable"><b>部署コード</b></label>

								                </div>
								                <div class="col-xs-2">
								                	 <div class="form-group">
								                       <input type="text" 
								                       	@if($department->headquarter()->status == false)
								                          readonly
								                        @endif
								                       name="department_list_code" value="{{$department->department_list_code}}" class="form-control">
								                     </div>
								                </div>
								                @if ($errors->has('department_list_code'))

                	                                <span class="text-danger">{{ $errors->first('department_list_code') }}</span>

            	                                @endif
						                </div>
						                 <div class="row">
								                <div class="col-md-3 offset-md-3">
								                  <label class="input_lable"><b>部署名</b></label>
								                </div>
								                <div class="col-xs-2">
								                	 <div class="form-group">
								                       <input type="text" 
								                       	@if($department->headquarter()->status == false)
								                          readonly
								                        @endif
								                       name="department_name"  value="{{$department->department_name}}" class="form-control">
								                       <input type="hidden" id="id" name="department_id" value="{{$department->id}}">
								                     </div>
								                </div>
								                @if ($errors->has('department_name'))

                	                                <span class="text-danger">{{ $errors->first('department_name')  }}</span>

            	                                @endif
						                </div>



						                <div class="row" id="change_reason" >
                                        	  <div class="col-md-3 offset-md-3">
                                                   <label class="input_lable">変更理由</label>
                                        	  </div>
                                        	  <div class="col-xs-2">
								                	<textarea rows="5" cols="63" name="note">{{ $department->note }}</textarea>
								               </div>
                                        </div>

                                        <div class="row">
						              
								                <div class="col-md-3 offset-md-3">
								                  <label class="input_lable hidden_lable">非表示</label>
								                </div>
								                <div class="col-xs-2">
								                 <div class="form-group">
                                                    <input type="checkbox" @if ($department->status == false) checked @endif 
                                                    @if($department->headquarter()->status == false)
                                                     disabled
                                                     @endif
                                                    name="status" id="status" 
                                                    class="minimal">
								                </div>
								                </div>
								           
								        </div>
					                    <div class="row" id="change_department" hidden>
								                <div class="col-md-3 offset-md-3">
								                  <label class="input_lable">移行先事業部</label>
								                </div>
								                <div class="col-xs-2">
								                	 <div class="form-group">
								                      <select class="form-control" id="change_id" name="new_department_id">
										                  	<option value=""> </option>
										                  	@foreach($departments as $department_list)
											                <option class="department_id_chose" 
											                @if ($department->id == $department_list->id) hidden @endif 
                                                            data-id = "{{$department_list->headquarter()->company_id}}"
											                value="{{$department_list->id}}">{{$department_list->department_name}}</option>
										                    @endforeach
										               </select>
								                     </div>
								                </div>
								                @if ($errors->has('company_id'))

                	                                <span class="text-danger">{{ trans('validation.company_chose') }}</span>

            	                                @endif
						                </div>

                                       

						                <div class="row">
						                	　　　<br>
						                	    @if($department->headquarter()->status != false)
								                <div class="col-sm-3">
								               
								                  <button type="button" id="change" style="float:right;width: 200px;" class="btn btn-primary">更新</button>
								               
								                </div>
                                                <div class="col-sm-5">
								                
										                  <a style="float: left;width: 200px;" class="btn btn-danger" href="{{ url('department/index?page='.request()->page) }}" >戻る</a>
								                </div>
								                @else

								                <div class="col-sm-2">
								               
								                </div>
                                                <div class="col-sm-5">
								                
										                  <a style="float: left;width: 200px;" class="btn btn-danger" href="{{ url('department/index?page='.request()->page) }}" >戻る</a>
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

	            $("#change").click(function() { 
	               
	               if($('#status').is(':checked') == true && $("#change_id").val() == ""){

	               	var form  = new FormData();
	                form.append('department_id', $("#id").val());

		            $.ajax({
					    url: '/department/check',
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
										            
										            $( "#department_form" ).submit();
									            }
									        },
									        cancel: {
									            text: 'NO',
									            btnClass: 'btn-red',
									            action: function(){
	                                                
	                                                   $('#change_department').hide();
									            }
									        }
									    }
									});
		                        
		                        $('#status').prop('selectedIndex', 0);

		                    }else {

	                    	   $( "#department_form" ).submit();
	                    	   
	                        }


					    },

					    error: function (exception) {
		                        
		                        alert(exception.responseText);
								

						}
					});

	            	}else {

	               	   $( "#department_form" ).submit();
	                }

	            }); 

	     }); 
	     $(document).ready(function(){
               
                    
     	      var headquarter = $("#department_id").find(':selected').attr('data-value');
              var company_id  = $("#headquarter_id").find(':selected').attr('data-id');
             

              
              $( ".headquarter_id_chose" ).each(function() {
                    
                 if($(this).attr('data-id') != company_id){

                    $(this).remove();

                 }
                   

              });

               $( ".department_id_chose" ).each(function() {
                    
                 if($(this).attr('data-id') != company_id){

                    $(this).remove();

                 }
                   

              });



     });

     $(document).on('change', '#status', function () {
         
         ckb = $("#status").is(':checked');

         if(ckb == true){
           
                    $('#change_department').show();
              

         }else {
                    
                    $('#change_department').hide();
               

         }
         


     });
</script>
<script src="{{ asset('select/icontains.js') }}" ></script>

<script src="{{ asset('select/comboTreePlugin.js') }}" ></script>


@endsection
