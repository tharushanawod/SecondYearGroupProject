<?php  

class Manufacturer{

    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function getPrices(){
        $this->db->query('SELECT * FROM prices');
        $results = $this->db->resultSet();
        return $results;
    }

    public function getLastPrice(){
        $this->db->query('SELECT * FROM prices ORDER BY date DESC LIMIT 1');
        $result = $this->db->single();
        return $result;
    }

    public function getPreviousPrice(){
        $this->db->query('SELECT * FROM prices ORDER BY date DESC LIMIT 2');
        $result = $this->db->resultSet();
        return $result;
    }
    
    public function RemovePrice($id){
        $this->db->query('DELETE FROM prices WHERE priceid = :id');
        $this->db->bind(':id',$id);
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }




}


?>