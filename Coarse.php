<?php
class Coarse extends CI_Controller
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
			
			$this->form_validation->set_rules("coarse_name", "coarse_name", "trim|required");
		

			if($this->form_validation->run() == TRUE)
			{
				if($this->input->post('coarse_id') == '')
				  {
					$data 	=	array(
										'coarse_name' => $this->input->post('coarse_name')
											
									 );
 
						$result = 	$this->City_model->insert($data);
				   
				if($result)
					{
							$this->session->set_flashdata('message', 'Successfully Saved !!!');
							redirect(base_url('index.php/Coarse/index'),'refresh');
					}
                              
                  }
             else
				{
					$field_list 	=	array('coarse_name' => $this->input->post('coarse_name'));
    				$where 			= 	array('coarse_id' => $this->input->post('coarse_id'));
					$result 		= 	$this->City_model->update('coarse_master', $field_list, $where);
				
		         if($result)
			       {
				     $this->session->set_flashdata('message', 'Successfully Saved !!!');
				      redirect(base_url('index.php/Coarse/index'),'refresh');
			       }

			                 
                 }
             }
        }

     $field_list =  array('coarse_id' , 'coarse_name' , 'status');
     $where     =  array();
     $viewData['tablelist'] = $this->City_model->get_data($field_list, $where ,'coarse_master');
     $viewData['message']   =$this->session->flashdata('message');
     $this->load->view('Coarse_form',$viewData );

	}

	 function edit($coarse_id)
    {
    	$field_list = array('coarse_id', 'coarse_name', 'status');
    	$where 		= array('coarse_id' => $coarse_id);

    	$viewData['tabledata'] = $this->City_model->get_data($field_list ,$where, 'coarse_master');

		$field_list =array('coarse_id', 'coarse_name' ,'status');
		$where =array();
		$viewData['tablelist']=$this->City_model->get_data($field_list, $where,'coarse_master');
    
    	$this->load->view('Coarse_form', $viewData);

    }


   function delete($coarse_id)
    {
    	
    		$where   	= 	array('coarse_id'=>$coarse_id);
			$result 	= 	$this->City_model->delete('coarse_master', $where);
			if($result)
			{
				$this->session->set_flashdata('value', 'Delete Successfully !!!');
			}
			$field_list =array('coarse_id', 'coarse_name' ,'status');
			$where =array();
			$viewData['tablelist']=$this->City_model->get_data($field_list, $where,'coarse_master');
			$viewData['message']	=	$this->session->flashdata('message');
				$this->load->view('Coarse_form', $viewData);
				
		
    }
}