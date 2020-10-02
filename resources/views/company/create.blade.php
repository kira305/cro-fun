@extends('layouts.app')

@section('content')
@section('breadcrumbs', Breadcrumbs::render('company/create'))
     
      <div class="row">
        <div class="col-md-12">
       
          <ul class="timeline">
	          	<li>
	             
	              <div class="timeline-item">
	               
	                <div class="timeline-body">
	                      <div>
				          
				            <div class="box-body">
				            	@if (isset($message))


								      <p class="message" >{{ $message }}</p>

					
								@endif
						        <form id="create_user" method="post" action="{{ url('company/create') }}" enctype="multipart/form-data">

								             

						                 <div class="row">
								                <div class="col-md-3 offset-md-3">
								                  <label class="input_lable"><b>会社名</b></label>
								                </div>
								                <div class="col-xs-2">
								                	 <div class="form-group">
								                	 	 @csrf
								                       <input type="text" name="company_name"  value="{{ old('company_name') }}" class="form-control" maxlength="25">
								                     </div>
								                </div>
								                @if ($errors->has('company_name'))

                	                                    <span class="text-danger">{{ $errors->first('company_name')  }}</span>

            	                                @endif
						                </div>
                                        
						                <div class="row">
								                <div class="col-md-3 offset-md-3">
								                  <label class="input_lable"><b>省略名</b></label>
								                </div>
								                <div class="col-xs-2">
								                	 <div class="form-group">
								                       <input type="text" maxlength="10" name="abbreviate_name"  value="{{ old('abbreviate_name') }}" class="form-control">
								                     </div>
								                </div>
								                @if ($errors->has('abbreviate_name'))

                	                              <span class="text-danger">{{ $errors->first('abbreviate_name')  }}</span>

            	                                @endif
						                </div>

					                    <div class="row">

								                <div class="col-md-3 offset-md-3">
								                  <label class="input_lable"><b>ロゴファイル</b></label>								                  
								                </div>
								                <div class="col-xs-2">
								                	<div class="form-group">
								                	     <input style="float: left;" id="logo" value="{{ old('logo') }}" type="file" name="logo">
								                	 </div>
								                </div>
								                
						                </div>

					                    <div class="row">
							                <div class="col-md-3 offset-md-3"></div>
							                <div class="col-xs-2">
							                	<div class="form-group">
							                	     <label >推奨サイズは、1770*452ピクセルになります。</label>
							                	 </div>
							                </div>
					                	</div>
                                        
   
						                @if ($errors->has('logo'))
					                    <div class="row">
							                <div class="col-md-3 offset-md-3"></div>
							                <div class="col-xs-2">
							                	<div class="form-group">
							                	     <span class="text-danger">{{ $errors->first('logo')  }}</span>
							                	 </div>
							                </div>
					                	</div>
    	                                @endif
                                     
						                <div class="row">
						                	　　<br>
								                <div class="col-sm-3">
								                
								                  <button type="submit" style="float:right;width: 200px;" class="btn btn-primary">登録</button>
								                </div>
                                                <div class="col-sm-5">

								                 <a style="float: left;width: 200px;" class="btn btn-danger" href="{{ url('company/index') }}" >戻る</a>
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


@endsection
