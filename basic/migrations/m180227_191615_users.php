<?php

use yii\db\Migration;

class m180227_191615_users extends Migration
{

    public function safeUp()
    {
		$this->createTable('role', [
			'id' => $this->primaryKey(),
			'name' => $this->string(50)->notNull()->unique(),
		]);
		
		//$this->batchInsert('role', ['name'], ['operator','admin','terminal']);
		$this->insert('role', [ 'name' => 'operator' ]);
		$this->insert('role', [ 'name' => 'admin' ]);
		$this->insert('role', [ 'name' => 'terminal' ]);
		
		
		$this->createTable('users', [
			'id' => $this->primaryKey(),
			'firstName' => $this->string(50)->notNull(),
			'secondName' => $this->string(50)->notNull(),
			'lastName' => $this->string(50)->notNull(),
			'login' => $this->string(50)->notNull()->unique(),
			'password' => $this->string(50)->notNull(),
			'role' => $this->string(50),
		]);
		
		$this->createIndex(
			'idx-users-role',
			'users',
			'role'
		);
		
		$this->addForeignKey(
			'fk-users-role',
			'users',
			'role',
			'role',
			'name',
			'SET NULL'
		);
    }

    public function safeDown()
    {
        $this->dropForeignKey(
			'fk-users-role',
			'users'
		);
		
		$this->dropIndex(
			'idx-users-role',
			'users'
		);
        
        $this->dropTable('users');
        
        $this->delete('role', ['name' => 'operator']);
        $this->delete('role', ['name' => 'admin']);
        $this->delete('role', ['name' => 'terminal']);
        
        $this->dropTable('role');
    }

}
