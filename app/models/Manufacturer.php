<?php  

class Manufacturer{

    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function getPrices($id){
        $this->db->query('SELECT * FROM prices WHERE manufacturerid = :id');
        $this->db->bind(':id',$id);
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

    public function AddPrices($data){
        $this->db->query('INSERT INTO prices (name,type,price,manufacturerid) VALUES (:name,:type,:price,:manufacturerid)');
        $this->db->bind(':name','Corn');
        $this->db->bind(':type',$data['type']);
        $this->db->bind(':price',$data['price']);
        $this->db->bind(':manufacturerid',$_SESSION['user_id']);
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function UpdateLastPrice($data){
        $this->db->query('UPDATE prices SET price = :price WHERE priceid = :priceid');
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':priceid', $data['priceid']);
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }






}


?>