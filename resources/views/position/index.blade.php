@extends('layouts.app')
@section('content')
@section('breadcrumbs', Breadcrumbs::render('position/index'))
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
					        		 @if( Auth::user()->can('create','App\Position_MST'))
						        	   <a href="{{ url('position/create') }}">
						        	   	  <button type="submit" style="float: left;margin-left: 10%;margin-top: 5px;" class="btn btn-primary btn-sm">新規登録</button>
						        	   	</a>
					        	   	@endif			
				            		</div>
				            		<div class="col-sm-5"></div>
				            		<div style="float: right" class="col-sm-3">
							        
							          	   @paginate(['item'=> $positions]) @endpaginate

							        </div>
							        <div class="col-sm-1"></div>
				                  </div>
						        <div class="row"> 
					              <table id="position_table" class="table table-bordered table-hover">
					                <thead>
					                <tr>
					                  <th class="edit_button_with">編集</th>

					                  <th>役職名</th>
                                      <th>詳細情報参照参照</th>
                                      <th>所属会社名</th>
                                      
					                </tr>
					                </thead>
					                <tbody>
                                    @foreach ($positions as $position)
						                <tr>
						                  <td>
							                @if( Auth::user()->can('update','App\Position_MST'))
						                  	<a href="{{route('edit_position', ['id' => $position->id,'page' => request()->page])}}" ><button type="submit" style="float: left;" class="btn btn-info btn-sm">編集</button></a>
						                  	@endif
						                  </td>

						                  <td>{{  $position->position_name }}</td>
                                          <td>{{  $position->getLookAttribute() }}</td>
						                  <td>{{  $position->company->abbreviate_name }}</td>
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
