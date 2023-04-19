<?php

namespace common\models\search;

use common\models\Course;
use common\models\YearOfStudy;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Grade;

/**
 * GradeSearch represents the model behind the search form of `common\models\Grade`.
 */
class GradeSearch extends Grade
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'academic_year_id', 'point', 'created_by'], 'integer'],
            [['lower_score', 'upper_score'], 'number'],
            [['grade', 'description', 'created_at', 'updated_at'], 'safe'],
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
        $query = Grade::find();

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
            'lower_score' => $this->lower_score,
            'upper_score' => $this->upper_score,
            'academic_year_id' => $this->academic_year_id,
            'point' => $this->point,
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



        $query->andFilterWhere(['like', 'grade', $this->grade])
            ->andFilterWhere(['like', 'description', $this->description])->orderBy(['lower_score'=>SORT_DESC]);

        return $dataProvider;
    }
}
