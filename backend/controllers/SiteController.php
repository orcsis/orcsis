<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\LoginForm;
use yii\filters\VerbFilter;

/**
 * Site controller
 */
class SiteController extends Controller
{

    public $enableCsrfValidation = false;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                    //'login' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {

        $data = Yii::$app->request->post();
        $model = new LoginForm();
        $mod = $model->load($data, '');
        //var_dump($model);
        if ($mod && $model->login())
        {
            $user = $model->getUser();
            /*if ($this->checkAccess) {
                call_user_func($this->checkAccess, $this->id, $user);
            }*/
            $user->usu_ulting = date('Y-m-d H:i:s');
            $user->generaToken();
            $update = $user->update();
            \Yii::trace('Actualizo: '.$update.' Token Generado: '.$user->usu_token);

            $this->setHeader(200);
            echo json_encode(array('status'=>1,'data'=>array_filter($user->attributes)),JSON_PRETTY_PRINT);
            //return $user;
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    private function setHeader($status)
  {
 
      $status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
      $content_type="application/json; charset=utf-8";
 
      header($status_header);
      header('Content-type: ' . $content_type);
      header('X-Powered-By: ' . "Orcsis <orcsis.com.ve>");
  }
  private function _getStatusCodeMessage($status)
  {
      $codes = Array(
      200 => 'OK',
      400 => 'Bad Request',
      401 => 'Unauthorized',
      402 => 'Payment Required',
      403 => 'Forbidden',
      404 => 'Not Found',
      500 => 'Internal Server Error',
      501 => 'Not Implemented',
      );
      return (isset($codes[$status])) ? $codes[$status] : '';
  }
}