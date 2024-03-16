
<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
 
class Users extends CI_Controller { 
     
    function __construct() { 
        parent::__construct(); 
         
        // Load form validation ibrary & user model 
        $this->load->library('form_validation'); 
        $this->load->model('UserModel'); 
         
        // User login status 
        $this->isUserLoggedIn = $this->session->userdata('isUserLoggedIn'); 
    } 
     
    public function index(){ 
        if($this->isUserLoggedIn){ 
            redirect('users/account'); 
        }else{ 
            redirect('users/login'); 
        } 
    } 

    public function profile()
    {
        $this->load->view('templates/header');
        $this->load->view('profilePage');
        $this->load->view('templates/footer');
    }

    public function loadLogin()
    {
        // Load the login view
        $this->load->view('templates/header');
        $this->load->view('auth/loginPage');
        $this->load->view('templates/footer');
    }

    public function loadRegister()
    {
        // Load the registration view
        $this->load->view('templates/header');
        $this->load->view('auth/signupPage');
        $this->load->view('templates/footer');
    }
 
    // public function account(){ 
    //     $data = array(); 
    //     if($this->isUserLoggedIn){ 
    //         $con = array( 
    //             'id' => $this->session->userdata('userId') 
    //         ); 
    //         $data['user'] = $this->user->getRows($con); 
             
    //         // Pass the user data and load view 
    //         $this->load->view('elements/header', $data); 
    //         $this->load->view('users/account', $data); 
    //         $this->load->view('elements/footer'); 
    //     }else{ 
    //         redirect('users/login'); 
    //     } 
    // } 
 



    // public function login(){ 
    //     $data = array(); 
         
    //     // Get messages from the session 
    //     if($this->session->userdata('success_msg')){ 
    //         $data['success_msg'] = $this->session->userdata('success_msg'); 
    //         $this->session->unset_userdata('success_msg'); 
    //     } 
    //     if($this->session->userdata('error_msg')){ 
    //         $data['error_msg'] = $this->session->userdata('error_msg'); 
    //         $this->session->unset_userdata('error_msg'); 
    //     } 
         
    //     // If login request submitted 
    //     if($this->input->post('loginSubmit')){ 
    //         $this->form_validation->set_rules('email', 'Email', 'required|valid_email'); 
    //         $this->form_validation->set_rules('password', 'password', 'required'); 
             
    //         if($this->form_validation->run() == true){ 
    //             $con = array( 
    //                 'returnType' => 'single', 
    //                 'conditions' => array( 
    //                     'email'=> $this->input->post('email'), 
    //                     'password' => md5($this->input->post('password')), 
    //                     'status' => 1 
    //                 ) 
    //             ); 
    //             $checkLogin = $this->user->getRows($con); 
    //             if($checkLogin){ 
    //                 $this->session->set_userdata('isUserLoggedIn', TRUE); 
    //                 $this->session->set_userdata('userId', $checkLogin['id']); 
    //                 redirect('users/account/'); 
    //             }else{ 
    //                 $data['error_msg'] = 'Wrong email or password, please try again.'; 
    //             } 
    //         }else{ 
    //             $data['error_msg'] = 'Please fill all the mandatory fields.'; 
    //         } 
    //     } 
         
    //     // Load view 
    //     $this->load->view('elements/header', $data); 
    //     $this->load->view('users/login', $data); 
    //     $this->load->view('elements/footer'); 
    // } 
 


    public function registration(){ 
        header("Access-Control-Allow-Origin: *");

        // Set validation rules
        $this->form_validation->set_rules('firstname', 'First Name', 'required');
        $this->form_validation->set_rules('lastname', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_check');
        $this->form_validation->set_rules('password', 'Password', 'required');
    
        if ($this->form_validation->run() == FALSE) {
            $responseData = array(
                'success' => true,
                'condition' => 'A', // Email already exixts
                'message' => 'Registration successful. Condition A met.'
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($responseData)); // Letting the frontend know that a user with same email exits.
            return;
        }
    
        // Form validation passed, proceed with registration
        $userData = array( 
            'first_name' => strip_tags($this->input->post('firstname')), 
            'last_name' => strip_tags($this->input->post('lastname')), 
            'email' => strip_tags($this->input->post('email')), 
            'password' => md5($this->input->post('password')) 
        ); 
    
        $insert = $this->UserModel->insert($userData); 
    
        if ($insert) {
            // Registration successful
            $responseData = array(
                'success' => true,
                'condition' => 'B', //Email unique, no prob
                'message' => 'Registration successful. Condition A met.'
            );
            $this->output->set_content_type('application/json')->set_output(json_encode($responseData));

        } else {
            // Registration failed
            echo json_encode(['success' => false, 'message' => 'Failed to register user. Please try again.']);
        }

    } 
     



    
    // public function logout(){ 
    //     $this->session->unset_userdata('isUserLoggedIn'); 
    //     $this->session->unset_userdata('userId'); 
    //     $this->session->sess_destroy(); 
    //     redirect('users/login/'); 
    // } 
     
     
    // Existing email check during validation 
    public function email_check($str){ 
        $con = array( 
            'returnType' => 'count', 
            'conditions' => array( 
                'email' => $str 
            ) 
        ); 
        $checkEmail = $this->UserModel->getRows($con); 
        if($checkEmail > 0){ 
            $this->form_validation->set_message('email_check', 'The given email already exists.'); 
            return FALSE; 
        }else{ 
            return TRUE; 
        } 
    } 
}