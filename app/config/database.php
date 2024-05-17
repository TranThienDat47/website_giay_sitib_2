<?php
include_once "../config/config.php";
class Database
{
    private $host = DB_HOST;
    private $user = DB_USER;
    private $password = DB_PASS;
    private $dbname = DB_NAME;
    public $conn;

    public function __construct()
    {
        $this->connect();
    }

    public function connect()
    {
        try {
            $this->conn = new mysqli($this->host, $this->user, $this->password, $this->dbname);

            if ($this->conn->connect_error) {
                throw new Exception("Connection failed: " . $this->conn->connect_error);
            } else {
                // echo "<script>console.log('Debug Objects: " . "Connect database successfully!" . "' );</script>";
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function query($sql)
    {
        try {
            $result = $this->conn->query($sql);

            if (!$result) {
                throw new Exception("Query failed: " . $this->conn->error);
            }

            return $result;
        } catch (Exception $e) {
            echo $e->getMessage();
            // throw new Exception("Query failed: " . $e->getMessage());
        }
    }

    public function fetchAll($sql)
    {
        try {

            $result = $this->query($sql);

            $rows = array();

            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }

            return $rows;
        } catch (Exception $e) {
            // Xử lý ngoại lệ
            // echo "Lỗi: " . $e->getMessage();

        }
    }

    public function fetchAllParams($sql, $params = [])
    {
        try {
            $stmt = $this->conn->prepare($sql);
            $type = array();
            foreach ($params as $value) {

                if (is_numeric($value))
                    $type[] = "i";
                else
                    $type[] = "s";
            }
            $stmt->bind_param(implode("", $type), ...$params);

            $stmt->execute();
            $result = $stmt->get_result();

            $rows = array();
            while ($temprow = $result->fetch_assoc()) {
                $rows[] = $temprow;
            }

            return $rows;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function fetchOne($sql, $params = array())
    {
        $type = array();
        $stmt = $this->conn->prepare($sql);
        if (!empty($params)) {

            foreach ($params as $value) {
                if (is_numeric($value))
                    $type[] = "i";
                else
                    $type[] = "s";
            }

            $stmt->bind_param(implode("", $type), ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return $row;
    }

    public function insert($table, $data)
    {
        try {
            $columns = array();
            $values = array();

            foreach ($data as $column => $value) {
                $columns[] = "`" . $column . "`";
                $values[] = "'" . $this->conn->real_escape_string($value) . "'";
            }

            $columns = implode(", ", $columns);
            $values = implode(", ", $values);

            $sql = "INSERT INTO `" . $table . "` (" . $columns . ") VALUES (" . $values . ")";
            $this->query($sql);

            return $this->conn->insert_id;
        } catch (Exception $e) {
            throw new Exception("Insert failed: " . $e->getMessage());
        }
    }

    public function insertResultRow($table, $data)
    {
        try {
            $columns = array();
            $values = array();

            foreach ($data as $column => $value) {
                $columns[] = "`" . $column . "`";
                $values[] = "'" . $this->conn->real_escape_string($value) . "'";
            }

            $columns = implode(", ", $columns);
            $values = implode(", ", $values);

            $sql = "INSERT INTO `" . $table . "` (" . $columns . ") VALUES (" . $values . ")";

            $this->query($sql);

            // Kiểm tra xem câu lệnh INSERT đã thêm row vào bảng hay không
            if ($this->conn->affected_rows > 0) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            throw new Exception("Insert failed: " . $e->getMessage());
        }
    }

    public function update($table, $data, $condition)
    {
        try {
            $fields = array();
            $values = array();

            $type = array();

            foreach ($data as $column => $value) {
                $fields[] = $column . " = ?";
                $values[] = $value;

                if (is_numeric($value))
                    $type[] = "i";
                else
                    $type[] = "s";
            }

            $fields = implode(", ", $fields);

            $stmt = $this->conn->prepare("UPDATE " . $table . " SET " . $fields . " WHERE " . $condition);
            $stmt->bind_param(implode("", $type), ...$values);
            $stmt->execute();

            return $stmt->affected_rows;
        } catch (Exception $e) {

            throw new Exception("Update failed: " . $e->getMessage());
        }
    }
    
    public function delete($table, $condition)
    {
        try {
            $table = filter_var($table, FILTER_SANITIZE_STRING);
            $condition = filter_var($condition, FILTER_SANITIZE_STRING);

            $query = "DELETE FROM $table WHERE $condition";

            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            return $stmt->affected_rows > 0;

        } catch (Exception $e) {
            throw new Exception("Delete failed: " . $e->getMessage());
        }
    }

    public function escape($string)
    {
        return $this->conn->real_escape_string($string);
    }

    public function close()
    {
        $this->conn->close();
        // echo "<script>console.log('" . "Close database! " . "' );</script>";
    }
}

?>