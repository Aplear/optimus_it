<?php

use yii\helpers\Html;
use yii\grid\GridView;

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
            'size',
            'uploaded_at',
            'downloaded',
            'description',

            [

                'class' => 'yii\grid\ActionColumn',
                'template' => '{download} {update} {delete}',
                'buttons' => [
                    'drivers-set' => function ($url,$model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-refresh"></span>',
                            str_replace('default', 'chains', $url),
                            [ 'class'=>'modal-btn-drivers-set', 'title' => 'Drivers set', 'aria-label'=>'Drivers set', 'data-pjax' => 0]
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
