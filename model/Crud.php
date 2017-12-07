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
            return false;
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
        } else {
            return false;
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
            return NULL;
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
            return NULL;
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
            return NULL;
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
            return NULL;
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
            return NULL;
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
            return false;
        }
    }

    public function saveReportDesign($deptId, $clientId, $branchId, $reportId, $captionList, $captionListWithDepth)
    {
        $stmt = $this->conn->prepare("INSERT INTO tempdesignedreport(deptId, clientId, branchId, reportId, captionList) VALUES(?, ?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("sssss", $deptId, $clientId, $branchId, $reportId, $captionList);
            $result = $stmt->execute();
            $stmt->close();
            if ($result) {
                $this->saveAccountingMapping($captionListWithDepth, $clientId, $branchId, $reportId);
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
            return false;
        }
    }

    private function saveAccountingMapping($captionListWithDepth, $clientId, $branchId, $reportId)
    {
        $decodedList = json_decode($captionListWithDepth, true);
        $chartOfCaptionList = array(array());

        $parentList = array();
        $hierarchyList = array();
        $index = 0;
        foreach ($decodedList as $i => $item) {
            if ($decodedList[$i]['parent_id'] != null) {
                $hierarchyList[$decodedList[$i]['id']] = $decodedList[$i]['parent_id'];
                $parentList[$index] = $decodedList[$i]['parent_id'];
                $index++;
            } else {
                $hierarchyList[$decodedList[$i]['id']] = $decodedList[$i]['id'];
            }
        }

        foreach ($decodedList as $i => $item) {
            $chartOfCaptionList[$i]['CaptionListKey'] = $clientId . $branchId . $reportId . $decodedList[$i]['id'];
            $chartOfCaptionList[$i]['OrgCode'] = $clientId;
            $chartOfCaptionList[$i]['CcReportCode'] = $reportId;
            $chartOfCaptionList[$i]['CcCaptionNo'] = $decodedList[$i]['id'];
            $chartOfCaptionList[$i]['CcCaptionName'] = $decodedList[$i]['name'];
            $chartOfCaptionList[$i]['CcCaptionLevel'] = $decodedList[$i]['depth'] + 1;
            $chartOfCaptionList[$i]['CcCaptionParent'] = $decodedList[$i]['parent_id'];
            $chartOfCaptionList[$i]['CcCaptionOrder'] = $i + 1;
            $chartOfCaptionList[$i]['CcIsLeaf'] = $this->isLeaf($decodedList[$i]['id'], $parentList);

            $stmt = $this->conn->prepare("INSERT INTO chartofcaption(CaptionListKey, OrgCode, CcReportCode, CcCaptionNo, CcCaptionName, CcCaptionLevel, CcCaptionParent, CcCaptionOrder, CcIsLeaf) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)");
            if ($stmt) {
                $stmt->bind_param("sssssssss",
                    $chartOfCaptionList[$i]['CaptionListKey'],
                    $chartOfCaptionList[$i]['OrgCode'],
                    $chartOfCaptionList[$i]['CcReportCode'],
                    $chartOfCaptionList[$i]['CcCaptionNo'],
                    $chartOfCaptionList[$i]['CcCaptionName'],
                    $chartOfCaptionList[$i]['CcCaptionLevel'],
                    $chartOfCaptionList[$i]['CcCaptionParent'],
                    $chartOfCaptionList[$i]['CcCaptionOrder'],
                    $chartOfCaptionList[$i]['CcIsLeaf']);

                $result = $stmt->execute();
                $stmt->close();
            }
        }
        print_r($chartOfCaptionList);
    }

    public function getLeafCaptionList($clientId, $reportId)
    {
        $stmt = $this->conn->prepare("SELECT CaptionListKey,CcReportCode,CcCaptionNo,CcCaptionName,OrgCode FROM `chartofcaption` WHERE OrgCode = ? AND CcReportCode = ? AND CcIsLeaf = 1 ");
        if ($stmt) {
            $stmt->bind_param("ss", $clientId, $reportId);
            if ($stmt->execute()) {
                $reports = $stmt->get_result();
                $stmt->close();
                return $reports;
            } else {
                return NULL;
            }
        } else {
            echo $this->conn->error;
            return NULL;
        }
    }

    private function isLeaf($id, $parentList)
    {
        if (in_array($id, $parentList)) {
            return 0;
        } else {
            return 1;
        }
    }

    private function createHierarchy($hierarchyList, $parent, $hierarchyString)
    {
        if ($hierarchyList[$parent] != null) {
            $hierarchyString .= $parent;
        }

        if ($hierarchyList[$parent] == $parent) {
            return $hierarchyString;
        }

        $hierarchyString = $this->createHierarchy($hierarchyList, $hierarchyList[$parent], $hierarchyString);
        return $hierarchyString;
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
            return NULL;
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
            return NULL;
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
            return NULL;
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