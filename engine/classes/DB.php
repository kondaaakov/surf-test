<?php

namespace classes;

use PDO;
use PDOException;

class DB {
    private bool $isDebug;
    private array $columnsCache;

    private PDO $connection;
    private Log $log;
    private ArrayHelper $arrayHelper;


    public function __construct($settings, $isDebug = FALSE) {
        $this->connect($settings);

        $this->isDebug     = $isDebug;
        $this->log         = new Log($this->isDebug);
        $this->arrayHelper = new ArrayHelper();
    }

    private function connect(array $settings) {
        $host   = $settings['host'];
        $port   = $settings['port'];
        $dbname = $settings['name'];
        $user   = $settings['user'];
        $pass   = $settings['password'];


        $connectionString = "mysql:host=$host;port=$port;dbname=$dbname;";

        try {
            $attributes = [
                PDO::MYSQL_ATTR_INIT_COMMAND       => 'SET NAMES utf8',
                PDO::ATTR_DEFAULT_FETCH_MODE       => PDO::FETCH_ASSOC,
                PDO::ATTR_PERSISTENT               => true,
                PDO::ATTR_ERRMODE                  => PDO::ERRMODE_EXCEPTION,
                PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
                PDO::ATTR_EMULATE_PREPARES         => false,
            ];

            $this->setConnection(new PDO($connectionString, $user, $pass, $attributes));
        } catch (PDOException $error) {
            $this->setLog('error', $error->getMessage());
        }
    }

    private function query (string $body, array $conditions = []) {
        if (!$this->checkConnection()) return NULL;

        try {
            if ($this->isDebug) $startTime = microtime(true);

            $prepared = $this->connection->prepare($body);

            foreach (array_keys($conditions) as $key) {
                $value = $conditions[$key];
                $type  = PDO::PARAM_STR;

                if (is_array($value)) {
                    $value = $value['value'];
                    if (isset($value['type'])) {
                        $type = $value['type'];
                    }
                }

                if (is_int($key)) {
                    $key++;
                }

                $prepared->bindValue($key, $value, PDO::PARAM_STR);
            }

            $prepared->execute();

            if ($this->isDebug) {
                $this->setLog('time', 'время выполнения - ' . number_format(microtime(true) - $startTime, 2));
            }

        } catch (PDOException $error) {
            $trimmedBody = trim($body);
            $log         = "({$error->errorInfo[2]}) $trimmedBody";

            $this->setLog('error', $log);
            return NULL;
        }

        return $prepared;
    }

    public function get(string $table, $fields, $conditions = []) {
        if (!$this->checkConnection()) return NULL;

        $fields = $this->arrayHelper->arrayToString($fields, ', ');
        if (empty($fields)) $fields = '*';

        $conditions = $this->generateConditions($conditions);

        $sql = "SELECT $fields FROM $table $conditions";

        $result = $this->query($sql);

        if ($result && $result->rowCount()) {
            $result = $result->fetchAll((!empty($conditions['pdo']) ? $conditions['pdo'] : false));

            return $result;
        }
        return [];
    }

    public function getValue($table, $field , $conditions = array()) {
        if (!$this->checkConnection()) return NULL;

        $sqlField = $field;
        if (is_array($field)) {
            if (isset($field['function'])) {
                $sqlField = $field['function'];
            }

            if (isset($field['field'])) {
                $sqlField = $field['function'].' as '.$field['field'];
                $field = $field['field'];
            }
        }

        $result = $this->get($table, $sqlField, $conditions);

        if ($result === false)
            return false;
        else {
            if (isset($result[0])) {
                return $result[0][$field];
            }
            else {
                return '';
            }
        }
    }

    public function update($table, $data, $conditions) {
        if (!$this->checkConnection()) return NULL;

        $tableColumns = $this->getTableColumns($table);

        if ($data === null || $data === false) {
            $data = [];

            foreach ($_POST as $fieldName => $fieldValue) {
                if (
                    !array_key_exists($fieldName, $tableColumns)
                    || is_array($fieldValue)
                    || ($tableColumns[$fieldName]['Key'] === 'PRI' && $tableColumns[$fieldValue]['Extra'] === 'auto_increment')
                ) {
                    continue;
                }

                $data[$fieldName] = $this->setValue($fieldValue, $fieldName, $tableColumns);
            }
        }

        $fields       = [];
        $where        = '';
        $parametheres = [];

        foreach ($data as $fieldName => $fieldValue) {
            if (!is_null($fieldValue)) {
                $fields[] = "`{$fieldName}` = :new_{$fieldName}";
                $parametheres[":new_{$fieldName}"] = $this->setValue($fieldValue, $fieldName, $tableColumns);
            } else {
                $fields[] = "`{$fieldName}` = NULL";
            }
        }

        $template     = $this->getParametheres($conditions);
        $parametheres = array_merge($parametheres, $template['bindParams']);
        $where        = $template['whereParams'];

        if (count($conditions) > 0) {
            $where = 'WHERE ' . $this->arrayHelper->arrayToString($conditions, ' AND ');
        }

        $data   = $this->arrayHelper->arrayToString($data, ',');
        $table  = $this->getTableName($table);
        $sql    = "UPDATE $table SET $data $where";
        $result = $this->query($sql, $conditions);

        if (!$result) return false;
        else return $result->rowCount();
    }

    public function create($table, $values = null) {
        if (!$this->checkConnection()) return NULL;

        $tableColumns = $this->getTableColumns($table);
        $table        = $this->getTableName($table);

        if ($values === null || $values === false) {
            $values = [];

            foreach ($_POST as $fieldName => $fieldValue) {
                if (!array_key_exists($fieldName, $tableColumns)
                    || is_array($fieldValue)
                    || ($tableColumns[$fieldName]['Key'] === 'PRI' && $tableColumns[$fieldName]['Extra'] === 'auto_increment')
                ) {
                    continue;
                }

                $values[$fieldName] = $this->setValue($fieldValue, $fieldName, $tableColumns);
            }
        }

        $parametheres = [];
        $fields       = [];

        foreach ($values as $fieldName => $fieldValue) {
            if (is_null($fieldValue) && !is_null($tableColumns[$fieldName]['Default'])) {
                $fields[]       = "`{$fieldName}`";
                $parametheres[] = $tableColumns[$fieldName]['Default'];
            } else if (!is_null($fieldValue)) {
                $fields[]       = "`{$fieldName}`";
                $parametheres[] = $this->setValue($fieldValue, $fieldName, $tableColumns);
            }
        }

        if (!$fields) {
            return false;
        }

        $values = $this->arrayHelper->arrayToString(array_fill(0, count($fields), '?'), ',');
        $fields = $this->arrayHelper->arrayToString($fields, ',');
        $sql    = "INSERT INTO $table ($fields) VALUES ($values)";
        $result = $this->query($sql, $parametheres);

        if ($result === false) {
            return false;
        } else
            return $this->getLastInsertedId();
    }

    public function delete($table, $conditions) {
        if (!$this->checkConnection()) return NULL;

        $where = '';
        $table = $this->getTableName($table);
        if (count($conditions) > 0) {
            $template         = $this->getParametheres($conditions);
            $parametheres     = $template['bingParams'];
            $conditions       = $template['whereParams'];
            $conditionsString = $this->arrayHelper->arrayToString($conditions, 'AND ');
            $where            = "WHERE $conditionsString";
        }

        $sql = "DELETE FROM $table $where";
        $result = $this->query($sql, $parametheres);

        if ($result === false) {
            return false;
        } else {
            return $result->rowCount();
        }
    }

    private function setConnection(PDO $connection) {
        $this->connection = $connection;
    }

    private function checkConnection() {
        if ($this->connection) return true;
        return false;
    }

    private function getTableColumns($table) {
        $columns = [];

        $tableName = $this->getTableName($table);
        $result    = $this->query("SHOW FULL COLUMNS FROM $tableName");

        if (!$result) return [];

        foreach ($result->fetchAll() as $field) $columns[$field['Field']] = $field;

        if (!empty($columns)) $this->columnsCache[$table] = $columns;

        return $columns;
    }

    private function generateConditions($conditions) : string {
        $where = '';
        if (is_string($conditions)) $conditions = ['where' => $conditions];

        if (array_key_exists('where', $conditions) && !empty($conditions['where'])) {
            $where = is_array($conditions['where'])
                ? "WHERE " . $this->arrayHelper->arrayToString($conditions['where'], ' AND ')
                : "WHERE " . $conditions['where']
            ;
        }

        $leftJoin = array_key_exists('leftJoin', $conditions)
            ? "LEFT JOIN {$conditions['leftJoin']}"
            : NULL
        ;

        $join = array_key_exists('join', $conditions)
            ? "JOIN {$conditions['join']}"
            : NULL
        ;

        $order = array_key_exists('order', $conditions)
            ?  "ORDER BY {$conditions['order']}"
            : NULL
        ;

        $group = array_key_exists('group', $conditions)
            ? "GROUP BY {$conditions['group']}"
            : NULL
        ;

        $limit = '';
        if (array_key_exists('limit', $conditions)) {
            $limit = "LIMIT ";
            $limit .= is_array($conditions['limit'])
                ? $conditions['limit']['from'] . ',' . $conditions['limit']['to']
                : $conditions['limit']
            ;
        }

        $offset = '';
        if (array_key_exists('offset', $conditions)) {
            $offset = " OFFSET {$conditions['offset']}";
        }

        return "$leftJoin $join $where $group $order $limit $offset";
    }

    private function getTableName($table) {
        if (strpos($table, ' ')) {
            list($valueTable, $valueAs) = explode(' ', $table, 2);
            $valueAs = " $valueAs";
        } else {
            $valueTable = $table;
            $valueAs = '';
        }

        return "`$valueTable` $valueAs";
    }

    private function setValue($value, $field, $fields) {
        if (empty($value) && isset($fields[$field])) {
            if ($fields[$field]['Type'] === 'timestamp' && $fields[$field]['Null'] === 'YES') {
                $value = NULL;
            }
        }

        return $value;
    }

    private function getParametheres($parametheres) {
        $whereParametheres = [];
        $bindParametheres  = [];


        foreach (array_keys($parametheres) as $key) {
            $operator = '=';
            $field    = $key;

            if (is_array($parametheres[$key])) {
                $operator = isset($parametheres[$key]['operator']) && $parametheres[$key]['operator'] !== ''
                    ? $parametheres[$key]['operator']
                    : $operator;
                $field    = isset($params[$key]['function']) && $params[$key]['function'] !== ''
                    ? $parametheres[$key]['function']
                    : $key;
                $value    = $parametheres[$key]['value'];
            } else {
                $value = $parametheres[$key];
            }

            if (strtolower($operator) === 'like') {
                $value = "%$value%";
            }

            if (is_array($value)) {
                if ($field === 'user.id') {
                    $counter = 1;
                    foreach ($value as $newKey => $newValue) {
                        $value[$newKey] = "'$newValue'";
                    }
                    $whereParametheres[] = "user.id = " . implode(' or user.id = ', $value);
                } else if (is_array($parametheres[$key]) && isset($parametheres[$key]['template']) && $parametheres[$key]['template'] !== '') {
                    $template            = $parametheres[$key]['template'];
                    $template            = str_replace('#VALUE_FROM#', $value[0], $template);
                    $template            = str_replace('#VALUE_TO#', $value[1], $template);
                    $whereParametheres[] = $template;
                } else {
                    $replacedKey = str_replace('.', '_', $key);

                    if ($value[0] !== '') {
                        $bindParametheres[":{$replacedKey}_from"] = $value[0];
                        $whereParametheres[] = $field . " >= :{$replacedKey}_from";
                    }

                    if ($value[1] !== '') {
                        $bindParametheres[":{$replacedKey}_to"] = $value[0];
                        $whereParametheres[] = $field . " <= :{$replacedKey}_to";
                    }
                }
            } else {
                $bind = true;

                if (is_array($parametheres[$key]) && isset($parametheres[$key]['template']) && $parametheres[$key]['template'] !== '') {
                    $bind = strpos($params[$key]['template'],'#VALUE#') === false ? false : $bind;
                    $whereParametheres[] = str_replace('#VALUE#', " :{$replacedKey}", $parametheres[$key]['template']);
                } else {
                    $whereParametheres[] = "$field $operator :{$replacedKey}";
                }

                if ($bind) {
                    $bindParametheres[":{$replacedKey}"] = $value;
                }
            }
        }

        return ['whereParams' => $whereParametheres, 'bindParams' => $bindParametheres];
    }

    private function getLastInsertedId() {
        if (!$this->checkConnection()) return FALSE;

        return $this->connection->lastInsertId();
    }

    private function setLog(string $status, $message) {
        $message = "$status: $message";

        $this->log->setLog('database', $status, $message);
    }
}