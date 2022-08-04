<?php

namespace App\Model;

use Conqui\Database;

class BaseModel
{
    protected $db;
    protected $queryString;
    protected $parameters;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }
    /*  Public functions  */
    public function all(){
        $this->queryString = "SELECT * FROM {$this->table}";
        return $this;
    }    
    public function id($id)
    {
        $this->queryString = "SELECT * FROM {$this->table} WHERE ";
        $this->setQueryParameters(['id' => $id]);
        $this->bindParams(['id' => $id]);
        return $this;
    }
    public function where(Array $parameters)
    {
        $this->queryString = "SELECT * FROM {$this->table} WHERE ";
        $this->setQueryParameters($parameters);
        $this->bindParams($parameters);
        return $this;
    }

    public function rawQuery($query,$parameters)
    {
        $this->queryString = $query;
        $this->bindParams($parameters);
        return $this;
    }

    public function create($parameters)
    {
        $this->queryString = "INSERT INTO {$this->table} ";
        $this->setColumns($parameters);
        $this->setValues($parameters);
        $this->bindParams($parameters);
        return $this;
    }

    public function setColumns($parameters)
    {
        if($parameters && is_array($parameters))
        {
            $paramString = '(';
            foreach($parameters as $k => $param)
            {
                if ($k === array_key_last($parameters)){
                    $paramString .= "{$k} ";
                }else{
                    $paramString .= "{$k},";
                }
            }
            $paramString .= ')';
            $this->queryString .= $paramString;
        }
    }

    public function setValues($parameters)
    {
        if($parameters && is_array($parameters))
        {
            $paramString = 'VALUES (';
            foreach($parameters as $k => $param)
            {
                if ($k === array_key_last($parameters)){
                    $paramString .= ":{$k} ";
                }else{
                    $paramString .= ":{$k},";
                }
            }
            $paramString .= ')';
            $this->queryString .= $paramString;
        }
    }

    public function get($params = null)
    {
        $this->setParams($params);
        $this->query();
        $this->bind();
        return $this->db->resultSingle();
    }
    public function getAll($params = null)
    {
        $this->setParams($params);
        $this->query();
        $this->bind();
        return $this->db->resultSet();
    }
    /*  Private functions  */
    private function setQueryParameters($parameters)
    {
        if($parameters && is_array($parameters))
        {
            $paramString = '';
            foreach($parameters as $k => $param)
            {
                if ($k === array_key_last($parameters)){
                    $paramString .= "{$k} = :{$k} ";
                }else{
                    $paramString .= "{$k} = :{$k} AND ";
                }
            }
            $this->queryString .= $paramString;
        }
    }

    private function bind()
    {
        if($this->parameters != null)
        {
            foreach($this->parameters as $k => $v){
                $this->db->bind($k,$v);
            }
        }
    }

    private function bindParams($parameters)
    {

        $this->parameters = $parameters;
    }

    private function query()
    {   
        $this->db->query($this->queryString);
    }

    private function setParams($params)
    {
        if($params)
        {
            $paramString = '';
            switch(true){
                case is_array($params):
                    foreach($params as $k => $param)
                    {
                        if ($k === array_key_last($params)){
                            $paramString .= "{$param} ";
                        }else{
                            $paramString .= "{$param}, ";
                        }
                    }
                    break;
                case is_string($params):
                    $paramString = $params;
                    break;
                default:
            }
            $this->queryString = str_replace('*', $paramString, $this->queryString);
        }
    }
}