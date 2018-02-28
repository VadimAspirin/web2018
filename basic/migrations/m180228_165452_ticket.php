<?php

use yii\db\Migration;

class m180228_165452_ticket extends Migration
{

    public function safeUp()
    {
		$this->createTable('ticket', [
			'id' => $this->primaryKey(),
			'name' => $this->string(50)->notNull(),
			'dateCreated' => $this->dateTime()->notNull(),
			'dateCompleted' => $this->dateTime(),
			'operator' => $this->string(50),
		]);
		
		$this->createIndex(
			'idx-ticket-operator',
			'ticket',
			'operator'
		);
		
		$this->addForeignKey(
			'fk-ticket-operator',
			'ticket',
			'operator',
			'users',
			'login',
			'SET NULL'
		);
    }

    public function safeDown()
    {
		$this->dropForeignKey(
			'fk-ticket-operator',
			'ticket'
		);
		
		$this->dropIndex(
			'idx-ticket-operator',
			'ticket'
		);
        
        $this->dropTable('ticket');
    }
    
}
