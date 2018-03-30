<?php

namespace app\models;

use Yii;
use app\models\WorkspaceAndOperator;
use app\models\Workspace;

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

    public function distributionTicket($workspaceAndOperatorId)
    {
        $this->dateDistribution = date('Y-m-d H:i:s');
        $this->workspaceAndOperatorId = $workspaceAndOperatorId;
        $this->save();
    }

    public static function freeTickets()
    {
        return Ticket::find()
            ->where(['workspaceAndOperatorId'=>null])
            ->all();
    }

    public static function distributeTickets()
    {
        while (Ticket::freeTickets() and WorkspaceAndOperator::freeWorkspaceOperators()) 
        {
            $rand_oper = random_int(0, count(WorkspaceAndOperator::freeWorkspaceOperators())-1);
            $rand_ticket = random_int(0, count(Ticket::freeTickets())-1);
            Ticket::freeTickets()[$rand_ticket]
                ->distributionTicket(WorkspaceAndOperator::freeWorkspaceOperators()[$rand_oper]->id);
        }
    }

    public static function workingTikets()
    {
        return Ticket::find()
            ->where(['dateProcessingEnd' => null])
            ->all();
    }

    public function getTicketWorkspaceName()
    {
        if($this->workspaceAndOperatorId != null){
            $workspaceAndOperator = WorkspaceAndOperator::findOne($this->workspaceAndOperatorId);
            return Workspace::findOne($workspaceAndOperator->workspaceId)['name'];
        }
    }

    public static function workingTicketsWorkspace()
    {
        $ticketWorkspace = [];
        $tickets = Ticket::workingTikets();
        foreach ($tickets as $ticket)
        {
            $ticketWorkspace[] = ["ticketName"=>$ticket->name, 
                                  "workspaceAndOperatorId"=>$ticket->workspaceAndOperatorId,
                                  "dateDistribution"=>$ticket->dateDistribution,
                                  "workspace"=>$ticket->getTicketWorkspaceName()];
        }
        return $ticketWorkspace;
    }
}
