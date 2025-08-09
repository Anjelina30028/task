<?php
namespace Service;

use MyProj\Exceptions\DbException;

class Connect
{
    public static $pdo;

    public static $instanse;

    public function __construct()
    {
        $dbConfig = (require __DIR__ . '/../setting.php')['db'];
            $this->pdo = new \PDO(
                'mysql:host=' . $dbConfig['host'] . ';dbname=' . $dbConfig['dbname'],
                $dbConfig['user'],
                $dbConfig['password']
            );
            $this->pdo->exec('SET NAMES UTF8');

    }

    // Прочитать про
    public function query(string $sql, array $params = [], string $className = 'stdClass')
    {
        $sth = $this->pdo->prepare($sql);
        $res = $sth->execute($params);
        if ($res === false) {
            return null;
        }
        return $sth->fetchAll(\PDO::FETCH_CLASS, $className);
    }

    public static function getInstanse(): ?self
    {
        if(self::$instanse === null)
        {
            return self::$instanse = new self();
        }
        return self::$instanse;
    }

    public function getLastInsertId(): int
{
    return (int) $this->pdo->lastInsertId();
}

}
