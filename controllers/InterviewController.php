<?php

namespace app\controllers;

use app\forms\InterviewEditForm;
use app\forms\InterviewJoinForm;
use app\forms\InterviewRejectForm;
use app\models\Interview;
use app\forms\search\InterviewSearch;
use app\services\StaffService;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * InterviewController implements the CRUD actions for Interview model.
 */
class InterviewController extends Controller
{
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
                        'reject' => ['POST'],
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

        $model->setScenario(Interview::SCENARIO_CREATE);
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
    public function actionJoin()
    {
        $form = new InterviewJoinForm();
        if ($this->request->isPost
            && $form->load($this->request->post())
            && $form->validate()){
            $service = new StaffService();
            $model = $service->joinToInterview(
                $form->last_name,
                $form->first_name,
                $form->email,
                $form->date);
            return $this->redirect(['view', 'id' => $model->id]);

        }
        return $this->render('join', [
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
            $service = new StaffService();
            $service->editInterview(
                $model->id,
                $form->last_name,
                $form->first_name,
                $form->email
            );
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
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
        $form = new InterviewRejectForm();

        if ($this->request->isPost && $form->load($this->request->post()) && $form->validate()) {
            $service = new StaffService();
            $service->rejectInterview($model->id, $form->reason);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
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

        throw new NotFoundHttpException(\Yii::t('app', 'The requested page does not exist.'));
    }
}
