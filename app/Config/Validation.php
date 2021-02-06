<?php

namespace Config;

use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;

class Validation
{
	//--------------------------------------------------------------------
	// Setup
	//--------------------------------------------------------------------

	/**
	 * Stores the classes that contain the
	 * rules that are available.
	 *
	 * @var string[]
	 */
	public $ruleSets = [
		Rules::class,
		FormatRules::class,
		FileRules::class,
		CreditCardRules::class,
	];

	/**
	 * Specifies the views that are used to display the
	 * errors.
	 *
	 * @var array<string, string>
	 */
	public $templates = [
		'list'   => 'CodeIgniter\Validation\Views\list',
		'single' => 'CodeIgniter\Validation\Views\single',
	];

	//--------------------------------------------------------------------
	// Rules
	//--------------------------------------------------------------------

	//Validasi Login Admin
	public $login = [
		'username' => 'required',
		'password' => 'required'
	];	 
	public $login_errors = [
		'username' => [
			'required'      => 'Username wajib diisi'
		],
		'password' => [
			'required'      => 'Password wajib diisi'
		]
	];
	
	//Validasi Daftar LCC
	public $peserta = [
		'nama' 		=> 'required',
		'instansi'	=> 'required',
		'email'		=> [
			'required',
			'valid_email'
		],
		'hp'		=> [
			'required',
			'is_natural'
		]
	];	 
	public $peserta_errors = [
		'nama' 		=> [
			'required'      => 'Nama wajib diisi'
		],
		'instansi' 	=> [
			'required'      => 'Instansi wajib diisi'
		],
		'email'		=> [
			'required'		=> 'Email wajib diisi',
			'valid_email'	=> 'Masukkan Email yang valid'
		],
		'hp'		=> [
			'required'		=> 'No. HP wajib diisi',
			'is_natural'	=> 'No. HP hanya bisa diisi bilangan bulat'
		]
	];
}
