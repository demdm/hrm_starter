<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\UnsplashSearchPhotoSetting $model
 * @var yii\bootstrap4\ActiveForm $form
 */
?>

<div class="unsplash-search-photo-setting-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'id') ?>
    <?php echo $form->field($model, 'social_network_account_id') ?>
    <?php echo $form->field($model, 'name') ?>
    <?php echo $form->field($model, 'search') ?>
    <?php echo $form->field($model, 'per_page') ?>
    <?php // echo $form->field($model, 'orientation') ?>
    <?php // echo $form->field($model, 'collections') ?>

    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('backend', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?php echo Html::resetButton(Yii::t('backend', 'Reset'), ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
