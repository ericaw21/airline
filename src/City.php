<?php
    class City
    {
        private $id;
        private $name;

        function __construct($name, $id = null)
        {
            $this->name = $name;
            $this->id = $id;
        }

        function getName()
        {
            return $this->name;
        }

        function setName($new_name)
        {
            $this->name = (string) $new_name;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO cities (city_name) VALUES ('{$this->getName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_cities = $GLOBALS['DB']->query("SELECT * FROM cities;");
            $all_cities = array();
            foreach ($returned_cities as $city) {
                $city_name = $city['city_name'];
                $id = $city['id'];
                $new_city = new City($city_name, $id);
                array_push($all_cities, $new_city);
            }
            return $all_cities;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM cities;");
        }

        static function findCity($search_id)
        {
            $queries = $GLOBALS['DB']->query("SELECT * FROM cities WHERE id = {$search_id};");
            $return_city = null;
            foreach ($queries as $query)
            {
                $id = $query['id'];
                $city_name = $query['city_name'];
                $return_city = new City($city_name,$id);
            }
            return $return_city;
        }

        function updateProperty($property,$value)
        {
            $GLOBALS['DB']->exec("UPDATE cities SET {$property} = '{$value}' WHERE id = {$this->getId()};");
            $this->{$property}=$value;
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM cities WHERE id = {$this->getId()};");
        }



    }




?>
