@extends('layouts.app')


@section('content')
@section('breadcrumbs', Breadcrumbs::render('custom_name/index'))

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

						        <form action="{{ url('custom_name/index') }}" id="form" method="post">
						        	  	<div class="row">
							                <div class="col-md-3 offset-md-3">
							                  <label style="float: right;">所属会社</label>
							                </div>
							                <div class="col-md-2">
							                	<div class="form-group">
								                    <select class="form-control" id="company_id" name="company_id" >
											        @foreach($companies as $company)
								                    <option 
								                     
								                    @if(session()->has('company_id_name'))

													   @if(session('company_id_name') == $company->id) selected  @endif 

													@else 
													       @if(Auth::user()->company_id == $company->id) selected  @endif 
													@endif

								                    value="{{$company->id}}">{{$company->abbreviate_name}}

								                    </option>
								                  
							                          @endforeach
													</select>
											    </div>
							                </div>
							                
						                </div>

								        <div class="row">
						                  
                                                <div class="col-md-1">
								                  <label style="float: right;">顧客コード</label>
								                </div>
								                <div class="col-md-2">
								                	 <div class="form-group">
								                       <input type="text" value="{{session('client_code_name')}}" name="client_code" id="client_code"  class="form-control" >
								                     </div>
								                </div>
                                                
                                            @csrf
                                                <div class="col-md-1">
								                  <label style="float: right;">法人番号</label>
								                </div>
								                <div class="col-md-2">
								                	 <div class="form-group">
								                       <input type="text" value="{{session('corporation_num_name')}}" name="corporation_num" id="corporation_num"  class="form-control" >
								                     </div>
								                </div>
								           
								        </div>
								        <div class="row">
						                  
                                                <div class="col-md-1">
								                  <label style="float: right;">顧客名カナ</label>
								                </div>
								                <div class="col-md-8">
								                	<div class="form-group">
								                       <input id="client_name_kana"  value="{{session('client_name_kana_name')}}" name="client_name_kana" type="text"   class="form-control" >
								                     </div>
								                </div>
								           
								        </div>
								        <div class="row">
						                  
                                                <div class="col-md-1">
								                  <label style="float: right;">検索対象顧客名カナ</label>
								                </div>
								                <div class="col-md-8">
								                	<div class="form-group">
								                       <input id="target_client_name_kana" value="{{session('target_client_name_kana_name')}}" name="target_client_name_kana" type="text" size="80%"   class="form-control" >
								                     </div>
								                </div>
								           
								        </div>
								        
								        <br>
						                <div class="row">
						                	　　　<br>
								                <div class="col-md-5">
								                
								                  <button type="submit" id="search" style="float: right;width: 100px;" class="btn btn-primary btn-sm">検索</button>

								                </div>
								                <div class="col-md-5">
								                
								                  <button type="button" style="float: left;width: 100px;"  id="clear" class="btn btn-default btn-sm">クリア</button>

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
                 <div class="timeline-item">

	                <div class="timeline-body">
	
				            <div class="box-body">
						          <div class="row">
						            <div class="col-sm-1"></div>
				            		<div class="col-sm-2">
				            		</div>
				            		<div class="col-sm-5"></div>
				            		<div style="float: right" class="col-sm-3">
							        
							          	   @paginate(['item'=> $custom_name]) @endpaginate

							        </div>
							        <div class="col-sm-1"></div>
						          </div>    
						          <div class="row">  
					              <table id="customer_name_table" class="table table-bordered table-hover">
					                <thead>
					                <tr>
					                  <th>顧客コード</th>
					                  <th>顧客名</th>
					                  <th>顧客名ｶﾅ</th>
					                  <th>検索対象顧客名ｶﾅ</th>
					                  <th>検索対象外</th>
					                  <th></th>
					                </tr>
					                </thead>

					                <tbody>
                                    @foreach ($custom_name as $customname)
						                <tr>
						                  <td>
						                  	@if($customname->customer->client_code_main == null)
							                  	{{  $customname->customer->client_code }}
						                  	@else
						                  		{{  $customname->customer->client_code_main }}
						                  	@endif 
						                  </td>
						                  <td>{{  $customname->customer->client_name }}</td>
						                  <td>{{  $customname->customer->client_name_kana }}</td>
						                  <td>{{  $customname->client_name_hankaku_s }}</td>
						                  <td>
						                  	@if($customname->del_flag == false)
							                  	{{ "検索対象" }}
						                  	@else
							                  	{{ "検索対象外" }}
						                  	@endif						                  
						                  <td>
						                  	@if($customname->client_name_hankaku_s != $customname->customer->client_name_kana)
							                  	@if($customname->del_flag == false)
								                  	<button  data-value = "{{$customname->id}}"  class="btn btn-danger delete btn-sm">削除</button>
							                  	@endif
						                  	@endif
						                  </td>
  						                </tr>
                                    @endforeach
					                </tbody>

					              </table>
					           </div>
				            </div>
	               
	              </div>				          
	            </li>
	            <li>		             
	            </li>
          </ul>
        </div>
      </div>
  <script type="text/javascript">
 

   $(document).on('click', '#clear', function () {
		//1ページに移動
         $('#example2').DataTable().state.clear();
         $('#company_id').prop('selectedIndex',0);
         $('#client_code').val('');
		 $('#corporation_num').val('');
         $('#client_name_kana').val('');
         $("#target_client_name_kana" ).val('');
         $( "#form" ).submit();

	});

	$(".delete").click(function(){

		var id = $(this).data('value');

		$.confirm({
		    title: 'このデータを削除しますか',
		    content: '',
		    type: 'red',
		    typeAnimated: true,
		    buttons: {
		        delete: {
		            text: 'YES',
		            btnClass: 'btn-blue',
		            with :'100px',
		            action: function(){
			            
			            document.location.href = "/custom_name/delete?id="+id;
		            }
		        },
		        cancel: {
		            text: 'NO',
		            btnClass: 'btn-red',
		            action: function(){
		            }
		        }
		    }
		});
	});
  </script>
@endsection
