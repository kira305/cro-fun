@extends('layouts.app')
@section('content')
@section('breadcrumbs', Breadcrumbs::render('global_info/edit'))
	<script type="text/javascript">
	</script>

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
						        <form id="create_user" method="post" action="{{ url('global_info/edit') }}" enctype="multipart/form-data" name="MainForm">
				                       <input type="hidden" name="id" value="{{$global_info->id}}">
				                       <input type="hidden" name="mode1" value="update">
				                       <input type="hidden" name="mode2" value="">
				                       <input type="hidden" name="save_sv_name" value="{{$global_info->save_sv_name}}">
				                       <input type="hidden" name="save_ol_name" value="{{$global_info->save_ol_name}}">
								        <div class="row">
								                <div class="col-md-3 offset-md-3">
								                  <label style="float: right;">タイトル</label>
								                </div>
								                <div class="col-xs-5">
								                     <div class="form-group">
								                       <input type="text" name="global_info_title" value="{{$global_info->global_info_title}}" class="form-control">
								                       @csrf
								                     </div>
								                </div>
								                @if ($errors->has('global_info_title'))
                	                                <span class="text-danger" >{{ $errors->first('global_info_title') }}</span>
            	                                @endif
						                </div>
								        <div class="row">
								                <div class="col-md-3 offset-md-3">
								                  <label style="float: right;">内容</label>
								                </div>
								                <div class="col-xs-7">
								                     <div class="form-group">
								                       <input type="text" name="global_info_content" value="{{$global_info->global_info_content}}" class="form-control">
								                       @csrf
								                     </div>
								                </div>
								                @if ($errors->has('global_info_content'))
                	                                <span class="text-danger" >{{ $errors->first('global_info_content') }}</span>
            	                                @endif
						                </div>
								        <div class="row">
								                <div class="col-md-3 offset-md-3">
								                  <label style="float: right;">重要度</label>
								                </div>
								                <div style="padding-bottom: 15px;">
													<label class="radio radio-inline"></label>
													<label class="radio radio-inline"><input type="radio" name="important_flg" @if ($global_info->important_flg == "1") checked @endif value="1">重要</label>
													<label class="radio radio-inline"><input type="radio" name="important_flg" @if ($global_info->important_flg == "2") checked @endif value="2">注意</label>
													<label class="radio radio-inline"><input type="radio" name="important_flg" @if ($global_info->important_flg == "3") checked @endif value="3">お知らせ</label>
								                    @csrf
								                </div>
								                @if ($errors->has('important_flg'))
                	                                <span class="text-danger" >{{ $errors->first('important_flg') }}</span>
            	                                @endif
						                </div>
								        <div class="row">
								                       @csrf
								                <div class="col-md-3 offset-md-3">
								                  <label style="float: right;">掲載開始</label>
								                </div>
								                <div class="col-xs-1" style="width: 15%;">
								                     <div>
								                       <input type="text" id="start_date" name="start_date" 
								                       @if (!empty($global_info->start_date))
								                       		value="{{date('Y/m/d', strtotime($global_info->start_date))}}"
								                       @else
								                       		value=""
								                       @endif
								                       class="form-control">
								                     </div>
								                </div>
							                     <div class="form-group"  style="display: inline-block;width: 10%;">
								                  <select class="form-control" id="start_time" name="start_time">
								                  	<option value="">▼ 選択してください</option>
								                  	@foreach($TIME_ARRAY as $id => $data)
									                <option 
									                @if(isset($global_info->start_time) && !empty($global_info->start_time))
									                @if ($data == date('H:i', strtotime($global_info->start_time))) selected @endif 
									                @endif
									                value="{{$data}}">{{$data}}</option>
								                     @endforeach
								                  </select>
							                     </div>

								                @if ($errors->has('start_date'))
                	                                <span class="text-danger" >{{ $errors->first('start_date') }}</span>
            	                                @endif
						                </div>
								        <div class="row">
								                <div class="col-md-3 offset-md-3">
								                  <label style="float: right;">掲載終了</label>
								                </div>
								                <div class="col-xs-1"  style="width: 15%;">
								                     <div class="form-group">
								                       <input type="text" id="end_date" name="end_date" 
								                       @if (!empty($global_info->end_date))
								                       		value="{{date('Y/m/d', strtotime($global_info->end_date))}}" 
								                       @else
								                       		value="" 
								                       @endif
								                       class="form-control">
								                       @csrf
								                     </div>
								                </div>
							                     <div class="form-group"  style="display: inline-block;width: 10%;">
								                  <select class="form-control" id="end_time" name="end_time">
								                  	<option value="">▼ 選択してください</option>
								                  	@foreach($TIME_ARRAY as $id => $data)
									                <option 
									                @if(isset($global_info->end_time) && !empty($global_info->end_time))
									                @if ($data == date('H:i', strtotime($global_info->end_time))) selected @endif 
									                @endif
									                value="{{$data}}">{{$data}}</option>
								                     @endforeach
								                  </select>
							                     </div>
								                @if ($errors->has('end_date'))
                	                                <span class="text-danger" >{{ $errors->first('end_date') }}</span>
            	                                @endif
						                </div>
										@if (!empty($global_info->save_ol_name))
								        <div class="row">
								                <div class="col-md-3 offset-md-3">
								                  <label style="float: right;">添付ファイル</label>
								                </div>
								                <div class="col-md-3 offset-md-3">
									              <a href="{{route('global_info.download', ['id' => $global_info->id,'ol_name' =>$global_info->save_ol_name ,'sv_name' => $global_info->save_sv_name])}}" >{{$global_info->save_ol_name}}</a>
									              <button type="sybmit" class="btn btn-primary btn-xs"  name="mode2" value="file_delete">削除</button>
								                </div>
						                </div>
										@else
								        <div class="row">
								                <div class="col-md-3 offset-md-3">
												@if (empty($global_info->save_ol_name))
								                  <label style="float: right;">添付ファイル</label>
								                @endif
								                </div>
								                <div class="col-xs-3">
								                     <div class="form-group">
								                       <input style="float: left;" type="file" name="save_ol_name">
								                       @csrf
								                     </div>
								                </div>
						                </div>
						                @endif
								        <div class="row">
								                <div class="col-md-3 offset-md-3">
								                  <label style="float: right;">削除</label>
								                </div>
								                <div class="col-xs-3">
								                     <div class="form-group">
								                       <input type="checkbox" name="delete_flg" @if ($global_info->delete_flg == 1) checked @endif value="1" >
								                       @csrf
								                     </div>
								                </div>
						                </div>

						                <div class="row">
						                	<br>
								                <div class="col-md-5">
								                
								                  <button type="submit" style="float:right;width: 200px;" class="btn btn-primary" name="mode1" value="update">更新</button>
								                </div>
                                                <div class="col-md-5">
                                                   <a style="float: left;width: 200px;" class="btn btn-danger" href="{{ url('global_info/index') }}" >戻る</a>
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
<script type="text/javascript">

     $(document).ready(function(){

		//ファイル追加
		$('input[type=file]').change(function() {
			objForm = document.MainForm;
			objForm.mode1.value = "update";
			objForm.mode2.value = "file_add";
			objForm.action = '{{ url('global_info/edit') }}';
			objForm.submit();
		});

      $("#start_date").datepicker({
                    dateFormat: 'yy-mm-dd'
      });
      $("#end_date").datepicker({
                    dateFormat: 'yy-mm-dd'
      });
     	      var headquarter = $("#department_id").find(':selected').attr('data-value');
         
     	      $("#fake_name").text(headquarter);
          
			  $("#department_id").change(function(){
			       
			       // alert($(this).children("option:selected").data("value"));
			       var headquarter_name = $(this).children("option:selected").data("value");

                   $("#fake_name").text(headquarter_name);
                   $("#headquarter_name").val(headquarter_name);
             

			  });


     });

     $(document).on('change', '#status', function () {
         
         ckb = $("#status").is(':checked');

         if(ckb == true){
           
                    $('#change_group').show();
                  

         }else {
                    
                    $('#change_group').hide();
                 

         }
         


     });
</script>

@endsection
