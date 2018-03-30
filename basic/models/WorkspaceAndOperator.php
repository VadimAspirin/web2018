<?php

namespace app\models;

use Yii;
use app\models\Ticket;

/**
 * This is the model class for table "workspaceAndOperator".
 *
 * @property int $id
 * @property int $workspaceId
 * @property int $operatorId
 * @property string $dateArrival
 * @property string $dateDeparture
 *
 * @property Ticket[] $tickets
 * @property Users $operator
 * @property Workspace $workspace
 */
class WorkspaceAndOperator extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'workspaceAndOperator';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['workspaceId', 'operatorId'], 'required'],
            [['workspaceId', 'operatorId'], 'integer'],
            [['dateArrival', 'dateDeparture'], 'safe'],
            [['operatorId'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['operatorId' => 'id']],
            [['workspaceId'], 'exist', 'skipOnError' => true, 'targetClass' => Workspace::className(), 'targetAttribute' => ['workspaceId' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'workspaceId' => 'Workspace ID',
            'operatorId' => 'Operator ID',
            'dateArrival' => 'Date Arrival',
            'dateDeparture' => 'Date Departure',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTickets()
    {
        return $this->hasMany(Ticket::className(), ['workspaceAndOperatorId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperator()
    {
        return $this->hasOne(Users::className(), ['id' => 'operatorId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWorkspace()
    {
        return $this->hasOne(Workspace::className(), ['id' => 'workspaceId']);
    }

    public static function workingWorkspaceOperators()
    {
        return WorkspaceAndOperator::find()->where(['dateDeparture'=>null])->all();
    }

    public static function freeWorkspaceOperators()
    {
        $busy_tickets = Ticket::find()
            ->where(['not', ['dateDistribution' => null]])
            ->andWhere(['dateProcessingEnd' => null])
            ->all();
        $working_ops = WorkspaceAndOperator::workingWorkspaceOperators();
        $busy_workspaceAndOperator_id = [];
        for ($i = 0; $i < count($busy_tickets); $i++) 
        {
            $busy_workspaceAndOperator_id[] = $busy_tickets[$i]['workspaceAndOperatorId'];
        }
        $free_workspaceAndOperator = [];
        for ($i = 0; $i < count($working_ops); $i++) 
        {
            if (!in_array($working_ops[$i]['id'], $busy_workspaceAndOperator_id)) 
            {
                $free_workspaceAndOperator[] = $working_ops[$i];
            }
        }
        return $free_workspaceAndOperator;
    }
}
