@extends('layouts.app')


@section('content')
@section('breadcrumbs', Breadcrumbs::render('mail_mst/indexm'))
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
						                 <a href="{{ url('mail_mst/createm') }}">
						                 	<button type="submit" style="float: left;" class="btn btn-primary">新規登録</button>
						                 </a>
						                @endif	
						          	</div>
                                    <div class="col-sm-6">
                                    	
                                    </div>
                                    <div class="col-sm-2">
                                    	 @paginate(['item'=>$mail_msts]) @endpaginate
                                    </div>
                                    <div class="col-sm-1">
                                    	
                                    </div>
					               </div>
					               <div class="row">
	                				<table id="example" class="table table-bordered table-hover">
							                <thead>
							                <tr>
							                  <th width="5%" class="hfsz text-center">編集</th>
							                  <th width="5%" class="hfsz text-center">ID</th>
							                  <th width="30%" class="hfsz text-left">管理名称</th>
							                  <th width="60%"  class="hfsz text-left">メールタイトル</th>
							                </tr>
							                </thead>
							                <tbody>
		                                    @foreach ($mail_msts as $mail_mst)
								                <tr>
								                  <td class="hfsz text-center">
								                  <a href="{{route('edit_mail_mst', ['id' => $mail_mst->id])}}" ><button type="submit" style="float: left;" class="btn btn-info btn-xs">編集</button></a>
								                  </td>
								                  <td class="hfsz text-center">{{  $mail_mst->id }}</td>
								                  <td class="hfsz">{{  $mail_mst->mail_ma_name }}</td>
								                  <td class="hfsz">{{  $mail_mst->mail_remark }}</td>
								                </tr>
		                                    @endforeach
							                </tbody>

							              </table>
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
