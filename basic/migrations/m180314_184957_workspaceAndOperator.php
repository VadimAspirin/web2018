<?php

use yii\db\Migration;

class m180314_184957_workspaceAndOperator extends Migration
{
    public function safeUp()
    {
		$this->createTable('workspaceAndOperator', [
			'id' => $this->primaryKey(),
			'workspaceId' => $this->integer()->notNull(),
			'operatorId' => $this->integer()->notNull(),
			'dateArrival' => $this->dateTime(),
			'dateDeparture' => $this->dateTime(),
		]);
		
		$this->createIndex(
            'idx-workspaceAndOperator-workspaceId',
            'workspaceAndOperator',
            'workspaceId'
        );
        
        $this->createIndex(
            'idx-workspaceAndOperator-operatorId',
            'workspaceAndOperator',
            'operatorId'
        );
        
        $this->addForeignKey(
            'fk-workspaceAndOperator-workspaceId',
            'workspaceAndOperator',
            'workspaceId',
            'workspace',
            'id',
            'NO ACTION'
        );
        
        $this->addForeignKey(
            'fk-workspaceAndOperator-operatorId',
            'workspaceAndOperator',
            'operatorId',
            'users',
            'id',
            'NO ACTION'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-workspaceAndOperator-operatorId',
            'workspaceAndOperator'
        );
        
        $this->dropForeignKey(
            'fk-workspaceAndOperator-workspaceId',
            'workspaceAndOperator'
        );
        
        $this->dropIndex(
            'idx-workspaceAndOperator-operatorId',
            'workspaceAndOperator'
        );
        
        $this->dropIndex(
            'idx-workspaceAndOperator-workspaceId',
            'workspaceAndOperator'
        );
        
        $this->dropTable('workspaceAndOperator');
    }
}
