<?php
class Area extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('City_model');
		
	}

	function index()
	{     
        
		if (!empty($_POST))
		{
			
			$this->form_validation->set_rules("city_id", "CityName", "trim|required");
			$this->form_validation->set_rules("area_name", "area Name", "trim|required");
			$this->form_validation->set_rules("pincode", "pincode", "trim|required");
			

			if($this->form_validation->run() == TRUE)
			{
			     if($this->input->post('area_id') == '')
			     {
					$data 	=	array(
										'city_id'   => $this->input->post('city_id'),
										'area_name' => $this->input->post('area_name'),
										'pincode'   => $this->input->post('pincode')
										
									 );
					
						$result = 	$this->City_model->insert($data);

		        if($result)
			       {
				     $this->session->set_flashdata('message', 'Successfully Saved !!!');
				     redirect(base_url('index.php/Area/'),'refresh');
			       }
			   
                 }

               else
				   {

			    	$field_list 	=	array('area_name' => $this->input->post('area_name'),
			    		                       'city_id'  => $this->input->post('city_id'),
			    		                       'pincode'  =>$this->input->post('pincode'));
    				$where 			= 	array('area_id'   => $this->input->post('area_id'));
					$result 		= 	$this->City_model->update('Area', $field_list, $where);
				
		         if($result)
			       {
				     $this->session->set_flashdata('message', 'Successfully Saved !!!');
				      redirect(base_url('index.php/Area/index'),'refresh');
			       }

			                 
                   }
             }
         }

     $field_list =  array('area_id', 'city_id' , 'area_name' , 'pincode');
     $where      =  array();
     $viewData['tablelist'] = $this->City_model->join_data();
     $viewData['dropdown']  = $this->City_model->get_dropdown();
     $viewData['message']   = $this->session->flashdata('message');
     $this->load->view('Area_form',$viewData );

}

      function edit($area_id)
    {
    	$field_list            = array('area_id', 'city_id' , 'area_name' , 'pincode');
    	$where 		           = array('area_id' => $area_id);
    	$viewData['tabledata'] = $this->City_model->get_data($field_list ,$where, 'Area');
	//	$field_list            =array('area_id', 'city_id' , 'area_name' , 'pincode');
	//	$where                 =array();
        $viewData['tablelist'] = $this->City_model->join_data();
	//	$viewData['dropdown']  =$this->City_model->get_dropdown();
    	$this->load->view('Area_form', $viewData);

    }


   function delete($area_id)

    {
    	
    		$where   	= 	array('area_id'=> $area_id);
			$result 	= 	$this->City_model->delete('Area', $where);
			if($result)
			{
				$this->session->set_flashdata('value', 'Delete Successfully !!!');
			}
			$field_list =array('area_id', 'city_id' , 'area_name' , 'pincode');
			$where =array();
			$viewData['tablelist']  =$this->City_model->get_data($field_list, $where,'Area');
			$viewData['dropdown']  =$this->City_model->get_dropdown();
			$viewData['message']	=	$this->session->flashdata('message');
				$this->load->view('Area_form', $viewData);
				
		
    }

     

		
}


       



 
