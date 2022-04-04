<?php


namespace App\Implementers\Amap;

use Abnermouke\EasyBuilder\Library\CodeLibrary;
use App\Handler\Cache\Data\Abnermouke\Console\ConfigCacheHandler;
use App\Model\Abnermouke\Console\AmapAreas;
use App\Repository\Abnermouke\Console\AmapAreaRepository;
use GuzzleHttp\Client;
use Illuminate\Support\Arr;

/**
 * 高德地图行政地区执行类
 * Class AmapAreaImplementers
 * @package App\Implementers\Amap
 */
class AmapAreaImplementers
{

    //请求种子链接
    private static $seed_link = 'https://restapi.amap.com/v3/config/district';

    //地区级别
    private static $level = [
        'country' => AmapAreas::TYPE_OF_COUNTRY,
        'province' => AmapAreas::TYPE_OF_PROVINCE,
        'city' => AmapAreas::TYPE_OF_CITY,
        'district' => AmapAreas::TYPE_OF_DISTRICT,
        'street' => AmapAreas::TYPE_OF_STREET,
    ];

    //地区数据
    private static $areas = [
        //国家
        'country' => [
            [
                'type' => AmapAreas::TYPE_OF_COUNTRY,
                'code' => 100000,
                'guard_name' => '中华人民共和国',
                'parent_ad_code' => 0,
                'coordinate' => ['116.3683244', '39.915085']
            ],
        ],
        //省份
        'province' => [],
        //城市
        'city' => [],
        //区县
        'district' => [],
        //街道
        'street' => [],
    ];

    /**
     * 执行更新
     * @Author Abnermouke <abnermouke@gmail.com>
     * @Originate in Abnermouke's MBP
     * @Time 2021-09-07 11:39:24
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Exception
     */
    public static function run()
    {
        //查询行政地区
        if (!self::query()) {
            //返回失败
            return false;
        }
        //循环地址信息
        foreach (self::$areas as $level => $areas) {
            //循环地区信息
            foreach ($areas as $k => $area) {
                //查询父级地区
                $parent_id = 0;
                //判断父级行政地区编码
                if ((int)$area['parent_ad_code'] > 0) {
                    //设置默认查询层级
                    $type = (int)$area['type'] - 1;
                    //判断是否为街道
                    if ((int)$area['type'] === AmapAreas::TYPE_OF_STREET) {
                        //设置查询市
                        $type = AmapAreas::TYPE_OF_CITY;
                    }
                    //获取前两位编码
                    $prefix_area_code = (int)substr($area['code'], 0, 2);
                    //判断行政区域编码是否为81（香港）、82（澳门）开头
                    if (in_array($prefix_area_code, [81, 82]) && !in_array($area['code'], [810000, 820000])) {
                        //查询父级ID
                        $parent_id = (int)(new AmapAreaRepository())->find(['type' => AmapAreas::TYPE_OF_PROVINCE, 'code' => $prefix_area_code.'0000'], 'id');
                    } else {
                        //查询父级ID
                        $parent_id = (int)(new AmapAreaRepository())->find(['type' => (int)$type, 'code' => (int)$area['parent_ad_code']], 'id');
                    }
                }
                //整理信息
                $area = Arr::except(array_merge($area, ['parent_id' => (int)$parent_id, 'created_at' => auto_datetime(), 'updated_at' => auto_datetime()]), 'parent_ad_code');
                //整理查询条件
                $condition = Arr::only($area, ['type', 'code', 'parent_id']);
                //判断是否为不设市辖区的地级市街道
                if ((int)$area['type'] === AmapAreas::TYPE_OF_STREET) {
                    //更改code
                    $condition = Arr::only($area, ['type', 'guard_name', 'parent_id']);
                }
                //查询是否存在
                if ((new AmapAreaRepository())->doesntExists($condition)) {
                    //创建信息
                    (new AmapAreaRepository())->insertGetId($area);
                } else {
                    //更新信息
                    (new AmapAreaRepository())->update($condition, Arr::only($area, ['type', 'code', 'guard_name', 'parent_id', 'updated_at']));
                }
                //释放内存
                unset($areas[$k]);
            }
            //释放内存
            unset(self::$areas[$level]);
        }
        //返回成功
        return true;
    }

    /**
     * 生成唯一地区编码
     * @Author Abnermouke <abnermouke@outlook.com>
     * @Originate in Abnermouke's MBP
     * @Time 2022-04-02 16:34:59
     * @param $prefix
     * @param int $length
     * @return string
     * @throws \Exception
     */
    private static function uniqueAreaCode($prefix, $length = 3)
    {
        //生成编码
        $code = $prefix.getRandChar($length, true);
        //判断是否存在
        if ((new AmapAreaRepository())->exists(['code' => $code])) {
            //重新生成
            return self::uniqueAreaCode($prefix, $length);
        }
        //返回编码
        return $code;
    }

    /**
     * 查询地区信息
     * @Author Abnermouke <abnermouke@gmail.com>
     * @Originate in Abnermouke's MBP
     * @Time 2021-09-07 11:37:41
     * @param int $ad_code
     * @return false|int|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private static function query($ad_code = 0)
    {
        //整理参数
        $params = [
            'keywords' => (int)$ad_code === 0 ? '' : (int)$ad_code,
            'key' => (new ConfigCacheHandler())->get('AMAP_WEB_SERVER_API_KEY', config('project.amap_web_server_api_key')),
            'subdistrict' => 1,
        ];
        //整理请求链接
        $query_link = self::$seed_link.(!empty($params) ? '?'.http_build_query($params) : '');
        //尝试发起请求
        try {
            //发起请求
            $response = (new Client())->get($query_link);
        } catch (\Exception $exception) {
            //返回失败
            return false;
        }
        //获取状态
        if ((int)$response->getStatusCode() !== CodeLibrary::CODE_SUCCESS) {
            //返回失败
            return false;
        }
        //获取结果集
        $results = $response->getBody()->getContents();
        //构建地址信息
        return self::buildArea(data_get(json_decode($results, true), 'districts.0.districts', []), ((int)$ad_code === 0 ? 100000 : (int)$ad_code));
    }

    /**
     * 构建数据
     * @Author Abnermouke <abnermouke@gmail.com>
     * @Originate in Abnermouke's MBP
     * @Time 2021-09-03 15:22:14
     * @param $areas
     * @param int $parent_ad_code
     * @return int|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private static function buildArea($areas, $parent_ad_code = 0)
    {
        //判断地区信息
        if ($areas) {
            //循环获取下级地区
            foreach ($areas as $k => $area) {
                //整理信息
                self::$areas[$area['level']][] = [
                    'type' => (int)self::$level[$area['level']],
                    'code' => (int)$area['adcode'],
                    'guard_name' => $area['name'],
                    'parent_ad_code' => (int)$parent_ad_code,
                    'coordinate' => explode(',', $area['center'])
                ];
                //判断当前是否为街道
                if ($area['level'] !== 'district' && $area['level'] !== 'street') {
                    //获取下级
                    self::query($area['adcode']);
                }
            }
        }
        //返回成功
        return $parent_ad_code;
    }

}
