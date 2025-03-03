<?php
class Student {
    private $conn;
    private $table = 'students';
    
    // Student properties
    public $id;
    public $student_id;
    public $name;
    public $email;
    public $phone;
    public $department;
    public $enrollment_date;
    public $created_at;
    public $updated_at;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    // Create new student
    public function create() {
        try {
            // Check if email already exists
            if ($this->checkEmailExists($this->email)) {
                throw new Exception("Email already exists");
            }

            $query = "INSERT INTO " . $this->table . "
                    (student_id, name, email, phone, department, enrollment_date)
                    VALUES
                    (:student_id, :name, :email, :phone, :department, :enrollment_date)";
            
            $stmt = $this->conn->prepare($query);
            
            // Sanitize inputs
            $this->student_id = htmlspecialchars(strip_tags($this->student_id));
            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->phone = htmlspecialchars(strip_tags($this->phone));
            $this->department = htmlspecialchars(strip_tags($this->department));
            
            // Bind values
            $stmt->bindParam(':student_id', $this->student_id);
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':phone', $this->phone);
            $stmt->bindParam(':department', $this->department);
            $stmt->bindParam(':enrollment_date', $this->enrollment_date);
            
            if($stmt->execute()) {
                return true;
            }
            throw new Exception("Error occurred while creating student");
        } catch (PDOException $e) {
            if ($e->errorInfo[1] === 1062) {  // MySQL duplicate entry error code
                throw new Exception("A student with this email already exists");
            }
            throw $e;  // Re-throw other database errors
        }
    }
    
    // Read all students
    public function read($search = '', $department = '', $page = 1, $per_page = 10) {
        $offset = ($page - 1) * $per_page;
        
        $query = "SELECT * FROM " . $this->table;
        $conditions = [];
        $params = [];
        
        if(!empty($search)) {
            $conditions[] = "(name LIKE :search OR student_id LIKE :search OR email LIKE :search)";
            $params[':search'] = "%$search%";
        }
        
        if(!empty($department)) {
            $conditions[] = "department = :department";
            $params[':department'] = $department;
        }
        
        if(!empty($conditions)) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }
        
        $query .= " ORDER BY created_at DESC LIMIT :offset, :per_page";
        
        $stmt = $this->conn->prepare($query);
        
        foreach($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':per_page', $per_page, PDO::PARAM_INT);
        
        $stmt->execute();
        return $stmt;
    }
    
    // Read single student
    public function readOne() {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row) {
            $this->student_id = $row['student_id'];
            $this->name = $row['name'];
            $this->email = $row['email'];
            $this->phone = $row['phone'];
            $this->department = $row['department'];
            $this->enrollment_date = $row['enrollment_date'];
            $this->created_at = $row['created_at'];
            $this->updated_at = $row['updated_at'];
            return true;
        }
        return false;
    }
    
    // Update student
    public function update() {
        try {
            // Check if email exists for other students
            if ($this->checkEmailExists($this->email, $this->id)) {
                throw new Exception("Email already exists");
            }

            $query = "UPDATE " . $this->table . "
                    SET
                        name = :name,
                        email = :email,
                        phone = :phone,
                        department = :department,
                        enrollment_date = :enrollment_date,
                        updated_at = CURRENT_TIMESTAMP
                    WHERE id = :id";
            
            $stmt = $this->conn->prepare($query);
            
            // Sanitize inputs
            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->phone = htmlspecialchars(strip_tags($this->phone));
            $this->department = htmlspecialchars(strip_tags($this->department));
            
            // Bind values
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':phone', $this->phone);
            $stmt->bindParam(':department', $this->department);
            $stmt->bindParam(':enrollment_date', $this->enrollment_date);
            
            if($stmt->execute()) {
                return true;
            }
            throw new Exception("Error occurred while updating student");
        } catch (PDOException $e) {
            if ($e->errorInfo[1] === 1062) {  // MySQL duplicate entry error code
                throw new Exception("A student with this email already exists");
            }
            throw $e;  // Re-throw other database errors
        }
    }
    
    // Delete student
    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    // Get total count
    public function getTotal($search = '', $department = '') {
        $query = "SELECT COUNT(*) as total FROM " . $this->table;
        $conditions = [];
        $params = [];
        
        if(!empty($search)) {
            $conditions[] = "(name LIKE :search OR student_id LIKE :search OR email LIKE :search)";
            $params[':search'] = "%$search%";
        }
        
        if(!empty($department)) {
            $conditions[] = "department = :department";
            $params[':department'] = $department;
        }
        
        if(!empty($conditions)) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }
        
        $stmt = $this->conn->prepare($query);
        
        foreach($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }
    
    // Check if student ID exists
    public function checkStudentIdExists($student_id, $exclude_id = null) {
        $query = "SELECT COUNT(*) as count FROM " . $this->table . " WHERE student_id = :student_id";
        if($exclude_id) {
            $query .= " AND id != :exclude_id";
        }
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':student_id', $student_id);
        if($exclude_id) {
            $stmt->bindParam(':exclude_id', $exclude_id);
        }
        
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['count'] > 0;
    }

    // Check if email exists
    public function checkEmailExists($email, $exclude_id = null) {
        $query = "SELECT COUNT(*) as count FROM " . $this->table . " WHERE email = :email";
        if($exclude_id) {
            $query .= " AND id != :exclude_id";
        }
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        if($exclude_id) {
            $stmt->bindParam(':exclude_id', $exclude_id);
        }
        
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['count'] > 0;
    }
}
?>
