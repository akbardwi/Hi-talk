<?php namespace App\Models;

use CodeIgniter\Model;

class User_model extends Model{
	protected $table 		= 'admin';
	protected $primaryKey 	= 'id';
	protected $allowedFields = ['username','password','name'];

	// Detail
	public function detail($username)
	{
		$this->select('*');
		$this->where(array(	'username'	=> $username));
		$query = $this->get();
		return $query->getRowArray();
	}

	// Check User
	public function check_user($username)
	{
		$this->select('*');
		$this->where(array(	'username'	=> $username));
		$query = $this->get();
		return $query->getRowArray();
	}
}