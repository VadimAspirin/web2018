<?php

use yii\db\Migration;

class m180314_193730_ticket extends Migration
{
    public function safeUp()
    {
		$this->createTable('ticket', [
			'id' => $this->primaryKey(),
			'name' => $this->string(50)->notNull(),
			'workspaceAndOperatorId' => $this->integer(),
			'dateCreated' => $this->dateTime()->notNull(),
			'dateDistribution' => $this->dateTime(),
			'dateProcessingStart' => $this->dateTime(),
			'dateProcessingEnd' => $this->dateTime(),
		]);
		
		$this->createIndex(
			'idx-ticket-workspaceAndOperatorId',
			'ticket',
			'workspaceAndOperatorId'
		);
		
		$this->addForeignKey(
			'fk-ticket-workspaceAndOperatorId',
			'ticket',
			'workspaceAndOperatorId',
			'workspaceAndOperator',
			'id',
			'NO ACTION'
		);
    }

    public function safeDown()
    {
		$this->dropForeignKey(
			'fk-ticket-workspaceAndOperatorId',
			'ticket'
		);
		
		$this->dropIndex(
			'idx-ticket-workspaceAndOperatorId',
			'ticket'
		);
        
        $this->dropTable('ticket');
    }
}
