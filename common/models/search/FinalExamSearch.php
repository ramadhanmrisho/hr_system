<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\FinalExam;

/**
 * FinalExamSearch represents the model behind the search form of `common\models\FinalExam`.
 */
class FinalExamSearch extends FinalExam
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'student_id', 'academic_year_id', 'nta_level', 'course_id', 'module_id', 'created_by','semester_id'], 'integer'],
            [[  'written_exam', 'practical', 'total_score',], 'number'],
            [['created_at', 'updated_at','registration_number','nta_level'], 'safe'],
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
        $query = FinalExam::find();

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
            'academic_year_id' => $this->academic_year_id,
          
            'course_id' => $this->course_id,
            'module_id' => $this->module_id,
            'semester_id' => $this->semester_id,
            'total_score' => $this->total_score,
            'written_exam' => $this->written_exam,
            'practical' => $this->practical,
            'nta_level' => $this->nta_level,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'registration_number', $this->registration_number]);

        return $dataProvider;
    }
}
