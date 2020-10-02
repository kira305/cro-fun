@extends('layouts.app')

@section('content')
@section('breadcrumbs', Breadcrumbs::render('headquarter/edit'))
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
						        <form id="headquarter_form" method="post" action="{{ url('headquarter/edit') }}" enctype="multipart/form-data">
                                        
                                        <div class="row">
								                <div class="col-md-3 offset-md-3">
								                  <label class="input_lable">所属会社</label>
								                </div>
								                <div class="col-xs-2">
								                	 <div class="form-group">
								                       <select class="form-control"   disabled ="disabled">
													          @foreach($companies as $company)
										                    <option  
										                   
											                @if ($headquarter->company_id == $company->id) selected    @endif 

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
								                  <label class="input_lable"><b>表示コード</b></label>
								                </div>
								                <div class="col-xs-2">
								                     <div class="form-group">
								                       <input type="text" name="headquarters_code" value="{{$headquarter->headquarters_code}}" class="form-control">
								                       <input type="hidden" name="company_id"  value = "{{ $headquarter->company_id }}">
								                       @csrf
								                     </div>
								                </div>
								                @if ($errors->has('headquarters_code'))

                	                               <span class="text-danger">{{ $errors->first('headquarters_code') }}</span>

            	                                @endif
            	                                @if ($errors->has('unique'))

                	                                <span class="text-danger" >{{ $errors->first('unique') }}</span>

            	                                @endif
						                </div>
						                <div class="row">
								                <div class="col-md-3 offset-md-3">
								                  <label class="input_lable"><b>事業本部コード</b></label>
								                </div>
								                <div class="col-xs-2">
								                	 <div class="form-group">
								                       <input type="text" name="headquarter_list_code" value="{{$headquarter->headquarter_list_code}}" class="form-control">
								                     </div>
								                </div>
								                @if ($errors->has('headquarter_list_code'))

                	                               
                	                               <span class="text-danger">{{ $errors->first('headquarter_list_code') }}</span>

            	                                @endif
						                </div>
						                 <div class="row">
								                <div class="col-md-3 offset-md-3">
								                  <label class="input_lable"><b>事業本部名</b></label>
								                </div>
								                <div class="col-xs-2">
								                	 <div class="form-group">
								                       <input type="text" name="headquarters" value="{{$headquarter->headquarters}}" class="form-control">
								                       <input type="hidden" id="id" name="id" value="{{$headquarter->id}}">
								                     </div>
								                </div>
								             @if ($errors->has('headquarters'))

                	                           <span class="text-danger">{{ $errors->first('headquarters') }}</span>

            	                              @endif
						                </div>


					                    
					                    <div class="row" id="change_reason" >
                                        	  <div class="col-md-3 offset-md-3">
                                                   <label class="input_lable">変更理由</label>
                                        	  </div>
                                        	  <div class="col-xs-2">
								                	<textarea rows="5" cols="63" name="note">{{ $headquarter->note }}</textarea>
								               </div>
                                        </div>

                                        <div class="row">
						              
								                <div class="col-md-3 offset-md-3">
								                
								                  <label class="input_lable hidden_lable">非表示</label>
								                </div>
								                <div class="col-xs-2">
								               
                                                    <input type="checkbox" id="status" @if ($headquarter->status == false) checked @endif name="status" 
                                                    class="minimal">
								             
								                </div>
								           
								        </div>
                                        
                                        <div class="row" id="change_headquarter" hidden>
								                <div class="col-md-3 offset-md-3">
								                  <label class="input_lable">移行先事業本部</label>
								                </div>
								                <div class="col-xs-2">
								                	 <div class="form-group">
								                      <select class="form-control" id="change_id" name="headquarter_id">
										                  	<option value=""> </option>
										                  	@foreach($headquarter_list as $headquarters)
											                <option 
											                @if ($headquarter->id == $headquarters->id) hidden @endif 
											                value="{{$headquarters->id}}">{{$headquarters->headquarters}}</option>
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
								                <div class="col-sm-3">
								                
								                  <button type="button" id="change" style="float:right;width: 200px;" class="btn btn-primary">更新</button>
								                </div>
                                                <div class="col-sm-5">
								                 <a style="float: left;width: 200px;" class="btn btn-danger" href="{{ url('headquarter/index?page='.request()->page) }}" >戻る</a>
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

<script type="text/javascript">

    $(document).ready(function() { 

            $("#change").click(function() { 
               
               if($('#status').is(':checked') == true && $("#change_id").val() == ""){

               	var form  = new FormData();
                form.append('headquarter_id', $("#id").val());

	            $.ajax({
				    url: '/headquarter/check',
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
									            
									            $( "#headquarter_form" ).submit();
								            }
								        },
								        cancel: {
								            text: 'NO',
								            btnClass: 'btn-red',
								            action: function(){
                                                
                                                  $('#change_headquarter').hide();
								            }
								        }
								    }
								});
	                        
	                        $('#status').prop('selectedIndex', 0);

	                    }else {

	                    	  $( "#headquarter_form" ).submit();
	                    }


				    },

				    error: function (exception) {
	                        
	                        alert(exception.responseText);
							

					}
				});
            	    
            	    }else {

	               	    $( "#headquarter_form" ).submit();
	                }
            }); 

     }); 

     $(document).on('change', '#status', function () {
         
         ckb = $("#status").is(':checked');

         if(ckb == true){
           
                    $('#change_headquarter').show();
                 

         }else {
                    
                    $('#change_headquarter').hide();
                  
         }
         


     });


</script>
<script src="{{ asset('select/icontains.js') }}" ></script>

<script src="{{ asset('select/comboTreePlugin.js') }}" ></script>


@endsection
