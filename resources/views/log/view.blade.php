@extends('layouts.app')

@section('content')
@section('breadcrumbs', Breadcrumbs::render('log/view'))
     
      <div class="row">
        <div class="col-md-12">
       
          <ul class="timeline">
	          	<li>
	             
	              <div class="timeline-item">
	               
	                <div class="timeline-body">
                      <div>
			          
			            <div class="box-body">
					        <form id="create_user" method="post" action="{{ url('log/view') }}" enctype="multipart/form-data">

				                <div class="row">
				              
					                <div class="col-md-3 offset-md-3">
					                  <label style="float: right;">所属会社</label>
					                </div>
					                <div class="col-xs-2">
										<p class = "form-control">
											@if($log->company){{$log->company->abbreviate_name}}@endif
										</p>

					                </div>
				              
					                <div class="col-md-3 offset-md-3">
					                  <label style="float: right;">処理区分</label>
					                </div>
					                <div class="col-xs-2" >
										<p class = "form-control">
											{{$log->process}}
										</p>
					                </div>

						        </div>
				                
				                <div class="row">
					                <div class="col-md-3 offset-md-3">
					                  <label style="float: right;">操作画面</label>
					                </div>
					                  @csrf
					                <div class="col-xs-2" >
										<p class = "form-control">
											@if($log->menu){{$log->menu->link_name}}@endif
										</p>
					                </div>
                                				              
					                <div class="col-md-3 offset-md-3">
					                  <label style="float: right;">対応テーブル</label>
					                </div>
					                <div class="col-xs-2" >
										<p class = "form-control">
											@if($log->table){{$log->table->table_name}}@endif
										</p>
					                </div>

						        </div>
                            
				                <div class="row">
					                <div class="col-md-3 offset-md-3">
					                  <label style="float: right;">変更されたデータのコード</label>
					                </div>  
					                <div class="col-xs-2" >
										<p class = "form-control">
											{{$log->code}}
										</p>
					                </div>
                                				              
					                <div class="col-md-3 offset-md-3">
					                  <label style="float: right;">変更されたデータの名称</label>
					                </div>
					                <div class="col-xs-2" >
										<p class = "form-control">
											{{$log->name}}
										</p>
					                </div>
						        </div>

				                <div class="row">
					                <div class="col-md-3 offset-md-3">
					                  <label style="float: right; ">操作ユーザー</label>
					                </div>  
					                <div class="col-xs-2" >
										<p class = "form-control" style="overflow: hidden;">
											{{$log->user->usr_name}}
										</p>
					                </div>
                                				              
					                <div class="col-md-3 offset-md-3">
					                  <label style="float: right;">操作日</label>
					                </div>
					                <div class="col-xs-2" >
										<p class = "form-control">
											{{$log->created_at}}
										</p>
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
				            
			            <div class="box-body" style="overflow-x: auto;">
		                	@if(isset($new_date) == true)

							<table  width="100%">
								<tr>
									<td>
						              <table class="table table-bordered table-hover">
						                <thead>
						                <tr>
						                  <th>変更項目</th>
						                  <th>変更前データ</th>
						                  <th>変更後データ</th>
						                </tr>
						                </thead>
						                <tbody>
										        @foreach($base as $key => $value)
									              <tr
									              @if($log->process == config('constant.operation_UPDATE')) 
									              	@if(isset($old_date[$key])) 
										              	@if(isset($new_date[$key])) 
											              	@if(strcmp($new_date[$key],$old_date[$key]) !=0)
												              class = "difference" 
											              	@endif

										              	 @endif
									              	 @else
										              	 @if(isset($new_date[$key])&& $new_date[$key]!=null)
												              class = "difference" 
										              	 @endif	       	 
									              	 @endif
									              @endif
									              >
									                  <td>{{  $item[$key] }} </td>
										              <td>
										              	@if(is_array($old_date))
											                @if(isset($old_date[$key])) 
												              {{  $old_date[$key] }}
											                @endif
										                @endif
										          	  </td>
										              <td>
										                @if(isset($new_date[$key])) 
											              {{  $new_date[$key] }}
										                @endif 
										          	  </td>
									              </tr>
						                        @endforeach
						                </tbody>

						               </table>	
									</td>

							</tr>
						</table>
                        @endif
	
	
					    <div class="col-md-13"　>
					       <a style="float: right;width: 200px;" class="btn btn-danger" href="{{ url('loxg/index?page='.request()->page) }}" >戻る</a>
					    </div>
					                   
			            </div>

	                </div>
	               
	              </div>
					          
            </li>

          </ul>
        </div>
				          
      </div>

@endsection
