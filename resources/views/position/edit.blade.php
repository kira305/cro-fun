@extends('layouts.app')

@section('content')
@section('breadcrumbs', Breadcrumbs::render('position/edit'))
     
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
						        <form id="create_user" method="post" action="{{ url('position/edit') }}" enctype="multipart/form-data">

								             
						                <div class="row">
						              
								                <div class="col-md-3 offset-md-3">
								                  <label style="float: right;"><b>所属会社</b></label>
								                </div>
								                <div class="col-xs-2" >
												<div class = "form-control" disabled>
													{{$position->company->abbreviate_name}}
												</div>

								                </div>

								        </div>
								        <br>
						                
						                <div class="row">
								                <div class="col-md-3 offset-md-3">
								                  <label style="float: right;"><b>役職</b></label>
								                </div>  @csrf
								                <div class="col-xs-2">
								                	 <div class="form-group">
								                       <input type="text" name="position_name"  value="{{ $position->position_name }}" class="form-control">
								                       <input type="hidden" name="id"  value="{{ $position->id }}" class="form-control">
								                     </div>
								                </div>
								                @if ($errors->has('position_name'))

                	                            <span class="text-danger">{{ $errors->first('position_name') }}</span>

            	                                @endif
						                </div>
                                        
								        <div class="row">
						              
								                <div class="col-md-3 offset-md-3">
								                  <label style="float: right;"><b>参照範囲</b></label>
								                </div>
								                <div class="col-xs-2">
								                	 <div class="form-group">
								                       	<select class="form-control" name="look">

										                  	<option 
										                  	{{ $position->company_look == true ? 'selected' : '' }}
										                  	value="1">全事業本部</option>
										                  	<option
										                  	{{ $position->headquarter_look == true ? 'selected' : '' }}
										                  	 value="2">所属事業本部のみ</option>
										                  	<option 
										                  	 {{ $position->department_look == true ? 'selected' : '' }}
										                  	value="3">所属部署のみ</option>
										                  	<option 
										                  	 {{ $position->group_look == true ? 'selected' : '' }}
										                  	value="4">所属Grpのみ</option>

										                  </select>
								                     </div>
								                </div>
								                @if ($errors->has('look'))

                	                                <span class="text-danger">{{ $errors->first('look') }}</span>

            	                                @endif

								           
								        </div>
						                <div class="row">
						              
								                <div class="col-md-3 offset-md-3">
								                  <label class="input_lable">与信限度額越えメールフラグ</label>
								                </div>
								                <div class="col-xs-2">
								                 <div class="form-group">
                                                    <input type="checkbox" name="mail_flag" id="mail_flag" @if ($position->mail_flag == true) checked @endif
                                                    class="minimal">
								                </div>
								                </div>
								           
								        </div>  
                                    
						                <div class="row">
						                	　　　<br>
								                <div class="col-sm-3">
								                
								                  <button type="submit" style="float:right;width: 200px;" class="btn btn-primary">登録</button>
								                </div>
                                                <div class="col-sm-5">
								                
								                 <a style="float: left;width: 200px;" class="btn btn-danger" href="{{ url('position/index?page='.request()->page) }}" >戻る</a>
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