<?php

namespace app\controllers;

use app\forms\EmpoloyeeCreateForm;
use app\models\Contract;
use app\models\Employee;
use app\forms\search\EmployeeSearch;
use app\models\Interview;
use app\models\Order;
use app\models\Recruit;
use app\services\StaffService;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\ServerErrorHttpException;

/**
 * EmployeeController implements the CRUD actions for Employee model.
 */
class EmployeeController extends Controller
{
    private $staffService;

    /**
     * @param $id
     * @param $module
     * @param StaffService $staffService
     * @param $config
     */
    public function __construct($id, $module, StaffService $staffService, $config = [])
    {
        $this->staffService = $staffService;
        parent::__construct($id, $module, $config);
    }

    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Employee models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new EmployeeSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Employee model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * @param $interview_id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     */
    public function actionCreate($interview_id = null)
    {
        $model = new Employee();
        $interview = ($interview_id) ? $this->findInterviewModel($interview_id) : null;
        /**  @var $interview Interview */
        $form = new EmpoloyeeCreateForm($interview);


        if ($this->request->isPost && $form->load($this->request->post()) && $form->validate()) {

            /** @var Employee $employee */
            $employee = $this->staffService->createEmployee(
                $interview_id,
                $form->first_name,
                $form->last_name,
                $form->email,
                $form->address,
                $form->order_date,
                $form->contract_date,
                $form->recruit_date,
            );
            \Yii::$app->session->setFlash('success', 'Employee Recruit');
            return $this->redirect(['view', 'id' => $employee->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Employee model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Employee model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Employee model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Employee the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Employee::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(\Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * @param int $id
     * @return Interview|null
     * @throws NotFoundHttpException
     */
    protected function findInterviewModel(int $id): ?Interview
    {
        if (($model = Interview::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(\Yii::t('app', 'The requested page does not exist.'));
    }
}
