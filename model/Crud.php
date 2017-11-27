<?php
/**
 * Created by PhpStorm.
 * User: wahid.sadique
 * Date: 10/19/2017
 * Time: 1:01 PM
 */

class Crud
{
    private $conn;

    function __construct()
    {
        require_once 'db/DbConnect.php';
        require_once 'db/Hashing.php';
        $db = new DbConnect();
        $this->conn = $db->connect();
    }

    function __destruct()
    {

    }

    public function storeUser($userType, $username, $email, $password)
    {
        $hash = Hashing::hash($password);
        $encrypted_password = $hash["encrypted"];
        $salt = $hash["salt"];
        $stmt = $this->conn->prepare("INSERT INTO users(usertype, username, email, password, salt) VALUES(?, ?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("sssss", $userType, $username, $email, $encrypted_password, $salt);
            $result = $stmt->execute();
            $stmt->close();
            if ($result) {
                $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $user = $stmt->get_result()->fetch_assoc();
                $stmt->close();
                return $user;
            } else {
                return false;
            }
        } else {
            echo $this->conn->error;
        }
    }

    public function isUserExisted($email)
    {
        $stmt = $this->conn->prepare("SELECT email from users WHERE email = ?");
        if ($stmt) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $stmt->close();
                return true;
            } else {
                $stmt->close();
                return false;
            }
        }
    }

    public function logInAttempt($username, $password)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ?");
        if ($stmt) {
            $stmt->bind_param("s", $username);
            if ($stmt->execute()) {
                $user = $stmt->get_result()->fetch_assoc();
                $stmt->close();
                $hash = $user['password'];
                $salt = $user['salt'];
                $check = Hashing::check_password($password, $salt, $hash);
                if ($check) {
                    return $user;
                } else {
                    return NULL;
                }
            } else {
                return NULL;
            }
        } else {
            echo $this->conn->error;
        }
    }

    public function getAllDepartments()
    {
        $stmt = $this->conn->prepare("SELECT * from departments");
        if ($stmt) {
            if ($stmt->execute()) {
                $departments = $stmt->get_result();
                $stmt->close();
                return $departments;
            } else {
                return NULL;
            }
        } else {
            echo $this->conn->error;
        }
    }

    public function getAllClients($deptId)
    {
        $stmt = $this->conn->prepare("SELECT 
                                             c.id,c.clientName,d.deptName
                                             FROM clients c 
                                             LEFT JOIN departments d ON c.deptId = d.id
                                             WHERE c.deptId = ?");
        if ($stmt) {
            $stmt->bind_param("s", $deptId);
            if ($stmt->execute()) {
                $clients = $stmt->get_result();
                $stmt->close();
                return $clients;
            } else {
                return NULL;
            }
        } else {
            echo $this->conn->error;
        }
    }

    public function getClientsBranches($clientId)
    {
        $stmt = $this->conn->prepare("SELECT * FROM clientbranchinfo WHERE clientId = ?");
        if ($stmt) {
            $stmt->bind_param("s", $clientId);
            if ($stmt->execute()) {
                $branches = $stmt->get_result();
                $stmt->close();
                return $branches;
            } else {
                return NULL;
            }
        } else {
            echo $this->conn->error;
        }
    }

    public function getReportsName()
    {
        $stmt = $this->conn->prepare("SELECT * FROM reportinfo");
        if ($stmt) {
            if ($stmt->execute()) {
                $reports = $stmt->get_result();
                $stmt->close();
                return $reports;
            } else {
                return NULL;
            }
        } else {
            echo $this->conn->error;
        }
    }

    public function saveReport($reportId, $clientId, $deptId, $branchId, $reportURL, $reportName)
    {
        $stmt = $this->conn->prepare("INSERT INTO svaedreport(reportId, clientId, deptId, branchId, reportURL, reportName) VALUES(?, ?, ?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("ssssss", $reportId, $clientId, $deptId, $branchId, $reportURL, $reportName);
            $result = $stmt->execute();
            $stmt->close();
            if ($result) {
                $stmt = $this->conn->prepare("SELECT * FROM svaedreport");
                $stmt->execute();
                $report = $stmt->get_result()->fetch_assoc();
                $stmt->close();
                return $report;
            } else {
                return false;
            }
        } else {
            echo $this->conn->error;
        }
    }

    public function saveReportDesign($deptId, $clientId, $branchId, $reportId, $captionList)
    {
        $stmt = $this->conn->prepare("INSERT INTO tempdesignedreport(deptId, clientId, branchId, reportId, captionList) VALUES(?, ?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("sssss", $deptId, $clientId, $branchId, $reportId, $captionList);
            $result = $stmt->execute();
            $stmt->close();
            if ($result) {
                $stmt = $this->conn->prepare("SELECT * FROM tempdesignedreport WHERE reportId = ?");
                $stmt->bind_param("s", $reportId);
                $stmt->execute();
                $report = $stmt->get_result()->fetch_assoc();
                $stmt->close();
                return $report;
            } else {
                return false;
            }
        } else {
            echo $this->conn->error;
        }
    }

    public function showReport($reportId, $clientId, $deptId, $branchId)
    {
        $stmt = $this->conn->prepare("SELECT * FROM `svaedreport` WHERE clientId = ? AND branchId = ? AND reportId = ?");
        if ($stmt) {
            $stmt->bind_param("sss", $clientId, $branchId, $reportId);
            if ($stmt->execute()) {
                $report = null;
                $reportDetails = $stmt->get_result()->fetch_assoc();
                if ($reportDetails != null) {
                    $report = $reportDetails["reportURL"];
                }
                $stmt->close();
                return $report;
            } else {
                return NULL;
            }
        } else {
            echo $this->conn->error;
        }
    }

    public function getDesignedReport($deptId, $clientId, $branchId, $reportId)
    {
        $stmt = $this->conn->prepare("SELECT captionList FROM tempdesignedreport WHERE deptId = ? AND clientId = ? AND branchId = ? AND reportId = ?");
        if ($stmt) {
            $stmt->bind_param("ssss", $deptId, $clientId, $branchId, $reportId);
            if ($stmt->execute()) {
                $report = null;
                $reportDetails = $stmt->get_result()->fetch_assoc();
                if ($reportDetails != null) {
                    $report = $reportDetails["captionList"];
                }
                $stmt->close();
                return $report;
            } else {
                return NULL;
            }
        } else {
            echo $this->conn->error;
        }
    }

    public function getSavedReports()
    {
        $stmt = $this->conn->prepare("SELECT * from svaedreport");
        if ($stmt) {
            if ($stmt->execute()) {
                $savedReports = array();
                $i = 0;
                $reports = $stmt->get_result();
                while ($report = $reports->fetch_assoc()) {
                    $savedReports[$i] = $report["reportName"];
                    $i++;
                }
                $stmt->close();
                return $savedReports;
            } else {
                return NULL;
            }
        } else {
            echo $this->conn->error;
        }
    }

    public function hashSSHA($password)
    {
        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }
}