<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddHashToPasswords extends Migration
{
	public function up()
	{
		$fields = [
			'hash' => [
				'type' => 'TEXT',
			]
		];
		$this->forge->addColumn('passwords', $fields);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropColumn('passwords', 'hash');
	}
}
