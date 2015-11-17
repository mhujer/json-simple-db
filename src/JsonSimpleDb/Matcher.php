<?php
namespace JsonSimpleDb;

class Matcher
{
    /**
     * @var array
     */
    protected $constraints;

    /**
     * @param array $constraints
     */
    public function __construct(array $constraints)
    {
        $this->constraints = $constraints;
    }

    /**
     * @param array $item
     * @return bool
     */
    public function match(array $item)
    {
        foreach ($this->constraints as $key => $expectedValue) {
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
     * @return Matcher
     */
    public static function factory(array $compareWith)
    {
        return new self($compareWith);
    }
}
