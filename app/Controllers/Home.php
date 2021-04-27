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
            if($peserta->countAllResults() < 150){
                if($check_email){
                    session()->setFlashdata('error', 'Email sudah terdaftar');
                    return redirect()->to(base_url()."/#registration");
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
                        $batas = strtotime(date("30-04-2021 10:00:00"));
                        $sekarang = strtotime(date("d-m-Y H:i:s"));
                        if($batas >= $sekarang){
                            $email_smtp = \Config\Services::email();
                            $email_smtp->setFrom("hmti@orma.dinus.ac.id", "HMTI UDINUS");
                            $email_smtp->setTo("$email");
                            $email_smtp->setSubject("Konfirmasi Pendaftaran Peserta Hi-Talk Series #2");
                            $email_smtp->setMessage("<div>Halo, $nama</div><div><br /></div><div>Terimakasih telah mendaftar sebagai Peserta di acara Hi-Talk Series #2. Untuk para peserta diharapkan untuk bergabung kedalam whatsapp group agar mendapatkan informasi-informasi terbaru.</div><div>Berikut link whatsapp group :</div><div><br /></div><div>https://chat.whatsapp.com/LiY0wOz3mE8GgJddd1WdL6</div><div><br /></div><div>Salam, Hi-Talk 2021</div>");
                            $kirim = $email_smtp->send();
                            if($kirim){
                                $model->tambah($peserta);
                                session()->setFlashdata('success', 'Terima kasih telah mendaftar. Nantikan informasi dari kami yang akan dikirim ke email Anda.');
                                return redirect()->to(base_url()."/#registration");  
                            } else {
                                session()->setFlashdata('inputs', $this->request->getPost());
                                session()->setFlashdata('error', 'Gagal mengirim email konfirmasi, silahkan coba lagi.');
                                return redirect()->to(base_url()."/#registration");
                            }             
                        } else {
                            session()->setFlashdata('inputs', $this->request->getPost());
                            session()->setFlashdata('error', 'Mohon maaf, waktu pendaftaran sudah ditutup.');
                            return redirect()->to(base_url()."/#registration");
                        }
                    }
                }
            } else {
                session()->setFlashdata('inputs', $this->request->getPost());
                session()->setFlashdata('error', 'Mohon maaf, kuota pendaftaran sudah penuh.');
                return redirect()->to(base_url()."/#registration");
            }
		} else {
			return redirect()->to(base_url());
		}
	}
}
