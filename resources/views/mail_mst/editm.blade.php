@extends('layouts.app')

@section('content')
@section('breadcrumbs', Breadcrumbs::render('mail_mst/editm'))
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
						        <form id="create_user" method="post" action="{{ url('mail_mst/editm') }}" enctype="multipart/form-data" name="MainForm">
				                       <input type="hidden" name="id" value="{{$mail_mst->id}}">
				                       <input type="hidden" name="mode1" value="update">
				                       <input type="hidden" name="mode2" value="">
								        <div class="row">
								                <div class="col-md-3 offset-md-3">
								                  <label style="float: right;">ID</label>
								                </div>
								                <div class="col-xs-5">
								                     <div class="form-group">
								                       {{$mail_mst->id}}
								                     </div>
								                </div>
								                @if ($errors->has('mail_ma_name'))
                	                                <span class="text-danger" >{{ $errors->first('mail_ma_name') }}</span>
            	                                @endif
						                </div>
								        <div class="row">
								                <div class="col-md-3 offset-md-3">
								                  <label style="float: right;">管理名称</label>
								                </div>
								                <div class="col-xs-5">
								                     <div class="form-group">
								                       <input type="text" name="mail_ma_name" value="{{$mail_mst->mail_ma_name}}" class="form-control">
								                       @csrf
								                     </div>
								                </div>
								                @if ($errors->has('mail_ma_name'))
                	                                <span class="text-danger" >{{ $errors->first('mail_ma_name') }}</span>
            	                                @endif
						                </div>
								        <div class="row">
								                <div class="col-md-3 offset-md-3">
								                  <label style="float: right;">メールタイトル</label>
								                </div>
								                <div class="col-xs-7">
								                     <div class="form-group">
								                       <input type="text" name="mail_remark" value="{{$mail_mst->mail_remark}}" class="form-control">
								                       @csrf
								                     </div>
								                </div>
								                @if ($errors->has('mail_remark'))
                	                                <span class="text-danger" >{{ $errors->first('mail_remark') }}</span>
            	                                @endif
						                </div>
								        <div class="row">
								                <div class="col-md-3 offset-md-3">
								                  <label style="float: right;">メール本文</label>
								                </div>
								                <div class="col-xs-7">
								                     <div class="form-group">
													   <textarea name="mail_text" rows="10" cols="70">{{$mail_mst->mail_text}}</textarea>
								                       @csrf
								                     </div>
								                </div>
								                @if ($errors->has('mail_text'))
                	                                <span class="text-danger" >{{ $errors->first('mail_text') }}</span>
            	                                @endif
						                </div>
								        <div class="row">
								                <div class="col-md-3 offset-md-3">
								                  <label style="float: right;"></label>
								                </div>
								                <table class="col-xs-7" border="1"  rules="none">
								                <tr>
								                	<th width="35%">パラメータ情報</td>
								                	<th width="25%"></td>
								                	<th width="25%"></td>
								                	<th width="15%"></td>
								                </tr>
								                <tr>
								                	<td class="text-center">##USER_ID##　:　</td>
								                	<td colspan="3">ログインユーザーID</td>
								                </tr>
								                <tr>
								                	<td class="text-center">##USER_NAME##　:　</td>
								                	<td colspan="3">ログインユーザー名</td>
								                </tr>
								                <tr>
								                	<td class="text-center">##USER_PASSWORD##　:　</td>
								                	<td colspan="3">ログインユーザーパスワード</td>
								                </tr>
								                </table>
						                </div>

						                <div class="row">
						                	<br>
								                <div class="col-md-5">
								                
								                  <button type="submit" style="float:right;width: 200px;" class="btn btn-primary" name="mode1" value="update">更新</button>
								                </div>
                                                <div class="col-md-5">
                                                   <a style="float: left;width: 200px;" class="btn btn-danger" href="{{ url('mail_mst/indexm') }}" >戻る</a>
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

     });
</script>

@endsection
