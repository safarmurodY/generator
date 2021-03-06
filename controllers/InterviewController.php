<?php

namespace app\controllers;

use app\forms\InterviewEditForm;
use app\forms\InterviewInviteForm;
use app\forms\InterviewMoveForm;
use app\forms\InterviewRejectForm;
use app\models\Interview;
use app\forms\search\InterviewSearch;
use app\services\StaffService;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * InterviewController implements the CRUD actions for Interview model.
 */
class InterviewController extends Controller
{
    private $staffService;

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
     * Lists all Interview models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new InterviewSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Interview model.
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
     * Creates a new Interview model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Interview();

//        $model->setScenario(Interview::SCENARIO_CREATE);
        $model->date = date('Y-m-d');

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    public function actionInvite()
    {
        $form = new InterviewInviteForm();
        if ($this->request->isPost
            && $form->load($this->request->post())
            && $form->validate()){
//            $service = new StaffService();
            $model = $this->staffService->joinToInterview(
                $form->last_name,
                $form->first_name,
                $form->email,
                $form->date);
            return $this->redirect(['view', 'id' => $model->id]);

        }
        return $this->render('invite', [
            'joinForm' => $form,
        ]);
    }

    /**
     * Updates an existing Interview model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $form = new InterviewEditForm($model);

        if ($this->request->isPost && $form->load($this->request->post()) && $form->validate()) {
//            Yii::$container->get(StaffService::class);
//            Yii::createObject(StaffService::class);
//            $service = new StaffService();
            $this->staffService->editInterview(
                $model->id,
                $form->last_name,
                $form->first_name,
                $form->email
            );
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'editForm' => $form,
            'model' => $model,
        ]);
    }
    public function actionMove($id)
    {
        $model = $this->findModel($id);
        $form = new InterviewMoveForm($model);

        if ($this->request->isPost && $form->load($this->request->post()) && $form->validate()) {
//            Yii::$container->get(StaffService::class);
//            Yii::createObject(StaffService::class);
//            $service = new StaffService();
            $this->staffService->moveInterview(
                $model->id,
                $form->date,
            );
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'editForm' => $form,
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionReject($id)
    {
        $model = $this->findModel($id);
        $rejectForm = new InterviewRejectForm();

        if ($this->request->isPost && $rejectForm->load($this->request->post()) && $rejectForm->validate()) {
            $this->staffService->rejectInterview($model->id, $rejectForm->reason);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('reject', [
            'rejectForm' => $rejectForm,
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Interview model.
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
     * Finds the Interview model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Interview the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Interview::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
