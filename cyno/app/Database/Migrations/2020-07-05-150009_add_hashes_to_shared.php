<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddHashesToShared extends Migration
{
	public function up()
	{
		$fields = [
			'hash' => [
				'type' => 'TEXT',
			],
			'inputs_hash' => [
				'type' => 'TEXT'
			],
			'inputs_preimage_hash' => [
				'type' => 'TEXT'
			],
		];
		$this->forge->addColumn('shared', $fields);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropColumn('shared', 'hash');
		$this->forge->dropColumn('shared', 'inputs_hash');
		$this->forge->dropColumn('shared', 'inputs_preimage_hash');
	}
}
