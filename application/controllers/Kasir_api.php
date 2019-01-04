<?php
require(APPPATH.'libraries/REST_Controller.php');
use Restserver\Libraries\REST_Controller;
 
class Kasir_api extends REST_Controller {
	function __construct(){
        parent::__construct();	
        $this->load->model('produk_model');
	}
 
    function index_get()
    {
    	if(!$this->get('id'))
        {
            $this->response(NULL, 400);
        }
 
        $produk = $this->produk_model->get_by_id( $this->get('id') );
         
        if($produk)
        {
            $this->response($produk, 200); // 200 being the HTTP response code
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
    	if(!$this->post('id'))
        {
            $this->response(NULL, 400);
        }
 
        $produk = $this->produk_model->get_by_id( $this->post('id') );
         
        if($produk)
        {
            $this->response($produk, 200); // 200 being the HTTP response code
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