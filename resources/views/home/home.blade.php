@extends('layouts.app')


@section('content')
@section('breadcrumbs', Breadcrumbs::render('home'))
<style type="text/css">
	table{
		width: 100%;
		word-break: break-word;
		word-wrap: break-word;
		margin-bottom : 0px!important;;
	}
	.panel-body{
		padding : 5px!important; 
	}
	.panel{
		padding : 5px!important;
		margin-bottom : 5px;
	}
	.col-lg-6{
		padding-right:1px!important;
		padding-left:1px!important;
	}
	.breadcrumb{
		margin-bottom : 0px;
	}
	.hfsz { 
		font-size: 9pt; 
		padding : 3px!important; 
		word-wrap: break-word;
		overflow-wrap: break-word;
		white-space: normal;
	}
</style>
<div class="panel panel-info">
  <div class="panel-heading">お知らせ</div>
  <div class="panel-body">
	<table cellpadding="3" class="table hfsz table-hover" width="50%" style="table-layout: auto;">
<!--
	<tr>
		<td width="5%" class="active hfsz text-center">添付</td>
		<td width="83%" class="active hfsz">内容</td>
		<td width="10%" class="active hfsz text-center">登録日</td>
	</tr>
-->
	@foreach($global_info as $set_data)
		@switch($set_data->important_flg)
			@case("1")
				<tr class="danger">
				@break
			@case("2")
				<tr class="warning">
				@break
			@case("3")
				<tr class="active">
				@break
			@default
				<tr class="active">
				@break
		@endswitch
		@if (!empty($set_data->save_ol_name))
			<td class="hfsz text-center"  width="5%">
			<a href="{{route('global_info.download', ['id' => $set_data->id,'ol_name' =>"__" ,'sv_name' => "__"])}}" title="{{$set_data->save_ol_name}}">
			<span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span>
			</a>
			</td>
		@else
			<td  width="5%"></td>
		@endif
		
		<td class="hfsz" width="83%">{{$set_data->global_info_title }}{{"  :  "}}{!!$set_data->global_info_content_change!!}</td>
		<td class="hfsz" width="10%">{{date('Y/m/d', strtotime($set_data->updated_at))}}</td>
		</tr>
	@endforeach
	</table>
  </div><!--/panel-body-->
</div><!--/panel-->

<div class="container-fluid">
	<div class="row">
		<div class="col-lg-6">
			<div class="panel panel-success">
				<div class="panel-heading">仮登録一覧</div>
					<div class="panel-body">
						<table class="table hfsz htsz table-hover table-striped" style="table-layout:fixed;width:100%;">
						<tr>
							<td width="18%" class="active hfsz">登録日</td>
							<td width="28%" class="active hfsz">顧客名</td>
							<td width="27%" class="active hfsz">申請部署</td>
							<td width="27%" class="active hfsz">申請Gr</td>
						</tr>
						<tr>
                            @foreach ($customer as $customer_date)
				                <tr>
				                  <td class="col-xs-1 hfsz">{{  date('Y年m月d日',strtotime($customer_date->created_at)) }}</td>
				                  <td class="col-xs-1 hfsz">
				                  	@if($customer_date->client_name_ab == null)
					                  	{{  $customer_date->client_name }}
				                  	@else
				                  		{{  $customer_date->client_name_ab }}
				                  	@endif 
				                  </td>
				                  <td class="col-xs-1 hfsz">{{  $customer_date->com_grp()->department_name }}
				                  </td>
				                  <td class="col-xs-1 hfsz">{{  $customer_date->com_grp()->group_name }}</td>
				                </tr>
                            @endforeach
						</table>
					</div><!--/panel-body-->
				</div><!--/panel-->        
			</div>
		<div class="col-lg-6">
			<div class="panel panel-warning">
				<div class="panel-heading">与信限度額要確認</div>
					<div class="panel-body">
						<table class="table hfsz htsz table-hover table-striped" style="table-layout:fixed;width:100%;">
						<tr>
							<td width="25%" class="active hfsz">顧客名</td>
							<td width="17%" class="active hfsz">対象月</td>
							<td width="19%" class="active hfsz text-right">与信限度額</td>
							<td width="18%" class="active hfsz text-right">取引想定額</td>
							<td width="19%" class="active hfsz text-right">売掛金残</td>
						</tr>
                        @foreach ($over_receivable as $key => $value)
			                <tr>
			                  <td class="col-xs-1 hfsz">
			                  	@if($value->client_name_ab == null)
				                  	{{  $value->client_name }}
			                  	@else
			                  		{{  $value->client_name_ab }}
			                  	@endif 
			                  </td>
				              <td class="col-xs-1 hfsz">
				              
				              	@if($receivable_date[$key]->target_data != null)
									{{  date('Y年m月',strtotime($receivable_date[$key]->target_data)) }}
								@endif	 
				              </td>
				              <td class="col-xs-1 hfsz text-right" >{{ number_format($value->credit_expect/1000) }}</td>
			                  <td class="col-xs-1 hfsz text-right"
                                @if($transaction_date[$key] > $value->credit_expect)
                                style = "background-color: #FFB6C1;"
                                @endif
			                  >{{ number_format($transaction_date[$key]/1000) }}</td>

			                  <td class="col-xs-1 hfsz text-right"
			                  @if($receivable_date[$key]->receivable != "")
			                    @if($receivable_date[$key]->receivable > $value->credit_expect)
                                style = "background-color: #FFB6C1;"
                                @endif
                              @endif
			                  >
				              	@if($receivable_date[$key]->receivable != "")
			                  	{{  number_format($receivable_date[$key]->receivable/1000)}}
								@endif	 
			                  </td>
			                </tr>
                        @endforeach
						</table>
					</div><!--/panel-body-->
				</div><!--/panel-->
			</div>
		</div>
	</div>
</div>




@endsection
