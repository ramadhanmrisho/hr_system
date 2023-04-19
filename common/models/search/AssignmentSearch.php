<?php

namespace common\models\search;

use common\models\Semester;
use common\models\YearOfStudy;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Assignment;

/**
 * AssignmentSearch represents the model behind the search form of `common\models\Assignment`.
 */
class AssignmentSearch extends Assignment
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'student_id', 'module_id', 'course_id', 'academic_year_id', 'semester_id', 'created_by','assessment_method_id'], 'integer'],
            [['created_at', 'updated_at','registration_number','nta_level'], 'safe'],
            [['score'], 'number'],
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
        $query = Assignment::find();

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
            'student_id' => $this->student_id,
            'module_id' => $this->module_id,
            'course_id' => $this->course_id,
         
            'assessment_method_id' => $this->assessment_method_id,
            'academic_year_id' => $this->academic_year_id,
            'semester_id' => $this->semester_id,
            'score' => $this->score,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $first_year=4;
        $second_year=5;
        $third_year=6;


        if (\Yii::$app->request->get('authorization')=='nta_4'){
            $query->andFilterWhere(['like','nta_level',$first_year]);
        }
        if (\Yii::$app->request->get('authorization')=='nta_5'){
            $query->andFilterWhere(['like','nta_level',$second_year]);
        }
        if (\Yii::$app->request->get('authorization')=='nta_6'){
            $query->andFilterWhere(['like','nta_level',$third_year]);
        }


        $active_semester=Semester::find()->where(['status'=>'Active'])->one()->id;
        $query->andFilterWhere(['like', 'registration_number', $this->registration_number]);
        $query->andFilterWhere(['like', 'created_by', Yii::$app->user->identity->id]);
        $query->andFilterWhere(['like', 'semester_id', $active_semester]);

        return $dataProvider;
    }
}
