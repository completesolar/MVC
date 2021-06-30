<?php
namespace CompleteSolar\MVC;

class DBBase {
    public $db;
    public $result;
    public $inTransaction;
    public $errors;
    private $isError;

    public function __construct($hostname, $username, $password, $dbname) {
        $this->result = null;
        $this->errors = array();
        $this->isError = false;

        $this->db = new \mysqli($hostname, $username, $password, $dbname);
        /* check connection */
        if ($this->db->connect_errno) {
            printf("Connect failed: %s\n", $this->db->connect_error);
            exit();
        }

        $this->inTransaction = false;
    }

    function __destruct() {
        if($this->result != null){
            $this->result->close();
            $this->result = null;
        }
        if($this->db != null){
            $this->db->close();
            $this->db= null;
        }
    }

    protected function ifEmptySetToNull(&$arg){
        if ($arg=="" || !isset($arg)) $arg="NULL";
        else $arg = "'$arg'";
    }
    public function startTransaction(){
        $this->db->query("START TRANSACTION") or die(sprintf("[%d] %s\n",
                $this->db->errno,
                $this->db->error));
        $this->inTransaction = true;
    }

    public function commitTransaction(){
        $this->db->query("COMMIT");
        $this->inTransaction = false;
        $this->db->autocommit(TRUE);
    }

    public function rollback() {
        #print ("Rolling back transaction");
        $this->db->query("ROLLBACK");
        $this->inTransaction = false;
    }

    public function checkError(){
        if ($this->db->error) { //(($this->db->errno > 0)){
            $error = array(
                    'errno' => $this->db->errno,
                    'text' => $this->db->error
            );
            if ($this->inTransaction){
                $this->rollback();
            }
            $this->errors[] = $error;
            return true;
        } else if ($this->isError){
            $this->isError = false;
            return true;
        }
        return false;
    }

    public function sanitize_string($val){
        $clean_string = $val;
        if($val != null){
            $clean_string = trim($val);
            $clean_string = htmlentities($clean_string);
            $clean_string= $this->db->real_escape_string($clean_string);
        }
        return $clean_string;
    }

    /*
     * You can pass many parameters
    */
    public function executePreparedStatement($query){
        $stmt = $this->db->prepare($query);
        if ($stmt === false){
            $this->errors[] = htmlspecialchars($this->db->error);
            return false;
        }
        if (func_num_args() > 1){
            $parameters = func_get_args();
            array_shift($parameters); // remove the query from the list
            // Array needs to be bound by reference
            foreach ($parameters as $key=>&$value) {
                $params[$key] = &$value;
            }
            $val = call_user_func_array(array($stmt, "bind_param"), $params);
            if ($val === false){
                $this->errors[] = htmlspecialchars($stmt->error);
                return false;
            }
        }
        $result = $stmt->execute();
        if ($result === false){
            $this->errors[] = htmlspecialchars($stmt->error);
            return false;
        }
        $affected_rows = $stmt->affected_rows;
        $this->result = $stmt->get_result();
        if ($stmt->error){
            $this->isError = true;
            $this->errors[] = array(
                    'errno' => $stmt->errno,
                    'text' => $stmt->error
            );
            $stmt->close();
            return false;
        }
        $stmt->close();
        return $affected_rows;
    }

    public function getLastError(){
        return end($this->errors);
    }

    protected function sanitize_string2(&$val){
        if ($val!=null){
            $val = $this->db->real_escape_string(htmlentities(trim($val)));
        }
    }
}
?>