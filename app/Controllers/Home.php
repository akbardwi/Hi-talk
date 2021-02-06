<?php namespace App\Controllers;

// Load model
use App\Models\Peserta_model;
// End load model

class Home extends BaseController{
	public function __construct(){
        helper('form', 'url');
        $this->form_validation = \Config\Services::validation();
    }

	public function index()	{
		return view('index');
	}

	//Proses pendaftaran
	public function registration(){
		$method = $_SERVER['REQUEST_METHOD'];
		if($method == "POST"){
			$nama = filter_var($this->request->getVar('nama'), FILTER_SANITIZE_STRING);
            $instansi = filter_var($this->request->getVar('institution'), FILTER_SANITIZE_STRING);
            $email = filter_var($this->request->getVar('email'), FILTER_SANITIZE_EMAIL);
            $hp = filter_var($this->request->getVar('hp'), FILTER_SANITIZE_NUMBER_INT);

            $model 		= new Peserta_model();
            $check_email= $model->check_email($email);
            $db      	= \Config\Database::connect();
            $peserta  	= $db->table('peserta');
            if($peserta->countAllResults() <= 100){
                if($check_email){
                    session()->setFlashdata('error', 'Email sudah terdaftar');
                    return redirect()->to(base_url());
                } else {
                    $peserta = [
                        'nama'      => $nama,
                        'instansi'  => $instansi,
                        'email'     => $email,
                        'hp'        => $hp
                    ];
                    if($this->form_validation->run($peserta, 'peserta') == FALSE){
                        // mengembalikan nilai input yang sudah dimasukan sebelumnya
                        session()->setFlashdata('inputs', $this->request->getPost());
                        // memberikan pesan error pada saat input data
                        session()->setFlashdata('errors', $this->form_validation->getErrors());
                        return redirect()->to(base_url());
                    } else {
                        $batas = strtotime(date("26-02-2021 10:00:00"));
                        $sekarang = strtotime(date("d-m-Y H:i:s"));
                        if($batas >= $sekarang){
                            $model->tambah($peserta);
							session()->setFlashdata('success', 'Terima kasih telah mendaftar. Nantikan informasi dari kami yang akan dikirim ke email Anda.');
							return redirect()->to(base_url());                       
                        } else {
                            session()->setFlashdata('inputs', $this->request->getPost());
                            session()->setFlashdata('error', 'Mohon maaf, waktu pendaftaran sudah ditutup.');
                            return redirect()->to(base_url());
                        }
                    }
                }
            } else {
                session()->setFlashdata('inputs', $this->request->getPost());
                session()->setFlashdata('error', 'Mohon maaf, kuota pendaftaran sudah penuh.');
                return redirect()->to(base_url());
            }
		} else {
			return redirect()->to(base_url());
		}
	}
}
