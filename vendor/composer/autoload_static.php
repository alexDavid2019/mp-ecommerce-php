<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit3182cd810d1570bd2895fa962cf596df
{
	/*
    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {

        }, null, ClassLoader::class);
    }
	*/
	public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit3182cd810d1570bd2895fa962cf596df::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit3182cd810d1570bd2895fa962cf596df::$prefixDirsPsr4;
			
            $loader->fallbackDirsPsr4 = ComposerStaticInit3182cd810d1570bd2895fa962cf596df::$fallbackDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit3182cd810d1570bd2895fa962cf596df::$prefixesPsr0;
            $loader->fallbackDirsPsr0 = ComposerStaticInit3182cd810d1570bd2895fa962cf596df::$fallbackDirsPsr0;
			
            $loader->classMap = ComposerStaticInit3182cd810d1570bd2895fa962cf596df::$classMap;

        }, null, ClassLoader::class);
    }

	public static $fallbackDirsPsr4 = array (
    );
	public static $prefixesPsr0 = array (
    );
	public static $fallbackDirsPsr0 = array (
    );

    public static $prefixLengthsPsr4 = array (
        'M' => 
			array (
				'MercadoPago\\' => 12,
			)
	);
    public static $prefixDirsPsr4 = array (
        'MercadoPago\\' => 
			array (
				0 => __DIR__ . '/..' . '/mercadopago/dx-php/src/MercadoPago',
				1 => __DIR__ . '/..' . '/mercadopago/dx-php/tests',
				2 => __DIR__ . '/..' . '/mercadopago/dx-php/src/MercadoPago/Entities',
				3 => __DIR__ . '/..' . '/mercadopago/dx-php/src/MercadoPago/Entities/Shared',
			)
	);	
	public static $classMap = array (
        'MercadoPago\\Annotation\\Attribute' => __DIR__ . '/..' . '/mercadopago/dx-php/src/MercadoPago/Annotation/Attribute.php',
        'MercadoPago\\Annotation\\DenyDynamicAttribute' => __DIR__ . '/..' . '/mercadopago/dx-php/src/MercadoPago/Annotation/DenyDynamicAttribute.php',
        'MercadoPago\\Annotation\\RequestParam' => __DIR__ . '/..' . '/mercadopago/dx-php/src/MercadoPago/Annotation/RequestParam.php',
        'MercadoPago\\Annotation\\RestMethod' => __DIR__ . '/..' . '/mercadopago/dx-php/src/MercadoPago/Annotation/RestMethod.php',
        'MercadoPago\\AuthorizedPayment' => __DIR__ . '/..' . '/mercadopago/dx-php/src/MercadoPago/Entities/AuthorizedPayment.php',
        'MercadoPago\\Card' => __DIR__ . '/..' . '/mercadopago/dx-php/src/MercadoPago/Entities/Card.php',
        'MercadoPago\\CardToken' => __DIR__ . '/..' . '/mercadopago/dx-php/src/MercadoPago/Entities/CardToken.php',
        'MercadoPago\\Config' => __DIR__ . '/..' . '/mercadopago/dx-php/src/MercadoPago/Config.php',
        'MercadoPago\\ConfigTest' => __DIR__ . '/..' . '/mercadopago/dx-php/tests/ConfigTest.php',
        'MercadoPago\\Config\\AbstractConfig' => __DIR__ . '/..' . '/mercadopago/dx-php/src/MercadoPago/Config/AbstractConfig.php',
        'MercadoPago\\Config\\Json' => __DIR__ . '/..' . '/mercadopago/dx-php/src/MercadoPago/Config/Json.php',
        'MercadoPago\\Config\\ParserInterface' => __DIR__ . '/..' . '/mercadopago/dx-php/src/MercadoPago/Config/ParserInterface.php',
        'MercadoPago\\Config\\Yaml' => __DIR__ . '/..' . '/mercadopago/dx-php/src/MercadoPago/Config/Yaml.php',
        'MercadoPago\\Customer' => __DIR__ . '/..' . '/mercadopago/dx-php/src/MercadoPago/Entities/Customer.php',
        'MercadoPago\\DummyEntity' => __DIR__ . '/..' . '/mercadopago/dx-php/tests/DummyEntity.php',
        'MercadoPago\\Entity' => __DIR__ . '/..' . '/mercadopago/dx-php/src/MercadoPago/Entity.php',
        'MercadoPago\\EntityTest' => __DIR__ . '/..' . '/mercadopago/dx-php/tests/EntityTest.php',
        'MercadoPago\\FakeApiHub' => __DIR__ . '/..' . '/mercadopago/dx-php/tests/FakeApiHub.php',
        'MercadoPago\\Http\\CurlRequest' => __DIR__ . '/..' . '/mercadopago/dx-php/src/MercadoPago/Http/CurlRequest.php',
        'MercadoPago\\Http\\HttpRequest' => __DIR__ . '/..' . '/mercadopago/dx-php/src/MercadoPago/Http/HttpRequest.php',
        'MercadoPago\\Inovice' => __DIR__ . '/..' . '/mercadopago/dx-php/src/MercadoPago/Entities/Invoices.php',
        'MercadoPago\\Item' => __DIR__ . '/..' . '/mercadopago/dx-php/src/MercadoPago/Entities/Shared/Item.php',
        'MercadoPago\\Manager' => __DIR__ . '/..' . '/mercadopago/dx-php/src/MercadoPago/Manager.php',
        'MercadoPago\\MercadopagoSdkTest' => __DIR__ . '/..' . '/mercadopago/dx-php/tests/MercadoPagoSdkTest.php',
        'MercadoPago\\MerchantOrder' => __DIR__ . '/..' . '/mercadopago/dx-php/src/MercadoPago/Entities/MerchantOrder.php',
        'MercadoPago\\MetaDataReader' => __DIR__ . '/..' . '/mercadopago/dx-php/src/MercadoPago/MetaDataReader.php',
        'MercadoPago\\Payer' => __DIR__ . '/..' . '/mercadopago/dx-php/src/MercadoPago/Entities/Shared/Payer.php',
        'MercadoPago\\Payment' => __DIR__ . '/..' . '/mercadopago/dx-php/src/MercadoPago/Entities/Shared/Payment.php',
        'MercadoPago\\PaymentMethod' => __DIR__ . '/..' . '/mercadopago/dx-php/src/MercadoPago/Entities/Shared/PaymentMethod.php',
        'MercadoPago\\Plan' => __DIR__ . '/..' . '/mercadopago/dx-php/src/MercadoPago/Entities/Plan.php',
        'MercadoPago\\Preapproval' => __DIR__ . '/..' . '/mercadopago/dx-php/src/MercadoPago/Entities/Preapproval.php',
        'MercadoPago\\Preference' => __DIR__ . '/..' . '/mercadopago/dx-php/src/MercadoPago/Entities/Preference.php',
        'MercadoPago\\Refund' => __DIR__ . '/..' . '/mercadopago/dx-php/src/MercadoPago/Entities/Refund.php',
        'MercadoPago\\RestClient' => __DIR__ . '/..' . '/mercadopago/dx-php/src/MercadoPago/RestClient.php',
        'MercadoPago\\RestClientTestextends' => __DIR__ . '/..' . '/mercadopago/dx-php/tests/RestClientTest.php',
        'MercadoPago\\SDK' => __DIR__ . '/..' . '/mercadopago/dx-php/src/MercadoPago/SDK.php',
        'MercadoPago\\Shipments' => __DIR__ . '/..' . '/mercadopago/dx-php/src/MercadoPago/Entities/Shipments.php',
        'MercadoPago\\Subscription' => __DIR__ . '/..' . '/mercadopago/dx-php/src/MercadoPago/Entities/Subscription.php',
        'MercadoPago\\Version' => __DIR__ . '/..' . '/mercadopago/dx-php/src/MercadoPago/Version.php'
	);
}
