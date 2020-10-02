@extends('layouts.app')

@section('content')
@section('breadcrumbs', Breadcrumbs::render('customer/edit'))
@section('styles')
       <link href="{{ asset('css/customer_edit.css') }}" rel="stylesheet">
@stop
@include('layouts.confirm_js')
      <div class="row">
        <div class="col-md-12">
       
          <ul class="timeline">
	          	<li>
	             
	              <div class="timeline-item">
	               
	                <div class="timeline-body">
		                <div>
								<div class="box-body">
									@if ($message = Session::get('message'))


									<p class="message" >{{ $message }}</p>

									
									@endif
									<form id="edit_customer" method="post" 
									action="{{ url('customer/edit?id='.$customer->id) }}">
										<div class="row">
											
											<table class="table table_create table-bordered">

	                                            <tbody>
	                                            	
                                                           <tr>

														   <td colspan="2">

						                                       <label class="label_level_1">会社コード:</label> 
																												
														   </td>

														   <td colspan="2">

				                                            <input class="form-control select_level_1" readonly style="width: 56%" 
				                                            value="{{$customer->company->abbreviate_name}}"  >
															<input type="hidden" id="company_id" value="{{$customer->company_id}}" name="company_id" >

														   </td>

						                                   <td colspan="2">

						                                        <label class="label_level_1">新規登録申請本部:</label>
						                                               
						                                   </td>
						                                   <td colspan="2">
																<input class="form-control select_level_1" readonly style="width: 100%" 
				                                                value="{{$customer->com_grp()->headquarters}}"  >
						                                   </td>

														</tr>
														@if ($errors->has('company_id'))
														<tr>
															<td colspan="2">
																
															</td>
															<td colspan="2">
															  <span class="text-danger">{{ $errors->first('company_id') }}
															  </span>
															</td>
															<td colspan="2">
																
															</td>
															<td colspan="2">
																
															</td>

														</tr>
														@endif
													    <tr>

														   <td colspan="2">

						                                       <label class="label_level_1">新規登録申請部署:</label> 
																	
														   </td>

														   <td colspan="2">
																<input class="form-control select_level_1" readonly style="width: 100%" 
				                                                value="{{$customer->com_grp()->department_name}}"  >
														   </td>
						                                   <td colspan="2">

						                                        <label class="label_level_1">新規登録申請グループ:</label>			
						                                   </td>
						                                   <td colspan="2">

																<input class="form-control select_level_1" readonly style="width: 100%" 
				                                                value="{{$customer->com_grp()->group_name}}"  >
				                                                <input type="hidden" name="group_id" value="{{$customer->com_grp()->id}}">

						                                   </td>

														</tr>
									
														@if ($errors->has('group_id'))
														<tr>
															<td colspan="2">
																
															</td>
															<td colspan="2">

															</td>
															<td colspan="2">
																
															</td>
															<td colspan="2">
															  <span class="text-danger">{{ $errors->first('group_id') }}
															  </span>
															</td>

														</tr>
														@endif
														<tr>
															
														  <td colspan="2">

														  	<label class="label_level_1"><b>顧客名:</b></label>

														  </td>
														  <td colspan="3">

														  	<input type="text" id="client_name" name="client_name" value="{{$customer->client_name}}" class="form-control input-sm">
									                        <input type="hidden" name="id" value=""
									                        class="form-control input-sm">
									                        @csrf

														  </td>
														  <td colspan="1">
	                                                       	<label class="label_level_1">データ登録日:</label>
	                                                       </td>
	                                                       <td colspan="2">
	                                                       	 <input type="text" readonly 
															    value="{{ Crofun::changeFormatDateOfCredit($customer->created_at) }}"
																style="float: left;" class="form-control input-sm">
	                                                       </td>
														</tr>
														@if ($errors->has('client_name'))

	                                                    <tr>
	                                                    <td colspan="2">
	                                                    		
	                                                    </td>
	                                                    <td colspan="6">
	                                                    <span class="text-danger">{{ $errors->first('client_name') }}</span>
	                                                    </td>
	                                                    </tr>

														@endif
														<tr>
															
														  <td colspan="2">

														  	<label class="label_level_1"><b>顧客名カナ:</b></label>

														  </td>
														  <td colspan="3">

									                        <input id="name_kana" type="text" name="client_name_kana" 
									                        value="{{$customer->client_name_kana}}"   
									                        class="form-control input-sm">

														  </td>
														  <td colspan="3">
														  	
														  </td>
														</tr>
	                                                    @if ($errors->has('client_name_kana_conversion'))

	                                                    <tr>
	                                                    <td colspan="2">
	                                                    		
	                                                    </td>
	                                                    <td colspan="6">
	                                                    <span class="text-danger">
	                                                    	{{ $errors->first('client_name_kana_conversion') }}
	                                                    </span>
	                                                    </td>
	                                                    </tr>

														@endif
														<tr>
															<td colspan="2">
															<label class="label_level_1">略称:</label>
															</td>
															<td colspan="2">
															<input type="text" value="{{$customer->client_name_ab}}" name="client_name_ab"   class="form-control input-sm">	
															</td>
															<td colspan="1">
																
															</td>
	                                                        <td colspan="1">
															<label class="label_level_1"><b>ステータス:</b></label>
															</td>
														    <td colspan="2">
																<select class="select_level_1" id="status" name="status">
																    
						                                            <option id="status_1" 
						                                             @if ($customer->status == 1) selected @endif  
						                                              value="1"> 取引終了
						                                            </option>
						                                            <option  id="status_2" 
				                                                       @if ($customer->status == 2) selected @endif  
					                                                   value="2">本登録中止
					                                                </option>
					                                                <option id="status_3" 
				                                                      @if ($customer->status == 3) selected @endif  
					                                                  value="3">取引中
					                                                </option>

					                                                <option id="status_4" 
					                                                 @if ($customer->status == 4) selected @endif      
					                                                 value="4">仮登録中 
					                                                 </option>

																</select>
															</td>
														</tr>
														@if ($errors->has('client_name_ab'))
	                                                    <tr>
	                                                    	<td colspan="2">
	                                                    		
	                                                    	</td>
	                                                    	<td colspan="2">
	                                                    		<span class="text-danger">
	                                                    			{{ $errors->first('client_name_ab') }}
	                                                    		</span>
	                                                    	</td>
	                                                    	<td colspan="2">
	                                                    		
	                                                    	</td>
	                                                    	<td colspan="2">
	                                                    		
	                                                    	</td>
	                                                    </tr>
	                                                    @endif
														<tr>
	                                                       <td colspan="2">
	                                                       	 <label class="label_level_1">法人番号:</label>
	                                                       </td>
	                                                       <td colspan="1">
	                                                       	 	<input type="text" 
																name="corporation_num" id="corporation_num" 
																value="{{$customer->corporation_num}}"
																class="form-control input-sm">
	                                                       </td>
	                                                       <td colspan="1">
	                                                       	<label class="label_level_1">TSRコード:</label>
	                                                       </td>
	                                                       <td colspan="1">
	                                                       	 <input  type="text" id="tsr_code" name="tsr_code"
	                                                       	  value="{{$customer->tsr_code}}"
								                             class="form-control input-sm">
	                                                       </td>
	                                                       <td colspan="1">
	                                                       	<label class="label_level_1">商蔵コード:</label>
	                                                       </td>
	                                                       <td colspan="1">
	                                                       	 <input type="text" 
																value="{{$customer->akikura_code}}"
																style="float: left;" name="akikura_code"  class="form-control input-sm">
	                                                       </td>

														</tr>
														@if($errors->has('corporation_num') ||
														    $errors->has('tsr_code')        ||
														    $errors->has('akikura_code')
														    )
														<tr>
															<td colspan="2">
																
															</td>
															<td colspan="1">
															@if ($errors->has('corporation_num'))
						
								                             <span class="text-danger">{{ $errors->first('corporation_num') }}</span>
							
							                                @endif
															</td>
															<td colspan="1">
																
															</td>
															<td colspan="1">
															@if ($errors->has('tsr_code'))
							
								                              <span class="text-danger">{{ $errors->first('tsr_code') }}</span>
							
							                                @endif
															</td>
															<td colspan="1">
																
															</td>
															<td colspan="1">
																@if ($errors->has('akikura_code'))
							
								                                <span class="text-danger">{{ $errors->first('akikura_code') }}</span>
							
							                                   @endif
															</td>
														</tr>
														@endif
														<tr>
															<td colspan="2">
															  <label class="label_level_1"><b>顧客コード:</b></label>
															</td>
															<td colspan="1">
					                                            @if($customer->client_code_main == null)
											                    <input  value="{{$customer->client_code}}" name="client_code" id="client_code"  class="form-control">
											                    @else
					                                            <input  value="{{$customer->client_code_main}}" name="client_code_main" id="client_code"  class="form-control">
					                                            @endif
															</td>
															<td colspan="1">
																<button type="button" 
																id="get_number" style="display: none;" 
						                                        class="btn btn-primary btn-sm">本登録
						                                        </button>
															</td>
														</tr>
	                                                   	<tr>
															<td colspan="2">
															  <label class="label_level_1">住所:</label>
															</td>
															<td colspan="3">
																<input type="text" 
																	value="{{$customer->client_address}}"
																	name="client_address" id="client_address" value="" class="form-control input-sm">
															</td>
															<td colspan="3">
																
															</td>
														</tr>
														<tr>
	                                                       <td colspan="2">
	                                                       	 <label class="label_level_1">決算月日:</label>
	                                                       </td>
	                                                       <td colspan="1">
															<input type="text" name="closing_month" id="closing_month" 
															value="{{$customer->closing_time}}"
															class="form-control input-sm">
	                                                       </td>
	                                                       <td colspan="1">
	                                                       	<label class="label_level_1">回収サイト:</label>
	                                                       </td>
	                                                       <td colspan="1">
																<input style="float: left;" 
																value="{{$customer->collection_site}}" 
																type="text" name="collection_site"  class="form-control input-sm">
	                                                       </td>
	                                                       <td colspan="1">
	                                                       	<label class="label_level_1"><b>取引区分:</b></label>
	                                                       </td>
	                                                       <td colspan="1">
															<select id="type" class="select_level_1" name="sale" >
																<option selected value=""></option>
				                                                <option  
				                                                @if ($customer->sale == 1) selected @endif 
				                                                value="1">売上先</option>
				                                                <option 
				                                                @if ($customer->sale == 2) selected @endif 
				                                                value="2">仕入先</option>
				                                                <option 
				                                                @if ($customer->sale == 3) selected @endif 
				                                                value="3">売上先+仕入先
				                                                </option>
															</select>
	                                                       </td>

														</tr>
														@if ($errors->has('sale'))
	                                                    <tr>
														  <td colspan="2">
														  	
														  </td>
														  <td colspan="1">
														  	
														  </td>
														  <td colspan="1">
														  	
														  </td>
														  <td colspan="1">
														  	
														  </td>
														  <td colspan="1">
														  	
														  </td>
														  <td colspan="1">

														  	<span class="text-danger">{{ $errors->first('sale') }}</span>

														  </td>
	                                                    </tr>
	                                                    @endif
														<tr>
															<td colspan="2">
																<label class="label_level_1">振込人名称:</label>
															</td>

															<td colspan="1">
																<input type="text" 
																value="{{$customer->transferee_name}}"
																name="transferee_name"  class="form-control input-sm">
															</td>

															<td colspan="1">

																<label class="label_checkbox">
																振込人名称相違:
																<input type="checkbox" 
																@if ($customer->transferee == true) checked @endif 
																name="transferee" class="input_checkbox">					
															    </label>

															</td>
															<td colspan="1">

																<label class="label_checkbox">
																	反社チェック済み:
	                                                                <input type="checkbox" 
																	@if ($customer->antisocial == true) checked @endif
																    name="antisocial"  class="input_checkbox">
																</label>
																
															</td>
															<td colspan="1">
																<label class="label_checkbox">
																	信用調査有無:
		                                                            <input type="checkbox" 
																	@if ($customer->credit == true) checked @endif
																    name="credit"  class="input_checkbox">
																</label>
																
															</td>
														</tr>
														<tr>
															<td colspan="2">
															 <label class="label_level_1">RM与信限度額:<sup>1</sup></label>
															</td>
															<td>
																<input  id="credit_limit" readonly 
					                                            @if($customer->credit_check())

					                                            value="{{number_format($customer->credit_check()->credit_limit / 1000)}}" 

					                       	                    @else 

					                                         	@endif
					                                            class="form-control input-sm" readonly >
					                                            <input type="hidden" name="credit_limit" 
							                                    @if($customer->credit_check())

													                 value="{{$customer->credit_check()->credit_limit}}" 

													            @else 

													            @endif 
                                                                >

															</td>
															<td>
																<label class="label_level_1">
																	取引想定合計金額:<sup>1</sup>
																</label>
		                                                            
															</td>
															<td>
															   <input type="text" readonly
																	value="{{number_format($transaction/1000)}}"
																    name="credit"  class="form-control">
															</td>
														</tr>
														<tr>
														   <td colspan="2">
														   	 <label class="label_level_1">格付け情報:</label>
														   </td>
														   <td colspan="1">
														   	<input  id="rank_h" name="rank" 
														   		@if($customer->credit_check_by_get_time())
                                                                value="{{$customer->credit_check_by_get_time()->rank}}"
										                       	@else 

										                       	@endif    
				                                             	class="form-control input-sm" 
				                                             	readonly >
														   </td>
														   <td colspan="1">
														   	<label class="label_level_1">与信情報取得日:</label>
														   </td>
														   <td colspan="1">
														   	 <input id="get_time_h" name="get_time" 
					                                          @if($customer->credit_check_by_get_time())

									  value="{{ Crofun::changeFormatDateOfCredit($customer->credit_check_by_get_time()->get_time) }}"

									                       	  @else 

									                       	  @endif

					                                          class="form-control input-sm"
					                                           readonly>
														   </td>
														</tr>
														<tr>
														   <td colspan="2">
														   	 <label class="label_level_1">希望限度額:<sup>1</sup></label>
														   </td>
														   <td colspan="1">
														   	<input  id="credit_expect"  readonly
				                                            @if($customer->credit_check())

					                          value="{{number_format($customer->credit_check()->credit_expect / 1000)}}"

					                                    	@else 

					                       	                @endif
				                                            class="form-control input-sm">
														   </td>
														   <td colspan="1">
														   	<label class="label_level_1">与信限度期限:</label>
														   </td>
														   <td colspan="1">
														   	 <input id="expiration_date" name="expiration_date" 
					                                         @if($customer->credit_check())

					                           value="{{Crofun::changeFormatDateOfCredit($customer->credit_check()->expiration_date) }}"

					                       	                 @else 

					                       	                 @endif 
					                                         class="form-control input-sm"
					                                         readonly>
														   </td>
														</tr>
														<tr hidden id="message_expect">
															<td colspan="2">
																
															</td>
															<td colspan="1">
															<span class="text-danger">希望限度額を入力してください！</span>
															</td>
															<td colspan="1">
																
															</td>
															<td colspan="1">
																
															</td>
														</tr>
														<tr>
															<td colspan="2">
																 <label class="label_level_1">備考:</label>
															</td>
															<td colspan="6">
																<textarea rows="5" cols="120" name="note">{{$customer->note}}</textarea>
															</td>
														</tr>
														<tr>
															<td colspan="2">
																 
															</td>
															<td colspan="6">
																 <h5>1)1000円が省略された金額で表示されています。</h5>
															</td>
														</tr>
                                                        <input type="hidden" name="id" id="client_id" 
						                                       value="{{$customer->id}}"
                                                        >
                                                        <input id="client_code_main" type="hidden" name="client_code_main" value="">
												</tbody>

											</table>
										</div>
                                      
	                                 </form>


		         	</div>

                    <div class="row">
                                <div class="col-md-1"></div>

				                <div class="col-md-1">
	                            @if( Auth::user()->can('contract-index'))
				                 <a><button onclick="contract_index_url()" type="button" style="float: left;width: 100%;" class="btn-sm btn-warning">契約書情報</button></a>
				                @endif
				                </div>
                                <div class="col-md-1">
	                            @if( Auth::user()->can('project-index'))
				                 <a><button onclick="project_index_url()"  type="button" style="float: left;width: 100%;" class="btn-sm btn-warning">プロジェクト情報</button></a>
				                @endif
				                </div>

                                <div class="col-md-1">
	                            @if( Auth::user()->can('credit-log'))
				                 <a><button onclick="credit_log_url()" type="button" style="float: left;width: 100%;" class="btn-sm btn-warning">与信情報取得履歴</button></a>
				                @endif
				                </div>

				                <div class="col-md-1">
		                         @if( Auth::user()->can('credit-index'))
				                 <a><button onclick="credit_index_url()" type="button" style="float: left;width: 100%;" class="btn-sm btn-warning">与信一覧</button></a>
				                 @endif
				                </div>


				                <div class="col-md-1">
		                         @if( Auth::user()->can('receivable-index'))
				                 <a><button onclick="receivable_index_url()" type="button" style="float: left;width: 100%;" class="btn-sm btn-warning">売掛金残</button></a>
				                 @endif
				                </div>

                        </div>
                        <br>
                        <div class="row" id="t2">

                                <div class="col-md-1">
                                
                                </div>
                                <div class="col-md-1">
	                            @if( Auth::user()->can('contract-up'))
							      <span class="btn btn-primary btn-file" >
									契約書PDF登録
									<input  type="file" id="input_file" name="file_data"
									 accept="application/pdf">
									@csrf
								  </span>
			                 		<p>※本画面からUPされた契約書は、<br>全ユーザー参照できます。</p>
                                @endif
				                </div>


				                <div class="col-md-1">
				                	
                                 @if ($customer->status == 3) 
                                 @if( Auth::user()->can('project-add'))
				                 <a>
				                 	<button onclick="project_create_url()" type="button" style="float: left;width: 100%;" class="btn-sm btn-primary">プロジェクト登録</button>
				                 </a>
				                 @endif
                                 @endif  
				                </div>
				                <div class="col-md-1">
	                            @if( Auth::user()->can('credit-add'))
				                 <a ><button onclick="create_credit()" type="button" style="float: left;width: 100%;" class="btn-sm btn-primary">与信情報登録</button></a>
                                @endif 
				                </div>
				                <div class="col-md-1">
				                	
				                </div>

				                <div class="col-md-1">
	
				                 <a><button id="csv" type="button" style="float: left;width: 100%;" class="btn-sm btn-success">CSV出力</button></a>

				                </div>

                        </div>
                        <div class="row" >

                                <div class="col-md-1">
                                
                                </div>
                                <div class="col-md-1">
                                  <span hidden id="upload_success" class="text-success">{{ trans('message.contract_upload_success') }}</span>
                                  <span hidden id="upload_fail" class="text-danger">{{ trans('message.contract_upload_fail') }}</span>
				                </div>

				                <div class="col-md-1">

				                </div>
				                <div class="col-md-1">

				                </div>

                        </div>
				        <div class="row">
		                	　　　<br>

				                <div class="col-md-4">
				                
				                <button type="button" id="form_submit"  style="float:right;width: 200px;" class="btn btn-primary">更新</button>

				                </div>
                                <div class="col-md-4">
	                            @if(Crofun::customer_edit_return_button() == 0)
				            	 		

				                <a href="{{ url('customer/infor?page='.request()->page) }}">
				                	<button type="button" style="float: left;width: 200px;" class="btn btn-danger">戻る</button>
				                </a>

				            	@else
				            	 		
				            	 		<a  href="{{route('Credit_index')}}">

				            	 			<button type="button" style="float: left;width: 200px;" class="btn btn-danger"> 戻る</button>
				            	 		 
				            	 		</a>

				            	@endif

				                </div>
				                
				               
				        
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
      $( document ).ready(function() {

          $("#client_code").prop("readonly", true);
          $( "#get_number" ).click(function(event) {
                      
                      var client_code = $("#client_code").val();
                         console.log(client_code);

				      $("#status_1" ).remove();
                      $("#status_2" ).remove();
                      $("#status_3" ).remove();
                      $("#status_4" ).remove();
                      $("#status").append("<option value='3' selected id='status_3'>取引中</option>");
                      $("#status").append("<option value='1'  id='status_1'>取引終了</option>");
                      var company_id = $("#company_id").val();
                          
			              	$.ajax({

					           type:'POST',
					           url:'/customer/changecode',
					           data: {

    						        "company_id"   : company_id
						        },

					           success:function(data){
                                
                               // $("#client_code").prop("name","client_code_main");
                               $("#client_code").val(data.num);
                               $("#client_code_main").val(data.num);

                            

					           },

					           error: function (exception) {

								         alert(exception.responseText);

								}

					        });

			   	     if($( "#status" ).val()=='2'){
                            
                            $( "#status_1" ).remove();
                            $( "#status_2" ).remove();
					       	$( "#status_3" ).remove();
                            $( "#status_4" ).remove();
                            $("#status").append("<option value='3' selected id='status_3'>取引中</option>");
                            $("#status").append("<option value='1'  id='status_1'>取引終了</option>");
                            return;
					  }

		  });

		$( "#csv" ).click(function(event) {
                   
                 client_id = $("#client_id").val();
                 document.location.href = "/customer/csv2?client_id="+client_id;

		  });
        
        $( "#form_submit" ).click(function(event) {
                   
              $( "#edit_customer" ).submit();

		 });


        if($( "#status" ).val()=='1'){

            $( "#status_2" ).remove();
           // $( "#status_3" ).remove();
            $( "#status_4" ).remove(); 
        }

        if($( "#status" ).val()=='2'){

            $( "#status_1" ).remove();
            $( "#status_3" ).remove();
            $( "#status_4" ).remove();
            $( "#get_number" ).show();
          
        }
        
        if($( "#status" ).val()=='3'){

            // $( "#status_1" ).remove();
            $( "#status_2" ).remove();
            $( "#status_4" ).remove(); 
            // $( "#get_number" ).show();
        }

        if($( "#status" ).val()=='4'){
            
            $( "#status_1" ).remove();
           // $( "#status_2" ).remove();
            $( "#status_3" ).remove();
            $( "#get_number" ).show();
        }


        $( "#input_file" ).change(function() {
			  
			var pdf   = $('#input_file')[0].files[0];
			var form  = new FormData();

			form.append('pdf', pdf);
            form.append('type', 1);
            form.append('client_id', $("#client_id").val());
            form.append('company_id', $("#company_id").val());
            
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
						

				}
			});


		});	

		$( "#status" ).change(function() {
            
            if($("#status").val() !=1){ return }

			var form  = new FormData();
            form.append('customer_id', $("#client_id").val());

            
			$.ajax({
			    url: '/customer/checkproject',
			    data: form,
			    cache: false,
			    contentType: false,
			    processData: false,
			    type: 'POST',
			    success:function(response) {
		            // console.log(response.status);
		            // alert(response);
                    if(response.status == 1){
                          
                        $.alert({
						    title: 'メッセージ',
						    content: response.message,
					    });
                        
                        $('#status').prop('selectedIndex', 0);

                    }


			    },

			    error: function (exception) {
                        
                        alert(exception.responseText);
						

				}
			});


		});	


      });
    
    function project_create_url() {

		    var base        =  '{!! route("create_project") !!}';
            var company_id  =  $( "#company_id" ).val();
            var customer_id =  $( "#client_id" ).val();
            var url         =  base+'?company_id='+company_id+'&customer_id='+customer_id+'&pre='+1;

			window.location.href = url;   
    }
    
    function create_credit() {

		    var base        =  '{!! route("create_credit") !!}';
            var company_id  =  $( "#company_id" ).val();
            var customer_id =  $( "#client_id" ).val();

            var url         =  base+'?company_id='+company_id+'&client_id='+customer_id;

			window.location.href = url;   
    }

    function project_index_url() {

		    var base        =  '{!! route('project_index') !!}';
            var company_id  =  $( "#company_id" ).val();
            var customer_id =  $( "#client_id" ).val();
            var url         =  base+'?client_id='+customer_id;

			window.location.href = url;   
    } 

    function credit_log_url() {

		    var base        =  '{!! route('Credit_log') !!}';
            var company_id  =  $( "#company_id" ).val();
            var customer_id =  $( "#client_id" ).val();
            var url         =  base+'?&client_id='+customer_id;

			window.location.href = url;   
    }
    function credit_index_url() {

		    var base        =  '{!! route('Credit_index') !!}';
            var company_id  =  $( "#company_id" ).val();
            var customer_id =  $( "#client_id" ).val();
            var url         =  base+'?&client_id='+customer_id;

			window.location.href = url;   
    }

    function contract_index_url() {

		    var base        =  '{!! route('Contract_index') !!}';
            var company_id  =  $( "#company_id" ).val();
            var customer_id =  $( "#client_id" ).val();
            var url         =  base+'?&client_id='+customer_id;

			window.location.href = url;   
    }

    function contract_index_url() {

		    var base        =  '{!! route('Contract_index') !!}';
            var company_id  =  $( "#company_id" ).val();
            var customer_id =  $( "#client_id" ).val();
            var url         =  base+'?&client_id='+customer_id;

			window.location.href = url;   
    }

    function receivable_index_url() {

		    var base        =  '{!! route('Receivable_index') !!}';
            var company_id  =  $( "#company_id" ).val();
            var customer_id =  $( "#client_id" ).val();
            var url         =  base+'?&client_id='+customer_id;

			window.location.href = url;   
    }

</script>
<script src="{{ asset('select/icontains.js') }}" ></script>

<script src="{{ asset('select/comboTreePlugin.js') }}" ></script>


@endsection
