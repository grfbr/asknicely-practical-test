<?php

require_once '../models/Employee.php';

class EmployeeController {
    private $employeeModel;

    public function __construct() {
        $this->employeeModel = new Employee();
    }

    public function listEmployees() {
        return $this->employeeModel->getEmployees();
    }

    public function editEmployeeEmail($id, $email) {
        
        return $this->employeeModel->updateEmployeeEmail($id, $email);
    }

    public function showAverageSalary() {
        return $this->employeeModel->getAverageSalary();
    }

    public function importCSV($filePath) {
        return $this->employeeModel->importFromCSV($filePath);
    }
}
