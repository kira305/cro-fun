@extends('layouts.app')

@section('content')
@section('breadcrumbs', Breadcrumbs::render('company/edit'))
     
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
						        <form id="create_user" method="post" action="{{ url('company/edit') }}" enctype="multipart/form-data">

								             

						                 <div class="row">
								                <div class="col-md-3 offset-md-3">
								                  <label class="input_lable"><b>会社名</b></label>
								                </div>
								                <div class="col-xs-2">
								                	 <div class="form-group">
								                       <input type="text" name="company_name" value="{{$company->company_name}}" class="form-control">
								                       <input type="hidden" name="own_company" value="{{$company->own_company}}" class="form-control">
								                       @csrf
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
								                       <input type="text" name="abbreviate_name" value="{{ $company->abbreviate_name }}" class="form-control">
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
								                	     <input style="float: left;" type="file" name="logo">
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

                                        <br>
                                       <div class="row" id="change_reason" >
                                        	  <div class="col-md-3 offset-md-3">
                                                   <label class="input_lable">変更理由</label>
                                        	  </div>
                                        	  <div class="col-xs-2">
								                	<textarea rows="5" cols="63" name="note">{{ $company->note }}</textarea>
								               </div>
                                        </div>
                                       

						                <div class="row">
						                	　　　<br>
								                <div class="col-sm-3">
								                
								                  <button type="submit" style="float:right;width: 200px;" class="btn btn-primary">更新</button>
								                </div>
                                                <div class="col-sm-5">
								                
                                                <a style="float: left;width: 200px;" class="btn btn-danger" href="{{ url('company/index?page='.request()->page) }}" >戻る</a>
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
<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
<script type="text/javascript">

</script>
<script src="{{ asset('select/icontains.js') }}" ></script>

<script src="{{ asset('select/comboTreePlugin.js') }}" ></script>


@endsection
