<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Items extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	 
	 public function __construct(){
           parent::__construct();
           $this->load->database();
	 }
	public function index()
	{
		$this->show_tree();
	}
	
	function show_tree()
    {
        $this->form_validation->set_error_delimiters("", "");
         $this->form_validation->set_rules('node', 'node ', 'trim|required');
        //$this->load->view('messaging');
        if($this->form_validation->run()== false){
            $this->load->view('show_tree');
        }else{
            redirect('show_tree');
        }
    }
	
	 function tree_all() {

        $result = $this->db->query("SELECT  id, name,name as text, parent_id FROM categories  ")->result_array();
            foreach ($result as $row) {
                $data[] = $row;
            }
            return $data;
    }
	
	function getChildren()
    {
        $result = $this->tree_all();

        $itemsByReference = array();

		// Build array of item references:
        foreach($result as $key => &$item) {
            $itemsByReference[$item['id']] = &$item;
            // Children array:
            $itemsByReference[$item['id']]['children'] = array();
            // Empty data class (so that json_encode adds "data: {}" )
            $itemsByReference[$item['id']]['data'] = new StdClass();
        }

		// Set items as children of the relevant parent item.
        foreach($result as $key => &$item)
            if($item['parent_id'] && isset($itemsByReference[$item['parent_id']]))
                $itemsByReference [$item['parent_id']]['children'][] = &$item;

		// Remove items that were added to parents elsewhere:
        foreach($result as $key => &$item) {
            if($item['parent_id'] && isset($itemsByReference[$item['parent_id']]))
                unset($result[$key]);
        }
        foreach ($result as $row) {
            $data[] = $row;
        }

		// Encode:
        echo json_encode($data);
    }
	
}
