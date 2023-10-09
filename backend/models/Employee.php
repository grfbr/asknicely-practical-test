<?php
require_once 'Database.php';

class Employee
{
    private $conn;
    private $table_name = "employees";

    public function __construct()
    {
        $this->conn = (new Database())->connect();
    }

    public function getEmployees()
    {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY employee_name ASC";
        $stmt = $this->conn->prepare($query);

        if (!$stmt->execute()) {
            return false; // or handle error accordingly
        }

        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function updateEmployeeEmail($id, $email)
    {
        $query = "UPDATE " . $this->table_name . " SET email_address=? WHERE id=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("si", $email, $id);

        return $stmt->execute();
    }

    public function getAverageSalary()
    {
        $query = "SELECT `company_name`, AVG(Salary) as average_salary FROM " . $this->table_name . " GROUP BY `company_name` ORDER BY average_salary ASC";
        $stmt = $this->conn->prepare($query);

        if (!$stmt->execute()) {
            return false; // or handle error accordingly
        }

        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function importFromCSV($filePath)
    {
        $file = fopen($filePath, 'r');

        $query = "INSERT IGNORE INTO " . $this->table_name . " (`company_name`, `employee_name`, `email_address`, `salary`) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        // Ignore the header line
        fgetcsv($file);

        while ($row = fgetcsv($file)) {
            $company_name = $row[0];
            $employee_name = $row[1];
            $email_address = $row[2];
            $salary = $row[3];

            try {
                $stmt->bind_param("ssss", $company_name, $employee_name, $email_address, $salary);
                $stmt->execute();
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }

        fclose($file);
    }
}
