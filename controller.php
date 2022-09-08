<?php

class loginn extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata("id") == true) {
			redirect(base_url());
		}
		$this->load->library('session');
	}
	

        public function forget_password($page = 'forget-password')
        {
            $data['title'] = ucfirst($page);
            $this->load->view('forget-password');
        }

        public function random_number()
        {
            $ran_num = rand(9999, 99999);
            return $ran_num;
        }

        //forget password functions start
        public function forget_password_mail()
        {
            $email = $this->input->post('email');
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<div class="red_error">', '</div>');
            $this->form_validation->set_rules('email', 'Email', 'required');
            $error_array = array();
            if ($this->form_validation->run() == FALSE) {

                $error_array['email_error'] = form_error('email');
            } else {

                $result = $this->user_model->get_email_data($email);
                $per_id = $result[0]->id;
                $random_number = $this->random_number();
                $this->load->helper('cookie');

                $set_cookies = setcookie("optcode", $random_number, time() + (5)); //5min
                $set_user_id_cookies = setcookie("per_id", $per_id, time() + (60 * 5)); //5min
                if ($set_cookies && $set_user_id_cookies) {
                    

                    $this->load->library('parser');
                    $this->load->library('email');
                    
                    $config['mailtype'] = 'html';
            
                    $this->email->initialize($config);
                    
                    $this->email->from('Elaine@TMH2000.com', 'The Mortgage Headhunter LLC.');
                    $this->email->to($email);
            
                    $this->email->subject('Forgot Password Reset');
                    
                    $message1 = '<html>';
                    $message1 .= '<head>';
                    $message1 .= '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
                    $message1 .= '<title>Forgot Password Notification</title>';
                    $message1 .= '</head>';
                    $message1 .= '<body>';
                    $message1 .= '<div style="border:5px solid #ffffff; width:642px; background-color:#ffffff;">';
                    $message1 .= '<div style="height:16px; padding:10px 0px 13px 12px; color:#000000; font-family:Arial, Sans-serif; width:630px; font-size:16px; font-weight:bold; background-color:#9ccb5d;">';
                    $message1 .= 'Forgot Password Notification';
                    $message1 .= '</div>';
                    $message1 .= '<div style="border:1px solid #e3f4f8; background-color:#ffffff; padding:20px; font-family:Arial, Sans-serif; font-size:13px; width:600px;">';
                    $message1 .= '<p style="padding:0; margin:0;">';
                    //$message1 .= '<span style="font-size:19px;">Dear, {alias}!</span>';
                    //$message1 .= '<br />';
                    $message1 .= '<p style="font-size:16px;">Your verification code is below  <small> - enter it in your open browser window and we will help you get signed in </small>.</p><p style="font-size:15px">This Code is valid for 5 minutes</p>';
                    //$message1 .= '<br />';
                    $message1 .= '<div style="width:98%; height:23px; padding:12px 0 22px 2%; background-color:#f6f6f6; border:1px solid #eeeeee; border-width:1px 1px 4px 1px; margin:12px 0;">';
                    $message1 .= '<span style="font-weight:bold;font-size:16px">Your verification code is: </span><span style="font-weight:bold;font-size:22px">'. $random_number. '</span>';
                    $message1 .= '</div>';
                    $message1 .= '<span style="font-size:16px">If you didn’t request this email, there’s nothing to worry about — <small>you can safely ignore it</small>.</span>';
                    // $message1 .= '<br />';
                    // $message1 .= '<div style="width:98%; height:23px; padding:8px 0 4px 2%; background-color:#f6f6f6; border-top:1px solid #eeeeee; border-bottom:1px solid #eeeeee; margin:12px 0;">';
                    // $message1 .= '<a style="text-decoration:none;" href="{egift_link}">Click here</a> to go to the login page.<br />';
                    // $message1 .= '</div>';
                    // $message1 .= '<br /><br />';
                    // $message1 .= 'All the best,';
                    $message1 .= '<br /><br />';
                    $message1 .= '<span style="font-weight:bold;">The Mortgage Headhunter, LLC. Team.</span>';
                    $message1 .= '</p>';
                    $message1 .= '</div>';
                    $message1 .= '</div>';
                    $message1 .= '</body>';
                    $message1 .= '</html>';
                            
                    $this->email->message($message1);
            
                    $this->email->send();

                    $message = $random_number . ' OTP is valid for 5 min ';

                //   $this->email->from('Elaine@TMH2000.com', 'The Mortgage Headhunter LLC.');
        //             $this->email->to($email);
        //             // $this->email->to('evan.vcana98@gmail.com');
        //             $this->email->subject('Reset Password');
        //             $this->email->message("Your confirmation code is below — enter it in your open browser window and we'll help you get signed in." ."\n\n".$random_number ."\n\n"."If you didn’t request this email, there’s nothing to worry about — you can safely ignore it.");
        //             $this->email->send();
                    
                    // $mail = $this->send_mail($email, $message);
                    $mail = true;
                    if ($mail) {
                        $error_array['success'] = 'Check E-mail for OTP';
                        $error_array['status'] = 1;
                        $error_array['otp'] = $message;
                    }
                }
            }
            echo json_encode($error_array);
        }

        //forget password functions start
        public function otp_verification()
        {

            $otp = $this->input->post('opt');
            $this->load->library('form_validation');
            $error_array = array();
            if ($_COOKIE['optcode'] != $otp) {
                $error_array['otp_error']  = ' Invalid  Code';
            }
            else {
                $error_array['status'] = 1;
            }
        // 	  if(!isset($_COOKIE['optcode'])){
        // 		    $error_array['otp_expired_error']  = ' Code expired';
        // 		}
            echo json_encode($error_array);
        }

        public function change_otp_password()
        {
            $pass = $this->input->post('pass');
            $confirm_pass = $this->input->post('confirm_pass');
            $encrypt_password = md5($pass);
            $user_id = $_COOKIE['per_id'];
            $error_array = array();
            if (empty($pass)) {
                $error_array['password_error'] = 'Password  is required';
            } elseif (empty($confirm_pass)) {
                $error_array['password_error'] = 'Confirm Password  is required';
            } elseif ($pass != $confirm_pass) {
                $error_array['password_error'] = 'Confirm Password is not matched';
            } else {
                $data = array(
                    'password' => $encrypt_password
                );
                $this->user_model->update_user($data, $user_id);
                $error_array['status'] = 1;
            }
            echo json_encode($error_array);
        }

}
?>