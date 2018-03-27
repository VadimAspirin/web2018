<?php

use yii\db\Migration;

class m180314_184646_workspace extends Migration
{
    public function safeUp()
    {
		$this->createTable('workspace', [
			'id' => $this->primaryKey(),
			'name' => $this->string(50)->notNull(),
		]);
    }

    public function safeDown()
    {
        $this->dropTable('workspace');
    }
}
