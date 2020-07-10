<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEmailsTokenTable extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type' => 'BIGINT',
				'unsigned' => TRUE,
				'auto_increment' => TRUE,
			],
			'hash' => [
				'type' => 'TEXT',
				'null' => FALSE,
			],
			'user_id' => [
				'type' => 'BIGINT',
				'constraint' => '255',
				'null' => FALSE
			],
			'status' => [
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
		$this->forge->createTable('emails_token');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('emails_token');
	}
}
