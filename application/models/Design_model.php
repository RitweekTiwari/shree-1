 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Design_model extends CI_Model {

	public function add($data)
	{
		// print_r($data); exit();
		$this->db->insert('design', $data);
	}
	public function get()
	{
    $sql = 'SELECT design.id, design.designName, design.designSeries, erc.desCode, erc.rate, design.stitch, design.dye, design.matching, src.sale_rate, design.htCattingRate, design.designPic, design.fabricName, design.barCode, design.designOn FROM design
            LEFT JOIN erc ON design.designName = erc.desName
            LEFT JOIN src ON src.fabName = design.fabricName AND src.fabCode = erc.desCode
            ORDER BY design.id DESC';
		$rec=$this->db->query($sql);
		return $rec->result();

	}
	public function edit($id,$data)
	{
		// print_r($data);
		// print_r($id);
		$this->db->where('id', $id);
		$this->db->update('design', $data);
		return true;
	}
	public function delete($id)
	{
		$this->db->where('id', $id);
     	$this->db->delete('design');
	}
	public function search($searchByCat,$searchValue)
	{
		$this->db->select('*');
		$this->db->from('design');
		$this->db->like($searchByCat, $searchValue);
		$rec=$this->db->get();
		return $rec->result_array();
		// print_r($searchValue);
		// print_r($this->db->last_query());

	}
  public function get_single_value_by_id($id)
  {
    $this->db->select('*');
    $this->db->from('design');
    // $this->db->like($searchByCat, $searchValue);
    $this->db->where('id',$id);
    $rec=$this->db->get();
    return $rec->row();
    // print_r($searchValue);
    // print_r($this->db->last_query());

  }

    public function get_multi_value_by_id($id)
  {
    $this->db->select('*');
    $this->db->from('design');
    $this->db->where('id',$id);
    $rec=$this->db->get();
    return $rec->row();
  }

  function get_design_exist($designName){
        $this->db->select('designName');
        $this->db->from('design');
        $this->db->where('designName',$designName);
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if($query->num_rows()>=1) {
            return true;
        }else{
            return false;
        }
    }
  function get_design_set_exist($data){
        $this->db->select('designName');
        $this->db->from('design');
        $this->db->where('designName',$data['design_name']);
        $this->db->where('designSeries',$data['designSeries']);
        $this->db->where('fabricName',$data['fabricName']);
        $query = $this->db->get();
        if($query->num_rows()>=1) {
            return true;
        }else{
            return false;
        }
    }
  //
  // public function delete_data($ids){
  // //  echo $ids;exit;
  //    $userid= explode(",",$ids){
  //      echo print_r($userid);exit;
  //       $this->db->delete('design', 'id' => $userid);
  //     }
  //       $this->db->last_query();exit;
  //
  //
  //    return 1;
  // }

  function select_value($table,$id){
    // echo $id.$table;exit;
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('id', $id);
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
    }


    public function delete_data($ids){
       $userid= explode(",", $ids);
       foreach ($userid as $value) {
        $this->db->delete('design', array('id' => $value));
          echo $this->db->last_query();exit;
        }
       return 1;
    }
function getLastId(){
    			$this->db->select("barCode");
    			$this->db->from('design');
    			$this->db->order_by('barCode','DESC');
    			$this->db->limit(1);
    			$query = $this->db->get();
    			$query = $query->row();
    			return $query;
    		}

}

/* End of file Branch_model.php */
/* Location: ./application/models/Branch_model.php */
 ?>
