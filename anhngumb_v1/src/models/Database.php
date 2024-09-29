<?php
namespace Models;

use mysqli;
use Dotenv\Dotenv;

class Database {
    private static $instance = null;
    private $connection;

    private function __construct() {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../'); // Đảm bảo đường dẫn đúng đến thư mục chứa .env
        $dotenv->load();

        $dbHost = $_ENV['DB_HOST'];
        $dbUsername = $_ENV['DB_USERNAME'];
        $dbPassword = $_ENV['DB_PASSWORD'];
        $dbDatabase = $_ENV['DB_DATABASE'];

        $this->connection = new mysqli($dbHost, $dbUsername, $dbPassword, $dbDatabase);

        if ($this->connection->connect_error) {
            die("Kết nối thất bại: " . $this->connection->connect_error);
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance->connection;
    }
}
