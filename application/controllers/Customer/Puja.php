<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Puja extends CI_Controller
{


	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Kolkata");
		$this->load->library("pagination");
        $this->load->library('form_validation');
	}

    public function nodeserverapi($end_point='',$method='POST',$data)
    {
        // $data = json_encode($data);
        return json_decode($this->applib->node_api_curl($end_point,$method,json_encode($data),true));
    }

    public function index()
    {
        // print_r($this->session->userdata());
        // die;

        if (!isset ($_GET['page']) ) {  
            $page = 1;
        } else {  
            $page = empty($_GET['page'])?1:intval($_GET['page']);
        }
        $limit=20;

		$template['page'] = CUSTOMER_VIEW.'/puja/index';
		$template['page_title'] = "Shaktipeethdigital Pooja";
        $template['limit']=$limit;

        $offset = ($page-1) * $limit;  

        $template['offset']=$offset;


        $req = (object)[
            'limit'=>$limit,
            'offset'=>$offset
        ];
        $req_res = $this->nodeserverapi('fetch_pujas','POST',$req);
        // print_r($req_res);die;
        if(!$req_res->status){
            $this->session->set_flashdata('message', array('message' => $req_res->message, 'class' => 'danger'));
            return redirect($this->agent->referrer());
        }
    // //   print_r($req_res);die;

           // How many pages will there be
        $pages = ceil($req_res->count / $limit);
        $template['number_of_pages']=$pages;
        $template['current_page']=!isset($_GET['page']) ? 1 : $_GET['page'];

        $template['self_url'] = base_url().'pooja-list';
        $template['pujadata'] = $req_res->data;
		$this->load->view( 'template', $template);
    }


    public function puja_details($id)
    {
        $req = [
            'puja_id'=>$id
        ];
        $req_res = $this->nodeserverapi('fetch_puja_review_locations_details','POST',$req);
        if(!$req_res->status){
            $this->session->set_flashdata('message', array('message' => $req_res->message, 'class' => 'danger'));
            return redirect($this->agent->referrer());
        }
        if(isset($_GET['la'])){
            $location_id = intval($_GET['la']);
            $req2 = [
                'location_id'=>$location_id,
                'puja_id'=>$id
            ];
            $req_res2 = $this->nodeserverapi('fetch_puja_venues','POST',$req2);
            $template['venues'] = isset($req_res2->data) ? $req_res2->data : [];
        }else{
            $template['venues'] = [];
        }
        $template['pujadata']= $req_res;
        $template['self_url'] = base_url().'pooja-details/'.$id.'';
        $template['page'] = CUSTOMER_VIEW.'/puja/puja_details';
		$template['page_title'] = "Shaktipeethdigital Pooja Details";
        $this->load->view( 'template', $template);
    }
}
