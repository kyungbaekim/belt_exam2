<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Exams extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

  public function index(){
		redirect('/main');
  }

	public function main(){
    $this->load->view('/index');
  }

  public function register(){
    $this->load->model('Exam');
    $name = $this->input->post('name');
    $alias = $this->input->post('alias');
		$email = $this->input->post('email');
    $password1 = $this->input->post('password1');
    $password2 = $this->input->post('password2');
		$birthday = $this->input->post('birthday');

    // form data validation
    $this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
    $this->form_validation->set_rules('name', 'NAME', 'required|min_length[3]');
    $this->form_validation->set_rules('alias', 'ALIAS', 'required|min_length[3]');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
    $this->form_validation->set_rules('password1', 'PASSWORD', 'required|min_length[8]');
    $this->form_validation->set_rules('password2', 'CONFIRM PASSWORD', 'required|matches[password1]');
		$this->form_validation->set_rules('birthday', 'BIRTHDAY', 'required');
    if($this->form_validation->run() == FALSE){
      $this->load->view('/index', array('register_errors' => validation_errors()));
    }
    else{
			$register_user = $this->Exam->add_user($name, $alias, $email, $password1, $birthday);
      if($register_user) {
				$this->session->set_flashdata('registered', true);
				redirect('/');
      }
      else{
        die("Problem occurred while register your information!");
			}
    }
  }

  public function login(){
    // form data validation
    $this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
    $this->form_validation->set_rules('email', 'EMAIL', 'required|valid_email');
    $this->form_validation->set_rules('password', 'PASSWORD', 'required|min_length[8]');
    if($this->form_validation->run() == FALSE){
      $this->load->view('/index', array('login_errors' => validation_errors()));
    }
    else{
      $this->load->model('Exam');
      $email = $this->input->post('email');
      $password = $this->input->post('password');
      $user = $this->Exam->get_user_by_email($email);
      if($user && $user['password'] == $password){
        $this->session->set_userdata('user_id',$user['id']);
				$this->session->set_userdata('user_alias',$user['alias']);
				redirect('/quotes');
      }
      else{
        die("Log in failed! Please check your email address and password!");
      }
    }
  }

	public function quotes(){
		$this->load->model('Exam');
		$all_quotes = $this->Exam->get_all_quotes($this->session->userdata['user_id']);
		$favorite_quotes = $this->Exam->get_all_favorite_quotes($this->session->userdata['user_id']);
		$this->load->view('/quotes', array('all_quotes' => $all_quotes, 'favorites' => $favorite_quotes));
	}

	public function add_quote(){
		date_default_timezone_set('America/Los_Angeles');
		// form data validation
		var_dump($this->input->post());
    $this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
    $this->form_validation->set_rules('quoted_by', 'QUOTED_BY', 'required|min_length[3]');
		$this->form_validation->set_rules('message', 'MESSAGE', 'required|min_length[10]');
    if($this->form_validation->run() == FALSE){
      $this->load->view('/quotes', array('add_errors' => validation_errors()));
    }
    else{
      $this->load->model('Exam');
      $quoted_by = $this->input->post('quoted_by');
      $message = $this->input->post('message');
      $add_quote = $this->Exam->add_quote($this->session->userdata['user_id'], $quoted_by, $message);
      if($add_quote){
				redirect('/quotes');
      }
      else{
        die("Adding quotes failed!");
      }
    }
	}

	public function add_favorite($quote_id){
		$this->load->model('Exam');
		$favorite = $this->Exam->add_favorite($this->session->userdata['user_id'], $quote_id);
		if($favorite){
			redirect('/quotes');
		}
		else{
			die("Updating your favorites failed!");
		}
	}

	public function remove_favorite($quote_id){
		$this->load->model('Exam');
		$remove = $this->Exam->remove_favorite($this->session->userdata['user_id'], $quote_id);
		if($remove){
			redirect('/quotes');
		}
		else{
			die("Updating your favorites failed!");
		}
	}

	public function users($user_id){
		$this->load->model('Exam');
		$get_user_quotes = $this->Exam->get_user_quotes($user_id);
		$get_quote_count = $this->Exam->get_number_of_user_quote($user_id);
		if($get_user_quotes){
			$this->load->view('/detail', array('user_quotes' => $get_user_quotes, 'quote_count' => $get_quote_count));
		}
		else{
			die("Fetching user information failed!");
		}
	}

  public function reset_session(){
    $this->session->sess_destroy();
    redirect('/');
  }
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */
