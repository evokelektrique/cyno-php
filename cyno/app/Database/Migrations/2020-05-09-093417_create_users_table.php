<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration {

	public function up() {
		$this->forge->addField([
			'id' => [
				'type' => 'BIGINT',
				'unsigned' => TRUE,
				'auto_increment' => TRUE,
			],
			'hash_id' => [
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => FALSE,
			],
			'email' => [
				'type' => 'VARCHAR',
				'constraint' => 100,
				'null' => FALSE,
			],
			'password' => [
				'type' => 'TEXT',
				'null' => FALSE,
			],
			'is_admin' => [
				'type' => 'BOOLEAN',
				'default' => FALSE
			],
			'is_email_verified' => [
				'type' => 'BOOLEAN',
				'default' => FALSE
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

		$this->forge->addPrimaryKey('id', TRUE);
		$this->forge->createTable('users');
	}

	//--------------------------------------------------------------------

	public function down() {
		$this->forge->dropTable('users');
	}
	
}
