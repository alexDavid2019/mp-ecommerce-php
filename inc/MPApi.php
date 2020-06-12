
<?php include 'inc/MPRestCli.php'; ?>

<?php

class MPApi
{
    public function __construct()
    {
    }

    /**
     * Instance the class
     *
     * @return MPApi
     */
    public static function getinstance()
    {
        static $mercadopago = null;
        if (null === $mercadopago) {
            $mercadopago = new MPApi();
        }
        return $mercadopago;
    }

    public function getInstallmentsDefault()
    {
        return MPRestCli::getInstallmentsDefault();
    }
    
    /**
     * Get access token
     *
     * @return string
     */
    public function getAccessToken()
    {
        return MPRestCli::getAccessToken();
    }
    
    /**
     * Get public key
     *
     * @return string
     */
    public function getPublicKey()
    {
        return MPRestCli::getPublicKey();
    }
    
    /**
     * Get payment methods
     *
     * @return array|bool
     * @throws Exception
     */
    public function getPaymentMethods()
    {
        $access_token = $this->getAccessToken();
        $response = MPRestCli::get('/v1/payment_methods?access_token=' . $access_token);

        //in case of failures
        if ($response['status'] > 202) {
            echo "API get_payment_methods error: " . $response['response']['message'];
            return false;
        }

        //response treatment
        $result = $response['response'];
        asort($result);

        $payments = array();
        foreach ($result as $value) {
            // remove on paypay release
            if ($value['id'] == 'paypal') {
                continue;
            }
            
            $payments[] = array(
                'id' => $value['id'],
                'name' => $value['name'],
                'type' => $value['payment_type_id'],
                'image' => $value['secure_thumbnail'],
                'config' => 'MERCADOPAGO_PAYMENT_' . $value['id'],
                'financial_institutions' => $value['financial_institutions'],
            );
        }

        return $payments;
    }

    /**
     * Create preference
     *
     * @param $preference
     * @return bool
     * @throws Exception
     */
    public function createPreference($preference)
    {
        $access_token = $this->getAccessToken();
        $tracking_id = "platform:desktop,so:1.0.0";
        $response = MPRestCli::postTracking('/checkout/preferences?access_token=' . $access_token,
                                                $preference,
                                                $tracking_id
                                            );

        //in case of failures
        if ($response['status'] > 202) {
            echo "API create_preferences error: " . $response['response']['message'];
            return false;
        }

        //response treatment
        $result = $response['response'];
        return $result;
    }

    /**
     * Create payment
     *
     * @param array $preference
     * @return bool
     * @throws Exception
     */
    public function createPayment($preference)
    {
        $access_token = $this->getAccessToken();
        $tracking_id = "platform:desktop,so:1.0.0";
        $response = MPRestCli::postTracking('/v1/payments?access_token=' . $access_token,
                                                $preference,
                                                $tracking_id
                                            );

        //in case of failures
        if ($response['status'] > 202) {
            echo "API create_custom_payment error: " . $response['response']['message'];
            return $response['response']['message'];
        }

        //response treatment
        $result = $response['response'];
        return $result;
    }

    /**
     * Get standard payment
     *
     * @param integer $transaction_id
     * @return bool
     * @throws Exception
     */
    public function getPaymentStandard($transaction_id)
    {
        $access_token = $this->getAccessToken();
        $response = MPRestCli::get('/v1/payments/' . $transaction_id . '?access_token=' . $access_token);

        //in case of failures
        if ($response['status'] > 202) {
            echo "API get_payment_standard error: " . $response['response']['message'];
            return false;
        }

        //response treatment
        $result = $response['response'];
        return $result;
    }

    public function getPreferenciesById($id)
    {
        $access_token = $this->getAccessToken();
        $response = MPRestCli::get('/checkout/preferences/' . $id . '?access_token=' . $access_token);
        
        //in case of failures
        if ($response['status'] > 202) {
            echo "API get_payment_standard error: " . $response['response']['message'];
            return false;
        }
        
        //response treatment
        $result = $response['response'];
        return $result;
    }

    public function searchPreferencies($collector_id)
    {
        $access_token = $this->getAccessToken();
        $response = MPRestCli::get('/checkout/preferences/search?access_token=' . $access_token ."&collector_id=".$collector_id);
        
        //in case of failures
        if ($response['status'] > 202) {
            echo "API get_payment_standard error: " . $response['response']['message'];
            return false;
        }
        
        //response treatment
        $result = $response['response'];
        return $result;
    }
    
    /**
     * Is valid access token
     *
     * @param [string] $access_token
     * @return boolean
     * @throws Exception
     */
    public function isValidAccessToken($access_token)
    {
        $response = MPRestCli::get('/users/me?access_token=' . $access_token);

        //in case of failures
        if ($response['status'] > 202) {
            echo "API valid_access_token error: " . $response['response']['message'];
            return false;
        }

        //response treatment
        $result = $response['response'];
        return $result;
    }

    /**
     * Is test user
     *
     * @return boolean
     * @throws Exception
     */
    public function isTestUser()
    {
        $access_token = $this->getAccessToken();
        $response = MPRestCli::get('/users/me?access_token=' . $access_token);

        //in case of failures
        if ($response['status'] > 202) {
            echo "API is_test_user error: " . $response['response']['message'];
            return false;
        }

        //response treatment
        if (in_array('test_user', $response['response']['tags'])) {
            return true;
        }
    }

    /**
     * Get merchant order
     *
     * @param [integer] $id
     * @return bool
     * @throws Exception
     */
    public function getMerchantOrder($id)
    {
        $access_token = $this->getAccessToken();
        $response = MPRestCli::get('/merchant_orders/' . $id . '?access_token=' . $access_token);

        //in case of failures
        if ($response['status'] > 202) {
            echo "API get_merchant_orders error: " . $response['response']['message'];
            return false;
        }

        //response treatment
        $result = $response['response'];
        return $result;
    }

    /**
     * Get application_id
     *
     * @param [integer] $seller
     * @return int
     */
    public function getApplicationId()
    {
        $seller = explode('-', $this->getAccessToken());
        return $seller[1];
    }

    /**
     * Get application_id
     *
     * @return bool
     * @throws Exception
     */
    public function homologValidate()
    {
        $seller = $this->getApplicationId();
        $response = MPRestCli::getMercadoLibre('/applications/' . $seller);

        //in case of failures
        if ($response['status'] > 202) {
            echo "API application_search_owner_id error: " . $response['response']['message'];
            return false;
        }

        //response treatment
        $result = $response['response'];

        return $result['scopes'];
    }
}
