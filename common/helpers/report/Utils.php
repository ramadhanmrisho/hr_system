<?php
/**
 * Created by PhpStorm.
 * User: memorymwageni
 * Date: 02/01/2019
 * Time: 14:01
 */

namespace common\helpers\report;


use common\models\ComplaintRbLocations;
use common\models\PccbDistricts;
use common\models\PccbRegions;
use common\models\PetsFinancialYear;
use common\models\Sector;
use common\models\Staff;
use common\models\Status;
use common\models\ZonalInspectors;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class Utils
{

    CONST YEAR_QUERY = "(SELECT YEAR(NOW())-daynum as year FROM ( SELECT n*10+n2 AS daynum FROM (SELECT 0 n UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) B, (SELECT 0 n2 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) C ORDER BY daynum DESC) AS years WHERE YEAR(NOW())- daynum>2015) as years";
    /**
     * Applies a filter according to office level of the logged in user
     * @param Query $query
     */
    public static function autoApplyLevelFilter(&$query){

        /*if (Staff::currentStaffHas(null,'region')){
            $query->where(['view_pccb_offices.pccb_region_id'=>Yii::$app->user->identity->pccb_region_id]);
        }elseif (Staff::currentStaffHas(null,'district')){
            $query->where(['view_pccb_offices.office_id'=>Yii::$app->user->identity->pccb_district_id,'view_pccb_offices.type'=>'district']);
        }elseif (Staff::currentStaffHas(null,'zone')){
            $query->where(['view_pccb_offices.zone_id'=>ZonalInspectors::find()->where(['status'=>Status::STATUS_ACTIVE,'staff_id'=>Yii::$app->user->identity->getId()])->one()->id]);
        }*/
    }

    /**
     * Applies a filter according to office level of the logged in user
     * @param Query $query
     */
    public static function autoApplyLevelFilterForExport(&$query){

        if (Staff::currentStaffHas(null,'region')){
            $query->andWhere(['view_pccb_offices.pccb_region_id'=>Yii::$app->user->identity->pccb_region_id]);
        }elseif (Staff::currentStaffHas(null,'district')){
            $query->andWhere(['view_pccb_offices.office_id'=>Yii::$app->user->identity->pccb_district_id,'view_pccb_offices.type'=>'district']);
        }
    }


    /**
     * Add region and district to SELECT and to GROUP BY
     * @param Query $query
     * @param $columns []
     * @param $group_by
     * @param bool $join_with_offices
     * @param null $table
     */
    public static function applySelectWithOfficeGroupBy(&$query, $columns, $group_by, $join_with_offices=false,$table=null){

        if ($join_with_offices){
            self::innerJoinWithOffices($query,$table);
        }
        if ($group_by=='regions'){
            array_unshift($columns,"region");
            $query->select($columns)
                ->groupBy('view_pccb_offices.pccb_region_id')
                ->groupBy('view_pccb_offices.region');
        }else{
            array_unshift($columns,"region", "district");
            $query->select($columns)
                ->groupBy('CONCAT(view_pccb_offices.type,view_pccb_offices.office_id)')
                ->groupBy('view_pccb_offices.region')
                ->groupBy('view_pccb_offices.district');
        }
    }

    /**
     * @param Query|ActiveRecord $query
     * @param null $table
     */
    public static function innerJoinWithOffices(&$query,$table=null){
        if ($table==ComplaintRbLocations::tableName()){
            $query->rightJoin('view_pccb_offices', "(({$table}.pccb_district_id=`view_pccb_offices`.office_id AND view_pccb_offices.type='district' AND gcr_office_level_id=3) OR ({$table}.pccb_region_id=`view_pccb_offices`.office_id AND view_pccb_offices.type='regional_office'  AND (gcr_office_level_id=1 OR gcr_office_level_id=2)))");
        }else{
            $query->rightJoin('view_pccb_offices', "(({$table}.pccb_district_id=`view_pccb_offices`.office_id AND view_pccb_offices.type='district' AND {$table}.office_level_id=3) OR ({$table}.pccb_region_id=`view_pccb_offices`.office_id AND view_pccb_offices.type='regional_office'  AND ({$table}.office_level_id=1 OR {$table}.office_level_id=2)))");
        }
    }

    /**
     * @param Query|ActiveRecord $query
     * @param null $table
     */
    public static function leftJoinWithOffices(&$query,$table=null){
        if ($table==ComplaintRbLocations::tableName()){
            $query->leftJoin('view_pccb_offices', "(({$table}.pccb_district_id=`view_pccb_offices`.office_id AND view_pccb_offices.type='district' AND gcr_office_level_id=3) OR ({$table}.pccb_region_id=`view_pccb_offices`.office_id AND view_pccb_offices.type='regional_office'  AND (gcr_office_level_id=1 OR gcr_office_level_id=2)))");
        }else{
            $query->leftJoin('view_pccb_offices', "(({$table}.pccb_district_id=`view_pccb_offices`.office_id AND view_pccb_offices.type='district' AND {$table}.office_level_id=3) OR ({$table}.pccb_region_id=`view_pccb_offices`.office_id AND view_pccb_offices.type='regional_office'  AND ({$table}.office_level_id=1 OR {$table}.office_level_id=2)))");
        }
    }

    /**
     *
     * @param Query $query
     * @param $columns []
     * @param $group_by
     * @param bool $join_with_offices
     * @param $table
     */
    public static function applySelectWithOfficeGroupByAndAutoLevelFilter(&$query, $columns, $group_by, $join_with_offices=false,$table=null){
        Utils::applySelectWithOfficeGroupBy($query, $columns, $group_by, $join_with_offices, $table);
        Utils::autoApplyLevelFilter($query);
    }

    /**
     * @return array
     */
    public static function initReportDates()
    {
        $start_date = Yii::$app->request->get('start_date', date('Y-m-d'));
        $end_date = Yii::$app->request->get('end_date', date('Y-m-d'));
        $date_range = Yii::$app->request->get('range', Report::DEFAULT_RANGE);
        if ($date_range != 'custom') {
            list($start_date, $end_date) = Report::rangeToDate($date_range);
        }

        return [$start_date,$end_date,$date_range];
    }

    /**
     * @param Report $report
     * @param $filter_group_by - Default selected value
     * @param null $filter_region
     * @param null $filter_district
     * @param null $view
     */
    public static function addGroupByFilterOptions(&$report, $filter_group_by=null,$filter_region=null, $filter_district=null,$view=null)
    {
        if (!empty($filter_group_by)){
            $report->filterOption([
                'name' => 'group_by',
                'label' => 'Group By',
                'data' => ['districts' => 'Districts', 'regions' => 'Regions'],
                'selected' => $filter_group_by
            ]);
        }

        if (!empty($filter_region)){
            $pccb_regions = Utils::optionsMap(PccbRegions::find()->all(),'id','name');

            $report->filterOption([
                'name' => 'region',
                'label' => 'Region',
                'data' => $pccb_regions,
                'selected' => $filter_region
            ]);
        }

        if (!empty($filter_region) && !empty($filter_district)){
            $_districts = self::districtsForFilter($pccb_regions);

            $report->filterOption([
                'name' => 'district',
                'label' => 'District',
                'data' => $_districts[$filter_region],
                'selected' => $filter_district
            ]);

            $view->registerJs(self::districtFilterJS($_districts));
        }
    }

    /**
     * @param $main_query
     * @param $columns
     * @return array
     */
    public static function queryToKPIs($main_query, $columns)
    {
        $temp_data = [];
        foreach ($columns as $column) {
            $query = Query::from('(' . $main_query->sql() . ') as temp_table')
                ->select('sum(`' . $column . '`)  as Total')
                ->select('avg(`' . $column . '`)  as average')
                ->select('(max(`' . $column . '`) - min(`' . $column . '`))  as `Range`')
                ->select('max(`' . $column . '`)  as Maximum')
                ->select('min(`' . $column . '`)  as Minimum')
                ->select(' STDDEV(`' . $column . '`)  as `S.Deviation`');
                
            $temp_data[$column] = $query->queryOne();
        }

        $data = [];
        $rows = ['Total', 'average', 'Range', 'Maximum', 'Minimum', 'S.Deviation'];
        foreach ($rows as $row) {
            $_data['Statistic'] = $row;
            foreach ($columns as $column){
                $_data[$column] = round($temp_data[$column][$row], 2);
            }
            $data[] = $_data;
        }
        return $data;
        
    }

    /**
     * @param $query Query
     * @param $columns
     * @param $group_by
     * @param $filter_sector
     */
    public static function autoApplySectorGroupByAndFilter(&$query, &$columns, $group_by, $filter_sector)
    {
        $query->rightJoin('('.Query::from('sector')->select(['sector.name as name','subsectors.name as sub_sector','subsectors.id as sub_sector_id','sector.id as sector_id'])->innerJoin('subsectors','sector.id=sector_id')->sql().') as sector', "sector.sub_sector_id=subsector_id");

        if ($group_by=='sub-sector'){
            $query->groupBy('sub_sector_id');
        }else{
            unset($columns[1]);
            $query->groupBy('sector_id');
        }
        if ($filter_sector!='all') $query->andWhere(['sector_id'=>$filter_sector]);
    }


    /**
     * @param Report $report
     * @param $selected
     * @param $selected_group_by
     */
    public static function includeSectorFilter(&$report, $selected, $selected_group_by)
    {
        $_sectors = ArrayHelper::map(Sector::find()->all(),'id','name');
        $sectors['all'] = 'All';
        foreach ($_sectors as $key=>$value){
            $sectors[$key] = $value;
        }

        $report->filterOption([
            'name'=>'sector',
            'label'=>'Sector',
            'data'=>$sectors,
            'selected'=>$selected
        ]);

        $report->filterOption([
            'name'=>'group_by',
            'label'=>'Group By',
            'data'=>['sector'=>'Sector','sub-sector'=>'Sub Sector'],
            'selected'=>$selected_group_by
        ]);
    }

    public static function optionsMap($objects,$from,$to,$include_all = true){
        $_data = ArrayHelper::map($objects,$from,$to);
        if ($include_all){
            $data['all'] = 'All';
        } else{
            $data = [];
        }
        foreach ($_data as $key=>$value){
            $data[$key] = $value;
        }
        return $data;
    }

    /**
     * @param array $_districts
     * @return string
     */
    public static function districtFilterJS(array $_districts)
    {
        $districts_json = json_encode($_districts);
        $js = <<<DD
     $('[name="region"]').on('change',function () {
            var pccb_districts = $districts_json;
            $('[name="district"]').html('');
            $('[name="district"]').append($('<option>', {
                value: 'all',
                text : 'All'
            }));
            if (this.value!=='all'){
                $.each(pccb_districts[this.value], function (i, item) {
                    if(i!='all')
                    $('[name="district"]').append($('<option>', {
                        value: i,
                        text : item
                    }));
                });
            }
        })
DD;
        return $js;
    }

    /**
     * @param array $data
     * @param $parent
     * @param $child
     * @return string
     */
    public static function dependentFilterJS(array $data,$parent,$child)
    {
        $data_json = json_encode($data);
        $js = <<<DD
     $('[name="$parent"]').on('change',function () {
            var data = $data_json;
            $('[name="$child"]').html('');
            $('[name="$child"]').append($('<option>', {
                value: 'all',
                text : 'All'
            }));
            if (this.value!=='all'){
                $.each(data[this.value], function (i, item) {
                    if(i!='all')
                    $('[name="$child"]').append($('<option>', {
                        value: i,
                        text : item
                    }));
                });
            }
        })
DD;
        return $js;
    }

    /**
     * @param Report $report
     * @param array|null $filter_fy
     */
    public static function projectCommencementFYFilter(&$report, $filter_fy)
    {
        $_fyrs = ArrayHelper::map(PetsFinancialYear::find()->all(), 'id', 'financial_year');
        $fyrs = ['all' => 'All'];
        foreach ($_fyrs as $key => $value) {
            $fyrs[$key] = $value;
        }

        $report->filterOption([
            'name' => 'fy',
            'label' => 'Commencement FY',
            'data' => $fyrs,
            'selected' => $filter_fy
        ]);
    }

    /**
     * @param $pccb_regions
     * @return array
     */
    public static function districtsForFilter($pccb_regions)
    {
        $_districts = [];
        foreach ($pccb_regions as $key => $value) {
            if ($key == 'all') {
                $_districts[$key] = ['all' => 'All'];
            } else {
                $_districts[$key] = Utils::optionsMap(PccbDistricts::find()->where(['pccb_region_id' => $key])->all(), 'id', 'name');
            }
        }
        return $_districts;
    }

}