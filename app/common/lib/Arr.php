<?php
    namespace app\common\lib;
    class Arr{
        /**
         * 分类树
         * 支持无限级分类
         * @param $data
         */
        public static function getTree($data){
            $items = array();
            foreach ($data as $v){
                $items[$v['category_id']] = $v;
            }
            $tree = [];

            foreach($items as $key=>$value){
                //判断$items下面是否存在pid
                if(isset($items[$value['pid']])){
                    $items[$value['pid']]['list'][] = &$items[$key];
                }else{
                    $tree[] = &$items[$key];
                }
            }
            return $tree;
        }

        public static function sliceTreeArr($data, $firstCount = 5,$secondCount = 3,$threeCount = 5){
            $data = array_slice($data, 0, $firstCount);
            foreach ($data as $k=>$v) {
                if(!empty($v['list'])){
                    $data[$v['list']] = array_slice($v['list'], 0, $secondCount);
                    foreach($v['list'] as $kk=>$vv){
                        if(!empty($vv['list'])){
                            $data[$k]['list'][$kk]['list'] = array_slice($vv['list'], 0, $threeCount);
                        }
                    }
                }
            }
        }

        //分页没有数据就来这
        public static function pagingNo(){
            return $resultList = [
                "total" => 0,
                "per_page" => 5,
                "current_page" => 1,
                "last_page" => 1,
                "data" => []
            ];
        }
    }
