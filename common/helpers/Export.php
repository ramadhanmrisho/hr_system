<?php
/**
 * Created by PhpStorm.
 * User: memorymwageni
 * Date: 18/01/2019
 * Time: 10:23
 */

namespace common\helpers;


use common\helpers\report\Report;
use common\helpers\report\Utils;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\data\SqlDataProvider;
use yii\db\ActiveQuery;
use yii\web\Controller;
use yii\web\Response;

class Export extends Report
{
    const DEFAULT_RANGE = 'this_fy';
    public $name = 'Report';

    public function __construct($config)
    {
        parent::__construct($config);
        if (!empty($this->data_provider)){
            $this->data_provider->pagination = ['pageSize' => 20];
        }
    }

    /**
     * @param \yii\db\ActiveQuery $search
     * @param array $filters
     * @return array
     */
    public static function configureFilters(&$search, array $filters)
    {
        $filter_options = [];
        foreach ($filters as $key => $filter) {
            if (isset($filter['visible']) && $filter['visible']!=true){
                continue;
            }
            $compare = !empty($filter['compare']) ? $filter['compare'] : '=';
            $default = !empty($filter['default']) ? $filter['default'] : null;
            $label = $filter['label'];
            $type = !empty($filter['type']) ? $filter['type'] : 'select';
            $data = !empty($filter['data']) ? $filter['data'] : null;
            $value = Yii::$app->request->get($key, $default);
            if ($type=='multiple' && is_array($value)) {
                $compare = 'in';
            }elseif ($type=='range'){
                $compare = 'between';
            }
            if ($value!='all' && $value!=null){
                if ($compare == 'like') {
                    $search->andFilterWhere(['like', str_replace('-','.',$key), $value]);
                } elseif ($compare == 'between'){
                    $values = explode(' to ',$value);
                    $start = $values[0];
                    $end = count($values)>1?$values[1]:'';
                    $search->andFilterWhere([strtoupper($compare), str_replace('-','.',$key), $start,$end]);
                }else {
                    $search->andFilterWhere([strtoupper($compare), str_replace('-','.',$key), $value]);
                }
            }
            $filter_options[] = [
                'type'=>$type,
                'name' => $key,
                'label' => $label,
                'data' => $data,
                'selected' => $value
            ];
        }
        return $filter_options;
    }

    /**
     * @param ActiveQuery $search
     * @param $filters
     * @param $start_date
     * @param $end_date
     * @param $date_range
     * @param Controller $controller
     * @return string|\yii\console\Response|Response
     */
    public static function renderOrExport($search,$name, $filters, $start_date, $end_date, $date_range, $controller)
    {
        $filter_options = Export::configureFilters($search, $filters);
        $dataProvider = null;
        if (Export::isDownloadAction()) {
            return Yii::$app->response->sendContentAsFile(Export::data2csv($search->asArray()->all(), true), 'activity_register.csv');
        } elseif (Export::isDisplayAction()) {
            //$data = $search->asArray()->all();
            //$dataProvider = new ArrayDataProvider(['allModels' => $data, 'sort' => ['attributes' => count($data) > 0 ? array_keys($data[0]) : []]]);

            $dataProvider = new SqlDataProvider(['sql' => $search->createCommand()->rawSql]);
            $dataProvider->pagination->pageSize = null;
        }

        $export = new Export([
            'name' => $name,
            'data_provider' => $dataProvider,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'date_range' => $date_range
        ]);

        $export->filterOptions($filter_options);

        $columns = [];
        $columns [] =   ['class' => 'yii\grid\SerialColumn'];

        foreach ($search->select as $key=>$select){
            $columns[] = is_numeric($key)?$select:$key;
        }

        $gridColumns = $columns;
        //$gridColumns[] = 'dce_drc_task_register.updated_at';
        return $controller->render('@app/views/export/view', ['export' => $export,'columns'=>$columns,'gridColumns'=>$gridColumns]);
    }

    public function getFilters()
    {
        return $this->other_filters;
    }

    public function getActionFilter(){
        $action = Yii::$app->request->get('action','download');
        return [
            'name' => 'action',
            'label' => 'Action',
            'data'=>['download'=>'Download','display'=>'Display'],
            'selected' => $action
        ];
    }

    public static  function isDownloadAction(){
        return Yii::$app->request->get('action','') == 'download';
    }

    public static  function isDisplayAction(){
        return Yii::$app->request->get('action','') == 'display';
    }

    public static function query2csvPrint($query,$filename){
        $content = self::query2csv($query);
        self::printContentDownloadHeaders($content,$filename);
        echo $content;
    }

    /**
     * @param $query
     * @return string
     * @throws \yii\db\Exception
     */
    public static function query2csv($query){
        if (is_string($query)){
            $data = Yii::$app->db->createCommand($query)->queryAll();
        }else{
            $data = $query->asArray()->all();
        }
        return self::data2csv($data,true);
    }


    public static function data2csv($data,$with_headers=false){
        $csv="";
        //Headers
        if ($with_headers){
            if (count($data)>0){
                $row=array_keys($data[0]);
                $_row="";
                for($i=0;$i<count($row);++$i){
                    $_row.="\"".$row[$i]."\"".($i!=count($row)-1?",":"\n");
                }
                $csv.=$_row;
            }
        }
        //data
        foreach ($data as $row){
            $_row="";
            $row=array_values($row);
            for($i=0;$i<count($row);++$i){
                $_row.="\"".$row[$i]."\"".($i!=count($row)-1?",":"\n");
            }
            $csv.=$_row;
        }

        return $csv;
    }


    public static function printContentDownloadHeaders($content,$filename){
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . strlen($content));
    }


}