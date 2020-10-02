<?php
namespace App\Service;
use App\User;
use App\Customer_MST;
use App\Concurrently;
use Auth;
use Mail;
use Exception;
use App\mail_mst;
class MailService 
{

       public function mail_text(){

       	  return 'があなたにCROSS-FUNのアカウントを作成しました。';

       }

       public function send_mail_reset_password($to_email,$data,$subject){
           
           //$result = Mail::send('mails.mail', $data, function($message) use ($to_email, $subject) {
           //         $message->to($to_email)->subject($subject);
           //    });
		

      		$send_edit = $this->creartSentence(3,$data);
      		$subject = $send_edit['subject'];
          $content['content'] = $send_edit['content'];
      		$result = Mail::send(['text' => 'mails.noc_mail'], $content, function($message) use ($to_email, $subject) {
      			$message->to($to_email)->subject($subject);
      		});
      		return $result;

       }

       public function send_mail_create_user($to_email,$data,$subject){
       
      		$send_edit          = $this->creartSentence(2,$data);
      		$subject            = $send_edit['subject'];
          $content['content'] = $send_edit['content'];
      		$result             = Mail::send(['text' => 'mails.noc_mail'], $content, function($message) use ($to_email, $subject) {
      		        $message->to($to_email)->subject($subject);
      		    });   
      		return $result;

       }

       public function send_mail_change_pass($to_email,$data,$subject){

            $result = Mail::send('mails.change_pass', $data, function($message) use ($to_email, $subject) {
                    $message->to($to_email)->subject($subject);
                });

            return $result;
       }
      // メール送信するためuser id リストを取得
      public function getListUserId($client_id){
             
             $customer_mst = Customer_MST::where('id',$client_id)->first();
            
             // $group_id     = $customer_mst->project_mst->pluck('group_id');

             $group_id     = $customer_mst->project->pluck('group_id');

             $user_id_1    = User::leftJoin('position_mst', 'user_mst.position_id', '=', 'position_mst.id')
                           ->where('retire',false)
                           ->where('mail_flag',true)
                           ->whereIn('group_id',$group_id)->pluck('user_mst.id')->toArray();
             // 兼務のユーザー
             $user_id_2    = Concurrently::leftJoin('position_mst', 'concurrently_mst.position_id', '=',
                            'position_mst.id')
                           ->where('status',true)
                           ->where('mail_flag',true)
                           ->whereIn('group_id',$group_id)->pluck('usr_id')->toArray();
             $user_id      = array_merge($user_id_1,$user_id_2);
           
             return $user_id;


      }

     // メール情報を抽出してそれぞれのユーザーに送る
      public function sendCreditMail($client_id,$list_user_id){

          $mail        = Mail_MST::find(1);
          
          $data        = array('mail_text'=>$mail->mail_text);

          $subject     =  $mail->mail_remark;

          // $user_id     = $this->getListUserId($client_id);
        
          $users       = User::whereIn('id',$list_user_id)->get();
        
          foreach ($users as $user) {
              
              $to_email = $user->email_address;
              $result = Mail::send('mails.credit', $data, function($message) use ($to_email, $subject) {
                    $message->to($to_email)->subject($subject);
              });

          }
          
          return $users->pluck('id');
      }

	// メール本文生成
	public function creartSentence($mail_id,$data){

		//	##USER_ID##			:　 ログインユーザーID 
		//	##USER_NAME##　		:　 ログインユーザー名 
		//	##USER_PASSWORD##	:　 ログインユーザーパスワード 

    		$chg_data = array(
    						"##USER_ID##"		    =>	"employee_id",
    						"##USER_NAME##"		  =>	"user_name",
    						"##USER_PASSWORD##"	=>	"password",
    						);

    		$mail = Mail_MST::find($mail_id);
    		$ret_data['subject'] = $mail->mail_remark;
    		$ret_data['content'] = $mail->mail_text;
    		foreach($chg_data as $key => $cdata){
    			if (!empty($data[$cdata])){
    				$ret_data['content'] = str_replace($key,$data[$cdata],$ret_data['content']);
    			}else{
    				$ret_data['content'] = str_replace($key,"",$ret_data['content']);
    			}
    		}

		    return $ret_data;
	}

}
?>