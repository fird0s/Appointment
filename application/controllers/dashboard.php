<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public function index()
	{

		// if user not login, redirect to login(homepage) 
		if(!$this->session->userdata('logged_in'))
	    {
	    	return redirect('/', 'refresh');
	    }
		$this->load->view('dashboard/dashboard');
	}

	public function add(){
		/*
			to add new appointment, wejust need 3 column. 
			author = id of author (in logged_in session)
			title = $_POST['appointment']
			date = $_POST['date_appointment']

		*/

		// if user not login, redirect to login(homepage)
		if(!$this->session->userdata('logged_in'))
	    {
	    	return redirect('/', 'refresh');
	    }
		$post_array = $this->session->userdata('logged_in');

		if (isset($_POST['appointment']) && isset($_POST['date_appointment'])){ // if form filled
			// insert $_POST form to array
			$data_insert = array(
				'author' => $post_array['id'],
				'title' => $_POST['appointment'],
				'date' => $_POST['date_appointment'],
			);
			// create new appointment from($data_insert)
			$res = $this->db->insert('appointment', $data_insert);
			echo "success"; //if success will return string "success"
		}else{
			echo "error"; //if error will return string "error"
		}
	}

	public function ajaxevent(){
		// if user not login, redirect to login(homepage)
		if(!$this->session->userdata('logged_in'))
	    {
	    	return redirect('/', 'refresh');
	    }

		$session_data = $this->session->userdata('logged_in');  // get id of author
		$this->db->where('author', $session_data['id']); // get data 'where' author=session.id
		$result = $this->db->get('appointment')->result_array();
		print_r(json_encode($result)); 
	}

	public function ajaxdelete(){
		// if user not login, redirect to login(homepage)
		if(!$this->session->userdata('logged_in'))
	    {
	    	return redirect('/', 'refresh');
	    }
	    if (isset($_POST['id'])){
			$delete_appointment = $this->db->delete('appointment', array('id' => $_POST['id']));
			echo "success delete appointment"; //if success delete appointment
		} else {
			echo "failed delete appointment"; //if failed to delete appoinment
		}
	}

	public function ajaxupdate(){
		/*
			ajaxupdate is a function that can update appointment. there are just three column we need to insert.
			id = $_POST['id'])
			title = $_POST['title']
			date = $_POST['date']

		*/

		// if user not login, redirect to login(homepage)
		if(!$this->session->userdata('logged_in'))
	    {
	    	return redirect('/', 'refresh');
	    }
	    if (isset($_POST['id'])){
		    $data_update = array(
				'title' => $_POST['title'],
				'date' => $_POST['date'],
			);

			$this->db->where('id', $_POST['id']); 
			$this->db->update('appointment', $data_update);
			echo "success update appointment";
		}

	}

}
