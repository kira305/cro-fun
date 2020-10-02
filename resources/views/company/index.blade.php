@extends('layouts.app')


@section('content')
@section('breadcrumbs', Breadcrumbs::render('company/index'))
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
	td { 
		padding : 3px!important; 
		word-wrap: break-word;
		overflow-wrap: break-word;
		white-space: normal;
	}
</style>
      <div class="row">
        <div class="col-md-12">
       
          <ul class="timeline">
	          	<li>
	             
	            </li>
	            <li>
					          
	            </li>
	            <li>
	            		             
	              <div class="timeline-item">

	                <div class="timeline-body">   
				            <div class="box-body">
				            	<div class="row">
				            		<div class="col-sm-1"></div>
				            		<div class="col-sm-2">
						               @if( Auth::user()->can('create','App\Company_MST'))
							               <a href="{{ url('company/create') }}">
							                 	<button type="submit" style="float: left;margin-left: 10%" class="btn btn-primary btn-sm">新規登録</button>
							               </a>
							           @endif	
				            		</div>
				            		<div class="col-sm-5"></div>
				            		<div style="float: right" class="col-sm-3">
							        
							          	   @paginate(['item'=> $companies]) @endpaginate

							        </div>
							        <div class="col-sm-1"></div>
				            	</div>
                              	<div class="row">  

					              <table id="company_table" class="table table-bordered table-hover">
					                <thead>
					                <tr>
					                  <th style="width: 100px;">編集</th>
					                  <th>会社名</th>
					                  <th>省略名</th>
					                </tr>
					                </thead>
					                <tbody>
                                    @foreach ($companies as $company)
						                <tr>
						                  <td>
						                  	@if( Auth::user()->can('update','App\Headquarters_MST'))
						                 		<a href="{{route('editcompany', ['id' => $company->own_company,'page'=>request()->page])}}">
						                 		<button  style="float: left;" class="btn btn-info btn-sm">編集</button>
								                 </a>
							                @endif	
						                  </td>
						                  <td>{{  $company->company_name }}</td>
						                  <td>{{  $company->abbreviate_name }}</td>
						                </tr>
                                    @endforeach
					                </tbody>

					              </table>
					           </div>
				            </div>
				            <!-- /.box-body -->
				          
	                </div>
	               
	              </div>
	            </li>
          </ul>
        </div>
      </div>
@endsection
