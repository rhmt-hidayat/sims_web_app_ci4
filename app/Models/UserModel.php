<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'user';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;
    protected $allowedFields = ['id', 'nama', 'email', 'password', 'password_decrypt', 'posisi', 'last_login', 'create_date', 'reset_token'];

	public function get_data($email, $password)
	{
      return $this->db->table('user')
      ->where(array('email' => $email, 'password' => $password))
      ->get()->getRowArray();
	}
}