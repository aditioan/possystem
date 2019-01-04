<?php
require(APPPATH.'libraries/REST_Controller.php');
use Restserver\Libraries\REST_Controller;
 
class Penjualan_update_api extends REST_Controller {
	function __construct(){
        parent::__construct();	
        $this->load->model('penjualan_model');  
        $this->load->model('produk_model');
	}
 
    function index_get()
    {
    	if(!$this->get('id'))
        {
            $this->response(NULL, 400);
        }
 
        $penjualan = $this->penjualan_model->get_by_id( $this->get('id') );
         
        if($penjualan)
        {
            $this->response($penjualan, 200); // 200 being the HTTP response code
        }
 
        else
        {
            $this->response(NULL, 404);
        }
    }
 
    function index_put()
    {
        // create a new user and respond with a status/errors
    }
 
    function index_post()
    {
    	if(!$this->post())
        {
            $this->response(NULL, 400);
        }
        
        $data = $this->input->post();
        $penjualan = $this->produk_model->update_qty_min($data['id'],array('product_qty' => $data['qty']));
         
        if($penjualan)
        {
            $this->response($penjualan, 200); // 200 being the HTTP response code
        }
 
        else
        {
            $this->response(NULL, 404);
        }
    }
 
    function index_delete()
    {
        // delete a user and respond with a status/errors
    }
}