<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use app\models\Ticket;

class TicketDaemonController extends Controller
{
    public function actionStart()
    {
        require_once '../websocketserver/ratchet/client-send-php.php';
        while(true)
        {
            Ticket::distributeTickets();
            $webSocketServerHost = 'localhost';
            $webSocketServerPort = '8080';
            $jsonData = json_encode(Ticket::workingTicketsWorkspace());
            webSocketClientSendMessages($webSocketServerHost, $webSocketServerPort, $jsonData);
            echo "OK\n";
            sleep(2);
        }
        
        
    }
}