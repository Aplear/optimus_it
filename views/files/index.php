<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FilesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Files';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="files-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Files', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title',
            'extention',
            [
                'attribute' => 'size',
                'value' => function($model) {
                    return $model->size . ' MB';
                },
                'format' => 'raw'
            ],
            [
                'attribute' => 'uploaded_at',
                'value' => function($model) {
                    $items = $model->downloaded??0;
                    return date('Y-m-d h:i', $model->uploaded_at);
                },
                'format' => 'raw'
            ],
            [
                'attribute' => 'downloaded',
                'value' => function($model) {
                    $items = $model->downloaded??0;
                    return $items . ' items';
                },
                'format' => 'raw'
            ],
            [
                'attribute' => 'description',
                'value' => function($model) {
                    return HTML::tag('a', mb_substr($model->description, 0, 30),[
                        'href' => '#',
                        'onclick' => 'getDataByUrl("'.Url::to(['files/ajax-view-full-description', 'id' => $model->id]).'", true);'
                    ]);
                },
                'format' => 'raw'
            ],
            [

                'class' => 'yii\grid\ActionColumn',
                'template' => '{download} {update} {delete}',
                'buttons' => [
                    'download' => function ($url,$model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-download"></span>',
                            $url,
                            [ 'class'=>'modal-btn-download', 'title' => 'Download']
                        );
                    },
                    'update' => function ($url,$model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-edit"></span>',
                            $url
                        );
                    },
                    'delete' => function ($url,$model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-trash"></span>',
                            $url
                        );
                    },
                ],
            ],
        ],
    ]); ?>


</div>

<?php
yii\bootstrap\Modal::begin([
    'header' => 'Files',
    'id' => 'modal',
    'size' => 'modal-md',
    //keeps from closing modal with esc key or by clicking out of the modal.
    // user must click cancel or X to close
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
]);
?>
    <div id='modal-content'>Loading...</div>
<?php yii\bootstrap\Modal::end(); ?>

<?php $this->registerJsFile('/js/files/index.js', [
    'depends' => ['app\assets\AppAsset']
])?>