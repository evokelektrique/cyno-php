<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDifficultyToUserKeys extends Migration
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
		$this->forge->addColumn('user_keys', $fields);
	}
	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropColumn('user_keys', 'difficulty');
	}
}
