<?php

use common\models\SocialNetworkAccount;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\SocialNetworkAccount $model
 * @var yii\bootstrap4\ActiveForm $form
 */
?>

<div class="social-network-account-form">
    <?php $form = ActiveForm::begin(); ?>
        <div class="card">
            <div class="card-body">
                <?= $form->errorSummary($model); ?>

                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'hash_tags')->textarea(['rows' => 6]) ?>
                <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>
                <?= $form->field($model, 'login')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'password')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'is_active')->checkbox() ?>

            </div>
            <div class="card-footer">
                <?= Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
</div>
