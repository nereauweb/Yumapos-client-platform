<?php
/**
 * Country
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
 * Country Class Doc Comment
 *
 * @category Class
 * @package  Swagger\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class Country implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'Country';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'country_iso' => 'string',
        'country_name' => 'string',
        'international_dialing_information' => '\App\Http\Ding\Model\InternationalDialingInfo[]',
        'region_codes' => 'string[]'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'country_iso' => null,
        'country_name' => null,
        'international_dialing_information' => null,
        'region_codes' => null
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
        'country_iso' => 'CountryIso',
        'country_name' => 'CountryName',
        'international_dialing_information' => 'InternationalDialingInformation',
        'region_codes' => 'RegionCodes'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'country_iso' => 'setCountryIso',
        'country_name' => 'setCountryName',
        'international_dialing_information' => 'setInternationalDialingInformation',
        'region_codes' => 'setRegionCodes'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'country_iso' => 'getCountryIso',
        'country_name' => 'getCountryName',
        'international_dialing_information' => 'getInternationalDialingInformation',
        'region_codes' => 'getRegionCodes'
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
        $this->container['country_iso'] = isset($data['country_iso']) ? $data['country_iso'] : null;
        $this->container['country_name'] = isset($data['country_name']) ? $data['country_name'] : null;
        $this->container['international_dialing_information'] = isset($data['international_dialing_information']) ? $data['international_dialing_information'] : null;
        $this->container['region_codes'] = isset($data['region_codes']) ? $data['region_codes'] : null;
    }
	
	public function getData(){
		return $this->container;
	}

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        if ($this->container['country_iso'] === null) {
            $invalidProperties[] = "'country_iso' can't be null";
        }
        if ($this->container['country_name'] === null) {
            $invalidProperties[] = "'country_name' can't be null";
        }
        if ($this->container['international_dialing_information'] === null) {
            $invalidProperties[] = "'international_dialing_information' can't be null";
        }
        if ($this->container['region_codes'] === null) {
            $invalidProperties[] = "'region_codes' can't be null";
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
     * Gets country_iso
     *
     * @return string
     */
    public function getCountryIso()
    {
        return $this->container['country_iso'];
    }

    /**
     * Sets country_iso
     *
     * @param string $country_iso Alphabetic 2 character ISO country code
     *
     * @return $this
     */
    public function setCountryIso($country_iso)
    {
        $this->container['country_iso'] = $country_iso;

        return $this;
    }

    /**
     * Gets country_name
     *
     * @return string
     */
    public function getCountryName()
    {
        return $this->container['country_name'];
    }

    /**
     * Sets country_name
     *
     * @param string $country_name English country name
     *
     * @return $this
     */
    public function setCountryName($country_name)
    {
        $this->container['country_name'] = $country_name;

        return $this;
    }

    /**
     * Gets international_dialing_information
     *
     * @return \App\Http\Ding\Model\InternationalDialingInfo[]
     */
    public function getInternationalDialingInformation()
    {
        return $this->container['international_dialing_information'];
    }

    /**
     * Sets international_dialing_information
     *
     * @param \App\Http\Ding\Model\InternationalDialingInfo[] $international_dialing_information Phone number dialing information
     *
     * @return $this
     */
    public function setInternationalDialingInformation($international_dialing_information)
    {
        $this->container['international_dialing_information'] = $international_dialing_information;

        return $this;
    }

    /**
     * Gets region_codes
     *
     * @return string[]
     */
    public function getRegionCodes()
    {
        return $this->container['region_codes'];
    }

    /**
     * Sets region_codes
     *
     * @param string[] $region_codes Regions supported within the country
     *
     * @return $this
     */
    public function setRegionCodes($region_codes)
    {
        $this->container['region_codes'] = $region_codes;

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


