@extends('layouts.app')
@section('content')
@section('breadcrumbs', Breadcrumbs::render('tree/index'))
    <style>
        .box-height {
            height: 34px;
        }

        .pading-title {
            padding-top: 8px;
            text-align: right
        }

    </style>
    <script type="text/javascript" src="{{ asset('js/diagram_document_ready.js') }}"></script>
    @include('layouts.confirm_js')
    <div class="row">
        <div class="col-md-12">
            <ul class="timeline">
                <li>
                    <div class="timeline-item">
                        <div class="timeline-body">
                            <form id="diagram" method="POST" action="{{ url('tree/index') }}">
                                <div class="box-body">
                                    <div class="row input_time">
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <select class="form-control input-sm" id="company_id" name="company_id">
                                                    @foreach ($companies as $company)
                                                        <option @if (session('company_id_d') != null)
                                                            {{ session('company_id_d') == $company->id ? 'selected' : '' }}
                                                        @else
                                                            {{ Auth::user()->company_id == $company->id ? 'selected' : '' }}
                                                    @endif
                                                    value="{{ $company->id }}">{{ $company->abbreviate_name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-1 box-height pading-title">
                                            表示年月日
                                        </div>
                                        <div class="col-sm-2 box-height">
                                            @csrf
                                            <input class="form-control " value="{{ old('search_date') }}" autocomplete="off"
                                                style="float: : left;" type='text' name="search_date" id='datepicker'>
                                        </div>
                                        <div class="col-sm-1 ">
                                            <button class="btn-sm box-height" type="submit">表示</button>
                                        </div>
                                        <div class="col-sm-1 box-height pading-title">
                                            出力期間
                                        </div>
                                        <div class="col-sm-2 box-height">
                                            <input class="form-control" autocomplete="off" id="start_date" type="" name=""
                                                value="">
                                        </div>

                                        <div class="col-sm-2 box-height">
                                            <input class="form-control " autocomplete="off" id="end_date" type="" name=""
                                                value="">
                                        </div>
                                        <div class="col-sm-1">
                                            <button class="btn-sm box-height" type="button" onclick="diagram()" style="">
                                                出力
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3 col-sm-offset-9">
                                            @paginate(['item'=> $diagrams]) @endpaginate
                                        </div>
                                    </div>
                                    <div class="row">
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead class="thead-table" style="background-color: #20B2AA">
                                                <tr>
                                                    <th class="title">事業本部</th>
                                                    <th class="title">部署</th>
                                                    <th class="title">グループ</th>
                                                    <th class="title">販管費</th>
                                                    <th class="title">原価コード</th>
                                                    <th class="title">集計コード</th>
                                                    <th class="title">PJコード</th>
                                                </tr>
                                                <tr>
                                                    <th class="col-md-1">
                                                        <select class="form-control" name="headquarter_id"
                                                            id="headquarter_id_d">
                                                            <option value="" data-id=""> </option>
                                                            @foreach ($headquarters as $headquarter)
                                                                <option class="headquarter_class"
                                                                    {{ session('headquarter_id_tr') == $headquarter->headquarters_code ? 'selected' : '' }}
                                                                    data-value="{{ $headquarter->company_id }}"
                                                                    data-id="{{ $headquarter->headquarter_list_code }}"
                                                                    value="{{ $headquarter->headquarters_code }}">
                                                                    {{ $headquarter->headquarters_code }}:{{ $headquarter->headquarters }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </th>
                                                    <th class="col-md-1">
                                                        <select class="search form-control" id="department_id_d"
                                                            name="department_id">
                                                            <option value="" data-id=""> </option>
                                                            @foreach ($departments as $department)
                                                                <option class="department_class"
                                                                    {{ session('department_id_tr') == $department->department_code ? 'selected' : '' }}
                                                                    data-value="{{ $department->company_id }}"
                                                                    data-id="{{ $department->department_code }}"
                                                                    value="{{ $department->department_code }}">
                                                                    {{ $department->department_code }}:{{ $department->department_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </th>
                                                    <th class="col-md-1">
                                                        <select class="search form-control" name="group_id" id="group_id_d">
                                                            <option value="" data-id=""> </option>
                                                            @foreach ($groups as $group)
                                                                <option class="group_class"
                                                                    {{ session('group_id_tr') == $group->group_code ? 'selected' : '' }}
                                                                    data-value="{{ $group->company_id }}"
                                                                    value="{{ $group->group_code }}">
                                                                    {{ $group->group_code }}:{{ $group->group_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </th>
                                                    <th class="col-md-1">
                                                        <select class="form-control" id="selling" name="hanka">
                                                            <option value=""></option>
                                                            @foreach ($hanka_s as $hanka)
                                                                <option class="hanka" data-id="{{ $hanka->company_id }}"
                                                                    {{ session('hanka') == $hanka->cost_code ? 'selected' : '' }}
                                                                    value="{{ $hanka->cost_code }}">
                                                                    {{ $hanka->cost_code }}:{{ $hanka->cost_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </th>
                                                    <th class="col-md-1">
                                                        <select class="form-control" id="cost" name="genka">
                                                            <option value=""></option>
                                                            @foreach ($genka_s as $genka)
                                                                <option class="genka" data-id="{{ $genka->company_id }}"
                                                                    {{ session('genka') == $genka->cost_code ? 'selected' : '' }}
                                                                    value="{{ $genka->cost_code }}">
                                                                    {{ $genka->cost_code }}:{{ $genka->cost_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </th>
                                                    <th class="col-md-1">
                                                        <select class="search form-control" id="pj_gr_code"
                                                            name="pj_gr_code">
                                                            <option value="" selected></option>
                                                            @foreach ($projects as $project)
                                                                <option class="pj_gr_code"
                                                                    {{ session('pj_gr_code') == $project->project_grp_code ? 'selected' : '' }}
                                                                    value="{{ $project->project_grp_code }}">
                                                                    {{ $project->project_grp_code }}:{{ $project->project_grp_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </th>
                                                    <th class="col-md-2">
                                                        <select class="search form-control" id="pj_code" name="pj_code">
                                                            <option class="" value="" selected></option>
                                                            @foreach ($code_projects as $project)
                                                                <option class="pj_code"
                                                                    {{ session('pj_code') == $project->project_code ? 'selected' : '' }}
                                                                    value="{{ $project->project_code }}">
                                                                    {{ $project->project_code }}:{{ $project->project_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($diagrams as $diagram)
                                                    <tr>
                                                        <td>{{ $diagram->headquarters_code }}:{{ $diagram->headquarters }}
                                                        </td>
                                                        <td>
                                                            @if ($diagram->department_code != null && $diagram->department_code != null)
                                                                {{ $diagram->department_code }}:{{ $diagram->department_name }}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($diagram->group_code != null && $diagram->group_name != null)
                                                                {{ $diagram->group_code }}:{{ $diagram->group_name }}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($diagram->sales_management_code != null && $diagram->sales_management != null)
                                                                {{ $diagram->sales_management_code }}:{{ $diagram->sales_management }}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($diagram->cost_code != null && $diagram->cost_name != null)
                                                                {{ $diagram->cost_code }}:{{ $diagram->cost_name }}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($diagram->project_grp_code != null && $diagram->project_grp_name != null)
                                                                {{ $diagram->project_grp_code }}:{{ $diagram->project_grp_name }}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($diagram->project_code != null && $diagram->project_name != null)
                                                                {{ $diagram->project_code }}:{{ $diagram->project_name }}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <script type="text/javascript">
        $(document).on('change', '#company_id', function() {
            $('#headquarter_id_d').prop('selectedIndex', 0);
            $('#department_id_d').prop('selectedIndex', 0);
            $('#group_id_d').prop('selectedIndex', 0);
            $('#selling').prop('selectedIndex', 0);
            $('#cost').prop('selectedIndex', 0);
            $('#pj_gr_code').prop('selectedIndex', 0);
            $('#pj_code').prop('selectedIndex', 0);
            $('#diagram').submit();
        });


        $(document).on('change', '#headquarter_id_d', function() {
            var headquarter_code = $('#headquarter_id_d').find('option:selected').data('id');
            $('#diagram').submit();
        });

        $(document).on('change', '#department_id_d', function() {
            $('#diagram').submit();
        });

        $(document).on('change', '#group_id_d', function() {
            $('#diagram').submit();
        });

        $(document).on('change', '#selling', function() {
            $('#diagram').submit();
        });

        $(document).on('change', '#cost', function() {
            $('#diagram').submit();
        });

        $(document).on('change', '#pj_gr_code', function() {
            $('#diagram').submit();
        });


        $(document).on('change', '#pj_code', function() {
            $('#diagram').submit();
        });

        function diagram() {
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            var company_id = $('#company_id').val();

            if (start_date == '' && end_date == '') {
                $.alert({
                    title: 'メッセージ',
                    content: '出力日を入力してください！',
                });
                return;
            }

            if (start_date == end_date) {
                document.location.href = "/tree/diagram2?start_date=" +
                    start_date + "&end_date=" + end_date +
                    "&company_id=" + company_id;
                return;
            }

            if (start_date == "" && end_date != "") {
                $.alert({
                    title: 'メッセージ',
                    content: '出力開始日を入力してください！',
                });
                return;
            }

            if (start_date != "" && end_date == "") {
                document.location.href = "/tree/diagram?start_date=" +
                    start_date + "&end_date=" + end_date +
                    "&company_id=" + company_id;
                return;
            }


            if (start_date > end_date) {
                $.alert({
                    title: 'メッセージ',
                    content: '出力日開始は出力日終了より大きいので出力できません！',
                });
                return;
            }

            document.location.href = "/tree/diagram?start_date=" +
                start_date + "&end_date=" + end_date +
                "&company_id=" + company_id;
        }

        function headquarter() {
            var company_id = $('#company_id').val();
            $(".headquarter_class").each(function() {
                $(this).show();
                if ($(this).attr('data-value') !== company_id) {
                    $(this).hide();
                }
            });
        }

        function department() {
            var company_id = $('#company_id').val();
            $(".department_class").each(function() {
                $(this).show();
                if ($(this).attr('data-value') !== company_id) {
                    $(this).hide();
                }
            });
        }

        function group() {
            var company_id = $('#company_id').val();
            $(".group_class").each(function() {
                $(this).show();
                if ($(this).attr('data-value') !== company_id) {
                    $(this).hide();
                }
            });
        }

        function print_data_genka(data) {
            //新しい値をセット
            $.each(data, function(i, item) {
                $("#cost").append("<option data-id='" + data[i].company_id + "' class = 'genka' value='" + data[i]
                    .cost_code + "'>" + data[i].cost_code + "</option>");
            });
        }

        function remove_old_genka() {
            $(".genka").each(function() {
                $(this).remove();
            });
        }

        function print_data_hanka(data) {
            //新しい値をセット
            $.each(data, function(i, item) {
                $("#selling").append("<option data-id='" + data[i].company_id + "' class = 'hanka' value='" + data[
                    i].cost_code + "'>" + data[i].cost_code + "</option>");
            });
        }

        function remove_old_hanka() {
            $(".hanka").each(function() {
                $(this).remove();
            });
        }

        function print_data_project(data) {
            //新しい値をセット
            $.each(data, function(i, item) {
                $("#pj_gr_code").append("<option data-id='" + data[i].company_id +
                    "' class = 'pj_gr_code' value='" + data[i].get_code + "'>" + data[i].get_code + "</option>");
            });
            $.each(data, function(i, item) {
                $("#pj_code").append("<option data-id='" + data[i].company_id + "' class = 'pj_code' value='" +
                    data[i].project_code + "'>" + data[i].project_code + "</option>");
            });
        }

        function remove_old_project() {
            $(".pj_gr_code").each(function() {
                $(this).remove();
            });
            $(".pj_code").each(function() {
                $(this).remove();
            });
        }

        $(document).ready(function() {
            var company_id = $('#company_id').val();
            $(".genka").each(function() {
                $(this).show();
                if ($(this).attr('data-id') !== company_id) {
                    $(this).remove();
                }
            });
            $(".hanka").each(function() {
                $(this).show();
                if ($(this).attr('data-id') !== company_id) {
                    $(this).remove();
                }
            });
        });

    </script>
@endsection
