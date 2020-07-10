<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPasswordIdToInputs extends Migration
{
	public function up()
	{
		$fields = [
			'password_id' => [
				'type' => 'BIGINT',
				'unsigned' => TRUE
			]
		];
		$this->forge->addColumn('inputs', $fields);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropColumn('inputs', 'password_id');
	}
}
