<?php
class Connection{
    
    private static $instance = null;
    private $pdo;

    public function __construct()
    {
        $host = 'localhost';
        $db = 'bidput_db';
        $user = 'root';
        $password = '';
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try{
            $this->pdo = new PDO($dsn, $user, $password, $options);
        } catch (PDOException $e){
            error_log("Database Connection Error: " . $e->getMessage());
            throw new Exception("Database Connection Error");
        }
    }

    public static function getInstance()
    {
        if(self::$instance === null)
        {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function dbInsert(string $query, array $data = [], $isUpdate = false)
    {
        try {
            $stm = $this->pdo->prepare($query);
            foreach ($data as $key => $value) {
                $param_name = is_int($key) ? $key + 1 : ":$key";
                $stm->bindValue($param_name, $value);
            }
    
            return $stm->execute();
        } catch (PDOException $e) {
            error_log("Database Insert Error: " . $e->getMessage());
            return false;
        }
    }

    public function dbRead(string $query, array $data = []): array
    {
        try {
            $stm = $this->pdo->prepare($query);

            foreach($data as $key => $value)
            {
                $param_name = is_int($key) ? $key + 1 : ":$key";
                $stm->bindValue($param_name, $value);
            }

            $stm->execute();
            return $stm->fetchAll();

        } catch (PDOException $e) {
            error_log("Database Read Error: " . $e->getMessage());
            return [];
        }
    }

    public function dbUpdate(string $query, array $data = []): bool
    {
        try {
            $stm = $this->pdo->prepare($query);
            foreach($data as $key => $value)
            {
                $param_name = is_int($key) ? $key + 1 : "$key";
                $stm->bindValue($param_name, $value);
            }
            return $stm->execute();
        } catch (PDOEXception $e) {
            error_log("Database Update Error: " . $e->getMessage());
            return false;
        }
    }
}