<?
    namespace Model;

use Service\Connect;

    abstract class ActiveRecord{

        public $id;

         public function __set($name, $value){   
            $camelCase = $this->underscoreToCamelCase($name);
            $this->$camelCase = $value;
        
         }

         public function underscoreToCamelCase(string $search)
         {
            lcfirst(str_replace('_', '', ucwords($search, '_')));
         }

         public function save(): void
         {
            $mappedProperties = $this->mapPropertiesToDbFormat();
            if ($this->id !== null) {
                $this->update($mappedProperties);
            } else {
                $this->insert($mappedProperties);
            }
         }

         public function insert(array $mappedProperties): void
         {
            $filteredProperties = array_filter($mappedProperties);
        
            $columns = [];
            $paramsNames = [];
            $params2values = [];
            foreach ($filteredProperties as $columnName => $value) {
                $columns[] = '`' . $columnName. '`';
                $paramName = ':' . $columnName;
                $paramsNames[] = $paramName;
                $params2values[$paramName] = $value;
            }
        
            $columnsViaSemicolon = implode(', ', $columns);
            $paramsNamesViaSemicolon = implode(', ', $paramsNames);
        
            $sql = 'INSERT INTO ' . static::getTable() . ' (' . $columnsViaSemicolon . ') VALUES (' . $paramsNamesViaSemicolon . ');';
        
            $db = Connect::getInstanse();
            $db->query($sql, $params2values, static::class);
            $this->id = $db->getLastInsertId();
        }

         public function update(array $mappedProperties): void
            {
                $columns2params = [];
                $params2values = [];
                $index = 1;
                foreach ($mappedProperties as $column => $value) {
                    $param = ':param' . $index; 
                    $columns2params[] = $column . ' = ' . $param; 
                    $params2values[':param' . $index] = $value; 
                    $index++;
                }
                $sql = 'UPDATE ' . static::getTable() . ' SET ' . implode(', ', $columns2params) . ' WHERE id = ' . $this->id;

                $db = Connect::getInstanse();
                $db->query($sql, $params2values, static::class);

            }

         public function mapPropertiesToDbFormat(): array
         {
             $reflector = new \ReflectionObject($this);
             $properties = $reflector->getProperties();
         
             $mappedProperties = [];
             foreach ($properties as $property) {
                 $propertyName = $property->getName();
                 $propertyNameAsUnderscore = $this->camelCaseToUnderscore($propertyName);
                 $mappedProperties[$propertyNameAsUnderscore] = $this->$propertyName;
             }
         
             return $mappedProperties;
         }

         public function delete(): void
            {
                $db = Connect::getInstanse();
                $db->query(
                    'DELETE FROM `' . static::getTable() . '` WHERE id = :id',
                    [':id' => $this->id]
                );
                $this->id = null;
            }

         public function camelCaseToUnderscore(string $source): string
            {
                return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $source));
            }

         public static function findAll(): ?array
         {
            $db = Connect::getInstanse();
            return $db->query(
                'SELECT * FROM `'.static::getTable().'`', 
                [], 
                static::class
            );
         }



         abstract public static function getTable() : string;
    
         
         public static function findOne(int $id) :self
         {
             $db = Connect::getInstanse();
             $entities = $db->query(
                 'SELECT * FROM `' . static::getTable() . '` WHERE id=:id;',
                 [':id' => $id],
                 static::class
             );

             return $entities ? $entities[0] : null;
         }

         public static function findOneByColumn(string $columnName, $value)
         {
            $db = Connect::getInstanse();
             $result = $db->query(
                 'SELECT * FROM `' . static::getTable() . '` WHERE `' . $columnName . '` = :value LIMIT 1;',
                 [':value' => $value],
                 static::class
             );
             if ($result === []) {
                 return null;
             }
             return $result[0];
         }

    }     
?>
