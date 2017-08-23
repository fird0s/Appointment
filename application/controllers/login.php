<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	public function index()
	/*
		this is homepage of this website. the home page is login page. 
	*/
	{

		// if user has session it will redirect to dashboard page without login anymore
		if($this->session->userdata('logged_in'))
	    {
	    	return redirect('/dashboard', 'refresh');
	    }

		// login handler to sign in to dashboard
		if (isset($_POST['login'])){
			$user = $this->db->query('SELECT * from account WHERE email = ? OR username = ? LIMIT 1', array($_POST['email'], $_POST['email']));
	    	$user = $user->row();
	    	if ($user){
	       		if ($this->encrypt->decode($user->password) == $_POST['password']){
	       			$sess_array = array('id' => $user->id, 'email' => $user->email);
	       			$this->session->set_userdata('logged_in', $sess_array);
				 	return redirect('/dashboard', 'refresh');
	       		}else{
	       			$this->session->set_flashdata('err_msg', 'Email or password wrong');
	       			return redirect('/', 'refresh');
	       		}
	        }else{
	       		$this->session->set_flashdata('err_msg', 'Something wrong');
       			return redirect('/', 'refresh');
	        }
		}
		$this->load->view('login');
	}
}
