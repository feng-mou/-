<?php
//强类型
declare (strict_types=1);
    namespace app\api\controller;
    use app\common\lib\Num;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;

class Test
{
    /**
     * @param string $phone 手机号
     * @param int $code 验证码
     * @return bool 返回类型
     * @throws ClientException
     */
    public function test(){
        $res=$this->aliSms('19974233942',99999);
        var_dump($res);
    }
    public function aliSms(string $phone,int  $code) :bool
    {
        if (empty($phone) || empty($code)) {
            return false;
        }
        AlibabaCloud::accessKeyClient("LTAI4GAT2bp8K7KatXUyucuK","25vQeT3SprTvGsP357u5W9EuzgV3zD")
            ->regionId('cn-hangzhou')
            ->asDefaultClient();

        $Verification_code = [
            'code' => $code
        ];
        try {
            $result = AlibabaCloud::rpc()
                ->product('Dysmsapi')
                // ->scheme('https') // https | http
                ->version('2017-05-25')
                ->action('SendSms')
                ->method('POST')
                ->host('dysmsapi.aliyuncs.com')
                ->options([
                    'query' => [
                        'RegionId' => "cn-hangzhou",
                        'PhoneNumbers' => "$phone",
                        'SignName' => "高并发商城项目练习",
                        'TemplateCode' => "SMS_204460951",
                        'TemplateParam' => json_encode($Verification_code),
                    ],
                ])
                ->request();
            //print_r($result->toArray());
        } catch (ClientException $e) {
            return false;
            //echo $e->getErrorMessage() . PHP_EOL;
        } catch (ServerException $e) {
            return false;
            //echo $e->getErrorMessage() . PHP_EOL;
        }
        return true;
    }

    //测试redis
    public function cpdd(){
        Cache('abc', 5, 60);
       // cache('abc',5);
        var_dump(extension_loaded('redis'));
    }

    //测试随机数
    public function ran(){
        $acg = Num::getCode(6);;
        var_dump($acg);
    }
}
