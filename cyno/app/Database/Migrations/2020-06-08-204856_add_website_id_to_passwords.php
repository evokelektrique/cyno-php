<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddWebsiteIdToPasswords extends Migration
{
	public function up()
	{
		$fields = [
			'website_id' => [
				'type' => 'BIGINT',
				'unsigned' => TRUE,
				'default' => NULL
			]
		];
		$this->forge->addColumn('passwords', $fields);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropColumn('passwords', 'website_id');
	}
}
