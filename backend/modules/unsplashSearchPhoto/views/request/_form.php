<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\UnsplashSearchPhotoRequest $model
 * @var yii\bootstrap4\ActiveForm $form
 */
?>

<div class="unsplash-search-photo-request-form">
    <?php $form = ActiveForm::begin(); ?>
        <div class="card">
            <div class="card-body">
                <?php echo $form->errorSummary($model); ?>

                <?php echo $form->field($model, 'setting_id')->textInput() ?>
                <?php echo $form->field($model, 'page')->textInput() ?>
                <?php echo $form->field($model, 'count_result')->textInput() ?>
                <?php echo $form->field($model, 'created_at')->textInput() ?>
                
            </div>
            <div class="card-footer">
                <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
</div>
