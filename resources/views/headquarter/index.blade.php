@extends('layouts.app')


@section('content')
@section('breadcrumbs', Breadcrumbs::render('headquarter/index'))
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
                 <div class="timeline-item">
	               
	                <div class="timeline-body">
	                      <div>
				            
				            <div class="box-body">

						        <form id="form" action="{{ url('headquarter/index') }}" method="POST">
						        	  	<div class="row">
						              
								                <div class="col-md-3 offset-md-3">
								                  <label class="input_lable">所属会社</label>
								                </div>
								                <div class="col-xs-2">
								                 <div class="form-group">
								                  <select class="form-control" id="company_id" name="company_id">
								                  	<option value=""> </option>
								                  	@foreach($companies as $company)
									                <option 
									                @if(isset($company_id))
									                @if ($company_id == $company->id) selected @endif 
									                @endif
									                value="{{$company->id}}">{{$company->abbreviate_name}}</option>
								                     @endforeach
								                  </select>
								                </div>
								                </div>

								                <div class="col-md-1 offset-md-3">
								                  <label class="input_lable">事業本部名</label>
								                </div>
								                <div class="col-xs-2">
								                 <div class="form-group">
								                 	<input type="" id="headquarter_name" name="headquarter_name"  @if(isset($headquarter_name)) value="{{ $headquarter_name }}"  @endif class="form-control">
								                </div>
								                </div>
								           
								        </div>
								        <div class="row">
						              
								                <div class="col-md-3 offset-md-3">
								                  <label class="input_lable">非表示</label>
								                </div>
								                <div class="col-xs-2">
								                 <div class="form-group">
                                                    <input type="checkbox" name="status" id="check" @if(isset($status))  @if($status == 'on') checked @endif  @endif
                                                    class="minimal">
								                </div>
								                </div>
								           
								        </div>
						                 @csrf
						                <div class="row">
						                	　　　<br>
								                <div class="col-md-5">
								                
								                  <button type="submit"  class="btn btn-primary kensaku_button btn-sm">検索</button>
								                </div>
								                <div class="col-md-5">
								                
								                  <button type="button"   id="clear" class="btn btn-default clear btn-sm">クリア</button>

								                </div>

								              
						                </div>
						        </form>
				            </div>
				            <!-- /.box-body -->
				          </div>
	                </div>
	               
	              </div>
					          
	            </li>
	            <li>
	            		             
	              <div class="timeline-item">

	                <div class="timeline-body">
				            <div class="box-body">
				               <div class="row">
				            		<div class="col-sm-1"></div>
				            		<div class="col-sm-2">
						              @if( Auth::user()->can('create','App\Headquarters_MST'))
						                 <a href="{{ url('headquarter/create') }}"><button type="submit" style="float: left;margin-left: 10%" class="btn btn-primary btn-sm">新規登録</button></a>
						              @endif	
				            		</div>
				            		<div class="col-sm-5"></div>
				            		<div style="float: right" class="col-sm-3">
							        
							          	   @paginate(['item'=> $headquarters]) @endpaginate

							        </div>
							        <div class="col-sm-1"></div>
				              </div>
					          <div class="row">
    
					              <table id="headquarter_table" class="table table-bordered table-hover">
					                <thead>
					                <tr>
					                  <th class="edit_button_with">編集</th>
					                  <th>表示コード</th>
					                  <th>事業本部コード</th>
					                  <th>事業本部名</th>
					                  <th>所属会社名</th>
					                  <th>非表示</th>
					                </tr>
					                </thead>
					                <tbody>
                                    @foreach ($headquarters as $headquarter)
						                <tr>
						                  <td>
							                @if( Auth::user()->can('update','App\Headquarters_MST'))
						                  	<a href="{{route('editheadquarter', ['id' => $headquarter->id,'page'=>request()->page])}}" ><button type="submit" style="float: left;" class="btn btn-info btn-sm">編集</button></a>
							                 @endif						                   
						                  </td>
						                  <td>{{  $headquarter->headquarters_code }}</td>
						                  <td>{{  $headquarter->headquarter_list_code }}</td>
						                  <td>{{  $headquarter->headquarters }}</td>
						                
						                  <td>{{  $headquarter->company()->abbreviate_name }}</td>
						                  <td>@if($headquarter->status == false) 非表示 @endif </td>
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

    <script type="text/javascript">
      	$( document ).ready(function() {
		    
	         $("#clear").click(function(){
	           
	             $('#example2').DataTable().state.clear();
				 $('#company_id').prop('selectedIndex',0);
				 $('#headquarter_name').val('');
	             $( "#check" ).prop( "checked", false );
	             $( "#form" ).submit();

			 });

		});
      </script>
@endsection
