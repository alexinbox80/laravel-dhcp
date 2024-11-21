<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/*
Afterwards override $colums in child models and you
should be good to perform queries as defined by you.

protected $columns = [
    'test_changed' => 'test',

];
*/

abstract class BaseModel extends Model
{
    /**
     * Override this to set property names that should be cast to a different
     * table column name.
     * @var array
     */
    static protected $columns = [];


    /**
     * Getter for the property names that should be cast to a different
     * table column name.
     * @param string $key
     * @return mixed
     */
    public function getAttribute($key)
    {
        return parent::getAttribute($this->getGetterKey($key));
    }

    /**
     * Setter for the property names that should be cast to a different table column name.
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    public function setAttribute($key, $value)
    {
        return parent::setAttribute($this->getSetterKey($key), $value);
    }

    /**
     * Getter for the property names that should be cast to a different
     * table column name.
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {
        return parent::__get($this->getGetterKey($key));
    }

    /**
     * Setter for the property names that should be cast to a different table column name.
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    public function __set($key, $value)
    {
        return parent::__set($this->getSetterKey($key), $value);
    }


    /**
     * Convert an attribute key to the column name, dictated by the $columns array.
     * @param string $key
     * @return string
     */
    protected function getGetterKey($key): string
    {
        if (isset(static::$columns[$key]) && !$this->getterExists($key)) {
            $key = static::$columns[$key];
        }

        return $key;
    }

    /**
     * Convert an attribute key to the column name, dictated by the $columns array.
     * @param string $key
     * @return string
     */
    protected function getSetterKey($key): string
    {
        if (isset(static::$columns[$key]) && !$this->setterExists($key)) {
            $key = static::$columns[$key];
        }

        return $key;
    }

    /**
     * Determine if a setter exists for an attribute. See link for how setters are defined
     * @see https://laravel.com/docs/10.x/eloquent-mutators#defining-a-mutator
     * @return bool
     */
    protected function setterExists($attribute): bool
    {
        $method = Str::camel($attribute);
        if (!method_exists($this, $method)) {
            return false;
        }
        if ($this->{$method}()->set === null) {
            return false;
        }
        return true;
    }


    /**
     * Determine if a getter exists for an attribute. Seee link for how getters are defined
     * @see https://laravel.com/docs/10.x/eloquent-mutators#defining-an-accessor
     * @return bool
     */
    protected function getterExists($attribute): bool
    {
        $method = Str::camel($attribute);
        if (!method_exists($this, $method)) {
            return false;
        }
        if ($this->{$method}()->get === null) {
            return false;
        }
        return true;
    }

    /**
     * Convert the property name to the column name.
     * @param string $name
     * @return string
     */
    public static function convertColumnName(string $name): string
    {
        if (isset(static::$columns[$name])) {
            $name = static::$columns[$name];
        }

        return $name;
    }

    /**
     * Override.
     * Convert the property names to the columns names from the $this->columns array.
     * @return array
     */
    public function attributesToArray()
    {
        $attributes = parent::attributesToArray();

        foreach (static::$columns as $convention => $actual) {
            if (array_key_exists($actual, $attributes)) {
                if ($this->getterExists($convention)) {
                    // If a Attribute getter exists, use that instead.
                    $attributes[$convention] = $this->{$convention};
                } else {
                    $attributes[$convention] = $attributes[$actual];
                }
                unset($attributes[$actual]);
            }
        }

        return $attributes;
    }
}
