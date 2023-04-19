<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Test;

/**
 * TestSearch represents the model behind the search form of `common\models\Test`.
 */
class TestSearch extends Test
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'student_id', 'year_of_study_id', 'academic_year_id', 'module_id', 'semester_id', 'course_id', 'created_by'], 'integer'],
            [['category', 'created_at', 'updated_at','registration_number'], 'safe'],
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
        $query = Test::find();

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
            'year_of_study_id' => $this->year_of_study_id,
            'academic_year_id' => $this->academic_year_id,
            'module_id' => $this->module_id,
            'semester_id' => $this->semester_id,
            'course_id' => $this->course_id,
            'score' => $this->score,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'category', $this->category]);
        $query->andFilterWhere(['like', 'registration_number', $this->registration_number]);

        return $dataProvider;
    }
}
