@extends('layouts.app')


@section('content')
@section('breadcrumbs', Breadcrumbs::render('rule/create'))
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
				            <form action="{{ url('rule/create') }}" id="create_rule" method="POST">
					                <div class="row">
					              
							                <div class="col-md-3 offset-md-3">
							                  <label class="input_lable">所属会社</label>
							                </div>
							                <div class="col-md-2">
							                	<div class="form-group">
								                    <select class="form-control" id="company_id" name="company_id" >
								               
											          @foreach($companies as $company)
								                    <option 
								                      {{ old('company_id') == $company->id ? 'selected' : '' }}
								                    value="{{$company->id}}">{{$company->abbreviate_name}}
								                    </option>
								                  
							                          @endforeach
													</select>
											    </div>
							                </div>
							                @if ($errors->has('company_id'))

            	                               <span class="text-danger">{{ $errors->first('company_id') }}</span>

        	                                @endif
							        </div>
				            	
	                            <div class="row">
									<div class="col-md-3 offset-md-3">
									                  <label class="input_lable">画面機能ルール</label>
									</div>
									<div class="col-xs-2">
									    <div class="form-group">
									      <input type="text" name="rule_name" value="{{ old('rule_name') }}" class="form-control">
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
		                                              {{ old('admin_flag') == 'on' ? 'checked' : '' }}
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
		                                              {{ old('superuser_user') == 'on' ? 'checked' : '' }}
		                                              name="superuser_user" class="minimal">
										    </div>
									    </div>
									           
								   </div>

								   <div class="row"> 
								   	    <div class="col-md-3">
									     
									    </div>
									    <div class="col-xs-2">
                                           
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
							          <table  class="table table-bordered table-hover">

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
							                    @if($menu->id != 0)
							                         {{ old($menu->id) == $menu->id ? 'checked' : '' }}
							                    @endif
                                                @if(old($menu->id) === '0')
                                                       checked
                                                @endif
							                         value="{{ $menu->id }}" class="check_rule">  {{  $menu->link_name }}
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
      	<!--
      	$(document).on('submit','#create_rule',function(){
           
                var check_data = [];

        	   $( ".check_rule" ).each(function() {

		             if($(this).is(":checked")){

		             	check_data.push($(this).val());
		             }

                     
		        });
              console.log(check_data);
               $("#check_data").val(check_data);


        });
  		
		$( document ).ready(function() {

		 //    $( ".check_area" ).click(function() {
			     

			//      if(!$(this)..prev().find('.check_rule').is(":checked")){
                 
   //                    $(this).find('.check_rule').prop('checked', true);

			//      }else {

			//      	  $(this).find('.check_rule').prop('checked', false);
			//      }
                 	     				     
			     
			// });

		});
 		-->
      </script>
@endsection
