<?php
/**
 * LocalizedProductDescription
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
 * LocalizedProductDescription Class Doc Comment
 *
 * @category Class
 * @package  Swagger\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class LocalizedProductDescription implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'LocalizedProductDescription';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'display_text' => 'string',
        'description_markdown' => 'string',
        'read_more_markdown' => 'string',
        'localization_key' => 'string',
        'language_code' => 'string'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'display_text' => null,
        'description_markdown' => null,
        'read_more_markdown' => null,
        'localization_key' => null,
        'language_code' => null
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
        'display_text' => 'DisplayText',
        'description_markdown' => 'DescriptionMarkdown',
        'read_more_markdown' => 'ReadMoreMarkdown',
        'localization_key' => 'LocalizationKey',
        'language_code' => 'LanguageCode'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'display_text' => 'setDisplayText',
        'description_markdown' => 'setDescriptionMarkdown',
        'read_more_markdown' => 'setReadMoreMarkdown',
        'localization_key' => 'setLocalizationKey',
        'language_code' => 'setLanguageCode'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'display_text' => 'getDisplayText',
        'description_markdown' => 'getDescriptionMarkdown',
        'read_more_markdown' => 'getReadMoreMarkdown',
        'localization_key' => 'getLocalizationKey',
        'language_code' => 'getLanguageCode'
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
        $this->container['display_text'] = isset($data['display_text']) ? $data['display_text'] : null;
        $this->container['description_markdown'] = isset($data['description_markdown']) ? $data['description_markdown'] : null;
        $this->container['read_more_markdown'] = isset($data['read_more_markdown']) ? $data['read_more_markdown'] : null;
        $this->container['localization_key'] = isset($data['localization_key']) ? $data['localization_key'] : null;
        $this->container['language_code'] = isset($data['language_code']) ? $data['language_code'] : null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        if ($this->container['display_text'] === null) {
            $invalidProperties[] = "'display_text' can't be null";
        }
        if ($this->container['localization_key'] === null) {
            $invalidProperties[] = "'localization_key' can't be null";
        }
        if ($this->container['language_code'] === null) {
            $invalidProperties[] = "'language_code' can't be null";
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
     * Gets display_text
     *
     * @return string
     */
    public function getDisplayText()
    {
        return $this->container['display_text'];
    }

    /**
     * Sets display_text
     *
     * @param string $display_text A short description of the product.
     *
     * @return $this
     */
    public function setDisplayText($display_text)
    {
        $this->container['display_text'] = $display_text;

        return $this;
    }

    /**
     * Gets description_markdown
     *
     * @return string
     */
    public function getDescriptionMarkdown()
    {
        return $this->container['description_markdown'];
    }

    /**
     * Sets description_markdown
     *
     * @param string $description_markdown A longer description of the product.
     *
     * @return $this
     */
    public function setDescriptionMarkdown($description_markdown)
    {
        $this->container['description_markdown'] = $description_markdown;

        return $this;
    }

    /**
     * Gets read_more_markdown
     *
     * @return string
     */
    public function getReadMoreMarkdown()
    {
        return $this->container['read_more_markdown'];
    }

    /**
     * Sets read_more_markdown
     *
     * @param string $read_more_markdown More detailed infomation about the product.
     *
     * @return $this
     */
    public function setReadMoreMarkdown($read_more_markdown)
    {
        $this->container['read_more_markdown'] = $read_more_markdown;

        return $this;
    }

    /**
     * Gets localization_key
     *
     * @return string
     */
    public function getLocalizationKey()
    {
        return $this->container['localization_key'];
    }

    /**
     * Sets localization_key
     *
     * @param string $localization_key localization_key
     *
     * @return $this
     */
    public function setLocalizationKey($localization_key)
    {
        $this->container['localization_key'] = $localization_key;

        return $this;
    }

    /**
     * Gets language_code
     *
     * @return string
     */
    public function getLanguageCode()
    {
        return $this->container['language_code'];
    }

    /**
     * Sets language_code
     *
     * @param string $language_code language_code
     *
     * @return $this
     */
    public function setLanguageCode($language_code)
    {
        $this->container['language_code'] = $language_code;

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


