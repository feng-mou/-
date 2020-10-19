<?php
    //强类型
    declare (strict_types = 1);
    namespace app\common\lib\sms;
    use AlibabaCloud\Client\AlibabaCloud;
    use AlibabaCloud\Client\Exception\ClientException;
    use AlibabaCloud\Client\Exception\ServerException;
    class AliSms
    {
        /**
         * @param string $phone 手机号
         * @param int $code 验证码
         * @return bool 返回类型
         * @throws ClientException
         */
        public function aliSms(string $phone,int  $code) :bool
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
            } catch (ClientException $e) {
                return false;
                //echo $e->getErrorMessage() . PHP_EOL;
            } catch (ServerException $e) {
                return false;
                //echo $e->getErrorMessage() . PHP_EOL;
            }
            return true;
        }
    }
