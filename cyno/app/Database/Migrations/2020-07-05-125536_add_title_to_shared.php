<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTitleToShared extends Migration
{
	public function up()
	{
		$fields = [
			'title' => [
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => FALSE
			]
		];
		$this->forge->addColumn('shared', $fields);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropColumn('shared', 'title');
	}
}
