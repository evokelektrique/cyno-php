<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIsActivateToUsers extends Migration
{
	public function up()
	{
		$fields = [
			'is_activate' => [
				'type' => 'BOOLEAN',
				'default' => TRUE
			],	
		];
		$this->forge->addColumn('users', $fields);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropColumn('users', 'is_activate');
	}
}
