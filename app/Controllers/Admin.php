<?php namespace App\Controllers;

// Load model
use App\Models\User_model;
use App\Models\Peserta_model;
// End load model

use App\Controllers\BaseController;

class Admin extends BaseController{
	//Konstruktor
	public function __construct(){
        helper(['form', 'url']);
        $this->form_validation = \Config\Services::validation();
    }

    //Index
    public function dashboard(){
        helper('form');
		$config = null;
		$session = \Config\Services::session($config);
		// Proteksi
		if($session->get('admin_user') == "") {
			return redirect()->to(base_url('login'));
		}
		// End proteksi
        
        $model = new User_model();
        $peserta = new Peserta_model();
        $data = array(  'title'			=> 'Halaman Dashboard',
                        'user'          => $model->detail($session->get('admin_user')),
                        'peserta'       => $peserta->listing(),
                        'content'		=> 'admin/dashboard');
        return view('admin/layout/wrapper',$data);
    }
}