<?php

namespace app\controllers;

use app\queries\IbanQuery;
use mgcode\graphql\GraphQLAction;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;
use backend\schema\queries\UserQuery;


class GraphqlController extends Controller
{


    /** @inheritdoc */
    public $enableCsrfValidation = false;
    /** @inheritdoc */
    public function init()
    {
        parent::init();
        \Yii::$app->response->format = Response::FORMAT_JSON;
    }

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'verbFilter' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['POST'],
                    'options' => ['OPTIONS'],
                ],
            ],
        ];
    }

    public function beforeAction($action): bool
    {
        return parent::beforeAction($action);
    }

    public function actions()
    {
        return [
            'index' => [
                'class' => GraphQLAction::class,
                'queries' => [
                    'iban' => IbanQuery::class
                ]
            ],
            'options' => [
                'class' => 'yii\rest\OptionsAction',
                'collectionOptions' => ['POST'],
                'resourceOptions' => ['POST'],
            ],
        ];
    }
}
