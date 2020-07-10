<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSharedTable extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type' => 'BIGINT',
				'unsigned' => TRUE,
				'auto_increment' => TRUE,
			],    
			'hash_id' => [
				'type' => 'VARCHAR', 
				'constraint' => '255',
			],
			'user_id' => [  
				'type' => 'BIGINT',
				'unsigned' => TRUE
			],
			'receiver_id' => [  
				'type' => 'BIGINT',
				'unsigned' => TRUE
			],
			'cipher' => [
				'type' => 'TEXT'
			],
			'created_at' => [
				'type' => 'DATETIME',
			],
			'updated_at' => [
				'type' => 'DATETIME',
			],
			'deleted_at' => [
				'type' => 'DATETIME',
			],
		]);
		$this->forge->addKey('id', TRUE);
		$this->forge->addKey('hash_id', TRUE);
		$this->forge->createTable('shared');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('shared');
	}
}
