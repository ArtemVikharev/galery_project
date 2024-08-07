<?php


class Model{
    private $data = [];

    protected $db;

    private $table;
    private $columns;

    public function __construct($table, $columns)
    {   
        $this-> db = new DB();
        
        $this->table =$table;
        $this->columns = $columns;

        $columns = Lib::convertListToString($this->columns);
        
        $this->data = $this->db->query("SELECT " . $columns . " FROM `" . $this->table . "`");
    
    }    


    public function get(array $params = null)
    {
        if (is_array($params) && count($params) > 0) {

            return $this->selectData($params);
        }

        return $this->data;
    }


    private function selectData($where)
    {
        $selected = [];

        if (count($this->data) == 0) {
            return [];
        }

        foreach ($this->data as $item) {
            foreach ($item as $key => $value) {
                if ($where[0] == $key && $where[1] == $value) {
                    $selected[] = $item;
                    break;
                }
            }
        }

        return $selected;
    }
}
