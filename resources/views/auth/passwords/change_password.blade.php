@extends('layouts.app')

@section('content')
@section('breadcrumbs', Breadcrumbs::render('password/change'))
     
      <div class="row">
        <div class="col-md-12">
       
          <ul class="timeline">
	          	<li>
	             
	              <div class="timeline-item">
	               
	                <div class="timeline-body">
	                      <div>
				          
				            <div class="box-body">
				            	    @if (isset($message))


								              <p class="" style="text-align: center;color: green">{{ $message }}</p>

					
								    @endif
						        <form id="create_user" method="post" action="{{ url('password/change') }}" enctype="multipart/form-data">

								             
								        <div class="row">
								                <div class="col-md-3 offset-md-3">
								                  <label style="float: right;">社員番号</label>
								                </div>
								                <div class="col-xs-2">
								                     <div class="form-group">
								                       <input type="text" disabled  value="{{ Auth::user()->usr_code }}" class="form-control">
								                       <input type="hidden" name="usr_code" value="{{ Auth::user()->usr_code }}">
								                       <input type="hidden" name="id" value="{{ Auth::user()->id }}">
								                       @csrf
								                     </div>
								                </div>
								                @if ($errors->has('usr_code'))

                	                                  <span class="text-danger">{{ $errors->first('usr_code') }}</span>

            	                                @endif
						                </div>
						                 <div class="row">
								                <div class="col-md-3 offset-md-3">
								                  <label style="float: right;">現在のPW</label>
								                </div>
								                <div class="col-xs-2">
								                	 <div class="form-group">
								                       <input  name="now_pass" type="password" value="{{ old('now_pass')}}" class="form-control">
								                     </div>
								                </div>
								                @if ($errors->has('now_pass'))

                	                                 <span class="text-danger">{{ $errors->first('now_pass') }}</span>

            	                                @endif
            	                                @if ($errors->has('correct'))

                	                                 <span class="text-danger">{{ $errors->first('correct') }}</span>

            	                                @endif
						                </div>
                                        
						                <div class="row">
								                <div class="col-md-3 offset-md-3">
								                  <label style="float: right;">新しいPW</label>
								                </div>
								                <div class="col-xs-2">
								                	 <div class="form-group">
								                       <input  name="new_pass_1" type="password" value="{{ old('new_pass_1')}}" class="form-control">
								                     </div>
								                </div>
								                @if ($errors->has('new_pass_1'))

                	                                 <span class="text-danger">{{ $errors->first('new_pass_1') }}</span>

            	                                @endif
						                </div>

                                        <div class="row">
								                <div class="col-md-3 offset-md-3">
								                  <label style="float: right;">新しいPW確認</label>
								                </div>
								                <div class="col-xs-2">
								                	 <div class="form-group">
								                       <input  name="new_pass_2" type="password" value="{{ old('new_pass_2')}}" class="form-control">
								                     </div>
								                </div>
								                @if ($errors->has('new_pass_2'))

                	                                  <span class="text-danger">{{ $errors->first('new_pass_2') }}</span>

            	                                @endif
            	                                @if ($errors->has('new_pass_retype'))

                	                                  <span class="text-danger">{{ $errors->first('new_pass_retype') }}</span>

            	                                @endif
						                </div>
                                         
                                     

						                <div class="row">
						                	　　　<br>
								                <div class="col-md-5">
								                
								                  <button type="submit" style="float:right;width: 200px;" class="btn btn-primary">登録</button>
								                </div>
                                                <div class="col-md-5">
								                
								                 <a href="{{ url('/home') }}"><button type="button" style="float: left;width: 200px;" class="btn btn-danger">戻る</button></a>
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
