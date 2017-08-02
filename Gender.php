<?php
class Gender extends CI_Controller
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
			
			$this->form_validation->set_rules("gender_name", "gender_name", "trim|required");
		

			if($this->form_validation->run() == TRUE)
			{
				if($this->input->post('gender_id') == '')
				  {
					$data 	=	array(   
										'gender_name' => $this->input->post('gender_name')
											
									 );
 
						$result = 	$this->City_model->insert($data);
				   
				if($result)
					{
							$this->session->set_flashdata('message', 'Successfully Saved !!!');
							redirect(base_url('index.php/Gender/index'),'refresh');
					}
                              
                  }
             else
				{
					$field_list 	=	array(
						                      'gender_name' => $this->input->post('gender_name'));
    				$where 			= 	array('gender_id' => $this->input->post('gender_id'));
					$result 		= 	$this->City_model->update('gender', $field_list, $where);
				
		         if($result)
			       {
				     $this->session->set_flashdata('message', 'Successfully Saved !!!');
				      redirect(base_url('index.php/Gender/index'),'refresh');
			       }

			                 
                 }
             }
        }

     $field_list =  array('gender_id' , 'gender_name' , 'status');
     $where     =  array();
     $viewData['tablelist'] = $this->City_model->get_data('gender',$field_list, $where);
     $viewData['message']   =$this->session->flashdata('message');
     $this->load->view('Gender_form',$viewData );

	}

	 function edit($gender_id)
    {
    	$field_list = array('gender_id', 'gender_name', 'status');
    	$where 		= array('gender_id' => $gender_id);

    	$viewData['tabledata'] = $this->City_model->get_data($field_list ,$where, 'gender');

		$field_list =array('gender_id', 'gender_name' ,'status');
		$where =array();
		$viewData['tablelist']=$this->City_model->get_data($field_list, $where,'gender');
    
    	$this->load->view('Gender_form',$viewData);

    }

    function delete($gender_id)
    {
    	
    		$where   	= 	array('gender_id'=>$gender_id);
			$result 	= 	$this->City_model->delete('gender', $where);
			if($result)
			{
				$this->session->set_flashdata('value', 'Delete Successfully !!!');
			}
			$field_list =array('gender_id', 'gender_name' ,'status');
			$where =array();
			$viewData['tablelist']=$this->City_model->get_data('gender',$field_list, $where);
			$viewData['message']	=	$this->session->flashdata('message');
				$this->load->view('Gender_form', $viewData);
				
		
    }
}

