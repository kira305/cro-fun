@extends('layouts.app')

@section('content')
@section('breadcrumbs', Breadcrumbs::render('user/edit',$user))
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
	            	    @if (isset($message))

			              <p class="message" >{{ $message }}</p>

					    @endif

				        <form id="create_user" method="post" action="{{ url('user/edit') }}">					             
					        <div class="row">
				                <div class="col-md-3 offset-md-3">
				                  <label class="input_lable"><b>社員番号</b></label>
				                </div>
				                <div class="col-xs-2">
				                     <div class="form-group">
				                       <input type="text" name="usr_code" class="form-control" value="{{$user->usr_code}}" 
				                       @if (Auth::user()->checkCompany($user->company_id) == false) disabled @endif
				                       @if (Auth::user()->checkIsDisable($user->id) == 1) disabled @endif
				                       >
				                       <input type="hidden" type="text" name="id" class="form-control" value="{{$user->id}}" id="user_id">
				                     </div>
				                </div>
				                @if ($errors->has('usr_code'))

	                                <span class="text-danger">{{ $errors->first('usr_code') }}</span>

                                @endif
                                @if ($errors->has('unique'))

	                                <span class="text-danger" >{{ $errors->first('unique') }}</span>

                                @endif
			                </div>
			                 <div class="row">
					                <div class="col-md-3 offset-md-3">
					                  <label class="input_lable"><b>社員名</b></label>
					                </div>
					                <div class="col-xs-2">
					                	 <div class="form-group">
					                       <input 
					                        type="text" name="usr_name" class="form-control" value="{{$user->usr_name}}" 
					                        @if (Auth::user()->checkCompany($user->company_id) == false) disabled @endif
					                        @if (Auth::user()->checkIsDisable($user->id) == 1) disabled @endif
					                        >
					                     </div>
					                </div>
					                @if ($errors->has('usr_name'))
   	                     
    	                                 <span class="text-danger">{{ $errors->first('usr_name') }}</span>

	                                @endif
			                </div>
			                <div class="row">
			              
				                <div class="col-md-3 offset-md-3">
				                  <label class="input_lable"><b>所属会社</b></label>
				                </div>
				                <div class="col-xs-2">
					                 <div class="form-group">
                                      @if (Auth::user()->checkIsDisable($user->id) == 1) 
                                          	<input 
					                        type="text"  readonly class="form-control" value="{{$user->company->company_name}}" 
					                        >
                                      @else
						                  @if (Auth::user()->checkCompany($user->company_id) == true) 
						                  <select class="form-control" name="company_id" id="company_id">
						                  	@foreach($companies as $company)
							                    <option 
							                    @if ($user->company_id == $company->id) selected @endif 
							                    value="{{$company->id}}">{{$company->abbreviate_name}}
							                    </option>
						                    @endforeach
						                    @else
											<select class="form-control" name="company_id" id="company_id" disabled >
							                    <option 
							                    value="{{$user->id}}">{{$user->company->abbreviate_name}}
							                    </option>
						                    @endif
						                  </select>
						              @endif
					                </div>
				                </div>
				                @if ($errors->has('company_id'))

	                               <span class="text-danger">{{ $errors->first('company_id') }}</span>

                                @endif
					        </div>

					        <div class="row">
			              
				                <div class="col-md-3 offset-md-3">
				                  <label class="input_lable"><b>所属本部</b></label>
				                </div>
				                <div class="col-md-2">
				                	<div class="form-group">
				                	@if (Auth::user()->checkIsDisable($user->id) == 1) 
                                          	<input 
					                        type="text"  readonly class="form-control" value="{{$user->headquarter->headquarters}}" 
					                        >
                                     @else
							                  @if (Auth::user()->checkCompany($user->company_id) == true) 
								                    <select class="form-control"  id="headquarter_id" name="headquarter_id" >
								                      <option value=""> </option>
											          @foreach($headquarters as $headquarter)
									                    <option class="headquarter_id" 
									                      data-value="{{ $headquarter->company_id }}"
									                      @if ($user->headquarter_id == $headquarter->id) selected @endif 
									                    value="{{$headquarter->id}}">{{$headquarter->headquarters}}
								                    </option>
								                  
							                          @endforeach
							                  @else
								                    <select class="form-control"  id="headquarter_id_N" name="headquarter_id"  disabled >
								                    <option 
								                    value="{{$user->id}}">{{$user->headquarter->headquarters}}
								                    </option>
							                  @endif
													</select>
							       @endif
								    </div>

				                </div>

				                @if ($errors->has('headquarter_id'))

	                                   <span class="text-danger">{{ $errors->first('headquarter_id') }}</span>

                                @endif
					        </div>
                            
                            <div class="row">
			              
				                <div class="col-md-3 offset-md-3">
				                  <label class="input_lable"><b>所属部署</b></label>
				                </div>
				                <div class="col-md-2">
				                	<div class="form-group">
				                	@if (Auth::user()->checkIsDisable($user->id) == 1) 
                                          	<input 
					                        type="text"  readonly class="form-control" value="{{$user->department->department_name}}" 
					                        >
                                     @else
						                  @if (Auth::user()->checkCompany($user->company_id) == true) 
							                    <select class="form-control" id="department_id" name="department_id" >
							                    <option> </option>
										          @foreach($departments as $department)
								                    <option class="department_id" 
								                    data-value="{{ $department->headquarter()->id }}"
								                     @if ($user->department_id == $department->id) selected @endif 
								                    value="{{$department->id}}">{{$department->department_name}}
								                    </option>
								                  
						                          @endforeach
						                    @else
							                    <select class="form-control" id="department_id_N" name="department_id" disabled>
							                    <option value="{{$user->id}}">{{$user->department->department_name}}
							                    </option>
						                    @endif
												</select>
									@endif
								    </div>
				                </div>
				                @if ($errors->has('department_id'))

	                               <span class="text-danger">{{ $errors->first('department_id') }}</span>

                                @endif
					        </div>
					        <div class="row">
			              
				                <div class="col-md-3 offset-md-3">
				                  <label class="input_lable" ><b>所属グループ</b></label>
				                </div>
				                <div class="col-lg-2">
									<div class="form-group">
									@if (Auth::user()->checkIsDisable($user->id) == 1) 
                                          	<input 
					                        type="text"  readonly class="form-control" value="{{$user->group->group_name}}" 
					                        >
                                     @else
							                  @if (Auth::user()->checkCompany($user->company_id) == true) 
										            <select class="form-control" id="group_id" name="group_id" >
										            	<option> </option>
											          @foreach($groups as $group)
								                    <option class="group_id" 
								                     data-value="{{ $group->department()->id }}"
								                     @if ($user->group_id == $group->id) selected @endif 
								                    value="{{$group->id}}">{{$group->group_name}}
								                    </option>
								                  
							                          @endforeach
							                    @else
								                    <select class="form-control" id="group_id_N" name="group_id" disabled>
								                    <option value="{{$user->id}}">{{$user->group->group_name}}
								                    </option>
							                    @endif
												</select>
									  @endif
									 </div>
								</div>
				           	    @if ($errors->has('group_id'))

	                               <span class="text-danger">{{ $errors->first('group_id') }}</span>

                                @endif
				           	   
					        </div>
					        <div class="row">
			              
				                <div class="col-md-3 offset-md-3">
				                  <label class="input_lable" ><b>役職</b></label>
				                </div>
				                <div class="col-xs-2">
				                	<div class="form-group">
				                    @if (Auth::user()->checkIsDisable($user->id) == 1) 
                                          	<input 
					                        type="text"  readonly class="form-control" value="{{$user->position->position_name}}" 
					                        >
                                     @else
							                  @if (Auth::user()->checkCompany($user->company_id) == true) 
								                    <select class="form-control"  id="position_id" name="position_id" >
								                      <option value=""> </option>
											          @foreach($position_list as $position)
									                    <option class="position_id" 
									                      data-value="{{ $position->company_id }}"
									                      @if ($user->position_id == $position->id) selected @endif 
									                    value="{{$position->id}}">{{$position->position_name}}
								                    </option>
								                  
							                          @endforeach
							                    @else
								                    <select class="form-control"  id="position_id_N" name="position_id"  disabled >
								                    <option 
								                    value="{{$user->id}}">{{$user->position->position_name}}
								                    </option>
							                    @endif
												</select>
									@endif
								    </div>				                

				                </div>
				           		@if ($errors->has('position_id'))

	                              <span class="text-danger">{{ $errors->first('position_id') }}</span>

                                @endif
					        </div>
					         <div class="row">
				                <div class="col-md-3 offset-md-3">
				                  <label class="input_lable"><b>メールアドレス</b></label>
				                </div>
				                <div class="col-xs-2">
				                	 <div class="form-group">
				                	@if (Auth::user()->checkIsDisable($user->id) == 1) 
                                          	<input 
					                        type="text"  readonly class="form-control" value="{{$user->email_address}}" 
					                        >
                                     @else
				                       <input type="text" name="mail_address" style="width: 500px;" class="form-control" value="{{$user->email_address}}" @if (Auth::user()->checkCompany($user->company_id) == false) disabled @endif>
				                     @endif
				                     @csrf
				                     </div>
				                </div>
				              @if ($errors->has('mail_address'))

                                 <span class="text-danger" style="float: right;margin-right: 400px">{{ $errors->first('mail_address') }}</span>

                              @endif
			                </div>
			                <div class="row">
			              
				                <div class="col-md-3 offset-md-3">
				                  <label class="input_lable" ><b>画面機能ルール</b></label>
				                </div>
				                <div class="col-xs-2">

				                	<div class="form-group">
				                	 @if (Auth::user()->checkIsDisable($user->id) == 1) 
                                          	<input 
					                        type="text"  readonly class="form-control" value="{{$user->getrole->rule}}" 
					                        >
                                     @else
							                  @if (Auth::user()->checkCompany($user->company_id) == true) 
								                    <select class="form-control"  id="rule_id" name="rule_id" >
								                      <option value=""> </option>
											          @foreach($rule_list as $rule)
									                    <option class="rule_id" 
									                      data-value="{{ $rule->company_id }}"
									                      @if ($user->rule == $rule->id) selected @endif 
									                    value="{{$rule->id}}">{{$rule->rule}}
								                    </option>
								                  
							                          @endforeach
							                    @else
								                    <select class="form-control"  id="rule_id_N" name="rule_id"  disabled >
								                    <option 
								                    value="{{$user->id}}">{{$user->getrole->rule}}
								                    </option>
							                    @endif
												</select>
									@endif
								    </div>				                

				                </div>

				               @if ($errors->has('rule_id'))

	                                <span class="text-danger">{{ $errors->first('rule_id') }}</span>

                                @endif
	           
					        </div>
					        <div class="row">
			              
				                <div class="col-md-3 offset-md-3">
				                  <label class="input_lable hidden_lable">退職</label>
				                </div>
				                <div class="col-xs-2">
					                 <div class="form-group">
	                                    <input type="checkbox" name="retire"  @if ($user->retire == true) checked @endif
	                                    class="minimal" @if (Auth::user()->checkCompany($user->company_id) == false) disabled @endif
	                                    @if (Auth::user()->checkIsDisable($user->id) == 1) 
	                                      readonly
	                                    @endif
	                                    >
					                </div>
				                </div>
					           
					        </div>
			                <div class="row">
		                	　　　<br>
		                	    @if (Auth::user()->checkIsDisable($user->id) == 1) 
		                	    <div class="col-sm-2">

				                </div>
                                <div class="col-sm-4">
				                
				                   <a style="float: left;width: 200px;" class="btn btn-danger" 
				                   href="{{ url('user/index?page='.request()->page) }}" >戻る</a>
				                </div>
		                	    @else 
				                <div class="col-sm-3">
				                
				                  <button type="submit" style="float:right;width: 200px;" class="btn btn-primary"@if (Auth::user()->checkCompany($user->company_id) == false) disabled @endif>更新</button>
				                </div>
                                <div class="col-sm-4">
				                
				                   <a style="float: left;width: 200px;" class="btn btn-danger" 
				                   href="{{ url('user/index?page='.request()->page) }}" >戻る</a>
				                </div>
                                @endif
					            <div class="col-sm-5">
					            	
					            </div>
			                </div>
				        </form>
		            </div>
		            <div class="row">
		             <div class="col-md-3"></div>
			  	     <div class="box-body col-md-9 offset-md-9 ">
				                   
			              <table id="example2" class="table table-bordered table-hover">
			                <thead>
			                <tr>
			                  <th style="width: 100px;">編集</th>
			                  <th>会社</th>
			                  <th>兼務本部</th>
			                  <th>兼務部署</th>
			                  <th>兼務グループ</th>
			                  <th>役職</th>
			                  <th>ステータス</th>
			                  <th></th>

			                </tr>
			                </thead>
			                <tbody>
                            @foreach ($concurrents as $concurrent)
				                <tr>
				                  <td>
                                    @if($concurrent->status == true)
				                  	<a href="{{route('concurrentedit', ['id' => $concurrent->id])}}" >
				                  	 <button type="submit" 
				                  	  @if (Auth::user()->checkIsDisable($user->id) == 1) 
				                  	    disabled
				                  	  @endif
				                  	  style="float: left;" class="btn btn-info btn-sm">編集</button>
				                  	</a>
                                    @endif
				                  </td>
				                  <td>{{  $concurrent->company->abbreviate_name }}</td>
				                  <td>{{  $concurrent->headquarter->headquarters }}</td>
				                  <td>{{  $concurrent->department->department_name }}</td>
				                  <td>{{  $concurrent->group->group_name }}</td>
				                  <td>{{  $concurrent->position->position_name }}</td>
				                  <td>
				                  	@if($concurrent->status == true)
					                  	{{ "兼務" }}
				                  	@else
				                  		{{ "兼務解除" }}
				                  	@endif
				                  </td>

                              	  <td>
  				                  	@if($concurrent->status == true)
		                              	<button  
		                              	   @if (Auth::user()->checkIsDisable($user->id) == 1) 
		                              	     disabled
		                              	   @endif
		                              	   data-value = "{{$concurrent->id}}"  class="btn btn-danger delete btn-sm">削除
		                              	</button>
		                            @else
                                        <button  
		                              	   @if (Auth::user()->checkIsDisable($user->id) == 1) 
		                              	     disabled
		                              	   @endif
		                              	   onclick="location.href='{{ url('user/concurrent/reset?id='.$concurrent->id)}}';"
		                              	   class="btn btn-danger btn-sm">解除取消
		                              	</button>
		                            @endif
	                              </td>
				                </tr>
                            @endforeach
			                </tbody>

			              </table>
			           <a href="{{route('concurrentcreate', ['usr_id' => $user->id])}}">
			           	<button 
			           	@if (Auth::user()->checkIsDisable($user->id) == 1) 
		                    disabled
		                @endif
			           	type="button" class="btn btn-primary">兼務情報新規登録</button></a>
		             </div>
			        </div>   
		            <!-- /.box-body -->
		          </div>
                </div>
               
              </div>

            </li>
            <li>

            </li>
           
          </ul>
        </div>
      </div>
<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
<script type="text/javascript">

</script>
<script src="{{ asset('select/icontains.js') }}" ></script>

<script src="{{ asset('select/comboTreePlugin.js') }}" ></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script type="text/javascript">


	$(document).on('change', '#headquarter_id', function () {

         $('#department_id').prop('selectedIndex',0);
         $('#group_id').prop('selectedIndex',0);
         $( "#department_id" ).prop( "disabled", false );
        var headquarter_id = $("#headquarter_id").val();

         $( ".department_id" ).each(function() {

		       $(this).show();
		       if($(this).attr('data-value') !== headquarter_id){

		       	     $(this).hide();
 
		       }

		   });




    });
     
    $(document).on('change', '#department_id', function () {
        
        $('#group_id').prop('selectedIndex',0);
        $( "#group_id" ).prop( "disabled", false );
        var department_id = $("#department_id").val();

         $( ".group_id" ).each(function() {

		       $(this).show();
		       if($(this).attr('data-value') !== department_id){

		       	     $(this).hide();
 
		       }

		   });

         


    });

    $(document).ready(function() {
          
		$(".delete").click(function(){
			var base        =  '{!! route("concurrentdelete") !!}';
			var id = $(this).data('value');
			var user_id = $("#user_id").val();
            var url         =  base+"?id="+id+"&usr_id="+user_id;
			$.confirm({
			    title: 'このデータを削除しますか',
			    content: '',
			    type: 'red',
			    typeAnimated: true,
			    buttons: {
			        delete: {
			            text: 'YES',
			            btnClass: 'btn-blue',
			            with :'100px',
			            action: function(){
				            			window.location.href = url;
			            }
			        },
			        cancel: {
			            text: 'NO',
			            btnClass: 'btn-red',
			            action: function(){
			            }
			        }
			    }
			});
		});          
         
          $( "#department_id" ).prop( "disabled", true );
          $( "#group_id" ).prop( "disabled", true );

    });


		
// var SampleJSONData = [
//     @foreach($departments as $department)
//     {
//         id: "{{ $department->department_code }}",
//         title: "{{ trim($department->department_name) }}",
//         subs: [
//             @foreach($department->groups as $group)
// 	            {
// 	                id: "{{ $group->group_code }}",
// 	                title: "{{ trim($group->group_name) }}"
// 	            },
//             @endforeach
//         ]
//     },
//    @endforeach
// ];
// var comboTree1;
// var selected_id = "value";
//   var spans = $( "span" );
// 	$( "#create_user" ).submit(function( event ) {
          
//        $( ".li_class" ).each(function( index ) {
		    
		    
// 		    // alert($(this).find('.comboTreeItemTitle').attr("data-id"));
// 		    // alert($(this).find('.input_checkbox').val());

// 		    if($(this).find('.input_checkbox').prop("checked") == true){
// 		    	// alert($(this).find('.comboTreeItemTitle').attr("data-id"));
//                 selected_id = selected_id + "," + $(this).find('.comboTreeItemTitle').attr("data-id");
               
              
// 		    }

// 		});

//           $("#group_id").val(selected_id);


// 	});

// jQuery(document).ready(function($) {
        
//         $.ajax({

//            type:'POST',

//            url:'/ajax/list_group',

//            data:{
// 			        "_token": "{{ csrf_token() }}",
// 			        "usr_id": '{{ $user->usr_id}}'
// 			    },

//            success:function(data){

//              var selected_title = "";
//              $( ".li_class" ).each(function() {

//                  if(data.includes($(this).find('.comboTreeItemTitle').attr("data-id"))){
                  
//                     $(this).find('.input_checkbox').prop('checked', true);
//                     if($(this).find('.input_checkbox').prop("checked") == true){
			    	   
// 			    	   if(selected_title == ""){

// 			    	   	  selected_title = selected_title + $(this).find('.comboTreeItemTitle').text();

// 			    	   }else {
                          
//                            selected_title = selected_title + "," + $(this).find('.comboTreeItemTitle').text();

// 			    	   }
	                   

               
              
// 		             }

//                  }

//              });

//               $('#justAnInputBox').val(selected_title);

//            }

//         });

// 		comboTree1 = $('#justAnInputBox').comboTree({
// 			source : SampleJSONData,
// 			isMultiple: true
// 		});

// });


</script>

@endsection
