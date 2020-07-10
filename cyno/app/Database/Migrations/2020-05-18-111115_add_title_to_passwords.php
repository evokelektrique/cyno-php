<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTitleToPasswords extends Migration
{
	public function up()
	{
		$fields = [
			'title' => [
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => FALSE
			]
		];
		$this->forge->addColumn('passwords', $fields);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropColumn('passwords', 'title');
	}
}
