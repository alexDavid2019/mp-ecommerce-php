<?php

class MPRestCli
{
    const PRODUCT_ID = 'BC32CCRU643001OI39AG';
    const PLATFORM_ID = 'BR8GRBKHPKU001JJH7F0';
    const MERCADOPAGO_INTEGRATOR_ID = 'dev_24c65fb163bf11ea96500242ac130004';
    const MERCADOPAGO_EXTERNAL_REFERENCE = 'alejandro.pariz@101si.com.ar';
    
    const API_BASE_URL = 'https://api.mercadopago.com';
    const API_BASE_MELI_URL = 'https://api.mercadolibre.com';
    
    //const MERCADOPAGO_ACCESS_TOKEN = 'APP_USR-6718728269189792-112017-dc8b338195215145a4ec035fdde5cedf-491494389';
    //const MERCADOPAGO_PUBLIC_KEY = 'APP_USR-5b9a3e27-3852-407d-8f49-e08bd5990007';
    //const MERCADOPAGO_CURRENCY = 'MXN';
    
    const MERCADOPAGO_PUBLIC_KEY = 'TEST-671a363d-1f52-431f-8d99-72708c6e40ba';
    const MERCADOPAGO_ACCESS_TOKEN = 'TEST-4692648458185345-061423-4a7bfc4da4e80efefe99ddb87d85e918-584639858';
    //const MERCADOPAGO_PUBLIC_KEY = 'APP_USR-7ce65aab-7924-4c6b-95f2-c7c5ffd17b96';
    //const MERCADOPAGO_ACCESS_TOKEN = 'APP_USR-4692648458185345-061423-4bf17e40b723efd7041c03282b932550-584639858';
    const MERCADOPAGO_CURRENCY = 'ARS';
    
    const MERCADOPAGO_INSTALLMENTS = 6; //cantidad maxima de cuotas
    
    public function __construct()
    {
    }

    public static function getCurrentCurrency()
    {
        return self::MERCADOPAGO_CURRENCY;
    }
    
    public static function getAccessToken()
    {
        return self::MERCADOPAGO_ACCESS_TOKEN;
    }
    public static function getPublicKey()
    {
        return self::MERCADOPAGO_PUBLIC_KEY;
    }
    public static function getInstallmentsDefault()
    {
        return self::MERCADOPAGO_INSTALLMENTS;
    }
    public static function getExternalReferenceDefault()
    {
        return self::MERCADOPAGO_EXTERNAL_REFERENCE;
    }
    
    /**
     * Get connect with cURL
     *
     * @param $uri
     * @param $method
     * @param $content_type
     * @param $uri_base
     * @return false|resource
     */
    private static function getConnect($uri, $method, $content_type, $uri_base)
    {
        $connect = curl_init($uri_base . $uri);
        $product_id = ($method == 'POST') ? "x-product-id: " . self::PRODUCT_ID : "";

        curl_setopt($connect, CURLOPT_USERAGENT, 'MercadoPago v'.MP_VERSION);
        curl_setopt($connect, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($connect, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt(
            $connect,
            CURLOPT_HTTPHEADER,
            array(
                $product_id,
                'Accept: application/json',
                'Content-Type: ' . $content_type,
                'x-platform-id:' . self::PLATFORM_ID,
                'x-integrator-id:' . self::MERCADOPAGO_INTEGRATOR_ID
            )
        );

        return $connect;
    }

    /**
     * Get tracking connect with cURL
     *
     * @param $uri
     * @param $method
     * @param $content_type
     * @param $trackingID
     * @return false|resource
     */
    private static function getConnectTracking($uri, $method, $content_type, $trackingID)
    {
        $connect = curl_init(self::API_BASE_URL . $uri);
        $product_id = ($method == 'POST') ? "x-product-id: " . self::PRODUCT_ID : "";

        curl_setopt($connect, CURLOPT_USERAGENT, 'MercadoPago v'.MP_VERSION);
        curl_setopt($connect, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($connect, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt(
            $connect,
            CURLOPT_HTTPHEADER,
            array(
                $product_id,
                'Accept: application/json',
                'Content-Type: ' . $content_type,
                'X-tracking-id:' . $trackingID,
                'x-platform-id:' . self::PLATFORM_ID,
                'x-integrator-id:' . self::MERCADOPAGO_INTEGRATOR_ID
            )
        );
 
        return $connect;
    }

    /**
     * execTracking
     *
     * @param $method
     * @param $uri
     * @param $data
     * @param $content_type
     * @param $trackingID
     * @return array
     * @throws Exception
     */
    private static function execTracking($method, $uri, $data, $content_type, $trackingID)
    {
        $connect = self::getConnectTracking($uri, $method, $content_type, $trackingID);

        if ($data) {
            self::setData($connect, $data, $content_type);
        }

        $api_result = curl_exec($connect);
        $api_http_code = curl_getinfo($connect, CURLINFO_HTTP_CODE);
        $response = array(
            'status' => $api_http_code,
            'response' => json_decode($api_result, true),
        );

        curl_close($connect);

        return $response;
    }

    /**
     * setData
     *
     * @param $connect
     * @param $data
     * @param $content_type
     * @return void
     * @throws Exception
     */
    private static function setData($connect, $data, $content_type)
    {
        if ($content_type == 'application/json') {
            if (gettype($data) == 'string') {
                json_decode($data, true);
            } else {
                $data = json_encode($data);
            }

            if (function_exists('json_last_error')) {
                $json_error = json_last_error();
                if ($json_error != JSON_ERROR_NONE) {
                    throw new Exception("JSON Error [{$json_error}] - Data: {$data}");
                }
            }
        }
        curl_setopt($connect, CURLOPT_POSTFIELDS, $data);
    }

    /**
     * exec
     *
     * @param $method
     * @param $uri
     * @param $data
     * @param $content_type
     * @param $uri_base
     * @return array
     * @throws Exception
     */
    private static function exec($method, $uri, $data, $content_type, $uri_base)
    {
        $connect = self::getConnect($uri, $method, $content_type, $uri_base);

        if ($data) {
            self::setData($connect, $data, $content_type);
        }

        $api_result = curl_exec($connect);
        $api_http_code = curl_getinfo($connect, CURLINFO_HTTP_CODE);
        $response = array(
            'status' => $api_http_code,
            'response' => json_decode($api_result, true),
        );

        curl_close($connect);

        return $response;
    }

    /**
     * get mercado libre api
     *
     * @param string $uri
     * @param string $content_type
     * @return array
     * @throws Exception
     */
    public static function getMercadoLibre($uri, $content_type = 'application/json')
    {
        return self::exec('GET', $uri, null, $content_type, self::API_BASE_MELI_URL);
    }

    /**
     * get
     *
     * @param string $uri
     * @param string $content_type
     * @return array
     * @throws Exception
     */
    public static function get($uri, $content_type = 'application/json')
    {
        return self::exec('GET', $uri, null, $content_type, self::API_BASE_URL);
    }

    /**
     * post
     *
     * @param string $uri
     * @param string $data
     * @param string $content_type
     * @return array
     * @throws Exception
     */
    public static function post($uri, $data, $content_type = 'application/json')
    {
        return self::exec('POST', $uri, $data, $content_type, self::API_BASE_URL);
    }

    /**
     * postTracking
     *
     * @param string $uri
     * @param string $data
     * @param string $trackingID
     * @param string $content_type
     * @return array
     * @throws Exception
     */
    public static function postTracking($uri, $data, $trackingID, $content_type = 'application/json')
    {
        return self::execTracking('POST', $uri, $data, $content_type, $trackingID);
    }

    /**
     * put
     *
     * @param string $uri
     * @param string $data
     * @param string $content_type
     * @return array
     * @throws Exception
     */
    public static function put($uri, $data, $content_type = 'application/json')
    {
        return self::exec('PUT', $uri, $data, $content_type, self::API_BASE_URL);
    }
}
