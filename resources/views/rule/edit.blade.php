@extends('layouts.app')


@section('content')
@section('breadcrumbs', Breadcrumbs::render('rule/edit'))
      <div class="row">
        <div class="col-md-12">
       
          <ul class="timeline">
	          	<li>
                 <div class="timeline-item">
           
	                <div class="timeline-body">
				            
				            <div class="box-body">
				            	    @if (isset($message))


						              <p class="message" >{{ $message }}</p>

					
								    @endif
				            <form action="{{ url('rule/edit') }}" id="create_rule" method="POST">

								             
			                <div class="row">
			              
					                <div class="col-md-3 offset-md-3">
					                  <label style="float: right;"><b>所属会社</b></label>
					                </div>
					                <div class="col-xs-2" >
									<div class = "form-control" disabled>
										{{$rule->company->abbreviate_name}}
									</div>

					                </div>

					        </div>
					        <br>
				            	
	                            <div class="row">
									<div class="col-md-3 offset-md-3">
									    <label style="float: right;"><b>画面機能ルール</b></label>
									</div>
									<div class="col-xs-2">
									    <div class="form-group">
									     <input type="text" name="rule_name" value="{{ $rule->rule }}" class="form-control">
									     <input type="hidden" name="rule_id" value="{{ $rule->id }}" class="form-control">
									    </div>
									</div>
									@if ($errors->has('rule_name'))

	                	                     
	                	                <span class="text-danger">{{ $errors->first('rule_name') }}</span>

	            	                @endif
	            	                @if ($errors->has('unique'))

                	                    <span class="text-danger" >{{ $errors->first('unique') }}</span>

            	                    @endif
							      </div>
							        @csrf
								  <div class="row">
							              
									    <div class="col-md-3">
									      <label style="float: right">管理者フラグ</label>
									    </div>
   									    <label style="float: left;color: blue;">CRO-FUN内の所属会社情報更新権限付与</label>

									    <div class="col-xs-2">
										    <div class="form-group">
		                                       <input type="checkbox" 
		                                              {{ $rule->admin_flag == '1' ? 'checked' : '' }}
		                                              name="admin_flag" class="minimal">
										    </div>
									    </div>
									           
								   </div>

								  <div class="row">
							              
									    <div class="col-md-3">

									      <label style="float: right">全会社参照フラグ</label>
									    
									    </div>

   									    <label style="float: left;color: blue;">CRO-FUN内の全会社情報更新権限付与</label>

									    <div class="col-xs-2">
										    <div class="form-group">
		                                       <input type="checkbox" 
		                                              {{ $rule->superuser_user == '1' ? 'checked' : '' }}
		                                              name="superuser_user" class="minimal">
										    </div>
									    </div>
								   </div>
	                               <div class="row">
							                	　　　<br>
									                <div class="col-md-4">
									                
									                  <button type="submit" style="float: right;width: 200px;" class="btn btn-primary">登録</button>
									                </div>
									                <div class="col-md-5">
									                
									                <a style="float: left;width: 200px;" class="btn btn-danger" href="{{ url('rule/index') }}" >戻る</a>

									                </div>

									              
							        </div>
							        <div class="row">
							          <table id="example2" class="table table-bordered table-hover">

						                <tbody>
	                                    @foreach ($menus as $menu)
							                <tr class="check_area">

							                  <td style="padding: 0px;"> 
								                 @if(($menu->dis_sort == 1)||($menu->dis_sort == 0) )
	                                                  
	                                                  @if(($menu->dis_sort === Null))

	                                                    <label style="margin-left: 30px">

	  		                                          @else

		                                               <label>
	  		
		                                              @endif	

		                                          @else

	  	                                                <label style="margin-left: 30px">
							          
	                                        	  @endif
						                	
							                  <input type="checkbox" name="{{ $menu->id }}"style="margin-right: 15px;"
							                          {{ $menu->rule_action($rule->id) == true ? 'checked' : '' }}
							                         value="{{ $menu->id }}" class="check_rule">{{  $menu->link_name }}
							                  </label>
							                  </td>
							                </tr>
	                                    @endforeach
						                </tbody>
                                        <input type="hidden" name="check_data" value="" id="check_data">
						              </table>
							        </div>           

					            </form>
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

      	$(document).on('submit','#create_rule',function(){
           
                var check_data = [];

        	   $( ".check_rule" ).each(function() {

		             if($(this).is(":checked")){

		             	check_data.push($(this).val());
		             }

                     
		        });
              
               $("#check_data").val(check_data);


        });



      </script>
@endsection
