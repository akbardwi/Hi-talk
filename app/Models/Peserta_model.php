<?php namespace App\Models;

use CodeIgniter\Model;

class Peserta_model extends Model{
    protected $table 		= 'peserta';
	protected $primaryKey 	= 'id';
    protected $allowedFields = ['nama', 'email', 'instansi', 'hp'];

    // Listing
	public function listing(){
		$this->select('*');
		$this->orderBy("id", "DESC");
		$query = $this->get();
		return $query->getResultArray();
	}
	
	// Count
	public function hitung(){
		$this->select('*');
		$query = $this->get();
		return $query->countAllResults();
    }
    
    //Cek NISN
    public function check_email($email){
        $this->select("*");
        $this->where(['email' => $email]);
        $query = $this->get();
		return $query->getRowArray();
    }

	//Tambah
	public function tambah($data){
		$this->save($data);
	}

	//Read
    public function read($id){
		$this->select('*');
		$this->where(['id' => $id]);
		$query = $this->get();
		return $query->getRowArray();
	}
}