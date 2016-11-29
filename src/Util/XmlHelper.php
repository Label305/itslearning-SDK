<?php
namespace Itslearning\Util;

use DOMDocument;
use DOMNode;
use DOMText;
use Itslearning\Exceptions\XmlException;

class XmlHelper
{

    /**
     * Transform an array into a DOMDocument
     *
     * @param array $input Array with data
     * @return DOMDocument
     * @throws XmlException
     */
    public static function fromArray(array $input):DOMDocument
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        self::handle($dom, $dom, $input);

        return $dom;
    }

    /**
     * @param DOMDocument $dom
     * @param DOMNode     $node
     * @param             $data
     * @throws XmlException
     */
    protected static function handle(DOMDocument $dom, DOMNode $node, &$data)
    {
        if (empty($data) || !is_array($data)) {
            return;
        }
        foreach ($data as $key => $value) {
            if (!is_string($key)) {
                throw new XmlException('Invalid array');
            }

            if (!is_array($value)) {
                $value = self::normalizeValue($value);
                if (self::isNamespace($key) !== false) {
                    $node->setAttributeNS('http://www.w3.org/2000/xmlns/', $key, $value);
                } else {
                    if (self::isKeyForAttribute($key)) {
                        self::appendAttribute($dom, $node, $key, $value);
                    } else {
                        self::appendChild($dom, $node, $value, $key);
                    }
                }
            } else {
                if (self::isKeyForAttribute($key)) {
                    throw new XmlException('Invalid array');
                }
                if (is_numeric(implode('', array_keys($value)))) {
                    foreach ($value as $item) {
                        self::handleChild($dom, $node, $key, $item);
                    }
                } else {
                    self::handleChild($dom, $node, $key, $value);
                }
            }
        }
    }

    /**
     * @param $dom
     * @param $node
     * @param $key
     * @param $value
     * @param $format
     */
    protected static function handleChild(DOMDocument $dom, DOMNode $node, string $key, $value)
    {
        $childNS = null;
        $childValue = null;

        if (is_array($value)) {
            if (isset($value['@'])) {
                $childValue = (string)$value['@'];
                unset($value['@']);
            }
            if (isset($value['xmlns:'])) {
                $childNS = $value['xmlns:'];
                unset($value['xmlns:']);
            }
        } elseif (!empty($value) || $value === 0) {
            $childValue = (string)$value;
        }

        $child = $dom->createElement($key);
        if ($childValue !== null) {
            $child->appendChild($dom->createTextNode($childValue));
        }
        if ($childNS) {
            $child->setAttribute('xmlns', $childNS);
        }

        self::handle($dom, $child, $value);
        $node->appendChild($child);
    }

    /**
     * @param DOMDocument $dom
     * @param DOMNode     $node
     * @param             $key
     * @param             $value
     * @return string
     */
    protected static function appendAttribute(DOMDocument $dom, DOMNode $node, $key, $value):string
    {
        $key = substr($key, 1);
        $attribute = $dom->createAttribute($key);
        $attribute->appendChild($dom->createTextNode($value));
        $node->appendChild($attribute);

        return $key;
    }

    /**
     * @param DOMDocument $dom
     * @param DOMNode     $node
     * @param             $value
     * @param             $key
     */
    protected static function appendChild(DOMDocument $dom, DOMNode $node, $value, $key)
    {
        $child = null;
        if (!is_numeric($value)) {
            $child = $dom->createElement($key, '');
            $child->appendChild(new DOMText($value));
        } else {
            $child = $dom->createElement($key, $value);
        }
        $node->appendChild($child);
    }

    /**
     * @param $key
     * @return bool
     */
    protected static function isNamespace(string $key):bool
    {
        return strpos($key, 'xmlns:') !== false;
    }

    /**
     * @param $value
     * @return mixed
     */
    protected static function normalizeValue($value)
    {
        if (is_bool($value)) {
            $value = (int)$value;
        } elseif ($value === null) {
            $value = '';
        }

        return $value;
    }

    /**
     * @param string $key
     * @return bool
     */
    protected static function isKeyForAttribute(string $key):bool
    {
        return $key[0] === '@';
    }

}