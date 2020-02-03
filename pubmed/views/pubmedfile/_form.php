<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Pubmedfile */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pubmedfile-form">

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<?= $form->field($model, 'file_name')->fileInput(['class' => 'form-control'])->label('Upload .nbib file (up to 500 KiB)') ?> 


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
