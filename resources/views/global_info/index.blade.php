@extends('layouts.app')


@section('content')
@section('breadcrumbs', Breadcrumbs::render('global_info/index'))
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
	.hfsz { 
		font-size: 9pt; 
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

						        <form action="{{ url('global_info/index') }}" id="form" method="POST">
						        	  	<div class="row">
						                        <div class="col-md-3"></div>
								                <div class="col-md-1 offset-md-3 text-right">
								                  <label style="float: right;min-width: 100px;">状態</label>
								                </div>
								                <div class="col-md-2">
								                 <div class="form-group">
								                  <select class="form-control" id="important_flg" name="important_flg">
								                  	<option value="">▼ 選択してください</option>
								                  	@foreach($sel_data as $id => $data)
									                <option 
									                @if(isset($important_flg_info))
									                @if ($important_flg_info == $id) selected @endif 
									                @endif
									                value="{{$id}}">{{$data}}</option>
								                     @endforeach
								                  </select>
								                </div>
								                </div>
								        </div>

						                 @csrf
						                <div class="row">
						                	　　　<br>
								                <div class="col-md-5">
								                
								                  <button type="submit" style="float: right;width: 100px;" class="btn btn-primary btn-sm">検索</button>

								                </div>
								                <div class="col-md-5">
								                
								                  <button type="button" style="float: left;width: 100px;"  id="clear" class="btn btn-default btn-sm">クリア</button>

								                </div>

								              
						                </div>
						        </form>
				            </div>
				          </div>
	                </div>
	               
	              </div>
	            <li>
	            		             
	              <div class="timeline-item">

	                <div class="timeline-body">
	                      <div>
				          
				            <div class="box-body">

						          <div class="row">
                                    <div class="col-sm-1">
						          	</div>
						          	<div class="col-sm-2">
							          	@if( Auth::user()->getRuleAction(11))
						                 <a href="{{ url('global_info/create') }}">
						                 	<button type="submit" style="float: left;" class="btn btn-primary btn-sm">新規登録</button>
						                 </a>
						                @endif
						          	</div>
						          	<div class="col-sm-6">
						          		
						          	</div>
                                    <div class="col-sm-2">
                                    	@if(sizeof($global_infos)  > 0)
                                           @paginate(['item'=>$global_infos]) @endpaginate
                                    	@endif
                                    </div>
                                    <div class="col-sm-1">
                                    	
                                    </div>
					               </div>
					               <div class="row">	
	                				<table id="example" class="table table-bordered table-hover">
							                <thead>
							                <tr>
							                  <th width="5%"  class="hfsz text-center">編集</th>
							                  <th width="25%" class="hfsz text-center">掲載期間</th>
							                  <th width="8%"  class="hfsz text-center">重要度</th>
							                  <th width="25%" class="hfsz">タイトル</th>
							                  <th width="37%" class="hfsz">内容</th>
							                </tr>
							                </thead>
							                <tbody>
		                                    @foreach ($global_infos as $global_info)
								                <tr>
								                  <td class="hfsz text-center">
								                  <a href="{{route('edit_global_info', ['id' => $global_info->id])}}" ><button type="submit" style="float: left;" class="btn btn-info btn-sm">編集</button></a>
								                  </td>
								                  <td class="hfsz text-center">
								                  @if (!empty($global_info->start_date))
								                  {{  date('Y/m/d[H:i]', strtotime($global_info->start_date)) }}
								                  @endif
								                  ～
								                  @if (!empty($global_info->end_date))
								                  {{ date('Y/m/d[H:i]', strtotime($global_info->end_date)) }}</td>
								                  @endif
								                  <td class="hfsz text-center">{{  $dis_data[$global_info->important_flg] }}</td>
								                  <td class="hfsz">{{  $global_info->global_info_title }}</td>
								                  <td class="hfsz">{{  $global_info->global_info_content }}</td>
								                </tr>
		                                    @endforeach
							                </tbody>

							              </table>
							        </div>
						          </div>

					          
				            </div>
				            <!-- /.box-body -->
				          </div>
	                </div>
	               
	              </div>
	            </li>
          </ul>
        </div>
      </div>

 <script type="text/javascript">


   
    $(document).ready(function() {
      
         
          $( "#department_id" ).prop( "disabled", true );

          if($( "#headquarter_id" ).val() != ""){
            
            $( "#department_id" ).prop( "disabled", false );
            
                     var headquarter_id = $("#headquarter_id").val();

			         $( ".department_id" ).each(function() {

					       $(this).show();
					     
					       if($(this).attr('data-value') !== headquarter_id){
			                     
					       	   $(this).remove();
			 
					       }

					   });


          }

         $("#clear").click(function(){
             
             $('#example2').DataTable().state.clear();
			 $('#important_flg').prop('selectedIndex',0);
             $( "#check" ).prop( "checked", false );
             $( "#form" ).submit();

		 });

		

    });
 </script>
@endsection
