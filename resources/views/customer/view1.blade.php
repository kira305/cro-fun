@extends('layouts.app')

@section('content')
@section('breadcrumbs', Breadcrumbs::render('customer/edit'))
@section('styles')

    <link href="{{ asset('css/customer_view.css') }}" rel="stylesheet">
    
@stop
      <div class="row">
        <div class="col-md-12">
       
          <ul class="timeline">

	          	<li>
	             
	              <div class="timeline-item">
	               
                       <div class="timeline-body">
                            
                        <table class="table blueTable">


							<tbody>
								<tr>
								   <td colspan="3" >

                                       <label class="organization"><b>会社コード:</b></label> 
								   	   <p style="display: inline;"> {{$customer->company->abbreviate_name}} </p>

								   </td>
								   <td colspan="3">

								   	  <label class="organization"><b>新規登録申請本部:</b></label>
								   	  <p style="display: inline;"> {{$customer->com_grp()->headquarters}} </p>


								   </td>

								</tr>
							    <tr>
								   <td colspan="3">

                                       <label class="organization"><b>新規登録申請部署:</b></label> 
                                       <p style="display: inline;"> {{$customer->com_grp()->department_name}} </p>
                                      
								   </td>

								   <td colspan="3">

								   	  <label class="organization"><b>新規登録申請グループ:</b></label>
								   	  <p style="display: inline;"> {{$customer->com_grp()->group_name}} </p>

								   </td>


								</tr>

								<tr>

								    <td colspan="3">

								    	<label class="organization"><b>顧客名:</b></label>
								    	<p style="display: inline;"> {{$customer->client_name}} </p>

								    </td>
								    <td colspan="3">
								    	
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
                                    	  @if ($customer->status == 1) 

										       <p style="display: inline;"> 取引中 </p>

										  @endif  
										  
										  @if ($customer->status == 2) 

										       <p style="display: inline;"> 仮登録中 </p>

										  @endif  


										  @if ($customer->status == 3) 

										       <p style="display: inline;"> 本登録中止 </p>

										  @endif  

	                                      @if ($customer->status == 4) 

										       <p style="display: inline;"> 取引終了 </p>

										  @endif 
                                    </td>

								</tr>
							    
							    <tr>

									<td colspan="2">
	                                   		<label ><b>法人番号:</b></label>
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
											<p style="display: inline;"> {{$customer->client_code}} </p>
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
											<p  style="display: inline;"> {{$customer->closing_time}} dfasfdaf</p>

									</td>
									<td colspan="2">
										    
										    <label class="col3"><b>回収サイト:</b></label>
											<p style="display: inline;"> {{$customer->collection_site}} </p>
									</td>
									<td colspan="2">

										    <label class="col3"><b>商蔵コード:</b></label>
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

	                                   		<label ><b>振込人名称:</b></label>
											<p style="display: inline;"> {{$customer->transferee_name}} </p>

									</td>
									<td colspan="2">
										    
										    <label  id="label_x_0"><b>振込人名称相違:</b></label>
											<input type="checkbox"  class="minimal" id="input_x_0" 
											 @if ($customer->transferee == true) checked @endif  >
											
									</td>
									<td colspan="2">

										    <label class="label_x_1" id="label_x_1"><b>反社チェック済み:</b></label>
											<input type="checkbox" class="minimal" id="input_x_1" 
											 @if ($customer->antisocial == true) checked @endif  >
								            <input type="hidden" name="id" id="hidden_id" value="{{$customer->id}}"
						                        class="form-control">
						                    <input type="hidden" id="company_id" value="{{$customer->company_id}}" name="company_id" >
											
									</td>

								</tr>
								<tr>

									<td colspan="2">
											<label ><b>RM与信限度額:</b></label>
											<p style="display: inline;"> 
											 @if($customer->credit_check())
												{{number_format($customer->credit_check()->credit_limit / 1000)}} 
											 @endif
											</p>
									</td>

									<td colspan="2">

											<label ><b>取引想定合計金額:</b></label>
											<p style="display: inline;"> {{number_format($transaction/1000)}} </p>

									</td>

                                    <td colspan="2">

										    <label id="yoshinchousa"><b>信用調査有無:</b>
                                           	<input type="checkbox"  id="yoshinchousa_1" 
											 @if ($customer->credit == true) checked @endif  >
										    </label>

											
									</td>

								</tr>
							    <tr>
								<td colspan="3">
										<label class="label_2"><b>格付け情報:</b></label>
										<p class="content_text"> 
					                       	@if($customer->credit_check())

					                       	{{$customer->credit_check()->rank}}

					                       	@else 

					                       	@endif
										</p>
								</td>
								<td colspan="3">
										<label class="label_2"><b>与信情報取得日:</b></label>
										<p class="content_text"> 
                                            @if($customer->credit_check())

					                       	  {{$customer->credit_check()->get_time}}

					                       	@else 

					                       	@endif
										 </p>
								</td>

								</tr>
								<tr>
								<td colspan="3">
										<label class="label_2"><b>希望限度額:</b></label>
										<p class="content_text"> 
					                        @if($customer->credit_check())

					                         {{number_format($customer->credit_check()->credit_expect / 1000)}}

					                       	@else 

					                       	@endif
										</p>
								</td>
								<td colspan="3">
										<label class="label_2"><b>与信限度期間:</b></label>
										<p class="content_text"> 
                                            @if($customer->credit_check())

					                       	{{$customer->credit_check()->expiration_date}}

					                       	@else 

					                       	@endif
										 </p>
								</td>

								</tr>
                                <tr>

								<td colspan="8">
										<label><b>備考:</b></label>
										<p class="content_text"> {{$customer->note}} </p>
								</td>

								</tr>
                                
                                <tr>


		                                
										<td colspan="1">
                                            <button onclick="project_index_url()" style="min-width: 100px;" class="btn-sm btn-warning">プロジェクト一覧</button>
										</td>

										<td colspan="1">
                                            <button onclick="credit_log_url()" style="min-width: 100px;" class="btn-sm btn-warning">与信履歴
                                            </button>
										</td>

										<td colspan="1">
                                            <button onclick="contract_index_url()" style="min-width: 100px;" class="btn-sm btn-warning">契約書一覧
                                            </button>
										</td>

										<td colspan="1">
                                             <button onclick="receivable_index_url()" style="min-width: 100px;" class="btn-sm btn-warning">売掛金情報</button>
										</td>

										<td colspan="2">
                                             <button onclick="credit_index_url()" style="min-width: 100px;"  class="btn-sm btn-warning">与信一覧
                                             </button>
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
	
				                 <a href="{{ url('customer/infor') }}"><button type="button" style="float: left;width: 200px;" class="btn btn-danger">戻る</button></a>

				                </div>
				                
				               
				        
		                </div>
	              </div>

	            </li>
	           
          </ul>
        </div>
      </div>
      <script type="text/javascript">

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
      </script>
@endsection