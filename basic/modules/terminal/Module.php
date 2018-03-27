<?php

namespace app\modules\terminal;

/**
 * terminal module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\terminal\controllers';
    
    public $layout = '/terminal';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
