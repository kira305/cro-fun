@extends('layouts.app')

@section('content')
@section('breadcrumbs', Breadcrumbs::render('customer/view'))
@section('styles')

    <link href="{{ asset('css/customer_view.css') }}" rel="stylesheet">
    
@stop
      <div class="row">
        <div class="col-md-12">
       
          <ul class="timeline">

	          	<li>
	             
	              <div class="timeline-item">
	               
                       <div class="timeline-body">
                            
                        <table class="blueTable"  >


							<tbody>

								<tr>
								   <td colspan="3"   >

                                       <label class="organization"><b>会社コード:</b></label> 
								   	   <p style="display: inline;"> {{$customer->company->abbreviate_name}} </p>

								   </td>
								   <td colspan="3" align="justify">

								   	  <label class="organization"><b>新規登録申請本部:</b>
								   	  <p style="display: inline;"> {{$customer->com_grp()->headquarters}} </p></label>


								   </td>

								</tr>
							    <tr>
								   <td colspan="3">

                                       <label class="organization"><b>新規登録申請部署:</b></label> 
                                       <p style="display: inline;"> {{$customer->com_grp()->department_name}} </p>
                                      
								   </td>

								   <td colspan="3">

								   	  <label class="organization"><b>新規登録申請グループ:</b>
								   	  <p style="display: inline;"> {{$customer->com_grp()->group_name}} </p></label>

								   </td>


								</tr>

								<tr>

								    <td colspan="3">

								    	<label class="organization"><b>顧客名:</b></label>
								    	<p style="display: inline;"> {{$customer->client_name}} </p>

								    </td>
										<td colspan="1">
	                                        <label class="label_level_1">データ登録日:</label>
	                                    </td>
	                                    <td colspan="2">
												<p style="display: inline;"> {{ Crofun::changeFormatDateOfCredit($customer->created_at) }} </p>
	                                    </td>
								</tr>
								<tr>

									<td colspan="3">

										<label class="organization"><b>顧客名カナ:</b></label>
										<p style="display: inline;"> {{$customer->client_name_kana}} </p>

									</td>
									<td colspan="3">
										
									</td>


								</tr>
							    
							    <tr>
                                    <td colspan="3">
                                    	<label class="organization"><b>略称:</b></label>
                                    	<p style="display: inline;"> {{$customer->client_name_ab}} </p>
                                    </td>

                                    <td colspan="3">
                                    	  <label class="organization"><b>ステータス:</b></label>
                                    	  @if ($customer->status == 3) 

										       <p style="display: inline;"> 取引中 </p>

										  @endif  
										  
										  @if ($customer->status == 4) 

										       <p style="display: inline;"> 仮登録中 </p>

										  @endif  


										  @if ($customer->status == 2) 

										       <p style="display: inline;"> 本登録中止 </p>

										  @endif  

	                                      @if ($customer->status == 1) 

										       <p style="display: inline;"> 取引終了 </p>

										  @endif 
                                    </td>

								</tr>
							    
							    <tr>

									<td colspan="2">
	                                   		<label style="width:45%"><b>法人番号:</b></label>
											<p style="display: inline;"> {{$customer->corporation_num}} </p>
									</td>
									<td colspan="2">
										    
										    <label ><b>TSRコード:</b></label>
											<p style="display: inline;"> {{$customer->tsr_code}} </p>
									</td>
									<td colspan="2">
										    <label ><b>商蔵コード:</b></label>
											<p style="display: inline;"> {{$customer->akikura_code}} </p>
									</td>


								</tr>
						        <tr>
									<td colspan="3">
											<label class="organization"><b>顧客コード:</b></label>
											<p style="display: inline;">
												@if($customer->client_code_main != null) 
												{{$customer->client_code_main}} 
												@else {{$customer->client_code}}
												@endif
											</p>
									</td>
                                    <td colspan="3">
                                    	
                                    </td>
								</tr>
							    <tr>

									<td colspan="3">
											<label class="organization"><b>住所:</b></label>
											<p style="display: inline;"> {{$customer->client_address}} </p>
									</td>
	                               <td colspan="3">
	                               	
	                               </td>

								</tr>
							    <tr>
									<td colspan="2">

	                                   		<label class="col3"><b>決算月日:</b></label>
											<p  style="display: inline;"> {{$customer->closing_time}}</p>

									</td>
									<td colspan="2">
										    
										    <label class="col3"><b>回収サイト:</b></label>
											<p style="display: inline;"> {{$customer->collection_site}} </p>
									</td>
									<td colspan="2">

										    <label class="col3"><b>取引区分:</b></label>
										    @if ($customer->sale == 1) 

											       <p style="display: inline;"> 売上先 </p>

											@endif  
											  
											@if ($customer->sale == 2) 

											       <p style="display: inline;"> 仕入先 </p>

											@endif  


											@if ($customer->sale == 3) 

											       <p style="display: inline;"> 売上先+仕入先 </p>

											@endif 

									</td>


								</tr>
								<tr>
									<td colspan="2">

	                                   		<label style="width: 45%"><b>振込人名称:</b></label>
											<p style="display: inline;"> {{$customer->transferee_name}} </p>

									</td>
									<td colspan="2">
										    
										    <label class="col3"><b>振込人名称相違:</b></label>
											<input type="checkbox" disabled  style="display: inline;height: 10px" 
											 @if ($customer->transferee == true) checked @endif  >
											
									</td>
									<td colspan="2">

										    <label class="col3"><b>反社チェック済み:</b>
											<input type="checkbox" style="display: inline;height: 10px" disabled
											 @if ($customer->antisocial == true) checked @endif  >
								            <input type="hidden" name="id" id="hidden_id" value="{{$customer->id}}"
						                        class="form-control">
						                    <input type="hidden" id="company_id" value="{{$customer->company_id}}" name="company_id" ></label>
											
									</td>

								</tr>
								<tr>

									<td colspan="2">
											<label style="width: 45%"><b>RM与信限度額:<sup>1</sup></b></label>
											<p style="display: inline;"> 
											 @if($customer->credit_check())
												{{number_format($customer->credit_check()->credit_limit / 1000)}} 
											 @endif
											</p>
									</td>

									<td colspan="2">

											<label class="col3" ><b>取引想定合計金額:<sup>1</sup></b></label>
											<p style="display: inline;"> {{number_format($transaction/1000)}} </p>

									</td>

                                    <td colspan="2">

										    <label class="col3"><b>信用調査有無:</b> 
                                           	<input type="checkbox"  style="display: inline;height: 10px" disabled
											 @if ($customer->credit == true) checked @endif  ></label>
											
									</td>

								</tr>
							    <tr>
								<td colspan="3">
										<label class="label_2"><b>格付け情報:</b></label>
										<p class="content_text"> 
					                       	@if($customer->credit_check_by_get_time())

					                       	{{$customer->credit_check_by_get_time()->rank}}

					                       	@else 

					                       	@endif
										</p>
								</td>
								<td colspan="3">
										<label class="label_2"><b>与信情報取得日:</b>
										<p class="content_text" style="display: inline;"> 
                                            @if($customer->credit_check_by_get_time())

					                       	  {{Crofun::changeFormatDateOfCredit($customer->credit_check_by_get_time()->get_time)}}

					                       	@else 

					                       	@endif
										 </p></label>
								</td>

								</tr>
								<tr>
								<td colspan="3">
										<label class="label_2"><b>希望限度額:<sup>1</sup></b></label>
										<p class="content_text"> 
					                        @if($customer->credit_check())

					                         {{number_format($customer->credit_check()->credit_expect / 1000)}}

					                       	@else 

					                       	@endif
										</p>
								</td>
								<td colspan="3">
										<label class="label_2"><b>与信限度期間:</b>
										<p class="content_text" style="display: inline;"> 
                                            @if($customer->credit_check())

					                       	{{Crofun::changeFormatDateOfCredit($customer->credit_check()->expiration_date)}}

					                       	@else 

					                       	@endif
										 </p></label>
								</td>

								</tr>
                                <tr>

								<td colspan="8">
										<label><b>備考:</b></label>
										<p class="content_text"> {{$customer->note}} </p>
								</td>

								</tr>

                                <tr>

								<td colspan="8">
										<p class="content_text" style="text-align: center"> 1)1000円が省略された金額で表示されています。 </p>
								</td>

								</tr>
                                <tr style="border:none;">

										<td colspan="1" style="border:none;">
											@if( Auth::user()->can('contract-index'))
                                            <button onclick="contract_index_url()" style="min-width: 100px;width:200px;" class="btn-sm btn-warning">契約書情報
                                            </button>
                                            @endif
										</td>

										<td colspan="1" style="border:none;">
											 @if( Auth::user()->can('project-index'))
                                            <button onclick="project_index_url()" style="min-width: 100px;width:200px;" class="btn-sm btn-warning">プロジェクト情報</button>
                                             @endif
										</td>

										<td colspan="1" style="border:none;">
											@if( Auth::user()->can('credit-log'))
                                            <button onclick="credit_log_url()" style="min-width: 100px;width:200px;" class="btn-sm btn-warning">与信情報取得履歴
                                            </button>
                                            @endif
										</td>


										<td colspan="1" style="border:none;">
											@if( Auth::user()->can('credit-index'))
                                             <button onclick="credit_index_url()" style="min-width: 100px;width:200px;"  class="btn-sm btn-warning">与信一覧
                                             </button>
                                             @endif
										</td>

										<td colspan="2" style="border:none;">
											@if( Auth::user()->can('receivable-index'))
                                             <button onclick="receivable_index_url()" style="min-width: 100px;width:200px;" class="btn-sm btn-warning">売掛金残</button>
                                             @endif
										</td>
								</tr>

    	                    <tr style="border:none;">

                                <td style="border:none;">
	                            @if( Auth::user()->can('contract-up'))
	                              <br>
							      <span class="btn btn-primary btn-file btn-sm" >
									契約UP
									<input  type="file" id="input_file" name="file_data"
									 accept="application/pdf">
									@csrf
								  </span>
			                 		<p>※本画面からUPされた契約書は、<br>全ユーザー参照できます。</p>
                                @endif
				                </td>

				                <td style="border:none;">
				                	
                                 @if ($customer->status == 3) 
                                 @if( Auth::user()->can('project-add'))
				                 <a>
				                 	<button onclick="project_create_url()" type="button" style="width:200px; float: left;" class="btn-sm btn-primary">プロジェクト登録</button>
				                 </a>
				                 @endif
                                 @endif  
				                </td>

				                <td style="border:none;">
	                            @if( Auth::user()->can('credit-add'))
				                 <a ><button onclick="create_credit()" type="button" style="width:200px; float: left;" class="btn-sm btn-primary">与信情報登録</button></a>
                                @endif 
				                </td>

				                <td style="border:none;">
	
				                </td>

				                <td  style="border:none;">
				                 <a><button id="csv" type="button" style="float: left;width:200px;" class="btn-sm btn-success">CSV出力</button></a>

				                </td>

	                        </tr>



							</tbody>


					    </table>

                       </div>
                       <div class="row">
		                	　　　<br>

				                <div class="col-md-4">
				                
				    

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

	            </li>
	           
          </ul>
        </div>
      </div>
      <script type="text/javascript">

		    function project_create_url() {

				    var base        =  '{!! route("create_project") !!}';
		            var company_id  =  $( "#company_id" ).val();
		            var customer_id =  $( "#hidden_id" ).val();
		            var url         =  base+'?company_id='+company_id+'&customer_id='+customer_id+'&pre='+2;

					window.location.href = url;   
		    }

		    function create_credit() {

				    var base        =  '{!! route("create_credit") !!}';
		            var company_id  =  $( "#company_id" ).val();
		            var customer_id =  $( "#hidden_id" ).val();
		            var url         =  base+'?company_id='+company_id+'&client_id='+customer_id;

					window.location.href = url;   
		    }

		    function project_index_url() {

				    var base        =  '{!! route('project_index') !!}';
		            var company_id  =  $( "#company_id" ).val();
		            var customer_id =  $( "#hidden_id" ).val();
		            var url         =  base+'?&client_id='+customer_id;

					window.location.href = url;   
		    } 


		    function credit_index_url() {

				    var base        =  '{!! route('Credit_index') !!}';
		            var company_id  =  $( "#company_id" ).val();
		            var customer_id =  $( "#hidden_id" ).val();
		            var url         =  base+'?&client_id='+customer_id;

					window.location.href = url;   
		    }

		    function contract_index_url() {

				    var base        =  '{!! route('Contract_index') !!}';
		            var company_id  =  $( "#company_id" ).val();
		            var customer_id =  $( "#hidden_id" ).val();
		            var url         =  base+'?&client_id='+customer_id;

					window.location.href = url;   
		    }

		    function receivable_index_url() {

				    var base        =  '{!! route('Receivable_index') !!}';
		            var company_id  =  $( "#company_id" ).val();
		            var customer_id =  $( "#hidden_id" ).val();
		            var url         =  base+'?&client_id='+customer_id;

					window.location.href = url;   
		    }

		   function credit_log_url() {

		    var base        =  '{!! route('Credit_log') !!}';
            var company_id  =  $( "#company_id" ).val();
            var customer_id =  $( "#hidden_id" ).val();
            var url         =  base+'?&client_id='+customer_id;

			window.location.href = url;   
          }
		$( "#csv" ).click(function(event) {
                   
                 var customer_id =  $( "#hidden_id" ).val();
                 document.location.href = "/customer/csv2?client_id="+customer_id;

		  });

      </script>
@endsection