@extends('layouts.app')

@section('content')
@section('breadcrumbs', Breadcrumbs::render('customer/edit'))
     
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
                                	<div class="col-md-1">
						                  <label style="float: right;"><b>会社コード<sup>※</sup></b></label>
						             </div>
						             <div class="col-md-2">
					                	 <div class="form-group">
					                	 	
                                            <p class="form-control"> {{$customer->company->abbreviate_name}} </p>
											<input type="hidden" id="company_id" value="{{$customer->company_id}}" name="company_id" >
					                       
					                     </div>
						             </div>
					                <div class="col-md-3 offset-md-3">
					                  <label class="input_lable"><b>新規登録申請本部</b></label>
					                </div>
					                <div class="col-md-2">
					                	<div class="form-group">
						                    <select class="form-control"  id="headquarter_id" name="headquarter_id">
									          @foreach($headquarters as $headquarter)
							                    <option class="headquarter_id" 
							                    data-value="{{ $headquarter->company_id }}"
							                     @if ($customer->com_grp()->headquarters_id == $headquarter->id) selected @endif 
							                    value="{{$headquarter->id}}">{{$headquarter->headquarters}}
							                    </option>
							                  
					                          @endforeach
	  										</select>


									    </div>

					                </div>
	                            </div>
					        <div class="row">
			              
				                <div class="col-md-3 offset-md-3">
				                  <label class="input_lable"><b>新規登録申請部署</b></label>
				                </div>
				                <div class="col-md-2">
				                	<div class="form-group">
					                    <select class="form-control" id="department_id" name="department_id" >
					                    <option> </option>
								          @foreach($departments as $department)
						                    <option class="department_id" 
						                    data-value="{{ $department->headquarter()->id }}"
						                     @if ($customer->com_grp()->department_id == $department->id) selected @endif 
						                    value="{{$department->id}}">{{$department->department_name}}
						                    </option>
						                  
				                          @endforeach
										</select>


								    </div>
				                </div>

				                <div class="col-md-3 offset-md-3">
				                  <label class="input_lable" ><b>新規登録申請グループ<sup>※</sup></b></label>
				                </div>
				                <div class="col-lg-2">
									<div class="form-group">
								            <select class="form-control" id="group_id" name="group_id" >
								            	<option> </option>
									          @foreach($groups as $group)
						                    <option class="group_id" 
						                     data-value="{{ $group->department()->id }}"
						                     @if ($customer->request_group == $group->id) selected @endif 
						                    value="{{$group->id}}">{{$group->group_name}}
						                    </option>
						                  
					                          @endforeach
										</select>
									

								
									 </div>
								</div>
				           	   
					        </div>
				                <div class="row">
                                	<div class="col-md-1">
						                
						             </div>

						             <div class="col-md-1">

						             </div>

						             <div class="col-md-1">
						                 
						             </div>
						             <div class="col-md-1">
						                 
						             </div>
						             <div class="col-md-1">
                                     @if ($errors->has('group_id'))
                                        <div class="form-group">
        	                            <span class="text-danger">{{ $errors->first('group_id') }}</span>
                                        </div>
    	                             @endif

						             </div>

                                </div>



                                <div class="row">
						                <div class="col-md-1">
						                  <label style="float: right;"><b>顧客名<sup>※</sup></b></label>
						                </div>
						                <div class="col-md-5">
						                     <div class="form-group">
						                       <input type="text" name="client_name" value="{{$customer->client_name}}" class="form-control">
						                      <input type="hidden" name="id" id="hidden_id" value="{{$customer->id}}"
						                        class="form-control">
						                     </div>
						                </div>
						                @if ($errors->has('client_name'))
                                            
                                            <span class="text-danger">{{ $errors->first('client_name') }}</span>
        	                              

    	                                @endif
				                </div> 
				                <div class="row">
						                <div class="col-md-1">
						                  <label style="float: right;"><b>顧客名カナ<sup>※</sup></b></label>
						                </div>
						                <div class="col-md-5">
						                	 <div class="form-group">
						                       <input type="text" value="{{$customer->client_name_kana}}" name="client_name_kana"  class="form-control">
						                     </div>
						                </div>
						                @if ($errors->has('client_name_kana_conversion'))

        	                             <span class="text-danger">{{ $errors->first('client_name_kana_conversion') }}</span>

    	                                @endif
				                </div> 
				                <div class="row">
                                	<div class="col-md-1">
						                  <label style="float: right;">略称</label>
						             </div>
						             <div class="col-md-1">
						                	 <div class="form-group">
						                       <input type="text" value="{{$customer->client_name_ab}}" name="client_name_ab"   class="form-control">

						                     </div>
						             </div>

						                <div class="col-md-1">
						                  <label style="float: right;"><b>ステータス</b></label>
						                </div>
						                <div class="col-md-1">
						                	 <div class="form-group">
								                 <select class="form-control" id="status" name="status">
								              
		                                            <option id="status_1" 
		                                             @if ($customer->status == 1) selected @endif  
		                                              value="1">取引中
		                                            </option>
	                                                <option id="status_2" 
                                                      @if ($customer->status == 2) selected @endif  
	                                                  value="2">仮登録中
	                                                </option>
	                                                <option  id="status_3" 
                                                       @if ($customer->status == 3) selected @endif  
	                                                   value="3">本登録中止
	                                                </option>
	                                                <option id="status_4" 
	                                                 @if ($customer->status == 4) selected @endif      
	                                                 value="4">取引終了
	                                                 </option>
								                  </select>
						                      
						                     </div>
						                </div>

                                </div>
                                <div class="row">
                                	<div class="col-md-1">
						                
						             </div>
						             <div class="col-md-1">
                                     @if ($errors->has('client_name_ab'))
                                        <div class="form-group">
        	                            <span class="text-danger">{{ $errors->first('client_name_ab') }}</span>
                                        </div>
    	                             @endif
						             </div>

						             <div class="col-md-1">
						                 
						             </div>
						             <div class="col-md-1">
                                     @if ($errors->has('status'))
                                         <div class="form-group">
        	                            <span class="text-danger">{{ $errors->first('status') }}</span>
                                        </div>
    	                             @endif
						             </div>

                                </div>
                                <div class="row">
						                <div class="col-md-1 ">
						                  <label style="float: right;">法人番号</label>
						                </div>
						                <div class="col-md-1">
						                	 <div class="form-group">
						                       <input type="text" name="corporation_num" value="{{$customer->corporation_num}}" class="form-control">
						                        
						                     </div>
						                </div>
                                        <div class="col-md-1 ">
						                  <label style="float: right;">TSRコード</label>
						                </div>
						                <div class="col-md-1">
						                	 <div  class="form-group">
						                       <input style="float: left;" type="text" name="tsr_code" value="{{$customer->tsr_code}}" class="form-control">
						                       
						                     </div>
						                </div>
						                <div class="col-md-1">
						                  <label style="float: right;">商蔵コード</label>
						                </div>
						                <div class="col-md-1">
						                	 <div class="form-group">
						                       <input type="text" value="{{$customer->akikura_code}}" style="float: left;" name="akikura_code"  class="form-control">
						                        
						                     </div>
						                </div>
				                </div>
				                <div class="row">
                                	<div class="col-md-1">
						                
						             </div>
						             <div class="col-md-1">
                                     @if ($errors->has('corporation_num'))
                                        <div class="form-group">
        	                            <span class="text-danger">{{ $errors->first('abbreviate_name') }}</span>
                                        </div>
    	                             @endif
						             </div>

						             <div class="col-md-1">
						                 
						             </div>
						             <div class="col-md-1">
                                     @if ($errors->has('tsr_code'))
                                        <div class="form-group">
        	                            <span class="text-danger">{{ $errors->first('tsr_code') }}</span>
                                        </div>
    	                             @endif
						             </div>

						             <div class="col-md-1">
						                 
						             </div>
						             <div class="col-md-1">
                                     @if ($errors->has('akikura_code'))
                                        <div class="form-group">
        	                            <span class="text-danger">{{ $errors->first('akikura_code') }}</span>
                                        </div>
    	                             @endif
						             </div>

                                </div>
						        <div class="row">
                                	<div class="col-md-1">
						                  <label style="float: right;">顧客コード</label>
						             </div>
						             <div class="col-md-1">
						               <div class="form-group">

                                            @if($customer->client_code_main == null)
						                    <input  value="{{$customer->client_code}}" name="client_code" id="client_code"  class="form-control">
						                    @else
                                            <input  value="{{$customer->client_code_main}}" name="client_code_main" id="client_code"  class="form-control">
                                            @endif

						                </div>
						             </div>
						             <div class="col-md-1">
						                <button type="button" id="get_number" style="display: none;" 
						                 class="btn btn-primary">本登録</button>
						             </div>
                                </div>     
                                <div class="row">
                                	<div class="col-md-1">
						                 
						             </div>
						             <div class="col-md-1">
                                     @if ($errors->has('client_code'))
                                        <div class="form-group">
        	                            <span class="text-danger">{{ $errors->first('client_code') }}</span>
                                        </div>
    	                             @endif
						             </div>
						             <div class="col-md-1">
						              
						             </div>
                                </div> 
                                 @csrf
				                <div class="row">
					                <div class="col-md-1">
					                  <label style="float: right;">住所</label>
					                </div>
					                <div class="col-md-5">
					                	 <div class="form-group">
					                       <input type="text" name="client_address" value="{{$customer->client_address}}" class="form-control">
					                     </div>
					                </div>
					                @if ($errors->has('client_address'))

    	                                <span class="text-danger">{{ $errors->first('client_address') }}</span>

	                                @endif
				                </div>
				                <div class="row">
					                <div class="col-md-1">
					                  <label style="float: right;">決算月日</label>
					                </div>
					                <div class="col-md-1">
					                	 <div class="form-group">
					                       <input type="text" name="closing_month"  value="{{$customer->closing_time}}" class="form-control">
					                        
					                     </div>
					                </div>
                                    <div class="col-md-1 ">
					                  <label style="float: right;">回収サイト</label>
					                </div>
					                <div class="col-md-1">
					                	 <div  class="form-group">
					                       <input style="float: left;" value="{{$customer->collection_site}}" type="text" name="collection_site"  class="form-control">
					                       
					                     </div>
					                </div>
					                <div class="col-md-1">
					                  <label style="float: right;"><b>取引区分<sup>※</sup></b></label>
					                </div>
					                <div class="col-md-1">
					                	 <div class="form-group">
					                       
					                       	<select id="type" class="form-control" name="sale" >
                                             
                                                <option  
                                                @if ($customer->sale == 1) selected @endif 
                                                value="1">売上先</option>
                                                <option 
                                                @if ($customer->sale == 2) selected @endif 
                                                value="2">仕入先</option>
                                                <option 
                                                @if ($customer->sale == 3) selected @endif 
                                                value="3">売上先+仕入先</option>
											</select>
					                        
					                     </div>
					                </div>
				                </div>
                                <div class="row">
                                	<div class="col-md-1">
						                
						             </div>
						             <div class="col-md-1">
                                     @if ($errors->has('closing_month'))
                                        <div class="form-group">
        	                            <span class="text-danger">{{ $errors->first('closing_month') }}</span>
                                        </div>
    	                             @endif
						             </div>

						             <div class="col-md-1">
						                 
						             </div>
						             <div class="col-md-1">
                                     @if ($errors->has('collection_site'))
                                        <div class="form-group">
        	                            <span class="text-danger">{{ $errors->first('collection_site') }}</span>
                                        </div>
    	                             @endif
						             </div>

						             <div class="col-md-1">
						                 
						             </div>
						             <div class="col-md-1">
                                     @if ($errors->has('sale'))
                                        <div class="form-group">
        	                            <span class="text-danger">{{ $errors->first('sale') }}</span>
                                        </div>
    	                             @endif
						             </div>

                                </div>
				                <div class="row">
					                <div class="col-md-1">
					                  <label style="float: right;">振込人名称</label>
					                </div>
					                <div class="col-md-1">
					                	 <div class="form-group">
					                       <input type="text" value="{{$customer->transferee_name}}" name="transferee_name"  class="form-control">

					                     </div>
					                </div>
                                 
					                <div class="col-md-1">
					                  <label style="float: left;">振込人名称相違</label>
					                   <input type="checkbox" style="float: left;margin-left: 20px;" name="transferee" @if ($customer->transferee == true) checked @endif  class="minimal">

					                </div>

					                <div class="col-md-1">
					                  <label style="float: left;">反社チェック済み</label>
					                  <input type="checkbox" style="float: left;margin-left: 20px;" name="antisocial" @if ($customer->antisocial == true) checked @endif  class="minimal">
					                </div>
                                    
                                    <div class="col-md-1">
					                  <label style="float: left;">信用調査有無</label>
					                  <input type="checkbox" style="float: left;margin-left: 20px;" name="credit" @if ($customer->credit == true) checked @endif class="minimal">
					                </div>
				                </div>
				                <div class="row">
					                <div class="col-md-1">
					                 
					                </div>
					                <div class="col-md-1">

                                      @if ($errors->has('transferee_name'))
                                        <div class="form-group">
                                        <span class="text-danger">{{ $errors->first('transferee_name') }}</span>
                                        </div>
	                                  @endif
					                </div>
                                     
				                </div>
				               <div class="row">
					                <div class="col-md-1">
					                  <label style="float: right;">RM与信限度額</label>
					                </div>
					                <div class="col-xs-2">
					                	 <div style="float: left;" class="form-group">
					                       <input disabled  style="text-align: right" 

					                        @if($customer->credit_check())

					                        value="{{number_format($customer->credit_check()->credit_limit / 1000)}}" 

					                       	@else 

					                       	@endif

					                   class="form-control">
					                       
					                     </div>
					                </div>

					                <div class="col-md-1">
					                  <label style="float: right;">取引想定合計金額</label>
					                </div>
					                <div class="col-xs-2">
					                	 <div style="float: left;" class="form-group">
					                       <input disabled type="text" style="text-align: right" value="{{number_format($transaction/1000)}}" class="form-control">
					                     </div>
					                </div>

				                </div>
				                <div class="row">
					                <div class="col-md-1">
					                  <label style="float: right;">格付け情報</label>
					                </div>
					                <div class="col-xs-2">
					                	 <div class="form-group">
					                      
					                       <p class="form-control">
					                       	@if($customer->credit_check())

					                       	{{$customer->credit_check()->rank}}

					                       	@else 

					                       	@endif

					                       </p>
					                        
					                     </div>
					                </div>
                                    <div class="col-md-1 ">
					                  <label style="float: right;">与信情報取得日</label>
					                </div>
					                <div class="col-xs-2">
					                	 <div style="float: left;" class="form-group">
					                       <input disabled 
					                       type="text" 
					                        @if($customer->credit_check())

					                       	  value="{{$customer->credit_check()->get_time}}"

					                       	@else 

					                       	@endif
					                     
					                        class="form-control">
					                       
					                     </div>
					                </div>

				                </div>
				                <div class="row">
					                <div class="col-md-1">
					                  <label class="input_lable">希望限度額<sup>※</sup></label>
					                </div>
					                <div class="col-xs-2">
					                	 <div style="float: left;" class="form-group">
					                       <input disabled  style="text-align: right" 
					                        @if($customer->credit_check())

					                          value="{{number_format($customer->credit_check()->credit_expect / 1000)}}"

					                       	@else 

					                       	@endif
					                   
					                       type="text"   class="form-control">
					                       
					                     </div>
					                </div>

                                    <div class="col-md-1 ">
					                  <label style="float: right;">与信限度期間</label>
					                </div>
					                <div class="col-xs-2">
					                	 <div style="float: left;" class="form-group">
					                       <input disabled 
					                        @if($customer->credit_check())

					                          value="{{$customer->credit_check()->expiration_date}}"

					                       	@else 

					                       	@endif
					                   
					                       type="text"   class="form-control">
					                       
					                     </div>
					                </div>

				                </div>						                
				                <div class="row" id="change_reason" >
                                	  <div class="col-md-3 offset-md-3">
                                           <label style="float: right;">備考</label>
                                	  </div>
                                	  <div class="col-xs-2">
						                	<textarea rows="5" cols="120" name="note">{{$customer->note}}
						                	</textarea>
						               </div>

                                </div>
                             <input type="hidden" name="get_time" 
                                    @if($customer->credit_check())

						                 value="{{$customer->credit_check()->get_time}}"

						            @else 

						            @endif
                             >
                             <input type="hidden" name="rank"   
                                    @if($customer->credit_check())

						                 value="{{$customer->credit_check()->rank}}"

						            @else 

						            @endif   
                             >
                             <input type="hidden" name="credit_limit" 
                                    @if($customer->credit_check())

						                 value="{{$customer->credit_check()->credit_limit}}" 

						            @else 

						            @endif 
                             >
                             <input type="hidden" name="expiration_date" 
                                    @if($customer->credit_check())

						                value="{{$customer->credit_check()->expiration_date}}"

						            @else 

						            @endif 
                            >
                            <input type="hidden" name="id" 
                                   
						                value="{{$customer->id}}"
                            >
                            <input id="client_code_main" type="hidden" name="client_code_main" value="">
				             </form>
				              <br>
                             <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-1">
	
				                 <a><button onclick="project_index_url()"  type="button" style="float: left;width: 70%;" class="btn btn-warning">プロジェクト一覧</button></a>
				                </div>
                                <div class="col-md-1">
	
				                 <a><button onclick="credit_log_url()" type="button" style="float: left;width: 70%;" class="btn btn-warning">与信履歴</button></a>

				                </div>
				                <div class="col-md-1">
	
				                 <a><button onclick="contract_index_url()" type="button" style="float: left;width: 70%;" class="btn btn-warning">契約書一覧</button></a>
				                </div>

				                <div class="col-md-1">

				                 <a><button onclick="receivable_index_url()" type="button" style="float: left;width: 70%;" class="btn btn-warning">売掛金情報</button></a>

				                </div>
				                <div class="col-md-1">
	
				                 <a><button onclick="credit_index_url()" type="button" style="float: left;width: 70%;" class="btn btn-warning">与信一覧</button></a>

				                </div>

                             </div>
                             <br>
                             <div class="row" id="t2">

                                <div class="col-md-1">
                                
                                </div>
                                <div class="col-md-1">
	
							      <span class="btn btn-primary btn-file" >
									契約UP
									<input  type="file" id="input_file" name="file_data"
									 accept="application/pdf">
									@csrf
								  </span>
			                 		<p>※本画面からUPされた契約書は、<br>全ユーザー参照できます。</p>

				                </div>


				                <div class="col-md-1">

				                 <a ><button onclick="project_create_url()" type="button" style="float: left;width: 70%;" class="btn btn-primary">プロジェクト登録</button></a>

				                </div>
				                <div class="col-md-1">
	
				                 <a ><button onclick="create_credit()" type="button" style="float: left;width: 70%;" class="btn btn-primary">与信情報登録</button></a>

				                </div>

				                <div class="col-md-1">
	
				                 <a><button id="csv" type="button" style="float: left;width: 70%;" class="btn btn-success">CSV出力</button></a>

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
	
				                 <a href="{{ url('customer/infor') }}"><button type="button" style="float: left;width: 200px;" class="btn btn-danger">戻る</button></a>

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
    
<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
<script type="text/javascript">
      $( document ).ready(function() {

          $("#client_code").prop("readonly", true);
          $( "#get_number" ).click(function(event) {
                      
                      var client_code = $("#client_code").val();
                         console.log(client_code);


				      $("#status_2" ).remove();
                      $("#status_3" ).remove();
                      $("#status").append("<option value='1' selected id='status_1'>取引中</option>");
                      $("#status").append("<option value='1'  id='status_4'>取引終了</option>");
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

			   	     if($( "#status" ).val()=='3'){

					       	$( "#status_2" ).remove();
                            $( "#status_3" ).remove();
                            $("#status").append("<option value='1' selected id='status_1'>取引中</option>");
                            $("#status").append("<option value='1'  id='status_4'>取引終了</option>");
                            return;
					  }

		  });

		$( "#csv" ).click(function(event) {
                   
                 client_id = $("#hidden_id").val();
                 document.location.href = "/customer/csv2?client_id="+client_id;

		  });
        
        $( "#form_submit" ).click(function(event) {
                   
              $( "#edit_customer" ).submit();

		 });


        if($( "#status" ).val()=='1'){

            $( "#status_2" ).remove();
            $( "#status_3" ).remove();

          
        }

        if($( "#status" ).val()=='2'){

            $( "#status_1" ).remove();
            $( "#status_4" ).remove();
            $( "#get_number" ).show();
          
        }
        
        if($( "#status" ).val()=='3'){

            $( "#status_1" ).remove();
            $( "#status_2" ).remove();
            $( "#status_4" ).remove(); 
            $( "#get_number" ).show();
        }

        if($( "#status" ).val()=='4'){

            $( "#status_2" ).remove();
            $( "#status_3" ).remove();
        }
        if(cro_value.check == 1){

            $( "input" ).prop( "disabled", true );
            $( "select" ).prop( "disabled", true );
            $( "textarea" ).prop( "disabled", true );
            $( "#t2" ).hide();
            $( "#get_number" ).hide();
            $( "#form_submit" ).hide();
            $( "#group_id" ).attr("id","new_group_id");
            $("#new_group_id").prop("disabled", true);
            $( "#department_id" ).attr("id","new_department_id");
            $("#new_department_id").prop("disabled", true);
            $( "#headquarter_id" ).attr("id","new_headquarter_id");
            $("#new_headquarter_id").prop("disabled", true);
        }

        $( "#input_file" ).change(function() {
			  
			var pdf   = $('#input_file')[0].files[0];
			var form  = new FormData();

			form.append('pdf', pdf);
            form.append('type', 1);
            form.append('client_id', $("#hidden_id").val());
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

      });

    function project_create_url() {

		    var base        =  '{!! route("create_project") !!}';
            var company_id  =  $( "#company_id" ).val();
            var customer_id =  $( "#hidden_id" ).val();
            var url         =  base+'?company_id='+company_id+'&customer_id='+customer_id;

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

    function credit_log_url() {

		    var base        =  '{!! route('Credit_log') !!}';
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

</script>
<script src="{{ asset('select/icontains.js') }}" ></script>

<script src="{{ asset('select/comboTreePlugin.js') }}" ></script>


@endsection
