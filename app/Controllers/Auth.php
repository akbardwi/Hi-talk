<?php namespace App\Controllers;

// Load model
use App\Models\User_model;
// End load model

class Auth extends BaseController{
	//Konstruktor
	public function __construct(){
        helper(['form', 'url']);
        $this->form_validation = \Config\Services::validation();
    }

    //Halaman login
    public function login(){
        helper('form');
		$config = null;
		$session = \Config\Services::session($config);
		// Proteksi
		if($session->get('admin_user') !="") {
			return redirect()->to(base_url('admin/dashboard'));
		}
		// End proteksi
		return view('admin/login');
    }

    //Proses Login
    public function login_admin(){
        $config = null;
		$session = \Config\Services::session($config);
		$model = new User_model();
		$username = filter_var($this->request->getVar('username'), FILTER_SANITIZE_STRING);
		$password = filter_var($this->request->getVar('password'), FILTER_SANITIZE_STRING);
		$login = [
            'username'  => $username,
            'password'  => $password
		];
		if($this->form_validation->run($login, 'login') == FALSE){
            // mengembalikan nilai input yang sudah dimasukan sebelumnya
            session()->setFlashdata('inputs', $this->request->getPost());
            // memberikan pesan error pada saat input data
			session()->setFlashdata('errors', $this->form_validation->getErrors());
			return redirect()->to(base_url('admin/login'));
        } else {
			$check_user = $model->check_user($username);
			if($check_user){
				if(password_verify($password, $check_user['password'])){
					// $session->set('admin_user',$username);
					$session->set('admin_user',$check_user['username']);
					// $session->set('admin_level',$check_user['akses_level']);
					// $session->set('admin_nama',$check_user['nama']);
					// Login success
					// $session->setFlashdata('sukses', 'Anda berhasil login');
					return redirect()->to(base_url('admin/dashboard'));
				} else {
					session()->setFlashdata('error', 'Password salah');
					return redirect()->to(base_url('login'));
				}
			} else {
				session()->setFlashdata('error', 'Username tidak ditemukan');
				return redirect()->to(base_url('login'));
			}
        }
    }
}