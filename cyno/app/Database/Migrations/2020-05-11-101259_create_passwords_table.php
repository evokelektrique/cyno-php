<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePasswordsTable extends Migration {
	public function up() {
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
				'null' => FALSE
			],
			'folder_id' => [
				'type' => 'BIGINT',
				'null' => FALSE,
				'default' => 0
			],
			'nonce' => [
				'type' => 'VARCHAR',
				'constraint' => '255',
				'null' => FALSE
			],
			'salt' => [
				'type' => 'VARCHAR',
				'constraint' => '255',
				'null' => FALSE
			],
			'cipher' => [
				'type' => 'TEXT',
				'null' => FALSE
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
		$this->forge->createTable('passwords');
	}

	//--------------------------------------------------------------------

	public function down() {
		$this->forge->dropTable('passwords');
	}
}
