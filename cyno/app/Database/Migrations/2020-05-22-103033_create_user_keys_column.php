<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserKeysColumn extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type' => 'BIGINT',
				'unsigned' => TRUE,
				'auto_increment' => TRUE,
			],
			'user_id' => [
				'type' => 'BIGINT',
				'unsigned' => TRUE,
			],
			'public_key' => ['type' => 'TEXT'],
			'secret_key' => ['type' => 'TEXT'],
			'salt' => [
				'type' => 'VARCHAR',
				'constraint' => 255,
			],
			'nonce' => [
				'type' => 'VARCHAR',
				'constraint' => 255,
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
		$this->forge->addKey('user_id', TRUE);
		$this->forge->createTable('user_keys');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('user_keys');
	}
}
