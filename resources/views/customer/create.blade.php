@extends('layouts.app')
@section('content')
@section('breadcrumbs', Breadcrumbs::render('customer/create'))
@section('styles')
       <link href="{{ asset('css/customer_create.css') }}" rel="stylesheet">
@stop
@include('layouts.confirm_js')
<div class="row">
	<div class="col-md-12">
		
		<ul class="timeline">
			<li>
				
				<div class="timeline-item">
					
					<div class="timeline">
						<div>
							
							<div class="box-body">
								@if ($message = Session::get('message'))


								<p class="message" >{{ $message }}</p>

								
								@endif
								<form id="create_customer" method="post" action="{{ url('customer/create') }}">
									<div class="row">
										
										<table class="table table_create table-bordered">

                                            <tbody>
													<tr>

													   <td colspan="2">

					                                       <label class="label_level_1"><b>会社コード:</b></label> 
																											
													   </td>

													   <td colspan="2">
													   	<select class="select_level_1" id="company_id" name="company_id" >
															@foreach($companies as $company)
																<option 
																		{{ old('company_id') == $company->id ? 'selected' : '' }}
																		value="{{$company->id}}">{{$company->abbreviate_name}}
																</option>
																	
															@endforeach
														</select>
													   </td>

					                                   <td colspan="2">

					                                        <label class="label_level_1"><b>新規登録申請本部:</b></label>
					                                               
					                                   </td>
					                                   <td colspan="2">
					                                   	 	<select class="select_level_1"  id="headquarter_id" name="headquarter_id">
																<option></option>
																@foreach($headquarters as $headquarter)
																<option class="headquarter_id" 
																	@if (old('headquarter_id') == $headquarter->id) selected @endif
																	data-value="{{ $headquarter->company_id }}"
																	value="{{$headquarter->id}}">{{$headquarter->headquarters}}
																</option>
																		
																@endforeach
															</select>
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

					                                       <label class="label_level_1"><b>新規登録申請部署:</b></label> 
																
													   </td>

													   <td colspan="2">
													   	 	<select class="select_level_1" id="department_id" name="department_id" >
																<option> </option>
																@foreach($departments as $department)
																<option class="department_id" 
																@if (old('department_id') == $department->id) selected @endif
																data-value="{{ $department->headquarter()->id }}"
																value="{{$department->id}}">{{$department->department_name}}
															</option>
															
															@endforeach
														   </select>
													   </td>
					                                   <td colspan="2">

					                                        <label class="label_level_1"><b>新規登録申請グループ:</b></label>			
					                                   </td>
					                                   <td colspan="2">
					                                   	  	<select class="select_level_1" id="group_id" name="group_id" >
															    <option> </option>
																@foreach($groups as $group)
																<option class="group_id"
																	@if (old('group_id') == $group->id) selected @endif 
																	data-value="{{ $group->department()->id }}"
																	value="{{$group->id}}">{{$group->group_name}}
																</option>
																
																@endforeach
															</select>
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

													  	<label class="label_level_1"><b>顧客名:</b><sup>※</sup></label>

													  </td>
													  <td colspan="3">

													  	<input type="text" id="client_name" name="client_name" value="{{ old('client_name')}}" class="form-control input-sm">
								                        <input type="hidden" name="id" value=""
								                        class="form-control input-sm">
								                        @csrf

													  </td>
													  <td colspan="3">
													  	
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

								                        <input id="name_kana" type="text" value="{{ old('client_name_kana_conversion')}}" name="client_name_kana"  class="form-control input-sm">

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
														<label class="label_level_1">略称</label>
														</td>
														<td colspan="2">
														<input type="text" value="{{ old('client_name_ab')}}" name="client_name_ab"   class="form-control input-sm">	
														</td>
														<td colspan="1">
															
														</td>
                                                        <td colspan="1">
														<label class="label_level_1">ステータス:</label>
														</td>
													    <td colspan="2">
															<select class="select_level_1" id="status" name="status">
															    
															    <option 
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
                                                       	 <label class="label_level_1">法人番号:<sup>※</sup></label>
                                                       </td>
                                                       <td colspan="1">
                                                       	 	<input type="text" 
															name="corporation_num" id="corporation_num" 
															value="{{ old('corporation_num')}}"
															class="form-control input-sm">
                                                       </td>
                                                       <td colspan="1">
                                                       	<label class="label_level_1">TSRコード:<sup>※</sup></label>
                                                       </td>
                                                       <td colspan="1">
                                                       	 <input  type="text" id="tsr_code" name="tsr_code"  value="{{ old('tsr_code')}}"
							                             class="form-control input-sm">
                                                       </td>
                                                       <td colspan="1">
                                                       	<label class="label_level_1">商蔵コード:</label>
                                                       </td>
                                                       <td colspan="1">
                                                       	 <input type="text" 
															value="{{ old('akikura_code')}}"
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
															<input type="text" id="client_code" 
																value="{{ old('client_code')}}"
																name="client_code"   class="form-control input-sm">
														</td>
													</tr>
                                                   	<tr>
														<td colspan="2">
														  <label class="label_level_1">住所:<sup>※</sup></label>
														</td>
														<td colspan="3">
															<input type="text" 
																value="{{ old('client_address')}}"
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
														value="{{ old('closing_month')}}"
														class="form-control input-sm">
                                                       </td>
                                                       <td colspan="1">
                                                       	<label class="label_level_1">回収サイト:</label>
                                                       </td>
                                                       <td colspan="1">
															<input style="float: left;" 
															value="{{ old('collection_site')}}"
															type="text" name="collection_site"  class="form-control input-sm">
                                                       </td>
                                                       <td colspan="1">
                                                       	<label class="label_level_1"><b>取引区分:</b></label>
                                                       </td>
                                                       <td colspan="1">
														<select id="type" class="select_level_1" name="sale" >
															<option selected value=""></option>
															<option  
															@if (old('sale') == '1') selected @endif  
															value="1">売上先</option>
															<option 
															@if (old('sale') == '2') selected @endif  
															value="2">仕入先</option>

															<option 
															@if (old('sale') == '3') selected @endif  
															value="3">仕入先+売上先</option>
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
															value="{{ old('transferee_name')}}"
															name="transferee_name"  class="form-control input-sm">
														</td>

														<td colspan="1">

															<label class="label_checkbox">
															振込人名称相違:
															<input type="checkbox" 
															@if(old('transferee') == 'on') checked @endif
															name="transferee" class="input_checkbox">					
														    </label>

														</td>
														<td colspan="1">

															<label class="label_checkbox">
																反社チェック済み:
                                                                <input type="checkbox" 
																@if(old('antisocial') == 'on') checked @endif
															    name="antisocial"  class="input_checkbox">
															</label>
															
														</td>
														<td colspan="1">
															<label class="label_checkbox">
																信用調査有無:
	                                                            <input type="checkbox" 
																@if(old('credit') == 'on') checked @endif
															    name="credit"  class="input_checkbox">
															</label>
															
														</td>
													</tr>
													<tr>
														<td colspan="2">
														 <label class="label_level_1">RM与信限度額:<sup>※,1</sup></label>
														</td>
														<td>
															<input  id="credit_limit" name="credit_limit" 
				                                            value="{{ old('credit_limit')}}" 
				                                            class="form-control input-sm" readonly >
														</td>
													</tr>
													<tr>
													   <td colspan="2">
													   	 <label class="label_level_1">格付け情報:<sup>※</sup></label>
													   </td>
													   <td colspan="1">
													   	<input  id="rank_h" name="rank"      
			                                             	value="{{ old('rank')}}" class="form-control input-sm" 
			                                             	readonly >
			                                            <input hidden id="check_credit" name="check_credit"      
			                                             	value="{{ old('check_credit')}}" >
													   </td>
													   <td colspan="1">
													   	<label class="label_level_1">与信情報取得日:<sup>※</sup></label>
													   </td>
													   <td colspan="1">
													   	 <input id="get_time_h" name="get_time" 
				                                           value="{{ old('get_time')}}" class="form-control input-sm"
				                                           readonly>
													   </td>
													</tr>
													<tr>
													   <td colspan="2">
													   	 <label class="label_level_1">希望限度額:<sup>1</sup></label>
													   </td>
													   <td colspan="1">
													   	<input  id="credit_expect" name="credit_expect"      
			                                             	value="{{ old('credit_expect')}}" class="form-control input-sm">
													   </td>
													   <td colspan="1">
													   	<label class="label_level_1">与信限度期限:<sup>※</sup></label>
													   </td>
													   <td colspan="1">
													   	 <input id="expiration_date" name="expiration_date" 
				                                           value="{{ old('expiration_date')}}" class="form-control input-sm"
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
															<textarea rows="5" cols="120" name="note">{{ old('note')}}</textarea>
														</td>
													</tr>
													<tr>
														<td colspan="2">
															 
														</td>
														<td colspan="6">
															 <h5>1)1000円が省略された金額で表示されています。</h5>
														</td>
													</tr>

											</tbody>

										</table>
									</div>

                                 </form>

			<div class="row">
				<div class="col-sm-2">
					
				</div>
				<div class="col-sm-2">
					<form id="upload" action="{{ url('customer/upload') }}" method="post" enctype="multipart/form-data">
						<span class="btn btn-primary btn-file" class="input_lable">
							RM情報取込
							<input id="input_file" type="file" name="file_data">
							@csrf
						</span>
					</form>
				</div>
				<div class="col-sm-4">
				
					<p>右上に※があるデータは、データ未入力であれば、</p>
					<p>RM情報からデータを設定します。</p>

				</div>


			</div>


		</div>
		<br>
		<div class="row">
			<div class="col-sm-2">
				
			</div>
			<div class="col-sm-2">
				
				<a target="_blank" rel="noopener noreferrer" href="https://hojin-info.go.jp/hojin/TopPage"><h4 style="text-decoration: underline;">法人インフォ</h4></a>

			</div>
			<div class="col-sm-4">
				
				<p>官庁法人DBへのリンクになります</p>
				<p>法人番号正式顧客名・住所などがわからなければ参照してください</p>

			</div>
		</div>
		<div class="row">
			　　　<br>

			<div class="col-md-4">
				
				<button type="button" id="form_submit"  style="float:right;width: 200px;" class="btn btn-primary">登録</button>

			</div>
			<div class="col-md-4">
				
				<a href="{{ url('customer/infor') }}"><button type="button" style="float: left;width: 200px;margin-bottom: 20px;" class="btn btn-danger">戻る</button></a>
                
			</div>
			
			　　　
			
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
	//画面が開いた際
	$( document ).ready(function() {
		
		$("#client_code").prop("readonly", true);
      		//クリックされたら
      		$( "#form_submit" ).click(function(event) {
                
                if(($( "#credit_expect" ).val() == "") && ($( "#input_file" ).val() != "")){
                   
                   $.alert({

						    title: 'メッセージ',
						    content: '希望限度額を入力してください！',

				   });

				   return;

      			}

      			$.ajax({

      				type:'POST',
      				url:'/customer/getcode',
      				data: {


      					"company_id"   :$('#company_id').val()

      				},

      				success:function(data){
      					

      					
      					$('#client_code').val(data.num);
      					$( "#create_customer" ).submit();
      					

      				},

      				error: function (exception) {

      					alert(exception.responseText);

      				}

      			});
      			

      		});
      		
      		$( "#input_file" ).change(function() {

      			if($( "#credit_expect" ).val() == ""){
                   
                   $.alert({

						    title: 'メッセージ',
						    content: '希望限度額を入力してください！',

				   });

                   $('#input_file').val('');

      			}else{

      				$( "#upload" ).submit();
      			}
      			

      		});	

		  $('#upload').submit(function(event) { // when from submit send data to server
		  	
		  	var csv   = $('#input_file')[0].files[0];
		  	var form  = new FormData();

		  	form.append('csv', csv);
		    form.append('credit_expect',$( "#credit_expect" ).val());


		  	$.ajax({
		  		url: '/customer/upload',
		  		data: form,
		  		cache: false,
		  		contentType: false,
		  		processData: false,
		  		type: 'POST',
		  		success:function(response) {
		  			
		  			
		  			if(response.status == 302){
		  				
                        $.alert({

						    title: 'メッセージ',
						    content: response.errors.csv,

				        });

				        return;

		  			}
                    
                    if(response.status == 300){
		  				
                        $.alert({

						    title: 'メッセージ',
						    content: response.errors.credit_expect,

				        });

				        return;

		  			}

		  			console.log(response);
		  			set_data(response);

		  			$('#check_credit').val(1);
		  		},

		  		error: function (exception) {
		  			
		  			alert(exception.responseText);
		  			if(exception.status == 500){
		  				
		  				alert('ファイルのルールはただしくありません。');

		  			}
		  			

		  		}
		  	});


		  	event.preventDefault();


		  });		

		});

	function set_data(response) {
		
        
    
		if($('#client_name').val().length == 0){

			$('#client_name').val(response.csv.client_name);
		}
		
		if($('#tsr_code').val().length == 0){

			$('#tsr_code').val(response.csv.tsr_code);
		}

		if($('#client_address').val().length == 0){

			$('#client_address').val(response.csv.client_address);
		}
		
		if($('#corporation_num').val().length == 0){

			$('#corporation_num').val(response.csv.corporation_num);
		}  
		
		$('#get_time_h').val(response.csv.get_time);
		$('#rank_h').val(response.csv.rank);
		// $('#credit_limit_h').val(response.csv.credit_limit);
		// $('#get_time').text(response.csv.get_time);
		// $('#rank').text(response.csv.rank);
		$('#credit_limit').val(response.csv.credit_limit);
		$('#expiration_date').val(response.expiration_date);
	
	}

	// 「,」区切りで出力
	function number_format(num) {
		return num.toString().replace(/([0-9]+?)(?=(?:[0-9]{3})+$)/g , '$1,');
	}	
	
</script>
<script src="{{ asset('select/icontains.js') }}" ></script>

<script src="{{ asset('select/comboTreePlugin.js') }}" ></script>


@endsection
