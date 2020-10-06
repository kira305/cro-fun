@extends('layouts.app')
@section('content')
@section('breadcrumbs', Breadcrumbs::render('pca/uplode'))
    <script type="text/javascript" src="{{ asset('js/MonthPicker.js') }}"></script>
    <div class="row" id="databinding">
        <div class="col-md-12">
            <ul class="timeline">
                <li>
                    <div class="timeline-item">
                        <div class="timeline-body">
                            <div class="box-body">
                                @if ($message = Session::get('message'))
                                    <p class="" style="text-align: center;color: green">{{ $message }}</p>
                                @endif
                                <p hidden id="server_err" style="text-align: center;color: red">
                                    {{ trans('message.save_fail') }}</p>
                                <form id="upload" method="post" action="{{ url('pca/upload') }}"
                                    enctype="multipart/form-data">
                                    {{-- row 1 --}}
                                    <div class="col-lg-10 col-lg-offset-1 col-md-12">
                                        <div class="row search-row">
                                            <div class="col-md-12 col-lg-6 search-form">
                                                <div class="search-title col-lg-3 col-sm-3">
                                                    <span class="">会社コード</span>
                                                </div>
                                                <div class="col-lg-9 col-sm-9 search-item">
                                                    <select class="form-control" id="company_id" name="company_id">
                                                        @foreach ($companies as $company)
                                                            <option
                                                                {{ old('company_id') == $company->id ? 'selected' : '' }}
                                                                value="{{ $company->id }}">{{ $company->abbreviate_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @if ($errors->has('company_id'))
                                                    <div class="text-danger">
                                                        {{ $errors->first('company_id') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    {{-- row 2 --}}
                                    <div class="col-lg-10 col-lg-offset-1 col-md-12">
                                        <div class="row search-row">
                                            <div class="col-md-12 col-lg-6 search-form">
                                                <div class="search-title col-lg-3 col-sm-3">
                                                    <span class="">取込データ</span>
                                                </div>
                                                <div class="col-lg-9 col-sm-9 search-item">
                                                    <select class="form-control" id="import_type" name="import_type">
                                                        <option {{ old('import_type') == 1 ? 'selected' : '' }} value="1">売上
                                                        </option>
                                                        <option {{ old('import_type') == 2 ? 'selected' : '' }} value="2">
                                                            売掛金残
                                                        </option>
                                                    </select>
                                                </div>
                                                @if ($errors->has('import_type'))
                                                    <div class="text-danger">
                                                        {{ $errors->first('import_type') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    {{-- row 3 --}}
                                    <div class="col-lg-10 col-lg-offset-1 col-md-12">
                                        <div class="row search-row">
                                            <div class="col-md-12 col-lg-6 search-form">
                                                <div class="search-title col-lg-3 col-sm-3">
                                                    <span class="">取得年月</span>
                                                </div>
                                                <div class="col-lg-9 col-sm-9 search-item">
                                                    <input id="get_time" value="{{ old('get_time') }}" autocomplete="off"
                                                        name="get_time" type="text" size="70" class="form-control">
                                                </div>
                                                @if ($errors->has('get_time'))
                                                    <div class="text-danger">
                                                        {{ $errors->first('get_time') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    {{-- row 4 --}}
                                    <div class="col-lg-10 col-lg-offset-1 col-md-12">
                                        <div class="row search-row">
                                            <div class="col-md-12 col-lg-6 search-form">
                                                <div class="col-lg-3 col-sm-3">
                                                    <span class="btn btn-primary btn-file">
                                                        データ取込
                                                        <input type="file" id="input_file" name="file_data">
                                                    </span>
                                                </div>
                                                @if ($errors->has('file_data'))
                                                    <div class="text-danger">
                                                        {{ $errors->first('file_data') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @csrf
                                    {{-- end --}}
                                </form>
                                <!-- /.box-body -->
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="timeline-item">
                        @if ($result == 0)
                            <div id="upload_status" class="box-body">
                                {{-- row 1 --}}
                                <div class="col-lg-10 col-lg-offset-1 col-md-12">
                                    <div class="row search-row">
                                        <div class="col-md-12 col-lg-8 search-form">
                                            <div class="search-title col-lg-3 col-sm-3">
                                                <span class="">取込データ</span>
                                            </div>
                                            <div class="col-lg-9 col-sm-9 search-item">
                                                <span id="import_type_1" class="form-control">{{ $type }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- row 2 --}}
                                <div class="col-lg-10 col-lg-offset-1 col-md-12">
                                    <div class="row search-row">
                                        <div class="col-md-12 col-lg-8 search-form">
                                            <div class="search-title col-lg-3 col-sm-3">
                                                <span class="">取込ステータス</span>
                                            </div>
                                            <div class="col-lg-9 col-sm-9 search-item">
                                                <span id="import_status" class="form-control">{{ $status }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- row 3 --}}
                                <div class="col-lg-10 col-lg-offset-1 col-md-12">
                                    <div class="row search-row">
                                        <div class="col-md-12 col-lg-8 search-form">
                                            <div class="search-title col-lg-3 col-sm-3">
                                                <span class="">データ件数</span>
                                            </div>
                                            <div class="col-lg-9 col-sm-9 search-item">
                                                <span id="total_data" class="form-control">{{ $data_total }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- row 4 --}}
                                <div class="col-lg-10 col-lg-offset-1 col-md-12">
                                    <div class="row search-row">
                                        <div class="col-md-12 col-lg-8 search-form">
                                            <div class="search-title col-lg-3 col-sm-3">
                                                <span class="">ファイル名</span>
                                            </div>
                                            <div class="col-lg-9 col-sm-9 search-item">
                                                <span id="file_name" class="form-control">{{ $file_name }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- row 5 --}}
                                <div class="col-lg-10 col-lg-offset-1 col-md-12">
                                    <div class="row search-row">
                                        <div class="col-md-12 col-lg-8 search-form">
                                            <div class="search-title col-lg-3 col-sm-3">
                                                <span class="">取込日</span>
                                            </div>
                                            <div class="col-lg-9 col-sm-9 search-item">
                                                <span class="form-control" id="get_time_1">
                                                    {{ date('Y年m月d日', strtotime($time)) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- row 6 --}}
                                @if (isset($file_name_err))
                                    <div class="col-lg-10 col-lg-offset-1 col-md-12">
                                        <div class="row search-row">
                                            <div class="col-md-12 col-lg-8 search-form">
                                                <div class="search-title col-lg-3 col-sm-3">
                                                    <span class="">エラーファイル</span>
                                                </div>
                                                <div class="col-lg-9 col-sm-9 search-item">
                                                    <span class="form-control" id="err_file_name">{{ $file_name_err }}</span>
                                                    <input type="hidden" id="import_id" value="{{ $import_id }}">
                                                </div>
                                                <button id="csv" class="btn btn-primary">Dowload</button>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                {{-- end --}}
                            </div>
                        @endif
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <script type="text/javascript">
        $("#get_time").MonthPicker({
            Button: false,
            MonthFormat: 'yy/mm'

        });
        $(document).ready(function() {


            $("#input_file").change(function() {

                $("#upload").submit();

            });

            //  $('#upload').submit(function(event) {

            // var file_data    = $('#input_file')[0].files[0];
            // var company_id   = $('#company_id').val();
            //          var check = 0;
            // if(company_id == ''){

            // 	 $('#message1').show();
            //               check = 1;
            // }

            // var import_type  = $('#import_type').val();

            //          if(import_type == ''){

            // 	 $('#message2').show();
            //                check = 1;
            // }

            //          if($('#get_time').val() == ''){

            // 	 $('#message3').show();
            //                check = 1;
            // }

            //          if(check == 1){

            //              $('#input_file').val('');
            //          	event.preventDefault();
            //          	return;
            //          }
            // var result       = $('#get_time').val().split('/');
            // var get_time     = result[0]+'-'+result[1]+'-01 00:00:00';

            // var form  = new FormData();

            // form.append('file_data', file_data);
            //          form.append('company_id', company_id);
            //          form.append('import_type', import_type);
            //          form.append('get_time', get_time);

            // $.ajax({
            //     url: '/pca/upload',
            //     data: form,
            //     cache: false,
            //     contentType: false,
            //     processData: false,
            //     type: 'POST',
            //     success:function(response) {
            //         console.log(response);
            //         $('#upload_status').show();
            //         $('#import_type_1').text(response.type);
            //         $('#file_name').text(response.file_name);
            //         $('#total_data').text(response.data_total);
            //         $('#import_status').text(response.status);
            //         $('#get_time_1').text(response.time);

            //                  $('#input_file').val('');
            //                  $('#err_file').hide();
            //                  $('#message1').hide();
            //                  $('#message2').hide();
            //                  $('#message3').hide();
            //                  $('#message4').hide();
            //                  $('#server_err').hide();

            //                  if(response.status_code == 302){

            //                         $('#err_file').show();
            //                         $('#err_file_name').text(response.file_name_err);
            //                         $('#import_id').val(response.import_id);

            //         }

            //         if(response.status_code == 500){

            //                      alert(response.message);

            //         }

            //                  if(response.status_code == 401){

            //                         $('#upload_status').hide();
            //                         $('#message4').show();
            //         }
            //     },

            //     error: function (exception) {

            //                      $('#err_file').show();
            //                       alert(exception.responseText);
            //                      if(exception.status == 500){

            //                         $('#server_err').show();

            //                      }

            //                      $('#input_file').val('');


            // 	}
            // });

            //          event.preventDefault();

            //  });

            $("#csv").click(function(event) {

                var import_id = $("#import_id").val();
                document.location.href = "/err/dowload?import_id=" + import_id;

            });

        });

    </script>
    <script src="{{ asset('select/icontains.js') }}"></script>

    <script src="{{ asset('select/comboTreePlugin.js') }}"></script>


@endsection
