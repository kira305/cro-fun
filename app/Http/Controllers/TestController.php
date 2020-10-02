<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\File_upload;
use App\User;
use App\customer_name_MST;
use App\Cost_MST;
use App\Customer_MST;
use App\Project_MST;
use App\Group_MST;
use App\Department_MST;
use App\Headquarters_MST;
use App\Service\MailService;
use App\Post;
use Mail;
use Auth;
use Response;
use Excel;
use DB;
use Carbon\Carbon;
class TestController extends Controller
{
    protected $mail_service;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MailService $mail_service)
    {
         $this->mail_service = $mail_service;
       
    }
    
    public function import_user(){

         DB::beginTransaction();
         try {

             $file_url = public_path() . '/import/user_mst.txt';
             $row = 0;
             if (($handle = fopen($file_url, "r")) !== FALSE) {

                while (($data = fgets($handle)) !== FALSE) {

                    if($row >= 1){

                       $content = explode(',', $data);
                       $user    = new User();
                       $user->usr_code            = $content[1];
                       $user->usr_name            = $content[2];
                       $user->rule                = $content[3];
                       $user->pw                  = password_hash("Noc-net!", PASSWORD_DEFAULT);
                       $user->email_address       = $content[5];
                       $user->company_id          = $content[6];
                       $user->headquarter_id      = $content[7];
                       $user->department_id       = $content[8];
                       $user->group_id            = $content[9];
                       $user->retire              = $content[10];
                       $user->created_at          = Carbon::now();
                       $user->updated_at          = Carbon::now();
                       $user->position_id         = $content[13];
                       $user->pw_error_ctr        = $content[14];
                       $user->login_first         = true;
                       $user->password_chenge_date= Carbon::now();
                       if($user->save()){

                              $to_email    = $user->email_address;
                              $mail_text   = $this->mail_service->mail_text();
                              $data        = array('user_name'=>$user->usr_name,
                                                    "mail_text" => $mail_text,
                                                    "password" => "Noc-net!",
                                                    "employee_id" => $user->usr_code);
                              $subject     = trans('message.create_user_success_mail');
                              $result_send_mail = $this->mail_service->send_mail_create_user($to_email,$data,$subject);
                       }

                    }

                    $row++;

                }
             }
              DB::commit();
         }catch(Exception $e) {

                //エラーある場合は蓄積されたデータを消し
                DB::rollBack();

                throw new Exception($e);

        }
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function import_cost()
    {    
         DB::beginTransaction();
         try {

             $file_url = public_path() . '/import/cost_mst.txt';
             $row = 0;
             if (($handle = fopen($file_url, "r")) !== FALSE) {

                while (($data = fgets($handle)) !== FALSE) {

                    if($row >= 1){

                       $content = explode(',', $data);
                       $cost    = new Cost_MST();
                       $cost->cost_name = $content[0];
                       $cost->cost_code =  $content[1];
                       $cost->company_id =  (int)$content[4];
                       $cost->headquarter_id  =  (int)$content[5];
                       $cost->department_id =  (int)$content[6];
                       $cost->group_id        =  (int)$content[7];
                       $cost->type            =  (int)$content[8];
                       if($content[9] == '-1'){
                         $cost->status          =  true;
                       }else {
                          $cost->status          =  false;
                       }
                      
                      
                       $cost->save();
                    }
                    $row++;

                }
             }
              DB::commit();
         }catch(Exception $e) {

                //エラーある場合は蓄積されたデータを消し
                DB::rollBack();

                throw new Exception($e);

        }

    }
    
    public function change_project(){
      $projects = Project_MST::all();

      foreach ($projects as $project) {
        $project->updated_at = '2020-08-12 13:58:18';
        $project->update();
      }
    }
    public function import_customer()
    {    
         DB::beginTransaction();
         try {

             $file_url = public_path() . '/import/customer_mst.txt';
             $row = 0;
             if (($handle = fopen($file_url, "r")) !== FALSE) {

                while (($data = fgets($handle)) !== FALSE) {

                    if($row >= 1){

                       $content = explode(',', $data);

                       $customer    = new Customer_MST();
                       $customer->id = (int)$content[0];
                       $customer->company_id = (int)$content[1];
                       $customer->client_code =  $content[2];
                       $customer->client_name =  $content[3];
                       $customer->client_name_kana  =  $content[4];
                       $customer->client_name_ab =  $content[5];
                       $customer->closing_time        =  $content[6];
                       $customer->sale        =  $content[7];
                       $customer->antisocial            =  $content[8];
                       $customer->collection_site    = $content[9];
                       $customer->transferee        = FALSE;
                       $customer->transferee_name    = $content[11];
                       $customer->credit    =  $content[12];
                       $customer->akikura_code    = (int)$content[13];
                       $customer->status    = (int)$content[14];
                       $customer->note    = $content[15];


                       $customer->corporation_num    = $content[18];
                       $customer->tsr_code   = (int)$content[19];
                       $customer->client_address  = $content[20];
                       $customer->request_group   = (int)$content[21];
                       $customer->client_code_main   = $this->clean($content[22]);
                      
                       $customer->save();
                    }
                    $row++;

                }
             }
             
              DB::commit();
         }catch(Exception $e) {

                //エラーある場合は蓄積されたデータを消し
                DB::rollBack();

                throw new Exception($e);

        }

    }
    
    public function change_code_customer(){
      $customers = Customer_MST::all();
      foreach ($customers as $customer) {
        $customer->client_code_main = $this->clean($customer->client_code_main);
        $customer->update();
      }
    }
    function clean($string) {

     $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
     return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

    }

    public function import_customer_name()
    {    
         DB::beginTransaction();
         try {

             $file_url = public_path() . '/import/customer_name.txt';
             $row = 0;
             if (($handle = fopen($file_url, "r")) !== FALSE) {

                while (($data = fgets($handle)) !== FALSE) {

                    if($row >= 1){

                       $content = explode(',', $data);
                       $customer_name    = new Customer_name_MST();
                       $customer_name->id = (int)$content[0];
                       $customer_name->client_id = (int)$content[1];
                       $customer_name->client_name_s =  $content[2];
                       $customer_name->client_name_hankaku_s =  $content[3];
                       $customer_name->del_flag  =  (int)$content[4];
                       $customer_name->save();
                    }
                    $row++;

                }
             }
              DB::commit();
         }catch(Exception $e) {

                //エラーある場合は蓄積されたデータを消し
                DB::rollBack();

                throw new Exception($e);

        }

    }

    public function import_project()
    {    
         DB::beginTransaction();
         try {

             $file_url = public_path() . '/import/project_mst.txt';
             $row = 0;
             if (($handle = fopen($file_url, "r")) !== FALSE) {

                while (($data = fgets($handle)) !== FALSE) {

                    if($row >= 1){

                       $content = explode(',', $data);
                       $project    = new Project_MST();
                       $project->client_id = (int)$content[1];
                       $project->project_code = $content[2];
                       $project->project_name = $content[3];
                       $project->company_id = (int)$content[4];
                       $project->headquarter_id = (int)$content[5];
                       $project->department_id = (int)$content[6];
                       $project->group_id = (int)$content[7];
                       $project->get_code = $content[8];
                       $project->get_code_name = $content[9];
                       $project->once_shot = false;
                       $project->status = true;
                       $project->note = $content[12];
                       $project->transaction_money = (int)$content[13];
                       $project->transaction_shot = (int)$content[14];
                       $project->save();
                    }
                    $row++;

                }
             }
              DB::commit();
         }catch(Exception $e) {

                //エラーある場合は蓄積されたデータを消し
                DB::rollBack();

                throw new Exception($e);

        }

    }

       
    public function import_group()
    {    
         DB::beginTransaction();
         try {

             $file_url = public_path() . '/import/group_mst.txt';
             $row = 0;
             if (($handle = fopen($file_url, "r")) !== FALSE) {

                while (($data = fgets($handle)) !== FALSE) {

                    if($row >= 1){

                       $content = explode(',', $data);
                       $group    = new Group_MST();
                       $group->id = $content[0];
                       $group->group_name = $content[1];
                       $group->department_id =  $content[2];
                       $group->group_list_code =  $content[3];
                       $group->status  = true;
                       $group->note  =  $content[5];
                       $group->group_code  = $content[8];
                       $group->cost_code  =  $content[9];
                       $group->cost_name  =  $content[10];
                       $group->save();
                    }
                    $row++;

                }
             }
              DB::commit();
         }catch(Exception $e) {

                //エラーある場合は蓄積されたデータを消し
                DB::rollBack();

                throw new Exception($e);

        }

    }
    
    // public function import_group()
    // {    
    //      DB::beginTransaction();
    //      try {

    //          $file_url = public_path() . '/import/group_mst.txt';
    //          $row = 0;
    //          if (($handle = fopen($file_url, "r")) !== FALSE) {

    //             while (($data = fgets($handle)) !== FALSE) {

    //                 if($row >= 1){

    //                    $content = explode(',', $data);
    //                    $group    = new Group_MST();
    //                    $group->group_name = $content[1];
    //                    $group->department_id =  $content[2];
    //                    $group->group_list_code =  $content[3];
    //                    $group->status  = true;
    //                    $group->note  =  $content[5];
    //                    $group->group_code  = $content[8];
    //                    $group->cost_code  =  $content[9];
    //                    $group->cost_name  =  $content[10];
    //                    $group->save();
    //                 }
    //                 $row++;

    //             }
    //          }
    //           DB::commit();
    //      }catch(Exception $e) {

    //             //エラーある場合は蓄積されたデータを消し
    //             DB::rollBack();

    //             throw new Exception($e);

    //     }

    // }
    

    public function import_department()
    {    
         DB::beginTransaction();
         try {

             $file_url = public_path() . '/import/department_mst.txt';
             $row = 0;
             if (($handle = fopen($file_url, "r")) !== FALSE) {

                while (($data = fgets($handle)) !== FALSE) {

                    if($row >= 1){

                       $content = explode(',', $data);
                       $department    = new Department_MST();
                       $department->department_name = $content[1];
                       $department->headquarters_id =  $content[2];
                       $department->department_list_code =  $content[3];
                       $department->status  = true;
                       $department->note  =  $content[5];
                       $department->department_code  =  $content[8];

                       $department->save();
                    }
                    $row++;

                }
             }
              DB::commit();
         }catch(Exception $e) {

                //エラーある場合は蓄積されたデータを消し
                DB::rollBack();

                throw new Exception($e);

        }

    }
    
    public function import_headquarter()
    {    
         DB::beginTransaction();
         try {

             $file_url = public_path() . '/import/headquarters_mst.txt';
             $row = 0;
             if (($handle = fopen($file_url, "r")) !== FALSE) {

                while (($data = fgets($handle)) !== FALSE) {

                    if($row >= 1){

                       $content = explode(',', $data);
                       $headquarter    = new Headquarters_MST();
                       $headquarter->headquarters = $content[1];
                       $headquarter->company_id =  $content[2];
                       $headquarter->headquarter_list_code =  $content[3];
                       $headquarter->status  = true;
                       $headquarter->note  =  $content[5];
                       $headquarter->headquarters_code  =  $content[8];

                       $headquarter->save();
                    }
                    $row++;

                }
             }
              DB::commit();
         }catch(Exception $e) {

                //エラーある場合は蓄積されたデータを消し
                DB::rollBack();

                throw new Exception($e);

        }

    }
     public function mail()
    {
        $to_name = 'Noc server';
        $to_email = 'nguyen.hung@noc-net.co.jp';
        $data = array('name'=>"Sam Jose", "body" => "顧客情報管理システムの件につきまして");
        $subject = '顧客管理システム';
        Mail::send('mails.mail', $data, function($message) use ($to_email, $subject) {
            $message->to($to_email)->subject($subject);
        });
    }


    public function getupload(Request $request){
         
     
           return view('test.upload');   
        

        }

     public function viewupload(Request $request){
         
     
           return view('test.view_upload');   
        

        }

    public function upload(Request $request){
         

         if ($request->isMethod('post')) {
            
            $cover = $request->file('bookcover');
            //$extension = $cover->getClientOriginalExtension();
            Storage::disk('public')->put($cover->getClientOriginalName(),  File::get($cover));
            $file            = new File_upload();
            $file->note      = $request->note;
            $file->file_name = $cover->getClientOriginalName();
            $file->save();
           

         }

           return view('test.view_upload', ["file"=>$file]);    

        }
    public function dowload(){


         $headers = array(
                      'Content-Type: application/pdf',
                    );
         $file= public_path(). "\uploads\N2.pdf";

         
         return Response::download($file, 'filename.pdf', $headers);
    }

    public function get_file(){
             
             $users = User::all();

             foreach ($users as $user) {
                 
                 $posts = $user->posts;
                 
                 foreach ($posts as $post) {

                     var_dump($post->title);
                 }
             }
       return view('test_data', ["users"=>$users]);  

    }
   public function create_excel(){
        
        $data = 1;
        Excel::create('Filename', function($excel) use ($data){
         //タイトルの変更
         $excel->setTitle('Winroda徒然草');
        
         $excel->setDescription('このファイルはWinroadが作成しました');

         $excel->sheet('mySheet', function($sheet) use ($data)
         {
                 $sheet->row(1, array(
                    '名前', '住所', '電話番号', '性別', '事務所', '銀行口座'
                 ));

                 $sheet->row(2, array(
                    '人事', '経理', '総務', '本部', '営業', '管理'
                 ));

                 $sheet->row(3, array(
                    '税金', '納税', '免除', '弁償', '解約', '解雇'
                 ));
                 // $sheet->row(1,function($row){
                 //     //1行目のセルの背景色に青を指定
                 //     $row->setBackground('#0000FF');
                 //     //1行目のセルの文字色に白を指定
                 //     $row->setFontColor('#FFFFFF');
                    
                 // });
                    $sheet->setStyle([
                        'borders' => [
                            'allborders' => [
                                'color' => [
                                    'rgb' => '#800000'
                                ]
                            ]
                        ]
                    ]);

                   $sheet->setHeight(1, 500);
                    // $sheet->setAutoFilter();
              
                    $sheet->cell('A7:E7', function($cell) {

                        // $cell->setBackground('#00CED1');
                        // $cell->setBorder('solid');
                        $cell->setBorder('thin', 'thin', 'thin', 'thin');
                     


                    });
                    $sheet->cell('A9', function($cell) {

                        // $cell->setBackground('#00CED1');
                        // $cell->setBorder('solid');
                        $cell->setBorder('thin', 'thin', 'thin', 'thin');
                     


                    });
                     $sheet->mergeCells('A5:E5');
                     $sheet->cell('A2', function($cell) {

                        $cell->setBackground('#7FFF00');
                        $cell->setBorder('solid', 'none', 'none', 'solid');


                    });
                    
                     //2行目の後に行を追加します。
                     $sheet->appendRow(2,['test1','test2']);
                     //最終行の後に行を追加します。
                     $sheet->appendRow(['test3','test4']);      
                   
                     $sheet->setSize('A1', 25, 18);
                   
                     $sheet->setBorder('A7', 'thin');

                     // $sheet->cell('B1', function($cell) {
                     //     $cell->setValue('some value');
                     // });
         });

    })->download();
        
   }

   public function show(Request $request){
      
    $user = auth()->user(); 
    $post_id = $request->input('id');
    $post = Post::where('id', $id);

    if($user->can('view',$post)){

       echo 1;

    }else{

        echo 0;
    }

   }
    public function getuserinfor(){

        echo "get user infor";
    }

    public function getadmininfor(){

        echo "get admin infor";
        
    }

    public function getsystemadminonfor(){

        echo "get system admin infor";

    }
}
