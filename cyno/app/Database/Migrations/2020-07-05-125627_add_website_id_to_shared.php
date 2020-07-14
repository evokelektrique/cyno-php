<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddWebsiteIdToShared extends Migration
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
		$this->forge->addColumn('shared', $fields);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropColumn('shared', 'website_id');
	}
}
