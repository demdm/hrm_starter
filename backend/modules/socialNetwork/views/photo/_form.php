<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\SocialNetworkPhoto $model
 * @var yii\bootstrap4\ActiveForm $form
 */
?>

<div class="social-network-photo-form">
    <?php $form = ActiveForm::begin(); ?>
        <div class="card">
            <div class="card-body">
                <?= $form->errorSummary($model); ?>

                <?= $form->field($model, 'file_caption')->textInput(['maxlength' => true]) ?>

            </div>
            <div class="card-footer">
                <?= Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
</div>
