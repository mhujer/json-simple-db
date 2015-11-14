<?php
namespace JsonSimpleDb;

class Table
{
    /**
     * @var string
     */
    protected $jsonFilename;

    /**
     * @var array
     */
    protected $jsonData;

    /**
     * @param string $jsonFilename
     */
    public function __construct($jsonFilename)
    {
        $this->jsonFilename = $jsonFilename;
        $this->jsonData = json_decode(file_get_contents($this->jsonFilename), true);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->jsonData);
    }

    /**
     * @param array $search
     * @return array
     */
    public function find($search = [])
    {
        if (!$search) {
            return $this->jsonData;
        }
        $key = key($search);
        $value = $search[$key];

        $result = [];
        foreach ($this->jsonData as $item) {
            if ($item[$key] == $value) {
                $result[] = $item;
            }
        }
        return $result;
    }
}
