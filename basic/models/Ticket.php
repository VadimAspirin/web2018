<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ticket".
 *
 * @property int $id
 * @property string $name
 * @property int $workspaceAndOperatorId
 * @property string $dateCreated
 * @property string $dateProcessingStart
 * @property string $dateProcessingEnd
 * @property string $dateDistribution
 *
 * @property WorkspaceAndOperator $workspaceAndOperator
 */
class Ticket extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ticket';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'dateCreated'], 'required'],
            [['workspaceAndOperatorId'], 'integer'],
            [['dateCreated', 'dateProcessingStart', 'dateProcessingEnd', 'dateDistribution'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['workspaceAndOperatorId'], 'exist', 'skipOnError' => true, 'targetClass' => WorkspaceAndOperator::className(), 'targetAttribute' => ['workspaceAndOperatorId' => 'id']],
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
            'workspaceAndOperatorId' => 'Workspace And Operator ID',
            'dateCreated' => 'Date Created',
            'dateProcessingStart' => 'Date Processing Start',
            'dateProcessingEnd' => 'Date Processing End',
            'dateDistribution' => 'Date Distribution',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWorkspaceAndOperator()
    {
        return $this->hasOne(WorkspaceAndOperator::className(), ['id' => 'workspaceAndOperatorId']);
    }
}
