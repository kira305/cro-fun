<?php
namespace App\Http\ViewComposers;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Laracasts\Utilities\JavaScript\JavaScriptFacade as Javascript;
use App\User;
use App\Company_MST;
use App\Project_MST;
use App\Diagram;
use DB;
use Common;
class GetListDepartmentDiagramComposer
{

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
       

        $usr_id        = Auth::user()->id;
        
        $company_id    = Common::checkUserCompany($usr_id);
        if(request()->company_id != null || request()->company_id != ""){
        
          $company_id    = request()->company_id;
          $diagrams      = Diagram::where('company_id',$company_id)->get();

        }else {
          
          $diagrams      = Diagram::whereIn('company_id',$company_id)->get();

        }
       
        $list_diagrams   = array();
        $checked_diagram = array();

        foreach ($diagrams as $diagram) {

           if(!in_array($diagram->department_code, $checked_diagram) && $diagram->department_name != null){
              
              array_push($list_diagrams, $diagram);
              array_push($checked_diagram, $diagram->department_code);
              
           }
           
        }
    
        $view->with([

             'departments'           =>  $list_diagrams,
          
        ]);
    }
}