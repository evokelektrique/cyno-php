<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddNonceShared.php extends Migration
{
	public function up()
	{
		$fields = [
			'nonce' => [
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => FALSE,
			],
		];
		$this->forge->addColumn('shared', $fields);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropColumn('shared', 'nonce');
	}
}