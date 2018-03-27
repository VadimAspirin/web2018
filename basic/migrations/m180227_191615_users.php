<?php

use yii\db\Migration;

class m180227_191615_users extends Migration
{

    public function safeUp()
    {
		$this->createTable('users', [
			'id' => $this->primaryKey(),
			'firstName' => $this->string(50)->notNull(),
			'secondName' => $this->string(50)->notNull(),
			'lastName' => $this->string(50)->notNull(),
			'login' => $this->string(50)->notNull()->unique(),
			'password' => $this->string(150)->notNull(),
			'role' => $this->integer()->notNull(),
			'tokenTerminal' => $this->string(150),
		]);
    }

    public function safeDown()
    {
        $this->dropTable('users');
    }

}
