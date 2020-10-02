@extends('layouts.app')
@section('content')
@section('breadcrumbs', Breadcrumbs::render('project/edit'))
@include('layouts.confirm_js')
      <div class="row">
        <div class="col-sm-12">
       
          <ul class="timeline">
	          	<li>
	             
	              <div class="timeline-item">
	               
	                <div class="timeline-body">
	                   			          
				            <div class="box-body">
				            	   @if (isset($message))


						            <p class="message" >{{ $message }}</p>

					
								    @endif
				            	    @if ($message = Session::get('message'))


						              <p class="" style="text-align: center;color: green">{{ $message }}</p>

					
								    @endif
								    @if ($errors->has('message'))
                                                    
                                        <span class="text-danger">{{ $errors->first('message') }}</span>
                	                              

            	                    @endif

						        <form id="edit_project" method="post" 
						        action="{{ url('project/edit?id='.$project->id) }}">
                                        
								        <div class="row">
                                            <div class="col-sm-2"></div>
                                        	<div class="col-sm-1">
								                  <label class="input_lable" >会社コード</label>
								            </div>
									        <div class="col-sm-2">
								                	 <div class="form-group">
								                	 	
                                                        <p class="form-control input-sm"> {{$project->company->abbreviate_name}} </p>
														<input type="hidden" id="company_id" value="{{$project->company_id}}" name="company_id" >
								                       
								                     </div>
								             </div>
                                        </div>
                                        <div class="row">
                                        	 <div class="col-sm-2"></div>
                                        	<div class="col-sm-1">
								                  <label class="input_lable">顧客コード</label>
								             </div>
								             <div class="col-sm-1">
							                	 <div class="form-group">

							                       <p type="text" class="form-control input-sm" >

                                                    {{  Crofun::getClientById($project->client_id)->client_code_main  }}
                                                    <input type="hidden" id="client_id" 
                                                           value="{{$project->client_id}}">
							                        </p>
							                       
							                     </div>
								             </div>
                                             <div class="col-sm-1">
							                	 <div class="form-group">
                                                  
                                                  @if( Auth::user()->can('customer-edit'))

	                                                  <a style="float: left;width: 200px;" 
	                                                     class="btn btn-warning"
	                                                     href="{{route('customer_edit', ['id' => $project->client_id])}}">顧客情報参照
	                                                  </a>

                                                  @else
                                                      
                                                      @if( Auth::user()->can('customer-view'))
                                                           
                                                        <a style="float: left;width: 200px;" 
	                                                     class="btn btn-warning"
	                                                     href="{{route('customer_view', ['id' => $project->client_id,'see' =>1])}}">顧客情報参照
	                                                    </a>

                                                      @endif

                                                  @endif
                                                  
							                     </div>
								             </div>
                                             
                                        </div> 
                                        <div class="row">
                                        	<div class="col-sm-2"></div>
								            <div class="col-sm-1">
							                	 <div class="form-group">

                                                 @if ($errors->has('client_code'))
                                                    
                                                 <span class="text-danger">{{ $errors->first('client_code') }}</span>
                	                              

            	                                 @endif
							                       
							                     </div>
								             </div>


                                        </div> 
                                        <div class="row">
                                        	    <div class="col-sm-2"></div>
								                <div class="col-sm-1">
								                  <label class="input_lable">顧客名</label>
								                </div>
								                <div class="col-sm-5">
								                     <div class="form-group">

								                     <p type="text" class="form-control" >

   								                        @if(Crofun::getClientById($project->client_id)->client_name)
								                        {{Crofun::getClientById($project->client_id)->client_name}}
								                        @else
								                        {{Crofun::getClientById($project->client_id)->client_name}}
								                        @endif
                                                        
								                     </p>

								                     </div>


								                </div>
								                @if ($errors->has('client_name'))
                                                    
                                                    <span class="text-danger">{{ $errors->first('client_name') }}</span>
                	                              

            	                                @endif
						                </div> 
                                        <div class="row">
                                        	    <div class="col-sm-2"></div>
								                <div class="col-sm-1 ">
								                  <label class="input_lable">与信希望限度額(顧客単位)<sup>1</sup></label>
								                </div>
								                <div class="col-sm-2">
								                	 <div class="form-group">
								                       <input type="text" disabled style="text-align: right"
								                       name="credit_expect" id="credit_expect"
								                       @if (isset($credit_expect))
									                       value={{ number_format($credit_expect/1000) }}
								                       @endif 
								                       class="form-control input-sm">
								                     </div>
								                </div>
                                                <div class="col-sm-1 ">
								                  <label class="input_lable">取引想定合計額(顧客単位)<sup>1</sup></label>
								                </div>
								                <div class="col-sm-2">
								                	 <div  class="form-group">
								                       <input style="float: left; text-align: right" disabled type="text" id="transaction" name="transaction"
								                       @if (isset($transaction))
								                       value="{{ number_format($transaction/1000) }}"
								                       @endif 
								                       class="form-control input-sm">
								                     </div>
								                </div>
						                </div>

                                        <div class="row">
                                        	    <div class="col-sm-2"></div>
								                <div class="col-sm-1 ">
								                  <label class="input_lable">プロジェクトコード</label>
								                </div>
								                <div class="col-sm-2">
								                	 <div class="form-group">
								                       <input type="text" disabled 
								                       value="{{ $project->project_code }}"
								                       class="form-control">
								                       <input type="hidden" id="project_id" name="id" value="{{ $project->id }}">
								                       <input type="hidden" 
								                       name="project_code" id="project_code" 
								                       value="{{ $project->project_code }}"
								                       class="form-control">
								                     </div>
								                </div>
                                                <div class="col-sm-1 ">
								                  <label class="input_lable"><b>プロジェクト名</b></label>
								                </div>
								                <div class="col-sm-2">
								                	 <div  class="form-group">
								                       <input style="float: left;" type="text" id="project_name" name="project_name"  value="{{ $project->project_name }}"
								                        class="form-control input-sm">
								                       
								                     </div>
								                </div>
						                </div>
                                        <div class="row">
                                             <div class="col-sm-3"></div>
								             <div class="col-sm-2">
                                             @if ($errors->has('project_code'))
                                                <div class="form-group">
                	                            <span class="text-danger">{{ $errors->first('project_code') }}</span>
                                                </div>
            	                             @endif
								             </div>

								             <div class="col-sm-1">
								                 
								             </div>
								             <div class="col-sm-3">
                                             @if ($errors->has('project_name'))
                                                 <div class="form-group">
                	                            <span class="text-danger">{{ $errors->first('project_name') }}</span>
                                                </div>
            	                             @endif
								             </div>

                                        </div>
                                        <div class="row">
                                        	    <div class="col-sm-2"></div>
								                <div class="col-sm-1 ">
								                  <label class="input_lable"><b>事業本部</b></label>
								                </div>
								                <div class="col-sm-2">
								                	 <div class="form-group">
									                    <select class="form-control"  id="headquarter_id" name="headquarter_id" >
									                    <option> </option>
												          @foreach($headquarters as $headquarter)
									                    <option class="headquarter_id" id="headquarter_id" 
									                    @if ($project->headquarter_id == $headquarter->id) selected @endif
									                    data-value="{{ $headquarter->company_id }}"
									                    value="{{$headquarter->id}}">{{$headquarter->headquarters}}
									                    </option>
									                  
								                          @endforeach
														</select>
								                        
								                     </div>
								                </div>
                                                <div class="col-sm-1 ">
								                  <label class="input_lable"><b>部署</b></label>
								                </div>
								                <div class="col-sm-2">
								                	 <div  class="form-group">
									                    <select class="form-control"  id="department_id" name="department_id" >
									                    <option > </option>
												          @foreach($departments as $department)
									                    <option class="department_id" 
									                    @if ($project->department_id == $department->id) selected @endif
									                    data-value="{{ $department->headquarter()->id }}"
									                    value="{{$department->id}}">{{$department->department_name}}
									                    </option>
									                  
								                          @endforeach
														</select>
								                       
								                     </div>
								                </div>
						                </div>
						                <div class="row">
                                             <div class="col-sm-2"></div>
								             <div class="col-sm-1">
                                             @if ($errors->has('headquarter_id'))
                                                <div class="form-group">
                	                            <span class="text-danger">{{ $errors->first('headquarter_id') }}</span>
                                                </div>
            	                             @endif
								             </div>

								             <div class="col-sm-1">
								                 
								             </div>
								             <div class="col-sm-1">
                                             @if ($errors->has('department_id'))
                                                 <div class="form-group">
                	                            <span class="text-danger">{{ $errors->first('department_id') }}</span>
                                                </div>
            	                             @endif
								             </div>

                                        </div>

                                        <div class="row">
                                        	    <div class="col-sm-2"></div>
								                <div class="col-sm-1 ">
								                  <label class="input_lable"><b>担当Grp</b></label>
								                </div>
								                <div class="col-sm-2">
								                	 <div class="form-group">
									                   <select class="form-control"  id="group_id" name="group_id" >
									                    <option> </option>
												          @foreach($groups as $group)

										                    <option class="group_id" 
										                    @if ($project->group_id == $group->id) selected @endif
										                    data-value="{{ $group->department_id }}"
										                    value="{{$group->id}}">{{$group->group_name}}
										                    </option>
									                  
								                          @endforeach
													  </select>
								                        
								                     </div>
								                </div>
                                            @if ($errors->has('group_id'))
                                                <div class="form-group">
                	                            <span class="text-danger">{{ $errors->first('group_id') }}</span>
                                                </div>
            	                             @endif
						                </div>
						                <div class="row">
						                	    <div class="col-sm-2"></div>
								                <div class="col-sm-1 ">
								                  <label class="input_lable">集計コード</label>
								                </div>
								                <div class="col-sm-2">
								                	 <div class="form-group">
								                       <input type="text" 
								                       name="get_code" id="get_code" 
								                       value="{{ $project->get_code}}"
								                       class="form-control input-sm">
								                        
								                     </div>
								                </div>
                                                <div class="col-sm-1 ">
								                  <label class="input_lable">集計コード名</label>
								                </div>
								                <div class="col-sm-2">
								                	 <div  class="form-group">
								                       <input style="float: left;" type="text" id="get_code_name" name="get_code_name"  value="{{ $project->get_code_name}}"
								                        class="form-control input-sm">
								                       
								                     </div>
								                </div>
						                </div>
						                <div class="row">
                                             <div class="col-sm-2"></div>
								             <div class="col-sm-1">
                                             @if ($errors->has('get_code'))
                                                <div class="form-group">
                	                            <span class="text-danger">{{ $errors->first('get_code') }}</span>
                                                </div>
            	                             @endif
								             </div>

								             <div class="col-sm-1">
								                 
								             </div>
								             <div class="col-sm-1">
                                             @if ($errors->has('get_code_name'))
                                                 <div class="form-group">
                	                            <span class="text-danger">{{ $errors->first('get_code_name') }}</span>
                                                </div>
            	                             @endif
								             </div>

                                        </div>
						                <div class="row">
                                            <div class="col-sm-2"></div>
							                <div class="col-sm-1 ">
							                  <label class="input_lable"><b>取引想定額</b><sup>1</sup></label>
							                </div>
							                <div class="col-sm-2">
							                  <div class="form-group">	

							                       <input type="text" name="transaction_money" style="text-align: right"
							                       value="{{ number_format( $project->transaction_money/1000 )}}"
							                       class="form-control input-sm">	

							                  </div>
							                </div>
                                           @if ($errors->has('transaction_money'))
                                                <div class="form-group">
                	                            <span class="text-danger">{{ $errors->first('transaction_money') }}</span>
                                                </div>
            	                             @endif
            	                             <div hidden id="transaction_data">
            	                             	<input value="{{ $project->transaction_money }}">
            	                             </div>

						                </div>
 						                  @csrf
						                <div class="row">
						                	<div class="col-sm-2"></div>
							                <div class="col-sm-1 ">
							                  <label class="input_lable">単発</label>
							                </div>
							                <div class="col-sm-2">
							                   <div class="form-group">
							                   	<label>
							                    <input type="checkbox" name="once_shot" style="margin-right: 15px;"  onchange="myfunc(this.value)" id="once_shot" 
							                       @if ($project->once_shot == true) checked @endif>
						                        </label>
							                   </div>
							                </div>
                                            <div class="col-sm-1 ">
							                  <label class="input_lable">スポット取引想定<sup>1</sup></label>
							                </div>
							                <div class="col-sm-2">
							                	 <div  class="form-group">
							                       <input type="text" id="transaction_shot" name="transaction_shot" size="4"  style="text-align: right"
							                       @if( $project->transaction_shot )
							                        value="{{ number_format( $project->transaction_shot/1000 )}}"
							                       @endif
							                        class="form-control"
							                        >
							                       
							                     </div>
							                </div>
					                
            	                         </div>

						                <div class="row">
                                             <div class="col-sm-2"></div>
								             <div class="col-sm-1">

								             </div>

								             <div class="col-sm-1">
								                 
								             </div>
								             <div class="col-sm-1">
                                             @if ($errors->has('transaction_shot'))
                                                 <div class="form-group">
                	                            <span class="text-danger">{{ $errors->first('transaction_shot') }}</span>
                                                </div>
            	                             @endif
								             </div>

                                        </div>						                
						                <div class="row" id="change_reason" >
                                        	  <div class="col-sm-3 offset-sm-3">
                                                   <label class="input_lable">備考</label>
                                        	  </div>
                                        	  <div class="col-xs-2">
								                	<textarea rows="5" cols="100" name="note" >{{ $project->note }}</textarea>
								               </div>

                                        </div>
                                        <br>
						                <div class="row">
						                	 <div class="col-sm-2"></div>
							                <div class="col-sm-1 ">
							                  <label class="input_lable">取引終了</label>
							                </div>
							                <div class="col-sm-1">
							                   <div class="form-group">

							                    <input type="checkbox" name="status" id="status" style="margin-right: 15px;" 
							                       @if ($project->status == false) checked @endif>
							                        
							                   </div>
							                </div>                                      
						                </div>
						                <div class="row">
						                	<div class="col-sm-3">
						                		
						                	</div>
						                	<div  class="col-sm-9">
						                		<h5>1)1000円が省略された金額で表示されています。</h5>
						                	</div>
						                </div>
                                        <br>

                                         
						           
						                <br>

                                     <div class="row">
                                     	<div class="col-sm-3"></div>
						                <div class="col-sm-2">
									     @if( Auth::user()->can('process-index'))
						                 <a><button onclick="process_index_url()" type="button" style="float: left;width: 100%;" class="btn btn-warning btn-sm">売上一覧</button></a>
						                 @endif
						                </div>

						                <div class="col-sm-2">
			                             @if( Auth::user()->can('contract-index'))
						                 <a><button onclick="contract_index_url()" type="button" style="float: left;width: 100%;" class="btn btn-warning btn-sm">契約書一覧</button></a>
                                         @endif
						                </div>
                                        <div class="col-sm-1">
			                            @if( Auth::user()->can('contract-up'))
									      <span class="btn btn-primary btn-file btn-sm" >
											契約UP
											<input  type="file" id="input_file" name="file_data"
											 accept="application/pdf">
											@csrf
										  </span>
                                         @endif
						                </div>
						                <div class="col-sm-1">
			
						                 <a><button id="csv2" type="button" style="float: left;width: 100%;" class="btn btn-success btn-sm">CSV出力</button></a>

						                </div>
				            	 	
				            	   </div>

				            	   <div class="row">
                                     	<div class="col-sm-3"></div>
						                <div class="col-sm-2">
	
						                </div>

						                <div class="col-sm-2">

						                </div>
                                        <div class="col-sm-3">
			
                                          <span hidden id="upload_success" class="text-success">{{ trans('message.contract_upload_success') }}</span>
                                          <span hidden id="upload_fail" class="text-danger">{{ trans('message.contract_upload_fail') }}</span>

						                </div>
						                <div class="col-sm-1">
			


						                </div>
				            	 	
				            	   </div>

						             <div class="row">
						                	　　<br>

								                <div class="col-sm-5">
								                
								                <button type="submit" id="form_submit"  style="float:right;width: 200px;" class="btn btn-primary">更新</button>

								                </div>
                                                <div class="col-sm-4">

								                 <a style="float: left;width: 200px;" class="btn btn-danger" 
								                 href="{{ url('project/index?page='.request()->page) }}" >戻る</a>

								                </div>
								                
						               
						        
				                     </div>

				              </form>
				            <!-- /.box-body -->
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

         
         $( "#csv2" ).click(function(event) {
                   
                var project_id = $("#project_id").val();
                document.location.href = "/project/csv2?project_id="+project_id;

		  });

         $( "#input_file" ).change(function() {
			  
			var pdf   = $('#input_file')[0].files[0];
			var form  = new FormData();

			form.append('pdf', pdf);
            form.append('type', 2);
            form.append('client_id', $("#hidden_id").val());
            form.append('company_id', $("#company_id").val());
            form.append('client_id', $("#client_id").val());
            form.append('project_id', $("#project_id").val());
            form.append('headquarter_id', $("#headquarter_id").val());
            form.append('department_id', $("#department_id").val());
            form.append('group_id', $("#group_id").val());

			$.ajax({
			    url: '/contract/upload',
			    data: form,
			    cache: false,
			    contentType: false,
			    processData: false,
			    type: 'POST',
			    success:function(response) {
		
                    if(response.status_code == 200){

                         $( "#upload_success" ).show();
                         $( "#upload_fail" ).hide();
                    }

                    if (response.status_code == 500) {
                         
                         $( "#upload_fail" ).show();
                         $( "#upload_success" ).hide();

                    }


			    },

			    error: function (exception) {
                        
                    alert(exception.responseText);
				    if (response.status_code == 500) {
                         
                         $( "#upload_fail" ).show();
                         $( "#upload_success" ).hide();

                    }

				}
			});


		});	
        

		$( "#status" ).change(function() {
            
      
            if($('#status').is(":checked") === true){ return }
           
			var form  = new FormData();
            form.append('customer_id', $("#client_id").val());

			$.ajax({
			    url: '/project/checkcustomer',
			    data: form,
			    cache: false,
			    contentType: false,
			    processData: false,
			    type: 'POST',
			    success:function(response) {
		            
		          
                    if(response.status == 1){
                          
                        $.alert({
						    title: 'メッセージ',
						    content: response.message,
					    });
                        
                        $('#status').prop('checked', true);
                    }


			    },

			    error: function (exception) {
                        
                        alert(exception.responseText);
						

				}
			});


		});	

        if(window.check == 1){
            
            $( "#group_id" ).attr("id","new_group_id");
            $("#new_group_id").prop("disabled", true);
            $( "#department_id" ).attr("id","new_department_id");
            $("#new_department_id").prop("disabled", true);
            $( "#headquarter_id" ).attr("id","new_headquarter_id");
            $("#new_headquarter_id").prop("disabled", true);
            $( "input" ).prop( "disabled", true );
            $( "textarea" ).prop( "disabled", true );
            $( "#form_submit" ).hide();
        }

    });
    function process_index_url() {

		    var base        =  '{!! route('Process_index') !!}';
            var project_id = $("#project_id").val();
            var url         =  base+'?&project_id='+project_id;

			window.location.href = url;   
    }

    function contract_index_url() {

		    var base        =  '{!! route('Contract_index') !!}';
            var project_id = $("#project_id").val();
            var url         =  base+'?&project_id='+project_id;

			window.location.href = url;   
    }

	function myfunc(value) {
	  var check1 = document.getElementById("once_shot").checked;
	  if (check1 == false) {
	 	 $('#transaction_shot').val(null);
		}
	}
</script>
<script src="{{ asset('select/icontains.js') }}" ></script>

<script src="{{ asset('select/comboTreePlugin.js') }}" ></script>


@endsection
