<?php 
   class Developer_Model extends CI_Model {
	
      function __construct() { 
         parent::__construct(); 
      } 
   
      public function insert($table, $data) {
         if ($this->db->insert($table, $data)) {
            return true;
         }
      }
   
      public function delete($roll_no) {
         if ($this->db->delete("stud", "roll_no = ".$roll_no)) {
            return true;
         }
      }
   
      public function update($data,$nAutoId) {
         $this->db->set($data);
         $this->db->where("id", $nAutoId); 
         $this->db->update("stud", $data);
      }
   }
?>