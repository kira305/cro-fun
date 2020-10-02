@extends('layouts.app')


@section('content')
@section('breadcrumbs', Breadcrumbs::render('customer/infor'))
<style type="text/css">
    /* table{
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
	td {
		padding : 3px!important;
		word-wrap: break-word;
		overflow-wrap: break-word;
		white-space: normal;
	} */
</style>
<div class="row">
    <div class="col-md-12">

        <ul class="timeline">
            <li>

                <div class="timeline-item">

                    <div class="timeline-body">
                        <div>

                            <div class="box-body">

                                <form action="{{ url('customer/infor') }}" id="form" method="POST">
                                    {{-- row 1 --}}
                                    <div class="col-lg-10 col-lg-offset-1 col-md-12">
                                        <div class="row search-row">
                                            <div class="col-md-12 col-lg-6 search-form">
                                                <div class="search-title col-lg-3 col-sm-3">
                                                    <span class="">所属会社</span>
                                                </div>
                                                <div class="col-lg-9 col-sm-9 search-item">
                                                    <select class="form-control" id="company_id" name="company_id">
                                                        @foreach($companies as $company)
                                                        <option @if(session()->has('company_id_c'))
                                                            @if(session('company_id_c') == $company->id) selected @endif
                                                            @else
                                                            @if(Auth::user()->company_id == $company->id) selected @endif
                                                            @endif
                                                            value="{{$company->id}}">{{$company->abbreviate_name}}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-lg-6 search-form">
                                                <div class="search-title col-lg-3 col-sm-3">
                                                    <span class="">法人番号</span>
                                                </div>
                                                <div class="col-lg-9 col-sm-9 search-item">
                                                    <input sale="text" value="{{session('personal_code_c')}}"
                                                    name="personal_code" id="personal_code"
                                                    class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- row 2 --}}
                                    <div class="col-lg-10 col-lg-offset-1 col-md-12">
                                        <div class="row search-row">
                                            <div class="col-md-12 col-lg-6 search-form">
                                                <div class="search-title col-lg-3 col-sm-3">
                                                    <span class="">顧客コード</span>
                                                </div>
                                                <div class="col-lg-9 col-sm-9 search-item">
                                                    <input sale="text" value="{{session('customer_code_c')}}"
                                                    name="customer_code" id="customer_code"
                                                    class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-lg-6 search-form">
                                                <div class="search-title col-lg-3 col-sm-3">
                                                    <span class="">顧客名カナ</span>
                                                </div>
                                                <div class="col-lg-9 col-sm-9 search-item">
                                                    <input id="customer_name" value="{{session('customer_name_c')}}"
                                                name="customer_name" sale="text" class="form-control ">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- row 3 --}}
                                    <div class="col-lg-10 col-lg-offset-1 col-md-12">
                                        <div class="row search-row">
                                            <div class="col-md-12 col-lg-6 search-form">
                                                <div class="search-title col-lg-3 col-sm-3">
                                                    <span class="">取引区分</span>
                                                </div>
                                                <div class="col-lg-9 col-sm-9 search-item">
                                                    <select id="sale" class="form-control" name="sale">
                                                        <option value=""></option>
                                                        <option @if (session('sale')==1) selected @endif value="1">売上先
                                                        </option>
                                                        <option @if (session('sale')==2) selected @endif value="2">仕入先
                                                        </option>
                                                        <option @if (session('sale')==3) selected @endif value="3">売上先+仕入先
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-lg-6 search-form">
                                                <div class="search-title col-lg-3 col-sm-3">
                                                    <span class="">ステータス</span>
                                                </div>
                                                <div class="col-lg-9 col-sm-9 search-item">
                                                    <select class="form-control" id="status" name="status">
                                                        <option value=""></option>
                                                        <option @if (session('status')==3) selected @endif value="3">取引中
                                                        </option>
                                                        <option @if (session('status')==4) selected @endif value="4">仮登録中
                                                        </option>
                                                        <option @if (session('status')==2) selected @endif value="2">本登録中止
                                                        </option>
                                                        <option @if (session('status')==1) selected @endif value="1">取引終了
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- end --}}
                                    @csrf
                                    <div class="col-lg-12 ">
                                        <div class="col-lg-3 col-sm-3 col-lg-offset-3 col-sm-offset-3">
                                            <button type="submit" id="search" class="search-button btn btn-primary btn-sm">検索</button>
                                        </div>
                                        <div class="col-lg-3 col-sm-3">
                                            <button type="button" id="clear" class="clear-button btn btn-default btn-sm">クリア</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>

                </div>
            <li>
                <div class="timeline-item">
                    <div class="timeline-body">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-lg-2">
                                    @if( Auth::user()->can('create','App\Customer_MST'))
                                        <a href="{{ url('customer/create') }}">
                                            <button class="btn btn-primary btn-sm">新規登録</button>
                                        </a>
                                    @endif
                                    <button type="button" id="csv1" class="btn btn-success btn-sm">CSV出力</button>
                                </div>
                                <div class="col-lg-3 col-lg-offset-9">
                                    @paginate(['item'=>$customers]) @endpaginate
                                </div>
                            </div>
                            <div class="row">
                                <table id="customer_index_table" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th class="edit_button_with"></th>
                                            <th>顧客コード</th>
                                            <th>顧客名</th>
                                            <th>顧客名カナ</th>
                                            <th>法人番号</th>
                                            <th>検索顧客名</th>
                                            <th>取引区分</th>
                                            <th>ステータス</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customers as $customer)

                                        <tr>
                                            <td>
                                                @if( Auth::user()->can('update','App\Customer_MST'))
                                                <a>
                                                    <button onclick='url("{{ $customer->me_id }}")' style="float: left;"
                                                        class="btn btn-info btn-sm">編集</button>
                                                </a>
                                                @else

                                                @if( Auth::user()->can('view','App\Customer_MST'))
                                                <a>
                                                    <button onclick='url_see("{{ $customer->me_id }}")'
                                                        style="float: left;" class="btn btn-info btn-sm">参照</button>
                                                </a>
                                                @endif

                                                @endif
                                            </td>
                                            @if($customer->client_code_main == null)
                                            <td>{{ $customer->client_code}}</td>
                                            @else
                                            <td>{{ $customer->client_code_main}}</td>
                                            @endif
                                            <td>{{ $customer->client_name}}</td>
                                            <td>{{ $customer->client_name_kana}}</td>
                                            <td>{{ $customer->corporation_num}}</td>
                                            <td>{{ $customer->search_name}}</td>
                                            <td>{{ $customer->type }}</td>
                                            <td>{{ $customer->status_name }}</td>

                                        </tr>

                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                        </div>

                        <input type="hidden" id="flag" value="0">
                    </div>

                </div>
            </li>
        </ul>
    </div>
</div>

<script sale="text/javascript">
    $(document).ready(function() {


         $("#clear").click(function(){

             $('#customer_data').DataTable().state.clear();
             $('#company_id').prop('selectedIndex',0);
			 $('#sale').prop('selectedIndex',0);
             $('#status').prop('selectedIndex',0);
             $('#customer_name').val('');
             $('#personal_code').val('');
             $('#customer_code').val('');
             $('#form').submit();

		 });

		  $( "#csv1" ).click(function(event) {

                document.location.href = "/customer/csv1";

		  });

    });

    function print_data(data){

                   $.each(data, function(i, item) {

					$("tbody").append("<tr  class = 'table_data'><td><button onclick='url("+data[i].me_id+")' class='change btn btn-info btn-sm'>編集</button></td><td>"+data[i].client_code+"</td><td>"+data[i].client_name_s+"</td><td>"+data[i].client_name_s+"</td><td >"+data[i].corporation_num+"</td><td>"+data[i].client_name_hankaku_s+"</td><td>"+data[i].sale+"</td><td >"+data[i].status_name+"</td></tr>");


					});
    }

    function remove_old(){

        	   $( ".table_data" ).each(function() {

		             $(this).remove();


		        });


    }

   function url(id) {

		    var base = '{!! route("customer_edit") !!}';
            var page = '{!! request()->page !!}';
            var url  = base+'?id='+id +'&page=' +page;

			window.location.href = url;
   }
  function url_see(id) {

		    var base = '{!! route("customer_view") !!}';
            var page = '{!! request()->page !!}';
            var url  = base+'?id='+id+'&see='+ 1 +'&page=' +page;

			window.location.href = url;
   }
</script>
@endsection
