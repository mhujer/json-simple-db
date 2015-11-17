<?php
namespace JsonSimpleDb;

class Comparator
{
    /**
     * @var array
     */
    protected $compareWith;

    /**
     * @param array $compareWith
     */
    public function __construct(array $compareWith)
    {
        $this->compareWith = $compareWith;
    }

    /**
     * @param array $item
     * @return bool
     */
    public function match(array $item)
    {
        foreach ($this->compareWith as $key => $expectedValue) {
            if (!array_key_exists($key, $item)) {
                return false;
            }
            if ($item[$key] !== $expectedValue) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param array $compareWith
     * @return Comparator
     */
    public static function factory(array $compareWith)
    {
        return new self($compareWith);
    }
}
