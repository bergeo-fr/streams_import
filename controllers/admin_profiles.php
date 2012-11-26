<?php defined('BASEPATH') or exit('No direct script access allowed');

class Admin_profiles extends Admin_Controller
{
    protected $section = 'profiles';
    protected $stream_slug = 'profiles';
    protected $namespace = 'streams_import';
    public function __construct()
    {
        parent::__construct();

		// Load Drivers
		$this->load->driver('Streams');
        $this->lang->load('streams_import');
        $this->load->library('streams');
        $this->load->model('streams_core/streams_m');
        $this->load->library(array('form_validation', 'streams_core/Fields'));
     /*   $this->load->helper('agency_management');
        $this->load->library('import_management');*/
    }

    public function index()
    {

         $params = array(
            'stream'    => $this->stream_slug,
            'namespace' => $this->namespace,
           //'where'        => $base_where
        );
         $request_entry = $this->streams->entries->get_entries($params);

		$this->template
             ->set('entries', $request_entry)                
             ->set('section', $this->section)              
             ->set('namespace', $this->namespace) 
             ->set('title', lang($this->namespace.':title:'.$this->section.':index'));

        $this->template->build('admin/index');
    }

     public function create()
    {
    /*    // Get stream
        $stream = $this->streams->stream_obj($this->stream_slug, $this->namespace);
        $stream_fields = $this->streams_m->get_stream_fields($stream->id);

        $data->fields=    $this->fields->build_form($stream, 'new', null, false, false, null,null, null);
        var_dump($data->fields);
        die();
        $this->template->build('admin/profiles/create',$data);*/
      /*  if ( ! $stream) $this->log_error('invalid_stream', 'entries_table');

        // -------------------------------------
        // Get Header Fields
        // -------------------------------------
        
        $stream_fields = $CI->streams_m->get_stream_fields($stream->id);*/



        $extra = array('title' =>  lang($this->namespace.':title:'.$this->section.':edit'),
        'success_message' => lang($this->namespace.':messages:'.$this->section.':edit:success'),
        'failure_message' => lang($this->namespace.':messages:'.$this->section.':edit:error'),
        'return'          => 'admin/'.$this->namespace.'/'.$this->section   );

       $data->form =   $this->streams->cp->entry_form($this->section, $this->namespace, $mode = 'new', $entry = null, $view_override = false, $extra, $skips = array());
        
        
       $this->template->build('admin/profiles/create',$data);

    }

    public function edit($id)
    {

        $extra = array('title' =>  lang($this->namespace.':title:'.$this->section.':edit'),
        'success_message' => lang($this->namespace.':messages:'.$this->section.':edit:success'),
        'failure_message' => lang($this->namespace.':messages:'.$this->section.':edit:error'),
        'return'          => 'admin/'.$this->namespace.'/'.$this->section   );

        echo $this->streams->cp->entry_form($this->section, $this->namespace, $mode = 'edit', $entry = $id, $view_override = true, $extra, $skips = array());
    }


    public function delete($id)
    {

        if($this->streams->entries->delete_entry($id, $this->section, $this->namespace)){
            $this->session->set_flashdata('success', lang($this->namespace.':messages:'.$this->section.':success:delete'));
        }else{
            $this->session->set_flashdata('error', lang($this->namespace.':messages:'.$this->section.':failure:delete'));
        }
        redirect('admin/'.$this->namespace.'/'.$this->section);
        
    }


}
?>