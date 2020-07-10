<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFoldersTable extends Migration
{
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
			'parent_id' => [
				'type' => 'BIGINT',
				'null' => FALSE,
				'default' => 0
			],
			'title' => [
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => FALSE
			],
			'is_default' => [
				'type' => 'BOOLEAN',
				'default' => FALSE,
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
		$this->forge->createTable('folders');
	}
	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('folders');
	}
}
