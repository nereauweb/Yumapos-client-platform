<?php
/**
 * Price
 *
 * PHP version 5
 *
 * @category Class
 * @package  Swagger\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * Ding API
 *
 * The Ding API is a Level 0 REST web service.  We have used the <a href=\"http://swagger.io\">swagger</a> standard to describe this service. As a result, we are able to provide this interactive documentation page. For further information, you may view the <a href=\"/api/description\">additional documentation</a>; read our <a href=\"/api/faq\">FAQ</a> or contact partnersupport@ding.com
 *
 * OpenAPI spec version: V1
 * 
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 * Swagger Codegen version: 2.4.16
 */

/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace App\Http\Ding\Model;

use \ArrayAccess;
use \App\Http\Ding\ObjectSerializer;

/**
 * Price Class Doc Comment
 *
 * @category Class
 * @package  Swagger\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class Price implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'Price';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'customer_fee' => 'float',
        'distributor_fee' => 'float',
        'receive_value' => 'float',
        'receive_currency_iso' => 'string',
        'receive_value_excluding_tax' => 'float',
        'tax_rate' => 'float',
        'tax_name' => 'string',
        'tax_calculation' => 'string',
        'send_value' => 'float',
        'send_currency_iso' => 'string'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'customer_fee' => 'decimal',
        'distributor_fee' => 'decimal',
        'receive_value' => 'decimal',
        'receive_currency_iso' => null,
        'receive_value_excluding_tax' => 'decimal',
        'tax_rate' => 'decimal',
        'tax_name' => null,
        'tax_calculation' => null,
        'send_value' => 'decimal',
        'send_currency_iso' => null
    ];

    /**
     * Array of property to type mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function swaggerTypes()
    {
        return self::$swaggerTypes;
    }

    /**
     * Array of property to format mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function swaggerFormats()
    {
        return self::$swaggerFormats;
    }

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @var string[]
     */
    protected static $attributeMap = [
        'customer_fee' => 'CustomerFee',
        'distributor_fee' => 'DistributorFee',
        'receive_value' => 'ReceiveValue',
        'receive_currency_iso' => 'ReceiveCurrencyIso',
        'receive_value_excluding_tax' => 'ReceiveValueExcludingTax',
        'tax_rate' => 'TaxRate',
        'tax_name' => 'TaxName',
        'tax_calculation' => 'TaxCalculation',
        'send_value' => 'SendValue',
        'send_currency_iso' => 'SendCurrencyIso'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'customer_fee' => 'setCustomerFee',
        'distributor_fee' => 'setDistributorFee',
        'receive_value' => 'setReceiveValue',
        'receive_currency_iso' => 'setReceiveCurrencyIso',
        'receive_value_excluding_tax' => 'setReceiveValueExcludingTax',
        'tax_rate' => 'setTaxRate',
        'tax_name' => 'setTaxName',
        'tax_calculation' => 'setTaxCalculation',
        'send_value' => 'setSendValue',
        'send_currency_iso' => 'setSendCurrencyIso'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'customer_fee' => 'getCustomerFee',
        'distributor_fee' => 'getDistributorFee',
        'receive_value' => 'getReceiveValue',
        'receive_currency_iso' => 'getReceiveCurrencyIso',
        'receive_value_excluding_tax' => 'getReceiveValueExcludingTax',
        'tax_rate' => 'getTaxRate',
        'tax_name' => 'getTaxName',
        'tax_calculation' => 'getTaxCalculation',
        'send_value' => 'getSendValue',
        'send_currency_iso' => 'getSendCurrencyIso'
    ];

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @return array
     */
    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @return array
     */
    public static function setters()
    {
        return self::$setters;
    }

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @return array
     */
    public static function getters()
    {
        return self::$getters;
    }

    /**
     * The original name of the model.
     *
     * @return string
     */
    public function getModelName()
    {
        return self::$swaggerModelName;
    }

    

    

    /**
     * Associative array for storing property values
     *
     * @var mixed[]
     */
    protected $container = [];

    /**
     * Constructor
     *
     * @param mixed[] $data Associated array of property values
     *                      initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->container['customer_fee'] = isset($data['customer_fee']) ? $data['customer_fee'] : null;
        $this->container['distributor_fee'] = isset($data['distributor_fee']) ? $data['distributor_fee'] : null;
        $this->container['receive_value'] = isset($data['receive_value']) ? $data['receive_value'] : null;
        $this->container['receive_currency_iso'] = isset($data['receive_currency_iso']) ? $data['receive_currency_iso'] : null;
        $this->container['receive_value_excluding_tax'] = isset($data['receive_value_excluding_tax']) ? $data['receive_value_excluding_tax'] : null;
        $this->container['tax_rate'] = isset($data['tax_rate']) ? $data['tax_rate'] : null;
        $this->container['tax_name'] = isset($data['tax_name']) ? $data['tax_name'] : null;
        $this->container['tax_calculation'] = isset($data['tax_calculation']) ? $data['tax_calculation'] : null;
        $this->container['send_value'] = isset($data['send_value']) ? $data['send_value'] : null;
        $this->container['send_currency_iso'] = isset($data['send_currency_iso']) ? $data['send_currency_iso'] : null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        if ($this->container['customer_fee'] === null) {
            $invalidProperties[] = "'customer_fee' can't be null";
        }
        if ($this->container['distributor_fee'] === null) {
            $invalidProperties[] = "'distributor_fee' can't be null";
        }
        if ($this->container['receive_value'] === null) {
            $invalidProperties[] = "'receive_value' can't be null";
        }
        if ($this->container['receive_currency_iso'] === null) {
            $invalidProperties[] = "'receive_currency_iso' can't be null";
        }
        if ($this->container['receive_value_excluding_tax'] === null) {
            $invalidProperties[] = "'receive_value_excluding_tax' can't be null";
        }
        if ($this->container['send_value'] === null) {
            $invalidProperties[] = "'send_value' can't be null";
        }
        if ($this->container['send_currency_iso'] === null) {
            $invalidProperties[] = "'send_currency_iso' can't be null";
        }
        return $invalidProperties;
    }

    /**
     * Validate all the properties in the model
     * return true if all passed
     *
     * @return bool True if all properties are valid
     */
    public function valid()
    {
        return count($this->listInvalidProperties()) === 0;
    }


    /**
     * Gets customer_fee
     *
     * @return float
     */
    public function getCustomerFee()
    {
        return $this->container['customer_fee'];
    }

    /**
     * Sets customer_fee
     *
     * @param float $customer_fee The fee that the distributor has asked us to collect from the customer
     *
     * @return $this
     */
    public function setCustomerFee($customer_fee)
    {
        $this->container['customer_fee'] = $customer_fee;

        return $this;
    }

    /**
     * Gets distributor_fee
     *
     * @return float
     */
    public function getDistributorFee()
    {
        return $this->container['distributor_fee'];
    }

    /**
     * Sets distributor_fee
     *
     * @param float $distributor_fee The fee that Ding charges the distributor to fulfil the transfer
     *
     * @return $this
     */
    public function setDistributorFee($distributor_fee)
    {
        $this->container['distributor_fee'] = $distributor_fee;

        return $this;
    }

    /**
     * Gets receive_value
     *
     * @return float
     */
    public function getReceiveValue()
    {
        return $this->container['receive_value'];
    }

    /**
     * Sets receive_value
     *
     * @param float $receive_value The estimated value that will be received by the target account, including any tax (if applicable).
     *
     * @return $this
     */
    public function setReceiveValue($receive_value)
    {
        $this->container['receive_value'] = $receive_value;

        return $this;
    }

    /**
     * Gets receive_currency_iso
     *
     * @return string
     */
    public function getReceiveCurrencyIso()
    {
        return $this->container['receive_currency_iso'];
    }

    /**
     * Sets receive_currency_iso
     *
     * @param string $receive_currency_iso The currency of the ReceiveValue and ReceiveValueExcludingTax fields
     *
     * @return $this
     */
    public function setReceiveCurrencyIso($receive_currency_iso)
    {
        $this->container['receive_currency_iso'] = $receive_currency_iso;

        return $this;
    }

    /**
     * Gets receive_value_excluding_tax
     *
     * @return float
     */
    public function getReceiveValueExcludingTax()
    {
        return $this->container['receive_value_excluding_tax'];
    }

    /**
     * Sets receive_value_excluding_tax
     *
     * @param float $receive_value_excluding_tax The estimated amount received into the account before Tax was added
     *
     * @return $this
     */
    public function setReceiveValueExcludingTax($receive_value_excluding_tax)
    {
        $this->container['receive_value_excluding_tax'] = $receive_value_excluding_tax;

        return $this;
    }

    /**
     * Gets tax_rate
     *
     * @return float
     */
    public function getTaxRate()
    {
        return $this->container['tax_rate'];
    }

    /**
     * Sets tax_rate
     *
     * @param float $tax_rate The tax rate that was applied
     *
     * @return $this
     */
    public function setTaxRate($tax_rate)
    {
        $this->container['tax_rate'] = $tax_rate;

        return $this;
    }

    /**
     * Gets tax_name
     *
     * @return string
     */
    public function getTaxName()
    {
        return $this->container['tax_name'];
    }

    /**
     * Sets tax_name
     *
     * @param string $tax_name The name of the tax applicable to this product
     *
     * @return $this
     */
    public function setTaxName($tax_name)
    {
        $this->container['tax_name'] = $tax_name;

        return $this;
    }

    /**
     * Gets tax_calculation
     *
     * @return string
     */
    public function getTaxCalculation()
    {
        return $this->container['tax_calculation'];
    }

    /**
     * Sets tax_calculation
     *
     * @param string $tax_calculation The type of calculation that was done (can vary by country)
     *
     * @return $this
     */
    public function setTaxCalculation($tax_calculation)
    {
        $this->container['tax_calculation'] = $tax_calculation;

        return $this;
    }

    /**
     * Gets send_value
     *
     * @return float
     */
    public function getSendValue()
    {
        return $this->container['send_value'];
    }

    /**
     * Sets send_value
     *
     * @param float $send_value The value that is submitted to SendTransfer
     *
     * @return $this
     */
    public function setSendValue($send_value)
    {
        $this->container['send_value'] = $send_value;

        return $this;
    }

    /**
     * Gets send_currency_iso
     *
     * @return string
     */
    public function getSendCurrencyIso()
    {
        return $this->container['send_currency_iso'];
    }

    /**
     * Sets send_currency_iso
     *
     * @param string $send_currency_iso The currency of the SendValue field
     *
     * @return $this
     */
    public function setSendCurrencyIso($send_currency_iso)
    {
        $this->container['send_currency_iso'] = $send_currency_iso;

        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     *
     * @param integer $offset Offset
     *
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     *
     * @param integer $offset Offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    /**
     * Sets value based on offset.
     *
     * @param integer $offset Offset
     * @param mixed   $value  Value to be set
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     *
     * @param integer $offset Offset
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    /**
     * Gets the string presentation of the object
     *
     * @return string
     */
    public function __toString()
    {
        if (defined('JSON_PRETTY_PRINT')) { // use JSON pretty print
            return json_encode(
                ObjectSerializer::sanitizeForSerialization($this),
                JSON_PRETTY_PRINT
            );
        }

        return json_encode(ObjectSerializer::sanitizeForSerialization($this));
    }
}


