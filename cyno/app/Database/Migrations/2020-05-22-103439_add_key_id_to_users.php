<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddKeyIdToUsers extends Migration
{
	public function up()
	{
		$fields = [
			'key_id' => [
				'type' => 'BIGINT',
				'unsigned' => TRUE,
			]
		];
		$this->forge->addColumn('users', $fields);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->addColumn('users', 'key_id');
	}
}
