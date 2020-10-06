@extends('layouts.app')
@section('content')
@section('breadcrumbs', Breadcrumbs::render('contract/index'))
    <style type="text/css">
    </style>
    <div class="row">
        <div class="col-md-12">
            <ul class="timeline">
                <li>
                    <div class="timeline-item">
                        <div class="timeline-body">
                            <div>
                                <div class="box-body">
                                    <form action="{{ url('contract/index') }}" id="form" method="post">
                                        {{-- row 1 --}}
                                        <div class="col-lg-10 col-lg-offset-1 col-md-12">
                                            <div class="row search-row">
                                                <div class="col-md-12 col-lg-6 search-form">
                                                    <div class="search-title col-lg-3 col-sm-3">
                                                        <span class="">所属会社</span>
                                                    </div>
                                                    <div class="col-lg-9 col-sm-9 search-item">
                                                        <select class="form-control" id="company_id" name="company_id">
                                                            @foreach ($companies as $company)
                                                                <option @if (session()->has('company_id_cont'))
                                                                    @if (session('company_id_cont') == $company->id)
                                                                        selected @endif
                                                                @else
                                                                    @if (Auth::user()->company_id == $company->id)
                                                                        selected @endif
                                                            @endif
                                                            value="{{ $company->id }}">{{ $company->abbreviate_name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-lg-6 search-form">
                                                    <div class="search-title col-lg-3 col-sm-3">
                                                        <span class="">事業本部</span>
                                                    </div>
                                                    <div class="col-lg-9 col-sm-9 search-item">
                                                        <select class="form-control" id="headquarter_id"
                                                            name="headquarter_id">
                                                            <option value=""> </option>
                                                            @foreach ($headquarters as $headquarter)
                                                                <option class="headquarter_id"
                                                                    data-value="{{ $headquarter->company_id }}" @if (isset($headquarter_id))
                                                                    @if ($headquarter_id == $headquarter->id)
                                                                        selected @endif
                                                            @endif
                                                            value="{{ $headquarter->id }}">{{ $headquarter->headquarters }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- row 2 --}}
                                        <div class="col-lg-10 col-lg-offset-1 col-md-12">
                                            <div class="row search-row">
                                                <div class="col-md-12 col-lg-6 search-form">
                                                    <div class="search-title col-lg-3 col-sm-3">
                                                        <span class="">部署</span>
                                                    </div>
                                                    <div class="col-lg-9 col-sm-9 search-item">
                                                        <select class="form-control" id="department_id"
                                                            name="department_id">
                                                            <option selected value=""></option>
                                                            @foreach ($departments as $department)
                                                                <option class="department_id"
                                                                    data-value="{{ $department->headquarter()->id }}"
                                                                    @if (isset($department_id))
                                                                    @if ($department_id == $department->id)
                                                                        selected @endif
                                                            @endif
                                                            value="{{ $department->id }}">{{ $department->department_name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-lg-6 search-form">
                                                    <div class="search-title col-lg-3 col-sm-3">
                                                        <span class="">グループ</span>
                                                    </div>
                                                    <div class="col-lg-9 col-sm-9 search-item">
                                                        <select class="form-control" id="group_id" name="group_id">
                                                            <option selected value=""></option>
                                                            @foreach ($groups as $group)
                                                                <option class="group_id"
                                                                    data-value="{{ $group->department()->id }}" @if (isset($group_id))
                                                                    @if ($group_id == $group->id) selected
                                                                    @endif
                                                            @endif
                                                            value="{{ $group->id }}">{{ $group->group_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- row 3 --}}
                                        <div class="col-lg-10 col-lg-offset-1 col-md-12">
                                            <div class="row search-row">
                                                <div class="col-md-12 col-lg-6 search-form">
                                                    <div class="search-title col-lg-3 col-sm-3">
                                                        <span class="">顧客コード</span>
                                                    </div>
                                                    <div class="col-lg-9 col-sm-9 search-item">
                                                        <input type="text" value="{{ session('client_code_cont') }}"
                                                            name="client_code" id="client_code" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-lg-6 search-form">
                                                    <div class="search-title col-lg-3 col-sm-3">
                                                        <span class="">顧客名カナ</span>
                                                    </div>
                                                    <div class="col-lg-9 col-sm-9 search-item">
                                                        <input id="client_name_kana"
                                                            value="{{ session('client_name_kana_cont') }}"
                                                            name="client_name_kana" type="text" size="80%"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- row 4 --}}
                                        <div class="col-lg-10 col-lg-offset-1 col-md-12">
                                            <div class="row search-row">
                                                <div class="col-md-12 col-lg-6 search-form display-flex">
                                                    <div class="search-title">
                                                        <span class="">プロジェクトコード</span>
                                                    </div>
                                                    <div class="search-item width-100 ">
                                                        <input type="text" value="{{ session('project_code_cont') }}"
                                                            name="project_code" id="project_code" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-lg-6 search-form display-flex">
                                                    <div class="search-title">
                                                        <span class="">プロジェクト名</span>
                                                    </div>
                                                    <div class="search-item width-100">
                                                        <input type="text" value="{{ session('project_name_cont') }}"
                                                            name="project_name" id="project_name" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- row 5 --}}
                                        <div class="col-lg-10 col-lg-offset-1 col-md-12">
                                            <div class="row search-row">
                                                <div class="col-md-12 col-lg-6 search-form">
                                                    <div class="search-title col-lg-3 col-sm-3">
                                                        <span class="">法人番号</span>
                                                    </div>
                                                    <div class="col-lg-9 col-sm-9 search-item">
                                                        <input type="text" value="{{ session('client_code_cont') }}"
                                                            name="client_code" id="client_code" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="col-md-12 col-lg-6 search-form">
                                                    <div class="search-title col-lg-3 col-sm-3">
                                                        <span class="">登録日</span>
                                                    </div>
                                                    <div class="col-lg-4 col-sm-4 search-item">
                                                        <input type="text" value="{{ session('created_at_st_cont') }}"
                                                            name="created_at_st" id="datepicker" class="form-control"
                                                            autocomplete="off">
                                                    </div>
                                                    <div class="search-title col-lg-1 col-sm-1">
                                                        <span class="">~</span>
                                                    </div>
                                                    <div class="col-lg-4 col-sm-4 search-item">
                                                        <input type="text" value="{{ session('created_at_en_cont') }}"
                                                            name="created_at_en" id="datepicker2" class="form-control"
                                                            autocomplete="off">
                                                    </div>
                                                    <div class="text-danger">
                                                        {{ $errors->has('created_at_st') ? $errors->first('created_at_st') : '' }}
                                                    </div>
                                                    <div class="text-danger">
                                                        {{ $errors->has('created_at_en') ? $errors->first('created_at_en') : '' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- end --}}
                                        @csrf
                                        <div class="col-lg-12 ">
                                            <div class="col-lg-3 col-sm-3 col-lg-offset-3 col-sm-offset-3">
                                                <button type="submit" id="search"
                                                    class="search-button btn btn-primary btn-sm">検索</button>
                                            </div>
                                            <div class="col-lg-3 col-sm-3">
                                                <button type="button" id="clear"
                                                    class="clear-button btn btn-default btn-sm">クリア</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="timeline-item">
                        <div class="timeline-body">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-lg-1">
                                        @if (Crofun::contract_index_return_button() == 1)
                                            <a href="{{ route('customer_edit', ['id' => request()->client_id]) }}">
                                                <button class="btn btn-warning btn-sm"> 戻る</button>
                                            </a>
                                        @endif
                                        @if (Crofun::contract_index_return_button() == 2)
                                            <a href="{{ route('customer_view', ['id' => request()->client_id]) }}">
                                                <button class="btn btn-warning btn-sm"> 戻る</button>
                                            </a>
                                        @endif
                                        @if (Crofun::contract_index_return_button() == 3)
                                            <a href="{{ route('edit_project', ['id' => request()->project_id]) }}">
                                                <button class="btn btn-warning btn-sm"> 戻る</button>
                                            </a>
                                        @endif
                                        @if (Crofun::contract_index_return_button() == 4)
                                            <a href="{{ route('view_project', ['id' => request()->project_id]) }}">
                                                <button class="btn btn-warning btn-sm"> 戻る</button>
                                            </a>
                                        @endif
                                    </div>
                                    <div class="col-lg-3 col-lg-offset-9">
                                        @paginate(['item'=>$contract]) @endpaginate
                                    </div>
                                </div>
                                <div class="row">

                                    <table id="contract_table" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>顧客コード</th>
                                                <th>顧客名</th>
                                                <th>プロジェクト</th>
                                                <th>プロジェクト名</th>
                                                <th>ファイル名</th>
                                                <th>本部</th>
                                                <th>部署</th>
                                                <th>グループ</th>
                                                <th>登録日</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($contract as $contract)
                                                <tr>

                                                    <td>
                                                        @if (Auth::user()->can('display', $contract))
                                                            <a target="_blank" rel="noopener noreferrer"
                                                                href="{{ route('contract_display', ['id' => $contract->id]) }}"><button
                                                                    style="float: left;"
                                                                    class="btn btn-info btn-sm">参照</button>
                                                            </a>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        @if ($contract->customer->client_code_main == null)
                                                            {{ $contract->customer->client_code }}
                                                        @else
                                                            {{ $contract->customer->client_code_main }}
                                                        @endif
                                                    </td>
                                                    <td>{{ $contract->customer->client_name }}</td>
                                                    <td>
                                                        @if ($contract->project)
                                                            {{ $contract->project->project_code }} @endif
                                                    </td>
                                                    <td>
                                                        @if ($contract->project)
                                                            {{ $contract->project->project_name }} @endif
                                                    </td>
                                                    <td>{{ $contract->save_ol_name }}</td>
                                                    <td>
                                                        @if ($contract->headquarter)
                                                            {{ $contract->headquarter->headquarters }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($contract->department)
                                                            {{ $contract->department->department_name }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($contract->group)
                                                            {{ $contract->group->group_name }} @endif
                                                    </td>
                                                    <td>{{ date('Y年m月d日', strtotime($contract->created_at)) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>
                            </div>

                        </div>
                </li>
                <li>
                </li>
            </ul>
        </div>
    </div>
    <script type="text/javascript">
        $(document).on('click', '#clear', function() {
            //1ページに移動
            $('#example2').DataTable().state.clear();
            $('#company_id').prop('selectedIndex', 0);
            $('#headquarter_id').prop('selectedIndex', 0);
            $('#department_id').prop('selectedIndex', 0);
            $('#group_id').prop('selectedIndex', 0);
            $('#client_code').val('');
            $('#corporation_num').val('');
            $('#client_name_kana').val('');
            $('#project_code').val('');
            $('#project_name').val('');
            $('#datepicker').val('');
            $('#datepicker2').val('');
            $('#form').submit();

        });

        $('#datepicker').datepicker({
            autoclose: true,
            todayHighlight: true,
        });

        $('#datepicker2').datepicker({
            autoclose: true,
            todayHighlight: true,
        });

    </script>
@endsection
