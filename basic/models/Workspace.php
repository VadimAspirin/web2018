<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "workspace".
 *
 * @property int $id
 * @property string $name
 *
 * @property WorkspaceAndOperator[] $workspaceAndOperators
 */
class Workspace extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'workspace';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWorkspaceAndOperators()
    {
        return $this->hasMany(WorkspaceAndOperator::className(), ['workspaceId' => 'id']);
    }
}
