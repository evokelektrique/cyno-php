<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWebsitesTable extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type' => 'BIGINT',
				'unsigned' => TRUE,
				'auto_increment' => TRUE,
			],    
			'hash_id' => [
				'type' => 'VARCHAR', 
				'constraint' => 255,
			],
			'user_id' => [  
				'type' => 'BIGINT',
				'unsigned' => TRUE,
			],
			'url' => [
				'type' => 'TEXT',
			],
			'fav_icon_url' => [
				'type' => 'TEXT'
			],
			'title' => [
				'type' => 'TEXT'
			],
			'pending_url' => [ // Action url
				'type' => 'TEXT'
			],
			'created_at' => [
				'type' => 'DATETIME',
			],
			'updated_at' => [
				'type' => 'DATETIME',
			],
			'deleted_at' => [
				'type' => 'DATETIME',
			],
		]);
		$this->forge->addKey('id', TRUE);
		$this->forge->addKey('hash_id', TRUE);
		$this->forge->createTable('websites');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('websites');
	}
}
