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

    public function persist()
    {
        file_put_contents($this->jsonFilename, json_encode($this->jsonData));
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
        $filter = Matcher::factory($search);
        return array_values(array_filter($this->jsonData, function ($item) use ($filter) {
            return $filter->match($item); //item matches the filter
        }));
    }

    /**
     * @param array $data
     */
    public function insert(array $data)
    {
        $this->jsonData[] = $data;
    }

    public function update(array $search, array $update)
    {
        $filter = Matcher::factory($search);

        $this->jsonData = array_map(function ($item) use ($filter, $update) {
            if ($filter->match($item)) { //item matches the filter
                foreach ($update as $updateKey => $updateValue) {
                    $item[$updateKey] = $updateValue;
                }
            }
            return $item;
        }, $this->jsonData);
    }
}
