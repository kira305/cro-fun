@extends('layouts.app')
@section('content')
@section('breadcrumbs', Breadcrumbs::render('credit/edit'))
<script type="text/javascript" src="{{ asset('js/digaram_datepicker.js') }}"></script>
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

                                <form id="edit_credit" method="post" action="{{ url('credit/edit') }}">

                                    <div class="row">
                                        <div class="col-md-1">
                                            <label class="input_lable">顧客コード</label>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">

                                                <input type="text" id="client_code"
                                                    @if($credit->customer->client_code_main != null)
                                                value="{{ $credit->customer->client_code_main }}"
                                                @else
                                                value="{{ $credit->customer->client_code }}"
                                                @endif
                                                name="client_code" disabled
                                                class="form-control">

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
                                                    value="{{ $credit->customer->client_name}}" class="form-control"
                                                    disabled>
                                                <input type="hidden" name="id" value="" class="form-control">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-1 ">
                                            <label class="input_lable">希望与信限度額<sup>1</sup></label>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <input type="text" style="text-align: right" name="credit_expect"
                                                    id="credit_expect"
                                                    value="{{ number_format( $credit->credit_expect  /1000) }}"
                                                    class="form-control" disabled>

                                            </div>
                                        </div>
                                        <div class="col-md-1 ">
                                            <label class="input_lable">取引想定合計額<sup>1</sup></label>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <input type="text" disabled style="text-align: right" name="transaction"
                                                    id="transaction" value="{{ number_format($transaction /1000 ) }}"
                                                    class="form-control" 　>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-1">
                                            <label class="input_lable">与信取得元</label>
                                        </div>
                                        <div class="col-md-1">
                                            <select class="form-control" id="credit_division" name="credit_division"
                                                disabled>

                                                <option id="credit_division_1" @if ($credit->credit_division == 1)
                                                    selected @endif
                                                    value="1">リスクモンスター
                                                </option>
                                                <option id="credit_division_2" @if ($credit->credit_division == 2)
                                                    selected @endif
                                                    value="2">東京商工リサーチ
                                                </option>
                                                <option id="credit_division_3" @if ($credit->credit_division == 3)
                                                    selected @endif
                                                    value="3">帝国データバンク
                                                </option>

                                            </select>

                                        </div>

                                    </div>
                                    <br>

                                    <div class="row">
                                        <div class="col-md-1">
                                            <label class="input_lable">格付け情報</label>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <input type="text" name="rank" id="rank" value="{{ $credit->rank }}"
                                                    class="form-control" disabled>

                                            </div>
                                        </div>
                                        <div class="col-md-1 ">
                                            <label class="input_lable">取得日</label>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <input style="float: left;" id="input_date" autocomplete="off"
                                                    value="{{ date('Y年m月d日',strtotime($credit->get_time))}}" type="text"
                                                    name="get_time" class="form-control" disabled>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-1">
                                            <label class="input_lable">与信期限</label>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <input style="float: left;" id="expiration_date"
                                                    value="{{ (!empty($credit->expiration_date)) ? date('Y年m月d日',strtotime($credit->expiration_date)) : ''}}"
                                                    readonly type="text" name="expiration_date" class="form-control">

                                            </div>
                                        </div>
                                        <div class="col-md-1 ">
                                            <label class="input_lable">RM与信限度額<sup>1</sup></label>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <input style="text-align: right" id="credit_limit"
                                                    value="{{ number_format( $credit->credit_limit /1000 ) }}" readonly
                                                    type="text" name="credit_limit" class="form-control">

                                            </div>
                                        </div>

                                    </div>

                                    <br>
                                    <div class="row" id="change_reason">
                                        <div class="col-md-3 offset-md-3">
                                            <label class="input_lable">備考</label>
                                        </div>
                                        <div class="col-xs-2">
                                            <textarea rows="5" cols="120" id="note" name="note"
                                                disabled>{{ $credit->note}}</textarea>
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
                                    <input type="hidden" name="company_id" value="{{$credit->company_id}}">
                                    <input type="hidden" id="client_id" name="client_id" value="{{$credit->client_id}}">
                                    <div class="row">

                                        <div class="col-md-4">

                                            <a href="{{route('Credit_log', ['url_id' => request()->url_id ,'page'=>request()->page])}}"
                                                style="float: right;width: 200px;" class="btn btn-danger">戻る</a>
                                            {{-- <a href="{{route('Credit_log', ['client_id' => $credit->client_id,'url_id' => request()->url_id ,'page'=>request()->page])}}"
                                            style="float: right;width: 200px;" class="btn btn-danger">戻る</a> --}}

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

<script src="{{ asset('select/icontains.js') }}"></script>

<script src="{{ asset('select/comboTreePlugin.js') }}"></script>


@endsection
