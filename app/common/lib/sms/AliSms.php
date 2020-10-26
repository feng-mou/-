<?php
    //强类型
    declare (strict_types = 1);
    namespace app\common\lib\sms;
    use AlibabaCloud\Client\AlibabaCloud;
    use AlibabaCloud\Client\Exception\ClientException;
    use AlibabaCloud\Client\Exception\ServerException;
    use think\facade\Log;

    class AliSms
    {
        /**
         * @param string $phone 手机号
         * @param int $code 验证码
         * @return bool 返回类型
         * @throws ClientException
         */
        public static function sendCode(string $phone,int  $code) :bool
        {
            if(empty($phone) || empty($code)) {
                return false;
            }
            AlibabaCloud::accessKeyClient(config('aliyun.accessKeyId'),config('aliyun.accessSecret'))
                ->regionId("cn-hangzhou")
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
                            'PhoneNumbers' => $phone,
                            'SignName' => "高并发商城项目练习",
                            'TemplateCode' => "SMS_204460951",
                            'TemplateParam' => json_encode($Verification_code),
                        ],
                    ])
                    ->request();
                //print_r($result->toArray());
                //info信息,error错误信息
                //成功日志
                Log::info("AliSms_aliSms_{$phone}result".json_encode($result->toArray()));
            } catch (ClientException $e) {
                //错误日志
                Log::error('AliSms_aliSms_ClientException'.$e->getErrorMessage());
                return false;
                //echo $e->getErrorMessage() . PHP_EOL;
            } catch (ServerException $e) {
                //错误日志
                Log::error('AliSms_aliSms_ServerException'.$e->getErrorMessage());
                return false;
                //echo $e->getErrorMessage() . PHP_EOL;
            }
            //判断是否成功
            if(isset($result['Code']) && $result['Code']=="OK")
            {
                return true;
            }
            return false;
        }
    }
