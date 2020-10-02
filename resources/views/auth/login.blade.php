@extends('layouts.auth')

@section('content')

<div class="login-box" style="width: 400px">

    <!-- /.login-logo -->
    <div class="login-box-body">
        <div class="login-logo">

        </div>
        <h2 style="margin-left: 130px; font-family: Times New Roman, Times, serif;">Cro-Fun</h2>
        <!--  <p class="login-box-msg">Sign in to start your session</p> -->
        <span class="text-danger">{!! \Session::get('message') !!}</span>
        <form action="{{ url('/login') }}" method="post" autocomplete="off" id="cross-form">
            {{ csrf_field() }}
            @if (isset($ok_message))
            <br><span class="text-info">{{ $ok_message }}</span>
            @endif

            <div class="form-group has-feedback">
                <label>社員番号</label>

                <input class="form-control" id="usr_id" name="usr_code" type="interger" autocomplete="nope"
                    value="{{ empty(old('usr_code')) ? Cookie::get('usr_code') :  old('usr_code') }}">
                @if ($errors->has('usr_code'))

                <br><span class="text-danger">{{ trans('auth.username') }}</span>

                @endif
                @csrf
            </div>
            <div class="form-group has-feedback">
                <label>パスワード</label>

            <input type="password" id="password" class="form-control" name="pw" autocomplete="new-password" value="{{ empty(old('pw')) ? Cookie::get('pw') : '' }}">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                @if ($errors->has('pw'))

                <br><span class="text-danger">{{ trans('auth.password') }}</span>

                @endif
            </div>

            <div>
                @if (isset($message))

                <span class="text-danger">{{ $message }}</span>

                @endif
            </div>
            <div class="row">
                <div class="col-xs-8">

                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">ログイン</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

        <div class="social-auth-links text-center">

        </div>
        <!-- /.social-auth-links -->

        <a href="{{ url('user/reset-password') }}">パスワードを忘れた場合</a><br>


    </div>
    <!-- /.login-box-body -->
</div>
<script type="text/javascript">
    $( document ).ready(function() {

      document.getElementById("cross-form").reset();

   });
</script>
@endsection
