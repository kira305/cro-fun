@extends('layouts.app')
@section('content')
@section('breadcrumbs', Breadcrumbs::render('credit/create'))

<div class="row">
    <div class="col-md-12">

        <ul class="timeline">
            <li>

                <div class="timeline-item">

                    <div class="timeline-body">
                        <div>

                            <div class="box-body">

                                @if (isset($message))


                                <p class="message">{{ $message }}</p>


                                @endif

                                <form id="create_credit" method="post"
                                    action="{{ url('credit/create?company_id='.request()->company_id.'&client_id='.request()->client_id) }}">

                                    <div class="row">
                                        <div class="col-md-1">
                                            <label class="input_lable">顧客コード</label>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">

                                                <input type="text" id="client_code" value="{{ $client_code }}"
                                                    name="client_code" class="form-control input-sm">

                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-1">
                                            <label class="input_lable">顧客名</label>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <input type="text" id="client_name" name="client_name"
                                                    value="{{ $client_name}}" class="form-control input-sm">
                                                <input type="hidden" name="id" value="" class="form-control">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-1 ">
                                            <label class="input_lable"><b>希望与信限度額</b><sup>1</sup></label>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <input type="text" style="text-align: right" name="credit_expect"
                                                    id="credit_expect" value="{{ old('credit_expect')}}"
                                                    class="form-control input-sm">

                                            </div>
                                        </div>

                                        <div class="col-md-1 ">
                                            <label class="input_lable">取引想定合計額<sup>1</sup></label>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <input type="text" style="text-align: right" name="transaction"
                                                    id="transaction" value="{{ number_format($transaction / 1000 )}}"
                                                    class="form-control input-sm" 　>

                                            </div>
                                        </div>

                                    </div>

                                    @if ($errors->has('credit_expect'))
                                    <div class="row">
                                        <div class="col-md-1 ">
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <span class="text-danger">
                                                    {{ $errors->first('credit_expect') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    <div class="row">
                                        <div class="col-md-1">
                                            <label class="input_lable"><b>与信取得元</b><sup>※</sup></label>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <select id="credit_division" class="form-control input-sm"
                                                    name="credit_division">
                                                    <option selected value=""></option>
                                                    <option @if (old('credit_division')=='1' ) selected @endif
                                                        value="1">リスクモンスター</option>
                                                    <option @if (old('credit_division')=='2' ) selected @endif
                                                        value="2">東京商工リサーチ</option>

                                                    <option @if (old('credit_division')=='3' ) selected @endif
                                                        value="3">帝国データバンク</option>
                                                </select>
                                            </div>
                                        </div>
                                        @if ($errors->has('credit_division'))

                                        <span class="text-danger">{{ $errors->first('credit_division') }}</span>

                                        @endif
                                    </div>
                                    <div class="row">
                                        <div class="col-md-1">
                                            <label class="input_lable"><b>格付け情報</b><sup>※</sup></label>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <input type="text" name="rank" id="rank" value="{{ $rank_conversion }}"
                                                    class="form-control">

                                            </div>
                                        </div>
                                        <div class="col-md-1 ">
                                            <label class="input_lable"><b>取得日</b><sup>※</sup></label>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">

                                                <input style="float: left;" id="datepicker" autocomplete="off"
                                                    value="{{ old('get_time')}}" type="text" name="get_time"
                                                    class="form-control input-sm">


                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-1">

                                        </div>
                                        <div class="col-md-1">
                                            @if ($errors->has('rank'))

                                            <span class="text-danger">
                                                {{ $errors->first('rank') }}
                                            </span>

                                            @endif
                                        </div>
                                        <div class="col-md-1 ">

                                        </div>
                                        <div class="col-md-1">
                                            @if ($errors->has('get_time'))

                                            <span class="text-danger">
                                                {{ $errors->first('get_time') }}
                                            </span>

                                            @endif

                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-1">
                                            <label class="input_lable">与信期限</label>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <input style="float: left;" id="expiration_date"
                                                    value="{{(!empty($renew_time)) ? date('Y/m/d',strtotime($renew_time)) : '' }}"
                                                    type="text" name="expiration_date" class="form-control input-sm">
                                            </div>
                                        </div>
                                        <div class="col-md-1 ">
                                            <label class="input_lable">RM与信限度額<sup>※,1</sup></label>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <input style="float: left; text-align: right" id="credit_limit"
                                                    value="{{ old('credit_limit')}}" type="text" name="credit_limit"
                                                    class="form-control input-sm">

                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-1">

                                        </div>
                                        <div class="col-md-1">
                                            @if ($errors->has('expiration_date'))

                                            <span class="text-danger">
                                                {{ $errors->first('expiration_date') }}
                                            </span>

                                            @endif
                                        </div>

                                        <div class="col-md-1 ">

                                        </div>
                                        <div class="col-md-1">
                                            @if ($errors->has('credit_limit'))

                                            <span class="text-danger">
                                                {{ $errors->first('credit_limit') }}
                                            </span>

                                            @endif

                                        </div>

                                    </div>

                                    <br>
                                    <div class="row" id="change_reason">
                                        <div class="col-md-3 offset-md-3">
                                            <label class="input_lable">備考</label>
                                        </div>
                                        <div class="col-xs-2">
                                            <textarea rows="5" cols="120" id="note"
                                                name="note">@if(isset($note)) {{ $note }} @endif</textarea>
                                        </div>

                                    </div>
                                    <div class="row" id="change_reason">
                                        <div class="col-md-3 offset-md-3">

                                        </div>
                                        <div class="col-xs-2">
                                            <p class="content_text"> 1)1000円が省略された金額で表示されています。 </p>
                                        </div>

                                    </div>


                                    <br>
                                    <div class="row">

                                        <div class="col-md-1"></div>
                                        <div class="col-md-1">


                                            <span class="btn btn-primary btn-file" class="input_lable">
                                                RM情報取込
                                                <input id="input_file" type="file" name="file_data">
                                                @csrf
                                            </span>


                                        </div>
                                        <div class="col-sm-4">

                                            <p>右上に※があるデータは、RM情報からデータを設定します。</p>

                                        </div>

                                    </div>

                                    <br>
                                    <input type="hidden" name="company_id" value="{{$company_id}}">
                                    <input type="hidden" id="client_id" name="client_id" value="{{$client_id}}">
                                    <input type="hidden" id="pre_url_status" name="pre_url_status"
                                        value="{{$pre_url_status}}">
                                    <div class="row">
                                        　　　<br>

                                        <div class="col-md-4">

                                            <button type="submit" style="float:right;width: 200px;"
                                                class="btn btn-primary">登録</button>

                                        </div>
                                        <div class="col-md-4">

                                            @if($pre_url_status == 1)

                                            <a href="{{route('customer_edit', ['id' => request()->client_id])}}">

                                                <button type="button" style="float: left;width: 200px;"
                                                    class="btn btn-danger">戻る</button>

                                            </a>

                                            @elseif($pre_url_status == 2)

                                            <a href="{{route('customer_view', ['id' => request()->client_id])}}">

                                                <button type="button" style="float: left;width: 200px;"
                                                    class="btn btn-danger"> 戻る</button>

                                            </a>

                                            @else

                                            <a href="{{route('Credit_index')}}">

                                                <button type="button" style="float: left;width: 200px;"
                                                    class="btn btn-danger"> 戻る</button>

                                            </a>


                                            @endif

                                        </div>



                                    </div>
                                </form>
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
    $('#datepicker').datepicker({

		    autoclose: true,
		    todayHighlight: true,

		});

	  //画面が開いた際

      $( document ).ready(function() {

          $("#client_name").prop("readonly", true);
          $("#client_code").prop("readonly", true);
          $("#transaction").prop("readonly", true);
          $("#expiration_date").prop("readonly", true);


		  $( "#input_file" ).change(function() {

			var csv   = $('#input_file')[0].files[0];
			var form  = new FormData();
			var client_id = $('#client_id').val();
			form.append('csv', csv);

			$.ajax({
			    url: '/credit/upload?client_id='+client_id,
			    data: form,
			    cache: false,
			    contentType: false,
			    processData: false,
			    type: 'POST',
			    success:function(response) {

			        if(response.status_code == 400){

                           alert(response.message);
                           return;

			        }
			        console.log(response);
			        set_data(response);
			    },

			    error: function (exception) {

                        alert(exception.responseText);
                        if(exception.status == 500){

                            alert('ファイルのルールはただしくありません。');

                        }


				}
			});


            event.preventDefault();

		  });


      });

     function set_data(response) {

     	   var get_time = changeDate(response.get_time);

           // alert(changeDate(response.get_time));
           $('#datepicker').val(get_time);
           $('#rank').val(response.rank);
           $('#credit_limit').val(response.credit_limit);
           $('#expiration_date').val(response.expiration_date);
		   $('#credit_division').val(response.credit_division);
		   $('#note').val(response.note);


           $("#rank").prop("readonly", true);
           $("#datepicker").prop("readonly", true);
           $("#expiration_date").prop("readonly", true);
           $('#credit_limit').prop("readonly", true);
           $("#datepicker").css('pointer-events', 'none');
     }

     function changeDate(data){

           var date = new Date(data);

           var res = date.getFullYear() + '/'+('0' + (date.getMonth()+1)).slice(-2) + '/' + ('0' + date.getDate()).slice(-2);

           return res;

     }

    function previous(){

    	    var base        =  '{!! route("Credit_index") !!}';

            var url         =  base+'?client_id='+ '{{ request()->client_id }}';

			window.location.href = url;

    }


</script>



@endsection
