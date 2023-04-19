<?php

namespace common\models\search;

use common\models\AcademicYear;
use common\models\Course;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Module;

/**
 * ModuleSearch represents the model behind the search form of `common\models\Module`.
 */
class ModuleSearch extends Module
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'course_id', 'year_of_study_id', 'semester_id', 'module_credit', 'created_by','department_id'], 'integer'],
            [['module_name', 'module_code', 'nta_level', 'prerequisite',  'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Module::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'course_id' => $this->course_id,
            'year_of_study_id' => $this->year_of_study_id,
            'semester_id' => $this->semester_id,
            'department_id' => $this->department_id,
            'module_credit' => $this->module_credit,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);



        $cm1=Course::find()->where(['abbreviation'=>'NTA4_CM'])->one()->id;
        $cm2=Course::find()->where(['abbreviation'=>'NTA5_CM'])->one()->id;
        $cm3=Course::find()->where(['abbreviation'=>'NTA6_CM'])->one()->id;

        if (\Yii::$app->request->get('authorization')=='clinical_1'){
            $query->andFilterWhere(['like','course_id',$cm1]);
        }

        if (\Yii::$app->request->get('authorization')=='clinical_2'){
            $query->andFilterWhere(['like','course_id',$cm2]);
        }

        if (\Yii::$app->request->get('authorization')=='clinical_3'){
            $query->andFilterWhere(['like','course_id',$cm3]);
        }

        $nm1=Course::find()->where(['abbreviation'=>'NTA4_NM'])->one()->id;
        $nm2=Course::find()->where(['abbreviation'=>'NTA5_NM'])->one()->id;
        $nm3=Course::find()->where(['abbreviation'=>'NTA6_NM'])->one()->id;

        if (\Yii::$app->request->get('authorization')=='nursing_1'){
            $query->andFilterWhere(['like','course_id',$nm1]);
        }

        if (\Yii::$app->request->get('authorization')=='nursing_2'){
            $query->andFilterWhere(['like','course_id',$nm2]);
        }
        if (\Yii::$app->request->get('authorization')=='nursing_3'){
            $query->andFilterWhere(['like','course_id',$nm3]);
        }




        $query->andFilterWhere(['like', 'module_name', $this->module_name])
            ->andFilterWhere(['like', 'module_code', $this->module_code])
            ->andFilterWhere(['like', 'nta_level', $this->nta_level])
            ->andFilterWhere(['like', 'prerequisite', $this->prerequisite]);
        return $dataProvider;
    }
}
