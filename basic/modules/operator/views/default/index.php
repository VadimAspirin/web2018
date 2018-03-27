<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Workspace */
/* @var $form yii\widgets\ActiveForm */
?>

<?php 
	$prompt = ['prompt' => 'Выберите рабочее место...'];

	if($currentWorkspace == null)
	{
		$buttonName = 'Активация';
		$fieldEditable = 'dateArrival';
	}
	else
	{
		$buttonName = 'Деактивация';
		$fieldEditable = 'dateDeparture';
	}
?>

<div class="workspace-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if($currentWorkspace == null){ ?>
    	<?= $form->field($model, 'workspaceId')->dropDownList($availableWorkspace, $prompt)->label('Рабочее место') ?>
    <?php }else{ 
    	echo '<b>Рабочее место: ' . $currentWorkspace->name . '</b>';
    } ?>

    <?= $form->field($model, 'operatorId')->hiddenInput(['value' => $userId])->label(false) ?>
    <?= $form->field($model, $fieldEditable)->hiddenInput(['value' => date('Y-m-d H:i:s')])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton($buttonName, ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>