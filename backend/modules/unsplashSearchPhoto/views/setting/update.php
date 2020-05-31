<?php

/**
 * @var yii\web\View $this
 * @var common\models\UnsplashSearchPhotoSetting $model
 */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Unsplash Search Photo Setting',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Unsplash Search Photo Settings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="unsplash-search-photo-setting-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
