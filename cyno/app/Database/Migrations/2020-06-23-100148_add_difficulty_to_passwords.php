<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDifficultyToPasswords extends Migration
{
	public function up()
	{
		$fields = [
			'difficulty' => [
				'type' => 'INT',
				'default' => 0,
				'unsigned' => TRUE
			]
		];
		$this->forge->addColumn('passwords', $fields);
	}
	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->removeColumn('passwords', 'difficulty');
	}
}
