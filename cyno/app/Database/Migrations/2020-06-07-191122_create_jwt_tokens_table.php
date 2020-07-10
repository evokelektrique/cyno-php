<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateJwtTokensTable extends Migration
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
				'constraint' => '255',
				'null' => FALSE
			],
			'token' => [
				'type' => 'TEXT',
			],
			'expire' => [
				'type' => 'TIMESTAMP',
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
		$this->forge->createTable('jwt_tokens');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('jwt_tokens');
	}
}
