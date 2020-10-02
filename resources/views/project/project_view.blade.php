@extends('layouts.app')
@section('content')
@section('breadcrumbs', Breadcrumbs::render('project/view'))

      <div class="row">
        <div class="col-md-12">
       
          <ul class="timeline">
	          	<li>
	             
	              <div class="timeline-item">
	               
	                <div class="timeline-body">
	                   			          
				            <div class="box-body">
                                       
								        <div class="row">
                                        	<div class="col-md-1">
								                  <label class="input_lable" >会社コード</label>
								             </div>
									             <div class="col-md-2">
								                	 <div class="form-group">
								                	 	
                                                        <p class="form-control"> {{$project->company->abbreviate_name}} </p>
														<input type="hidden" id="company_id" value="{{$project->company_id}}" name="company_id" >
								                       
								                     </div>
								             </div>
                                        </div>
                                        <div class="row">
                                        	<div class="col-md-1">
								                  <label class="input_lable">顧客コード</label>
								             </div>
								             <div class="col-md-1">
							                	 <div class="form-group">

							                       <p type="text" class="form-control" >

                                                    {{  Crofun::getClientById($project->client_id)->client_code_main  }}
                                                    <input type="hidden" id="client_id" 
                                                           value="{{$project->client_id}}">
							                        </p>
							                       
							                     </div>
								             </div>
                                             <div class="col-md-1">
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
                                        	<div class="col-md-1">
								                 
								             </div>
								             <div class="col-md-1">
							                	 <div class="form-group">

                                                 @if ($errors->has('client_code'))
                                                    
                                                 <span class="text-danger">{{ $errors->first('client_code') }}</span>
                	                              

            	                                 @endif
							                       
							                     </div>
								             </div>


                                        </div> 
                                        <div class="row">
								                <div class="col-md-1">
								                  <label class="input_lable">顧客名</label>
								                </div>
								                <div class="col-md-5">
								                     <div class="form-group">

								                     <p type="text" class="form-control" >

   								                        @if(Crofun::getClientById($project->client_id)->client_name_ab)
								                        {{Crofun::getClientById($project->client_id)->client_name_ab}}
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
								                <div class="col-md-1 ">
								                  <label class="input_lable">与信希望限度額(顧客単位)<sup>1</sup></label>
								                </div>
								                <div class="col-md-1">
								                	 <div class="form-group">
								                       <input type="text" readonly style="text-align: right"
								                       name="credit_expect" id="credit_expect"
								                       @if (isset($credit_expect))
									                       value={{ number_format($credit_expect/1000)}}
								                       @endif 
								                       class="form-control">
								                     </div>
								                </div>
                                                <div class="col-md-1 ">
								                  <label class="input_lable">取引想定合計額(顧客単位)<sup>1</sup></label>
								                </div>
								                <div class="col-md-1">
								                	 <div  class="form-group">
								                       <input style="float: left; text-align: right" 
								                        readonly 
								                        type="text" id="transaction" name="transaction"
								                        @if (isset($transaction))
								                        value="{{  number_format($transaction/1000)}}"
								                        @endif 
								                        class="form-control">
								                     </div>
								                </div>
						                </div>

                                        <div class="row">
								                <div class="col-md-1 ">
								                  <label class="input_lable">プロジェクトコード</label>
								                </div>
								                <div class="col-md-1">
								                	 <div class="form-group">

								                       <input type="text" readonly
								                       
								                       value="{{ $project->project_code }}"
								                       class="form-control">

								                     </div>

								                     <input type="hidden" id="project_id" name="id" value="{{ $project->id }}">
								                       <input type="hidden" 
								                       name="project_code" id="project_code" 
								                       value="{{ $project->project_code }}"
								                       class="form-control">

								                </div>
                                                <div class="col-md-1 ">
								                  <label class="input_lable"><b>プロジェクト名</b></label>
								                </div>
								                <div class="col-md-1">
								                	 <div  class="form-group">
								                       <input style="float: left;" readonly type="text" id="project_name" name="project_name"  value="{{ $project->project_name }}"
								                        class="form-control">
								                       
								                     </div>
								                </div>
						                </div>

                                        <div class="row">
								                <div class="col-md-1 ">
								                  <label class="input_lable"><b>事業本部</b></label>
								                </div>
								                <div class="col-md-1">
								                 <div class="form-group">


								                  <input readonly type="text" value="{{$project->headquarter->headquarters}}" name="" class="form-control">

								                  <input type="hidden"  id="headquarter_id" name="headquarter_id" value="{{$project->headquarter->id}}">

								                        
								                  </div>
								                </div>
                                                <div class="col-md-1 ">
								                  <label class="input_lable"><b>部署</b></label>
								                </div>
								                <div class="col-md-1">
								                	 <div  class="form-group">

								              <input readonly type="text" value="{{$project->department->department_name}}" name="" class="form-control">
												<input type="hidden"  id="department_id" name="department_id" value="{{$project->department->id}}">

								                       
								                     </div>
								                </div>
						                </div>


                                        <div class="row">
								                <div class="col-md-1 ">
								                  <label class="input_lable"><b>担当Grp</b></label>
								                </div>
								                <div class="col-md-1">
								                	 <div class="form-group">

								              <input readonly type="text" value="{{$project->group->group_name}}" name=""
								              class="form-control">

												<input type="hidden"  id="group_id" name="group_id" value="{{$project->group->id}}">
								                        
								                     </div>
								                </div>

						                </div>
						                <div class="row">
								                <div class="col-md-1 ">
								                  <label class="input_lable">集計コード</label>
								                </div>
								                <div class="col-md-1">
								                	 <div class="form-group">
								                       <input type="text" readonly 
								                       name="get_code" id="get_code" 
								                       value="{{ $project->get_code}}"
								                       class="form-control">
								                        
								                     </div>
								                </div>
                                                <div class="col-md-1 ">
								                  <label class="input_lable">集計コード名</label>
								                </div>
								                <div class="col-md-1">
								                	 <div  class="form-group">
								                       <input style="float: left;" readonly type="text" id="get_code_name" name="get_code_name"  value="{{ $project->get_code_name}}"
								                        class="form-control">
								                       
								                     </div>
								                </div>
						                </div>

						                <div class="row">

							                <div class="col-md-1 ">
							                  <label class="input_lable"><b>取引想定額</b><sup>1</sup></label>
							                </div>
							                <div class="col-md-3">
							                  <div class="form-group">	

							                       <input type="text" readonly name="transaction_money" style="text-align: right"
							                       @if($project->transaction_money != null)
							                       value="{{  number_format($project->transaction_money/1000) }}"
							                       @endif
							                       class="form-control">	

							                  </div>
							                </div>


						                </div>
 						                  @csrf
						                <div class="row">
							                <div class="col-md-1 ">
							                  <label class="input_lable">単発</label>
							                </div>
							                <div class="col-md-1">
							                   <div class="form-group">
							                   	<label>
								                    <input type="checkbox" disabled 
								                           style="margin-right: 15px;"  
								                         
								                       @if ($project->once_shot == true) checked @endif
								                    >
						                        </label>
							                   </div>
							                </div>
                                            <div class="col-md-1 ">
							                  <label class="input_lable">スポット取引想定<sup>1</sup></label>
							                </div>
							                <div class="col-md-1">
							                	 <div  class="form-group">
							                       <input type="text" readonly 
							                       style="text-align: right"
							                       @if( $project->transaction_shot )
							                        value="{{  number_format($project->transaction_shot/1000) }}"
							                       @endif
							                        class="form-control"
							                        >
							                       
							                     </div>
							                </div>
					                
            	                         </div>
					                
						                <div class="row" id="change_reason" >
                                        	  <div class="col-md-3 offset-md-3">
                                                   <label class="input_lable">備考</label>
                                        	  </div>
                                        	  <div class="col-xs-2">

								                	<textarea rows="5" cols="100" name="note" readonly>{{ $project->note }}</textarea>
								                										                	
								               </div>

                                        </div>

						                <div class="row">
							                <div class="col-md-1 ">
							                  <label class="input_lable">取引終了</label>
							                </div>
							                <div class="col-md-1">
							                   <div class="form-group">

							                    <input type="checkbox"  disabled 
							                           style="margin-right: 15px;" 
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
                                     	<div class="col-md-1"></div>
						                <div class="col-md-1">
									    @if( Auth::user()->can('process-index'))
						                 <a><button onclick="process_index_url()" type="button" style="float: left;width: 70%;" class="btn btn-warning">売上一覧</button></a>
						                @endif
						                </div>

						                <div class="col-md-1">
			                            @if( Auth::user()->can('contract-index'))
						                 <a><button onclick="contract_index_url()" type="button" style="float: left;width: 70%;" class="btn btn-warning">契約書一覧</button></a>
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

						                <div class="col-md-1">
			
						                 <a><button id="csv2" type="button" style="float: left;width: 70%;" class="btn btn-success">CSV出力</button></a>

						                </div>
				            	 	
				            	   </div>

				            	   <div class="row">
                                     	<div class="col-md-1"></div>
						                <div class="col-md-1">
	
						                </div>

						                <div class="col-md-1">

						                </div>
                                        <div class="col-md-1">
			
                                          <span hidden id="upload_success" class="text-success">{{ trans('message.contract_upload_success') }}</span>
                                          <span hidden id="upload_fail" class="text-danger">{{ trans('message.contract_upload_fail') }}</span>

						                </div>
						                <div class="col-md-1">
			


						                </div>
				            	 	
				            	   </div>

						             <div class="row">
						                	　　　<br>

								                <div class="col-md-2">
								                
<!-- 								                <button type="submit" id="form_submit"  style="float:right;width: 200px;" class="btn btn-primary">更新</button> -->

								                </div>
                                                <div class="col-md-4">

								                 <a style="float: left;width: 200px;" class="btn btn-danger" 
								                 href="{{ url('project/index?page='.request()->page) }}" >戻る</a>

								                </div>
								               
				                     </div>

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
<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>

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
            var project_id  = '{!! request()->id !!}';
            var url         =  base+'?&project_id='+project_id;

			window.location.href = url;   
    }

    function contract_index_url() {

		    var base        =  '{!! route('Contract_index') !!}';
            var project_id  = '{!! request()->id !!}';
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
