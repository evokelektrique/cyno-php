<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddInputsPreimageHash extends Migration
{
	public function up()
	{
		$fields = [
			'inputs_preimage_hash' => [
				'type' => 'TEXT'
			]
		];
		$this->forge->addColumn('passwords', $fields);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropColumn('passwords', 'inputs_preimage_hash');
	}
}
