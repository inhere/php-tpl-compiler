<?php
/**
 * Created by PhpStorm.
 * User: inhere
 * Date: 2017-12-21
 * Time: 13:31
 */

namespace Inhere\Stc;

/**
 *
 */
class Object
{
    public function offsetExists($offset)
    {
        return array_key_exists($offset, get_object_vars($this));
    }

    public function offsetUnset($key)
    {
        if (array_key_exists($key, get_object_vars($this))) {
            unset($this->{$key});
        }
    }

    public function offsetSet($offset, $value)
    {
        $this->{$offset} = $value;
    }

    public function offsetGet($var)
    {
        return $this->$var;
    }
}
