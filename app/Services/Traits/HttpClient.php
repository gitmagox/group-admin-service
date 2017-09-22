<?php
/**
 * http助手函数
 */
namespace App\Services\Traits;

trait HttpClient
{
    public $baseUrl;
    public $method = ['GET','POST','PUT','DELETE'];
    public function http($method, $request_data, $api_url )
    {
        ksort($request_data);


        $sign = md5(md5(implode('&', $request_data)."&".env('API_SECRET')));

        if( !in_array($method,$this->method) )
        {
            return false;
        }
        $client = new \GuzzleHttp\Client(['base_uri' => $this->baseUrl]);
        switch ($method)
        {
            case 'GET':
                $query_key='query';
                break;
            case 'POST':
                $query_key='form_params';
                break;
            case 'PUT':
                $query_key='form_params';
                break;
            case 'DELETE':
                $query_key='form_params';
                break;
        }

        $response = $client->request($method, $api_url, [
                $query_key => $request_data,
                'headers'  =>[
                    //自定义头
                ]
            ]
        );

        $result = json_decode($response->getBody()->getContents(), true);

        if( in_array('error',array_keys($result)) )
        {
            return response()->json(['error' => $result['error']]);
        }else{
            return $result['success'];
        }
    }
}
