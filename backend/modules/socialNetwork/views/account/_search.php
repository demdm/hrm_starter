<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\SocialNetworkAccount $model
 * @var yii\bootstrap4\ActiveForm $form
 */
?>

<div class="social-network-account-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'id') ?>
    <?php echo $form->field($model, 'name') ?>
    <?php echo $form->field($model, 'comment') ?>
    <?php echo $form->field($model, 'type') ?>
    <?php echo $form->field($model, 'login') ?>
    <?php // echo $form->field($model, 'password') ?>
    <?php // echo $form->field($model, 'extra') ?>

    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('backend', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?php echo Html::resetButton(Yii::t('backend', 'Reset'), ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
