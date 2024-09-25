<?php 
namespace App\Models;

use CodeIgniter\Model;

class BaseModel extends Model{
	public function dbconn($tabla){
		$db      = \Config\Database::connect();
		$builder = $db->table($tabla);
		return $builder;
	}

	public function getLastID($table){
		$db = \Config\Database::connect();
		$id = $db->insertID();
		return $id;
	}
} 