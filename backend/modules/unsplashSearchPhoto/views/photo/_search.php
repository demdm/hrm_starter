<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\UnsplashSearchPhoto $model
 * @var yii\bootstrap4\ActiveForm $form
 */
?>

<div class="unsplash-search-photo-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'id') ?>
    <?php echo $form->field($model, 'setting_id') ?>
    <?php echo $form->field($model, 'request_id') ?>
    <?php echo $form->field($model, 'unsplash_id') ?>
    <?php echo $form->field($model, 'raw_url') ?>
    <?php // echo $form->field($model, 'description') ?>
    <?php // echo $form->field($model, 'width') ?>
    <?php // echo $form->field($model, 'height') ?>
    <?php // echo $form->field($model, 'downloaded_at') ?>
    <?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('backend', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?php echo Html::resetButton(Yii::t('backend', 'Reset'), ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
