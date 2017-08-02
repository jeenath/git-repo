<?php
class Student_detail extends CI_Controller
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
			
		$this->form_validation->set_rules("name", "name", "trim|required");
		$this->form_validation->set_rules("fathername", "fathername", "trim|required");
		$this->form_validation->set_rules("dob", "dob", "trim|required");
		$this->form_validation->set_rules("gender_id", "gender_id", "trim|required");
		$this->form_validation->set_rules("coarse_id", "coarse_id", "trim|required");
		$this->form_validation->set_rules("addressline1", "addressline1", "trim|required");
		$this->form_validation->set_rules("addressline2", "addressline2", "trim|required");
		$this->form_validation->set_rules("city_id", "city_id", "trim|required");
		$this->form_validation->set_rules("area_id", "area_id", "trim|required");
		$this->form_validation->set_rules("pincode", "pincode", "trim|required");
		

			if($this->form_validation->run() == TRUE)
			{
			     if($this->input->post('student_id') == '')
			     {
					$data 	=	array(
										'name'        => $this->input->post('name'),
										'fathername'  => $this->input->post('fathername'),
										'dob'         => $this->input->post('dob'),
										'gender_id'   => $this->input->post('gender_id'),
										'coarse_id'   => $this->input->post('coarse_id'),
										'addressline1'=> $this->input->post('addressline1'),
										'addressline2'=> $this->input->post('addressline2'),
										'city_id'     => $this->input->post('city_id'),
										'area_id'     => $this->input->post('area_id'),
										'pincode'     => $this->input->post('pincode')

									 );
					
						$result = 	$this->City_model->insert($data);

		        if($result)
			       {
				     $this->session->set_flashdata('message', 'Successfully Saved !!!');
				     redirect(base_url('index.php/Student_detail/'),'refresh');
			       }
			   
                 }

            else
			      {

			       $field_list = array(
			       	                   'name'         => $this->input->post('name'),
		    		                   'fathername'   => $this->input->post('fathername'),
		    		                   'dob'          =>$this->input->post('dob'),
		    		                   'gender_id'    => $this->input->post('gender_id'),
		    		                   'coarse_id'    => $this->input->post('coarse_id'),
		    		                   'addressline1' => $this->input->post('addressline1'),
		    		                   'addressline2' => $this->input->post('addressline2'),
		    		                   'city_id'      => $this->input->post('city_id'),
		    		                   'area_id'      => $this->input->post('area_id'),
		    		                   'pincode'      => $this->input->post('pincode')

		    		                   );

    				$where 		= 	array('student_id'   => $this->input->post('student_id'));
					$result 	= 	$this->City_model->update('student_detail', $field_list, $where);
				
		         if($result)
			       {
				     $this->session->set_flashdata('message', 'Successfully Saved !!!');
				      redirect(base_url('index.php/Student_detail/index'),'refresh');
			       }

			                 
                   }
             }
         }

	  $field_list   = array('gender_id','gender_name');
	  $genderData   = $this->City_model->get_data('gender',$field_list,"");
	  $genderoption = array();
	         foreach ($genderData as $row)

	               {
	                 $genderoption[$row->gender_id]= $row->gender_name;
	               }

	  $viewData['genderData']= $genderoption;


	  $field_list   = array('coarse_id','coarse_name');
	  $coarseData   = $this->City_model->get_data('coarse_master',$field_list,"");
	  $coarseoption = array();
	        foreach ($coarseData as $row)

	               {
	                 $coarseoption[$row->coarse_id] = $row->coarse_name;
	               }

	  $viewData['coarseData']= $coarseoption;
 


      $field_list  = array('city_id','city_name');
      $cityData    = $this->City_model->get_data('City',$field_list,"");
      $cityoption  = array();
      foreach ($cityData as $row)

                   {
                     $cityoption[$row->city_id]= $row->city_name;
                   }

     $viewData['cityData']= $cityoption;
  
     $viewData['tablelist'] = $this->City_model->join_data();
     $viewData['message']   = $this->session->flashdata('message');
     $this->load->view('Student_form',$viewData );

     
    }

    function getarea()
    {
        $field_list     =   array(
                                        'area_id', 'area_name'
                                  );
        $where          =   array(
                                        'city_id' => $this->input->post('cityy_id') 
                                  );
        $areaData       =   $this->City_model->get_data('Area',$field_list, $where);
        $areaoption     =   array();
        foreach  ($areaData as $row)
        {
            $areaoption[$row->area_id]=  $row->area_name;
        }
       $extra          =   array(
                                        'id'         =>    'area_id',
                                        'onChange'   =>  'loadpincode()'
                                 );
        echo form_dropdown('area_id', $areaoption, '', $extra);
        

    }

     function loadpincode()
    {
        $field_list     =   array(
                                        'pincode'
                                  );
        $where          =   array(
                                        'area_id' => $this->input->post('area_id') 
                                  );
        $areaData       =   $this->City_model->get_data('Area',$field_list, $where);
        $areaoption     =   array();
        foreach  ($areaData as $row)
        {
            echo $row->pincode;
        }
    }

     function edit($student_id)

    {

	  $field_list = array('student_id', 'name' , 'fathername' , 'dob', 'gender_id','coarse_id', 'addressline1', 'addressline2', 'city_id', 'area_id', 'pincode', 'status');
	  $where 		= array('student_id' => $student_id);

	  $viewData['tabledata'] = $this->City_model->get_data( 'student_detail', $field_list ,$where);

        
	  $field_list   = array('gender_id','gender_name');
	  $genderData   = $this->City_model->get_data('gender',$field_list,"");
	  $genderoption = array();
	         foreach ($genderData as $row)

	               {
	                 $genderoption[$row->gender_id]= $row->gender_name;
	               }

	  $viewData['genderData']= $genderoption;


	  $field_list   = array('coarse_id','coarse_name');
	  $coarseData   = $this->City_model->get_data('coarse_master',$field_list,"");
	  $coarseoption = array();
	        foreach ($coarseData as $row)

	               {
	                 $coarseoption[$row->coarse_id] = $row->coarse_name;
	               }

	  $viewData['coarseData']= $coarseoption;
 


      $field_list  = array('city_id','city_name');
      $cityData    = $this->City_model->get_data('City',$field_list,"");
      $cityoption  = array();
            foreach ($cityData as $row)

                   {
                     $cityoption[$row->city_id]= $row->city_name;
                   }

     $viewData['cityData']= $cityoption;

     $tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class="mytable table table-bordered">');
		$this->table->set_template($tmpl);

		$this->table->set_heading('student_id', 'name' , 'fathername' , 'dob', 'gender_id', 'coarse_id', 'addressline1', 'addressline2', 'city_id', 'area_id', 'pincode','status');
        
		
  

		 $viewData['message']   = $this->session->flashdata('message');
         $viewData['tablelist'] = $this->City_model->join_data();
    	$this->load->view('Student_form', $viewData);

    }


     function delete($student_id)
    {
    	
    		$where   	= 	array('student_id'=>$student_id);
			$result 	= 	$this->City_model->delete('student_detail', $where);
			if($result)
			{
				$this->session->set_flashdata('value', 'Delete Successfully !!!');
			}
			$field_list =array('student_id', 'student_name' ,'status');
			$where      =array();
			$viewData['tablelist']  =   $this->City_model->get_data('student_detail',$field_list, $where);
			$viewData['message']	=	$this->session->flashdata('message');
				$this->load->view('Student_form', $viewData);
				
		
    }

     function get_data()
    { 
               
		//set table id in table open tag
		$tmpl = array('table_open' => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class="mytable table table-bordered">');
		$this->table->set_template($tmpl);

		$this->table->set_heading('student_id', 'name' , 'fathername' , 'dob', 'gender_id', 'coarse_id', 'addressline1', 'addressline2', 'city_id', 'area_id', 'pincode','status');
        
		$this->load->view('Student_form');
    }


    function datatable()

	{    

	    $this->datatables->select('a.student_id,a.name,a.fathername,a.dob,b.gender_name,c.coarse_name,a.addressline1,a.addressline2,d.city_name,e.area_name,a.pincode,a.status,b.gender_name,c.coarse_name, d.city_name, e.area_name' );
		$this->datatables->from('student_detail as a');
		$this->datatables->join('Area as e', 'a.area_id = e.area_id');
	 	$this->datatables->join('City as d', 'a.city_id = d.city_id');
		$this->datatables->join('gender as b', 'a.gender_id = b.gender_id');
		$this->datatables->join('coarse_master as c', 'a.coarse_id = c.coarse_id');
		
		$this->datatables->edit_column('a.student_id', '$1', 'get_buttons(a.student_id)');
	    echo $this->datatables->generate();
    }

  
}
