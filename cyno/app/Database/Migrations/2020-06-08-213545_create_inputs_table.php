<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInputsTable extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type' => 'BIGINT',
				'unsigned' => TRUE,
				'auto_increment' => TRUE,
			],    
			'website_id' => [
				'type' => 'BIGINT',
				'unsigned' => TRUE
			],
			'name' => [ // Input name
				'type' => 'VARCHAR',
				'constraint' => 255,
			],
			'type' => [ // Input type
				'type' => 'VARCHAR',
				'constraint' => 255,
			],
			'value' => [ // Input value
				'type' => 'TEXT',
			],
			'id_name' => [ // Input #id
				'type' => 'TEXT',
			],
			'class_name' => [ // Input .class
				'type' => 'TEXT',
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
		$this->forge->createTable('inputs');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('inputs');
	}
}
