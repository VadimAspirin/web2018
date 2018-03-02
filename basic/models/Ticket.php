<?php

namespace app\models;

use yii\db\ActiveRecord;

class Ticket extends ActiveRecord
{
	public static function tableName()
	{
		return '{{ticket}}';
	}
}
