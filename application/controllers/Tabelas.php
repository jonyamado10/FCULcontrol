<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tabelas extends CI_Controller {

  function __contruct(){
    parent::__contruct();
        $this->load->model('Users_model');


  }

  public function alunos()
     {
          $this->load->model('Users_model');
          // Datatables Variables
          $draw = intval($this->input->get("draw"));
          $start = intval($this->input->get("start"));
          $length = intval($this->input->get("length"));


          $alunos = $this->Users_model->get_alunos();

          $data = array();

          foreach($alunos->result() as $r) {

               $data[] = array(
                    $r->num_aluno,
                    $r->nome,
                    $r->email,
                    $r->num_cc ,
                    $r->departamento
               );
          }
          $total_alunos = $this->Users_model->get_total_alunos();
          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $total_alunos,
                 "recordsFiltered" => $total_alunos,
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
      public function docentes()
     {
          $this->load->model('Users_model');
          // Datatables Variables
          $draw = intval($this->input->get("draw"));
          $start = intval($this->input->get("start"));
          $length = intval($this->input->get("length"));

          $docentes = $this->Users_model->get_docentes();

          $data = array();

          foreach($docentes->result() as $r) {

               $data[] = array(
                    $r->num_funcionario,
                    $r->nome,
                    $r->email,
                    $r->num_cc ,
                    $r->departamento
               );
          }
          $total_docentes = $this->Users_model->get_total_docentes();
          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $total_docentes,
                 "recordsFiltered" => $total_docentes,
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }

    
      public function acessos_user_aluno()
     {
           $this->load->model('Acessos_model');

          $columns = array( 
                              0 =>'num_aluno', 
                              1 =>'nome',
                              2=> 'data',
                              3=> 'hora',
                              4=> 'porta',
                              5=> 'sentido'
                          );

          $limit = $this->input->post('length');
          $start = $this->input->post('start');
          $order = $columns[$this->input->post('order')[0]['column']];
          $dir = $this->input->post('order')[0]['dir'];
    
          $totalData = $this->Acessos_model->acessos_user_aluno_count();
              
          $totalFiltered = $totalData; 

          $columns_search = array();
          if( !empty($this->input->post('columns')[0]['search']['value']) ){
            $columns_search[$this->input->post('columns')[0]['data']] = $this->input->post('columns')[0]['search']['value'];
          }
          if( !empty($this->input->post('columns')[1]['search']['value']) ){
            $columns_search[$this->input->post('columns')[1]['data']] = $this->input->post('columns')[1]['search']['value'];
          }
          if( !empty($this->input->post('columns')[2]['search']['value']) ){
            $columns_search[$this->input->post('columns')[2]['data']] = $this->input->post('columns')[2]['search']['value'];
          }
          if( !empty($this->input->post('columns')[3]['search']['value']) ){

            $columns_search[$this->input->post('columns')[3]['data']] = $this->input->post('columns')[3]['search']['value'];
          }
          if( !empty($this->input->post('columns')[4]['search']['value']) ){
            $columns_search[$this->input->post('columns')[4]['data']] = $this->input->post('columns')[4]['search']['value'];
          }  
          if( !empty($this->input->post('columns')[5]['search']['value']) ){
            $columns_search[$this->input->post('columns')[5]['data']] = $this->input->post('columns')[5]['search']['value'];
          }  
  

          if(empty($this->input->post('search')['value']))
          {            
              $acessos = $this->Acessos_model->get_acessos_user_aluno($limit,$start,$order,$dir,$columns_search);
              if(!empty(array_values($columns_search))){
                $totalFiltered = $this->Acessos_model->acessos_user_aluno_search_column_count($columns_search);
              }
    
          }
          else {
              $search = $this->input->post('search')['value']; 

              $acessos =  $this->Acessos_model->acessos_user_aluno_search($limit,$start,$search,$order,$dir,$columns_search);

              $totalFiltered = $this->Acessos_model->acessos_user_aluno_search_count($search,$columns_search);
          }

          $data = array();
          if(!empty($acessos))
          {
              foreach ($acessos as $acesso)
              {

                  $nestedData['num_aluno'] = $acesso->num_aluno;
                  $nestedData['nome'] = $acesso->nome;
                  $nestedData['data'] = $acesso->data;
                  $nestedData['hora'] = $acesso->hora;
                  $nestedData['porta'] = $acesso->porta;
                  $nestedData['sentido'] = $acesso->sentido;
                 

                  $data[] = $nestedData;

              }
          }
            
          $json_data = array(
                      "draw"            => intval($this->input->post('draw')),  
                      "recordsTotal"    => intval($totalData),  
                      "recordsFiltered" => intval($totalFiltered), 
                      "data"            => $data   
                      );
              
          echo json_encode($json_data); 
     }

      public function acessos_user_docente()
     {
      $this->load->model('Acessos_model');

      $columns = array( 
                            0 =>'num_funcionario', 
                            1 =>'nome',
                            2=> 'data',
                            3=> 'hora',
                            4=> 'porta',
                            5=> 'sentido'
                        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
  
        $totalData = $this->Acessos_model->acessos_user_docente_count();
            
        $totalFiltered = $totalData; 

        $columns_search = array();
        if( !empty($this->input->post('columns')[0]['search']['value']) ){
          $columns_search[$this->input->post('columns')[0]['data']] = $this->input->post('columns')[0]['search']['value'];
        }
        if( !empty($this->input->post('columns')[1]['search']['value']) ){
          $columns_search[$this->input->post('columns')[1]['data']] = $this->input->post('columns')[1]['search']['value'];
        }
        if( !empty($this->input->post('columns')[2]['search']['value']) ){
          $columns_search[$this->input->post('columns')[2]['data']] = $this->input->post('columns')[2]['search']['value'];
        }
        if( !empty($this->input->post('columns')[3]['search']['value']) ){

          $columns_search[$this->input->post('columns')[3]['data']] = $this->input->post('columns')[3]['search']['value'];
        }
        if( !empty($this->input->post('columns')[4]['search']['value']) ){
          $columns_search[$this->input->post('columns')[4]['data']] = $this->input->post('columns')[4]['search']['value'];
        }  
        if( !empty($this->input->post('columns')[5]['search']['value']) ){
          $columns_search[$this->input->post('columns')[5]['data']] = $this->input->post('columns')[5]['search']['value'];
        }  

        if(empty($this->input->post('search')['value']))
        {            
            $acessos = $this->Acessos_model->get_acessos_user_docente($limit,$start,$order,$dir,$columns_search);
            if(!empty(array_values($columns_search))){
              $totalFiltered = $this->Acessos_model->acessos_user_docente_search_column_count($columns_search);
            }
        }
        else {
            $search = $this->input->post('search')['value']; 

            $acessos =  $this->Acessos_model->acessos_user_docente_search($limit,$start,$search,$order,$dir,$columns_search);

            $totalFiltered = $this->Acessos_model->acessos_user_docente_search_count($search,$columns_search);
        }

        $data = array();
        if(!empty($acessos))
        {
            foreach ($acessos as $acesso)
            {

                $nestedData['num_funcionario'] = $acesso->num_funcionario;
                $nestedData['nome'] = $acesso->nome;
                $nestedData['data'] = $acesso->data;
                $nestedData['hora'] = $acesso->hora;
                $nestedData['porta'] = $acesso->porta;
                $nestedData['sentido'] = $acesso->sentido;

                $data[] = $nestedData;

            }
        }
          
        $json_data = array(
                    "draw"            => intval($this->input->post('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        echo json_encode($json_data); 
     }
  //ACESSOS ALUNOS 
  public function acessos_alunos()
  {
          $this->load->model('Acessos_model');

          $columns = array( 
                              0 =>'num_aluno', 
                              1 =>'nome',
                              2=> 'data',
                              3=> 'hora',
                              4=> 'porta',
                              5=> 'sentido',
                              6=> 'passou_cartao',
                          );

          $limit = $this->input->post('length');
          $start = $this->input->post('start');
          $order = $columns[$this->input->post('order')[0]['column']];
          $dir = $this->input->post('order')[0]['dir'];
    
          $totalData = $this->Acessos_model->acessos_alunos_count();
              
          $totalFiltered = $totalData; 

          $columns_search = array();
          if( !empty($this->input->post('columns')[0]['search']['value']) ){
            $columns_search[$this->input->post('columns')[0]['data']] = $this->input->post('columns')[0]['search']['value'];
          }
          if( !empty($this->input->post('columns')[1]['search']['value']) ){
            $columns_search[$this->input->post('columns')[1]['data']] = $this->input->post('columns')[1]['search']['value'];
          }
          if( !empty($this->input->post('columns')[2]['search']['value']) ){
            $columns_search[$this->input->post('columns')[2]['data']] = $this->input->post('columns')[2]['search']['value'];
          }
          if( !empty($this->input->post('columns')[3]['search']['value']) ){

            $columns_search[$this->input->post('columns')[3]['data']] = $this->input->post('columns')[3]['search']['value'];
          }
          if( !empty($this->input->post('columns')[4]['search']['value']) ){
            $columns_search[$this->input->post('columns')[4]['data']] = $this->input->post('columns')[4]['search']['value'];
          }  
          if( !empty($this->input->post('columns')[5]['search']['value']) ){
            $columns_search[$this->input->post('columns')[5]['data']] = $this->input->post('columns')[5]['search']['value'];
          }  
          if( !empty($this->input->post('columns')[6]['search']['value']) ){
            $columns_search[$this->input->post('columns')[6]['data']] = $this->input->post('columns')[6]['search']['value'];
          }    

          if(empty($this->input->post('search')['value']))
          {            
              $acessos = $this->Acessos_model->get_acessos_alunos($limit,$start,$order,$dir,$columns_search);
              if(!empty(array_values($columns_search))){
                $totalFiltered = $this->Acessos_model->acessos_alunos_search_column_count($columns_search);
              }
    
          }
          else {
              $search = $this->input->post('search')['value']; 

              $acessos =  $this->Acessos_model->acessos_alunos_search($limit,$start,$search,$order,$dir,$columns_search);

              $totalFiltered = $this->Acessos_model->acessos_alunos_search_count($search,$columns_search);
          }

          $data = array();
          if(!empty($acessos))
          {
              foreach ($acessos as $acesso)
              {

                  $nestedData['num_aluno'] = $acesso->num_aluno;
                  $nestedData['nome'] = $acesso->nome;
                  $nestedData['data'] = $acesso->data;
                  $nestedData['hora'] = $acesso->hora;
                  $nestedData['porta'] = $acesso->porta;
                  $nestedData['sentido'] = $acesso->sentido;
                  $nestedData['passou_cartao'] = "Sim";

                  $data[] = $nestedData;

              }
          }
            
          $json_data = array(
                      "draw"            => intval($this->input->post('draw')),  
                      "recordsTotal"    => intval($totalData),  
                      "recordsFiltered" => intval($totalFiltered), 
                      "data"            => $data   
                      );
              
          echo json_encode($json_data); 
    }
  public function acessos_alunos_corrigidos()
  {
          $this->load->model('Acessos_model');

          $columns = array( 
                              0 =>'num_aluno', 
                              1 =>'nome',
                              2=> 'data',
                              3=> 'hora',
                              4=> 'porta',
                              5=> 'sentido',
                              6=> 'passou_cartao',
                          );

          $limit = $this->input->post('length');
          $start = $this->input->post('start');
          $order = $columns[$this->input->post('order')[0]['column']];
          $dir = $this->input->post('order')[0]['dir'];
    
          $totalData = $this->Acessos_model->acessos_alunos_corrigidos_count();
              
          $totalFiltered = $totalData; 
          $columns_search = array();
          if( !empty($this->input->post('columns')[0]['search']['value']) ){
            $columns_search[$this->input->post('columns')[0]['data']] = $this->input->post('columns')[0]['search']['value'];
          }
          if( !empty($this->input->post('columns')[1]['search']['value']) ){
            $columns_search[$this->input->post('columns')[1]['data']] = $this->input->post('columns')[1]['search']['value'];
          }
          if( !empty($this->input->post('columns')[2]['search']['value']) ){
            $columns_search[$this->input->post('columns')[2]['data']] = $this->input->post('columns')[2]['search']['value'];
          }
          if( !empty($this->input->post('columns')[3]['search']['value']) ){

            $columns_search[$this->input->post('columns')[3]['data']] = $this->input->post('columns')[3]['search']['value'];
          }
          if( !empty($this->input->post('columns')[4]['search']['value']) ){
            $columns_search[$this->input->post('columns')[4]['data']] = $this->input->post('columns')[4]['search']['value'];
          }  
          if( !empty($this->input->post('columns')[5]['search']['value']) ){
            $columns_search[$this->input->post('columns')[5]['data']] = $this->input->post('columns')[5]['search']['value'];
          }  
          if( !empty($this->input->post('columns')[6]['search']['value']) ){
            $columns_search[$this->input->post('columns')[6]['data']] = $this->input->post('columns')[6]['search']['value'];
          }    
          if(empty($this->input->post('search')['value']))
          {            
              $acessos = $this->Acessos_model->acessos_alunos_corrigidos($limit,$start,$order,$dir,$columns_search);
              if(!empty(array_values($columns_search))){
                $totalFiltered = $this->Acessos_model->acessos_alunos_corrigidos_search_column_count($columns_search);
              }
          }
          else {
              $search = $this->input->post('search')['value']; 

              $acessos =  $this->Acessos_model->acessos_alunos_corrigidos_search($limit,$start,$search,$order,$dir,$columns_search);

              $totalFiltered = $this->Acessos_model->acessos_alunos_corrigidos_search_count($search,$columns_search);
          }

          $data = array();
          if(!empty($acessos))
          {
              foreach ($acessos as $acesso)
              {

                  $nestedData['num_aluno'] = $acesso->num_aluno;
                  $nestedData['nome'] = $acesso->nome;
                  $nestedData['data'] = $acesso->data;
                  $nestedData['hora'] = $acesso->hora;
                  $nestedData['porta'] = $acesso->porta;
                  $nestedData['sentido'] = $acesso->sentido;
                  $nestedData['passou_cartao'] = $acesso->passou_cartao;

                  $data[] = $nestedData;

              }
          }
            
          $json_data = array(
                      "draw"            => intval($this->input->post('draw')),  
                      "recordsTotal"    => intval($totalData),  
                      "recordsFiltered" => intval($totalFiltered), 
                      "data"            => $data   
                      );
              
          echo json_encode($json_data); 
    }
  //-------------------------------------------
  //ACESSOS DOCENTES
  public function acessos_docentes()
{
    $this->load->model('Acessos_model');

    $columns = array( 
                            0 =>'num_funcionario', 
                            1 =>'nome',
                            2=> 'data',
                            3=> 'hora',
                            4=> 'porta',
                            5=> 'sentido',
                            6=> 'passou_cartao',
                        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
  
        $totalData = $this->Acessos_model->acessos_docentes_count();
            
        $totalFiltered = $totalData; 


        $columns_search = array();
        if( !empty($this->input->post('columns')[0]['search']['value']) ){
          $columns_search[$this->input->post('columns')[0]['data']] = $this->input->post('columns')[0]['search']['value'];
        }
        if( !empty($this->input->post('columns')[1]['search']['value']) ){
          $columns_search[$this->input->post('columns')[1]['data']] = $this->input->post('columns')[1]['search']['value'];
        }
        if( !empty($this->input->post('columns')[2]['search']['value']) ){
          $columns_search[$this->input->post('columns')[2]['data']] = $this->input->post('columns')[2]['search']['value'];
        }
        if( !empty($this->input->post('columns')[3]['search']['value']) ){

          $columns_search[$this->input->post('columns')[3]['data']] = $this->input->post('columns')[3]['search']['value'];
        }
        if( !empty($this->input->post('columns')[4]['search']['value']) ){
          $columns_search[$this->input->post('columns')[4]['data']] = $this->input->post('columns')[4]['search']['value'];
        }  
        if( !empty($this->input->post('columns')[5]['search']['value']) ){
          $columns_search[$this->input->post('columns')[5]['data']] = $this->input->post('columns')[5]['search']['value'];
        }  
        if( !empty($this->input->post('columns')[6]['search']['value']) ){
          $columns_search[$this->input->post('columns')[6]['data']] = $this->input->post('columns')[6]['search']['value'];
        }

        if(empty($this->input->post('search')['value']))
        {            
            $acessos = $this->Acessos_model->get_acessos_docentes($limit,$start,$order,$dir,$columns_search);
            if(!empty(array_values($columns_search))){
              $totalFiltered = $this->Acessos_model->acessos_docentes_search_column_count($columns_search);
            }
        }
        else {
            $search = $this->input->post('search')['value']; 

            $acessos =  $this->Acessos_model->acessos_docentes_search($limit,$start,$search,$order,$dir,$columns_search);

            $totalFiltered = $this->Acessos_model->acessos_docentes_search_count($search,$columns_search);
        }

        $data = array();
        if(!empty($acessos))
        {
            foreach ($acessos as $acesso)
            {

                $nestedData['num_funcionario'] = $acesso->num_funcionario;
                $nestedData['nome'] = $acesso->nome;
                $nestedData['data'] = $acesso->data;
                $nestedData['hora'] = $acesso->hora;
                $nestedData['porta'] = $acesso->porta;
                $nestedData['sentido'] = $acesso->sentido;
                $nestedData['passou_cartao'] = "Sim";

                $data[] = $nestedData;

            }
        }
          
        $json_data = array(
                    "draw"            => intval($this->input->post('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        echo json_encode($json_data); 
  }
public function acessos_docentes_corrigidos()
{
    $this->load->model('Acessos_model');

    $columns = array( 
                            0 =>'num_funcionario', 
                            1 =>'nome',
                            2=> 'data',
                            3=> 'hora',
                            4=> 'porta',
                            5=> 'sentido',
                            6=> 'passou_cartao',
                        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
  
        $totalData = $this->Acessos_model->acessos_docentes_corrigidos_count();
            
        $totalFiltered = $totalData; 
        $columns_search = array();
        if( !empty($this->input->post('columns')[0]['search']['value']) ){
          $columns_search[$this->input->post('columns')[0]['data']] = $this->input->post('columns')[0]['search']['value'];
        }
        if( !empty($this->input->post('columns')[1]['search']['value']) ){
          $columns_search[$this->input->post('columns')[1]['data']] = $this->input->post('columns')[1]['search']['value'];
        }
        if( !empty($this->input->post('columns')[2]['search']['value']) ){
          $columns_search[$this->input->post('columns')[2]['data']] = $this->input->post('columns')[2]['search']['value'];
        }
        if( !empty($this->input->post('columns')[3]['search']['value']) ){

          $columns_search[$this->input->post('columns')[3]['data']] = $this->input->post('columns')[3]['search']['value'];
        }
        if( !empty($this->input->post('columns')[4]['search']['value']) ){
          $columns_search[$this->input->post('columns')[4]['data']] = $this->input->post('columns')[4]['search']['value'];
        }  
        if( !empty($this->input->post('columns')[5]['search']['value']) ){
          $columns_search[$this->input->post('columns')[5]['data']] = $this->input->post('columns')[5]['search']['value'];
        }  
        if( !empty($this->input->post('columns')[6]['search']['value']) ){
          $columns_search[$this->input->post('columns')[6]['data']] = $this->input->post('columns')[6]['search']['value'];
        } 
        if(empty($this->input->post('search')['value']))
        {            
            $acessos = $this->Acessos_model->acessos_docentes_corrigidos($limit,$start,$order,$dir,$columns_search);
            if(!empty(array_values($columns_search))){
              $totalFiltered = $this->Acessos_model->acessos_docentes_corrigidos_search_column_count($columns_search);
            }
        }
        else {
            $search = $this->input->post('search')['value']; 

            $acessos =  $this->Acessos_model->acessos_docentes_corrigidos_search($limit,$start,$search,$order,$dir,$columns_search);

            $totalFiltered = $this->Acessos_model->acessos_docentes_corrigidos_search_count($search,$columns_search);
        }

        $data = array();
        if(!empty($acessos))
        {
            foreach ($acessos as $acesso)
            {

                $nestedData['num_funcionario'] = $acesso->num_funcionario;
                $nestedData['nome'] = $acesso->nome;
                $nestedData['data'] = $acesso->data;
                $nestedData['hora'] = $acesso->hora;
                $nestedData['porta'] = $acesso->porta;
                $nestedData['sentido'] = $acesso->sentido;
                $nestedData['passou_cartao'] = $acesso->passou_cartao;

                $data[] = $nestedData;

            }
        }
          
        $json_data = array(
                    "draw"            => intval($this->input->post('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        echo json_encode($json_data); 
  } 
    //-------------------------------------------
  //ACESSOS NAO DOCENTES
  public function acessos_naoDocentes()
{
    $this->load->model('Acessos_model');

    $columns = array( 
                            0 =>'num_funcionario', 
                            1 =>'nome',
                            2=> 'data',
                            3=> 'hora',
                            4=> 'porta',
                            5=> 'sentido',
                            6=> 'passou_cartao',
                        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
  
        $totalData = $this->Acessos_model->acessos_nao_docentes_count();
            
        $totalFiltered = $totalData; 
        $columns_search = array();
        if( !empty($this->input->post('columns')[0]['search']['value']) ){
          $columns_search[$this->input->post('columns')[0]['data']] = $this->input->post('columns')[0]['search']['value'];
        }
        if( !empty($this->input->post('columns')[1]['search']['value']) ){
          $columns_search[$this->input->post('columns')[1]['data']] = $this->input->post('columns')[1]['search']['value'];
        }
        if( !empty($this->input->post('columns')[2]['search']['value']) ){
          $columns_search[$this->input->post('columns')[2]['data']] = $this->input->post('columns')[2]['search']['value'];
        }
        if( !empty($this->input->post('columns')[3]['search']['value']) ){

          $columns_search[$this->input->post('columns')[3]['data']] = $this->input->post('columns')[3]['search']['value'];
        }
        if( !empty($this->input->post('columns')[4]['search']['value']) ){
          $columns_search[$this->input->post('columns')[4]['data']] = $this->input->post('columns')[4]['search']['value'];
        }  
        if( !empty($this->input->post('columns')[5]['search']['value']) ){
          $columns_search[$this->input->post('columns')[5]['data']] = $this->input->post('columns')[5]['search']['value'];
        }  
        if( !empty($this->input->post('columns')[6]['search']['value']) ){
          $columns_search[$this->input->post('columns')[6]['data']] = $this->input->post('columns')[6]['search']['value'];
        }    
        if(empty($this->input->post('search')['value']))
        {            
            $acessos = $this->Acessos_model->get_acessos_nao_docentes($limit,$start,$order,$dir,$columns_search);
            if(!empty(array_values($columns_search))){
                $totalFiltered = $this->Acessos_model->acessos_nao_docentes_search_column_count($columns_search);
              }
        }
        else {
            $search = $this->input->post('search')['value']; 

            $acessos =  $this->Acessos_model->acessos_nao_docentes_search($limit,$start,$search,$order,$dir,$columns_search);

            $totalFiltered = $this->Acessos_model->acessos_nao_docentes_search_count($search,$columns_search);
        }

        $data = array();
        if(!empty($acessos))
        {
            foreach ($acessos as $acesso)
            {

                $nestedData['num_funcionario'] = $acesso->num_funcionario;
                $nestedData['nome'] = $acesso->nome;
                $nestedData['data'] = $acesso->data;
                $nestedData['hora'] = $acesso->hora;
                $nestedData['porta'] = $acesso->porta;
                $nestedData['sentido'] = $acesso->sentido;
                $nestedData['passou_cartao'] = "Sim";

                $data[] = $nestedData;

            }
        }
          
        $json_data = array(
                    "draw"            => intval($this->input->post('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        echo json_encode($json_data); 
  }
public function acessos_naoDocentes_corrigidos()
{
    $this->load->model('Acessos_model');

    $columns = array( 
                            0 =>'num_funcionario', 
                            1 =>'nome',
                            2=> 'data',
                            3=> 'hora',
                            4=> 'porta',
                            5=> 'sentido',
                            6=> 'passou_cartao',
                        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
  
        $totalData = $this->Acessos_model->acessos_nao_docentes_corrigidos_count();
            
        $totalFiltered = $totalData; 
        $columns_search = array();
        if( !empty($this->input->post('columns')[0]['search']['value']) ){
          $columns_search[$this->input->post('columns')[0]['data']] = $this->input->post('columns')[0]['search']['value'];
        }
        if( !empty($this->input->post('columns')[1]['search']['value']) ){
          $columns_search[$this->input->post('columns')[1]['data']] = $this->input->post('columns')[1]['search']['value'];
        }
        if( !empty($this->input->post('columns')[2]['search']['value']) ){
          $columns_search[$this->input->post('columns')[2]['data']] = $this->input->post('columns')[2]['search']['value'];
        }
        if( !empty($this->input->post('columns')[3]['search']['value']) ){

          $columns_search[$this->input->post('columns')[3]['data']] = $this->input->post('columns')[3]['search']['value'];
        }
        if( !empty($this->input->post('columns')[4]['search']['value']) ){
          $columns_search[$this->input->post('columns')[4]['data']] = $this->input->post('columns')[4]['search']['value'];
        }  
        if( !empty($this->input->post('columns')[5]['search']['value']) ){
          $columns_search[$this->input->post('columns')[5]['data']] = $this->input->post('columns')[5]['search']['value'];
        }  
        if( !empty($this->input->post('columns')[6]['search']['value']) ){
          $columns_search[$this->input->post('columns')[6]['data']] = $this->input->post('columns')[6]['search']['value'];
        }    
        if(empty($this->input->post('search')['value']))
        {            
            $acessos = $this->Acessos_model->acessos_nao_docentes_corrigidos($limit,$start,$order,$dir,$columns_search);
                       if(!empty(array_values($columns_search))){
              $totalFiltered = $this->Acessos_model->acessos_nao_docentes_corrigidos_search_column_count($columns_search);
            }
        }
        else {
            $search = $this->input->post('search')['value']; 

            $acessos =  $this->Acessos_model->acessos_nao_docentes_corrigidos_search($limit,$start,$search,$order,$dir,$columns_search);

            $totalFiltered = $this->Acessos_model->acessos_nao_docentes_corrigidos_search_count($search,$columns_search);
        }

        $data = array();
        if(!empty($acessos))
        {
            foreach ($acessos as $acesso)
            {

                $nestedData['num_funcionario'] = $acesso->num_funcionario;
                $nestedData['nome'] = $acesso->nome;
                $nestedData['data'] = $acesso->data;
                $nestedData['hora'] = $acesso->hora;
                $nestedData['porta'] = $acesso->porta;
                $nestedData['sentido'] = $acesso->sentido;
                $nestedData['passou_cartao'] = $acesso->passou_cartao;

                $data[] = $nestedData;

            }
        }
          
        $json_data = array(
                    "draw"            => intval($this->input->post('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        echo json_encode($json_data); 
  }


  public function tabela_disciplinas()
     {
          $this->load->model('Users_model');
          // Datatables Variables
          $draw = intval($this->input->get("draw"));
          $start = intval($this->input->get("start"));
          $length = intval($this->input->get("length"));

          $disciplinas_licenciatura = $this->Users_model->get_disciplinas_licenciatura_docente();
          $disciplinas_mestrado = $this->Users_model->get_disciplinas_mestrado_docente();
          $disciplinas_pos_graduacao = $this->Users_model->get_disciplinas_pos_graduacao_docente();
          

          $data = array();

          foreach($disciplinas_licenciatura->result() as $r) {
              $num_alunos_insc = $this->Users_model->get_num_alunos_inscritos_disciplina_licenciatura($r->id);
              $num_alunos_insc_total = $this->Users_model->get_num_alunos_inscritos_disciplina_licenciatura_total($r->disciplina);
              $data[] = array(
                    $r->disciplina,
                    $r->regente,
                    $r->semestre,
                    $r->ects,
                    $r->turma,
                    $r->ano_lectivo,
                    "Licenciatura em ".$r->licenciatura,
                    "<a id = 'BotaoVeAlunosInsc".$r->id. "'href= '#'>".$num_alunos_insc."</a>
                    <script>$('#BotaoVeAlunosInsc".$r->id."').click(function(){
                      $('#content').load("."'".base_url('Docente/alunosInscDisciplinaLicenciatura/').$r->id."'".")
                    });</script>"
                    ." / ".
                    "<a id = 'BotaoVeTotalAlunosInsc".$r->id. "'href= '#'>".$num_alunos_insc_total."</a>
                    <script>$('#BotaoVeTotalAlunosInsc".$r->id."').click(function(){
                      $('#content').load("."'".base_url('Docente/totalAlunosInscDisciplinaLicenciatura/').$r->id."'".")
                    });</script>",
                    "<a id = 'BotaoVeAulasL".$r->id. "'href= '#' value=".$r->id.">Ver Plano de Aulas</a><script>$('#BotaoVeAulasL".$r->id."').click(function(){
        $('#content').load("."'".base_url('Docente/aulasPorDisciplinaLicenciatura/').$r->id."'".")
    });</script>"

               );

          }

          foreach($disciplinas_mestrado->result() as $r) {
              $num_alunos_insc = $this->Users_model->get_num_alunos_inscritos_disciplina_mestrado($r->id);
              $num_alunos_insc_total = $this->Users_model->get_num_alunos_inscritos_disciplina_mestrado_total($r->disciplina);
               $data[] = array(
                    $r->disciplina,
                    $r->regente,
                    $r->semestre,
                    $r->ects,
                    $r->turma,
                    $r->ano_lectivo,
                    "Mestrado em ".$r->mestrado,
                    "<a id = 'BotaoVeAlunosInscM".$r->id. "'href= '#'>".$num_alunos_insc."</a>
                    <script>$('#BotaoVeAlunosInscM".$r->id."').click(function(){
                      $('#content').load("."'".base_url('Docente/alunosInscDisciplinaMestrado/').$r->id."'".")
                    });</script>"
                    ." / ".
                    "<a id = 'BotaoVeTotalAlunosInscM".$r->id. "'href= '#'>".$num_alunos_insc_total."</a>
                    <script>$('#BotaoVeTotalAlunosInscM".$r->id."').click(function(){
                      $('#content').load("."'".base_url('Docente/totalAlunosInscDisciplinaMestrado/').$r->id."'".")
                    });</script>",             
                    "<a id = 'BotaoVeAulasM".$r->id. "'href= '#' value=".$r->id.">Ver Plano de Aulas</a><script>$('#BotaoVeAulasM".$r->id."').click(function(){
        $('#content').load("."'".base_url('Docente/aulasPorDisciplinaMestrado/').$r->id."'".")
    });</script>"


               );
          }
          foreach($disciplinas_pos_graduacao->result() as $r) {
              $num_alunos_insc = $this->Users_model->get_num_alunos_inscritos_disciplina_pos_graduacao($r->id);
              $num_alunos_insc_total = $this->Users_model->get_num_alunos_inscritos_disciplina_pos_graduacao_total($r->disciplina);
               $data[] = array(
                    $r->disciplina,
                    $r->regente,
                    $r->semestre,
                    $r->ects,
                    $r->turma,
                    $r->ano_lectivo,
                    "Pós-Graduação em ".$r->pos_graduacao,
                    "<a id = 'BotaoVeAlunosInscPG".$r->id. "'href= '#'>".$num_alunos_insc."</a>
                    <script>$('#BotaoVeAlunosInscPG".$r->id."').click(function(){
                      $('#content').load("."'".base_url('Docente/alunosInscDisciplinaPosGraduacao/').$r->id."'".")
                    });</script>"
                    ." / ".
                    "<a id = 'BotaoVeTotalAlunosInscPG".$r->id. "'href= '#'>".$num_alunos_insc_total."</a>
                    <script>$('#BotaoVeTotalAlunosInscPG".$r->id."').click(function(){
                      $('#content').load("."'".base_url('Docente/totalAlunosInscDisciplinaPosGraduacao/').$r->id."'".")
                    });</script>",
                  "<a id = 'BotaoVeAulasPg".$r->id. "'href= '#' value=".$r->id.">Ver Plano de Aulas</a><script>$('#BotaoVeAulasPg".$r->id."').click(function(){
        $('#content').load("."'".base_url('Docente/aulasPorDisciplinaPosGraduacao/').$r->id."'".")
    });</script>"


               );
          }
          $total_disciplinas = sizeof($disciplinas_licenciatura) +  sizeof($disciplinas_mestrado) +  sizeof($disciplinas_pos_graduacao);
          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $total_disciplinas,
                 "recordsFiltered" => $total_disciplinas,
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
function cmp($a, $b)
{
    return strcmp($a["fruit"], $b["fruit"]);
}

 public function tabela_aulas()
     {
          $this->load->model('Users_model');
          // Datatables Variables
          $draw = intval($this->input->get("draw"));
          $start = intval($this->input->get("start"));
          $length = intval($this->input->get("length"));

          $aulas_licenciatura = $this->Users_model->get_aulas_licenciatura_docente();
          $aulas_mestrado = $this->Users_model->get_aulas_mestrado_docente();
          $aulas_pos_graduacoes = $this->Users_model->get_aulas_pos_graduacoes_docente();

          $data = array();

          foreach($aulas_licenciatura->result() as $r) {

               $data[] = array(
                    $r->disciplina,
                    $r->turma,
                    $r->data,
                    $r->horario,
                    $r->sala

               );
          }
          foreach($aulas_mestrado->result() as $r) {

                   $data[] = array(
                        $r->disciplina,
                        $r->turma,
                        $r->data,
                        $r->horario,
                        $r->sala

                   );
              }

          foreach($aulas_pos_graduacoes->result() as $r) {

                   $data[] = array(
                        $r->disciplina,
                        $r->turma,
                        $r->data,
                        $r->horario,
                        $r->sala

                   );
              }
         
 $total_disciplinas = sizeof($data) ;
          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $total_disciplinas,
                 "recordsFiltered" => $total_disciplinas,
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
 

 public function tabela_aulas_disciplina_licenciatura($id_disciplina)
     {
          $this->load->model('Users_model');
          // Datatables Variables
          $draw = intval($this->input->get("draw"));
          $start = intval($this->input->get("start"));
          $length = intval($this->input->get("length"));

          $aulas_disciplina = $this->Users_model->get_aulas_disciplina_licenciatura($id_disciplina);

          

          $data = array();
          $i=1;
          foreach($aulas_disciplina->result() as $r) {
                if($i<10)
                { $aula = "0".$i;} else{$aula = $i}
               $data[] = array(
                    $r->disciplina,
                    $r->turma,
                    $r->data,
                    $r->horario,
                    $r->sala,
                    "Aula ".$aula,
                    "<a id = 'BotaoVePresencasAL".$r->id_aula. "'href= '#' value=".$r->id_aula.">Ver Presenças</a><script>$('#BotaoVePresencasAL".$r->id_aula."').click(function(){
        $('#content').load("."'".base_url('Docente/presencasAulaLicenciatura/').$r->id_aula."/".$id_disciplina."'".")
    });</script>"


               );
               $i++;
          }

          $total_disciplinas = sizeof($aulas_disciplina);
          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $total_disciplinas,
                 "recordsFiltered" => $total_disciplinas,
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
  public function tabela_aulas_disciplina_mestrado($id_disciplina)
     {
          $this->load->model('Users_model');
          // Datatables Variables
          $draw = intval($this->input->get("draw"));
          $start = intval($this->input->get("start"));
          $length = intval($this->input->get("length"));

          $aulas_disciplina = $this->Users_model->get_aulas_disciplina_mestrado($id_disciplina);

          

          $data = array();
          $i=1;
          foreach($aulas_disciplina->result() as $r) {
                if($i<10)
                { $aula = "0".$i;} else{$aula = $i}
               $data[] = array(
                    $r->disciplina,
                    $r->turma,
                    $r->data,
                    $r->horario,
                    $r->sala,
                    "Aula ".$aula,
                    "<a id = 'BotaoVePresencasAM".$r->id_aula. "'href= '#' value=".$r->id_aula.">Ver Presenças</a><script>$('#BotaoVePresencasAM".$r->id_aula."').click(function(){
        $('#content').load("."'".base_url('Docente/presencasAulaMestrado/').$r->id_aula."/".$id_disciplina."'".")
    });</script>"


               );
               $i++;
          }


          $total_disciplinas = sizeof($aulas_disciplina);
          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $total_disciplinas,
                 "recordsFiltered" => $total_disciplinas,
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     } public function tabela_aulas_disciplina_pos_graduacao($id_disciplina)
     {
          $this->load->model('Users_model');
          // Datatables Variables
          $draw = intval($this->input->get("draw"));
          $start = intval($this->input->get("start"));
          $length = intval($this->input->get("length"));

          $aulas_disciplina = $this->Users_model->get_aulas_disciplina_pos_graduacao($id_disciplina);

          

          
          $data = array();
          $i=1;
          foreach($aulas_disciplina->result() as $r) {
              if($i<10)
                { $aula = "0".$i;} else{$aula = $i}
               $data[] = array(
                    $r->disciplina,
                    $r->turma,
                    $r->data,
                    $r->horario,
                    $r->sala,
                    "Aula ".$aula,
                    "<a id = 'BotaoVePresencasPg".$r->id_aula. "'href= '#' value=".$r->id_aula.">Ver Presenças</a><script>$('#BotaoVePresencasPg".$r->id_aula."').click(function(){
              }
        $('#content').load("."'".base_url('Docente/presencasAulaPosGraduacao/').$r->id_aula."/".$id_disciplina."'".")
    });</script>"


               );
               $i++;
          }


          $total_disciplinas = sizeof($aulas_disciplina);
          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $total_disciplinas,
                 "recordsFiltered" => $total_disciplinas,
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
      public function tabela_presencas_aula_licenciatura($id)
     {
          $this->load->model('Users_model');
          // Datatables Variables
          $draw = intval($this->input->get("draw"));
          $start = intval($this->input->get("start"));
          $length = intval($this->input->get("length"));

          $presencas_aula = $this->Users_model->get_presencas_aula_licenciatura($id);

          

          $data = array();

          foreach($presencas_aula->result() as $r) {

               $data[] = array(
                    $r->num_aluno,
                    $r->nome,
                    $r->hora_de_entrada,
                    $r->hora_de_aula

               );
          }

          $total_disciplinas = sizeof($presencas_aula);
          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $total_disciplinas,
                 "recordsFiltered" => $total_disciplinas,
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
     public function tabela_presencas_aula_mestrado($id)
     {
          $this->load->model('Users_model');
          // Datatables Variables
          $draw = intval($this->input->get("draw"));
          $start = intval($this->input->get("start"));
          $length = intval($this->input->get("length"));

          $presencas_aula = $this->Users_model->get_presencas_aula_mestrado($id);

          

          $data = array();

          foreach($presencas_aula->result() as $r) {

               $data[] = array(
                    $r->num_aluno,
                    $r->nome,
                    $r->hora_de_entrada,
                    $r->hora_de_aula

               );
          }

          $total_disciplinas = sizeof($presencas_aula);
          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $total_disciplinas,
                 "recordsFiltered" => $total_disciplinas,
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
     public function tabela_presencas_aula_pos_graduacao($id)
     {
          $this->load->model('Users_model');
          // Datatables Variables
          $draw = intval($this->input->get("draw"));
          $start = intval($this->input->get("start"));
          $length = intval($this->input->get("length"));

          $presencas_aula = $this->Users_model->get_presencas_aula_pos_graduacao($id);

          

          $data = array();

          foreach($presencas_aula->result() as $r) {

               $data[] = array(
                    $r->num_aluno,
                    $r->nome,
                    $r->hora_de_entrada,
                    $r->hora_de_aula

               );
          }

          $total_disciplinas = sizeof($presencas_aula);
          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $total_disciplinas,
                 "recordsFiltered" => $total_disciplinas,
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
     
     public function tabela_alunos_inscritos_disciplina_licenciatura($id_disciplina)
     {
          $this->load->model('Users_model');
          // Datatables Variables
          $draw = intval($this->input->get("draw"));
          $start = intval($this->input->get("start"));
          $length = intval($this->input->get("length"));

          $alunos_insc = $this->Users_model->get_alunos_inscritos_disciplinas_licenciatura($id_disciplina);

          

          $data = array();

          foreach($alunos_insc->result() as $r) {
               $n_presencas =$this->Users_model->get_num_presencas_aluno_disciplina_licenciatura($id_disciplina, $r->id_aluno);
               $n_aulas = $this->Users_model->get_num_aulas_disciplina_licenciatura($id_disciplina);
               $assiduidade = ($n_presencas/$n_aulas)*100;
               $data[] = array(
                    $r->num_aluno,
                    $r->nome,
                    $r->disciplina,
                    $r->turma,
                    $n_presencas,
                    $assiduidade.'%'

               );
          }

          $total_disciplinas = sizeof($alunos_insc);
          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $total_disciplinas,
                 "recordsFiltered" => $total_disciplinas,
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
      public function tabela_total_alunos_inscritos_disciplina_licenciatura($id_disciplina)
     {
          $this->load->model('Users_model');
          // Datatables Variables
          $draw = intval($this->input->get("draw"));
          $start = intval($this->input->get("start"));
          $length = intval($this->input->get("length"));

          $alunos_insc = $this->Users_model->get_total_alunos_inscritos_disciplinas_licenciatura($id_disciplina);

          

          $data = array();

          foreach($alunos_insc->result() as $r) {
               $n_presencas =$this->Users_model->get_num_presencas_aluno_disciplina_licenciatura($r->id_disc, $r->id_aluno);
               $n_aulas = $this->Users_model->get_num_aulas_disciplina_licenciatura($r->id_disc);
               $assiduidade = ($n_presencas/$n_aulas)*100;
               $data[] = array(
                    $r->num_aluno,
                    $r->nome,
                    $r->disciplina,
                    $r->turma,
                    $n_presencas,
                    $assiduidade.'%'

               );
          }

          $total_disciplinas = sizeof($alunos_insc);
          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $total_disciplinas,
                 "recordsFiltered" => $total_disciplinas,
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
    public function tabela_alunos_inscritos_disciplina_mestrado($id_disciplina)
     {
          $this->load->model('Users_model');
          // Datatables Variables
          $draw = intval($this->input->get("draw"));
          $start = intval($this->input->get("start"));
          $length = intval($this->input->get("length"));

          $alunos_insc = $this->Users_model->get_alunos_inscritos_disciplinas_mestrado($id_disciplina);

          

          $data = array();

          foreach($alunos_insc->result() as $r) {
               $n_presencas =$this->Users_model->get_num_presencas_aluno_disciplina_mestrado($id_disciplina, $r->id_aluno);
               $n_aulas = $this->Users_model->get_num_aulas_disciplina_mestrado($id_disciplina);
               $assiduidade = ($n_presencas/$n_aulas)*100;
               $data[] = array(
                    $r->num_aluno,
                    $r->nome,
                    $r->disciplina,
                    $r->turma,
                    $n_presencas,
                    $assiduidade.'%'

               );
          }
          $total_disciplinas = sizeof($alunos_insc);
          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $total_disciplinas,
                 "recordsFiltered" => $total_disciplinas,
                 "data" => $data
            );
          echo json_encode($output);
          exit();
      }
     public function tabela_total_alunos_inscritos_disciplina_mestrado($id_disciplina)
     {
          $this->load->model('Users_model');
          // Datatables Variables
          $draw = intval($this->input->get("draw"));
          $start = intval($this->input->get("start"));
          $length = intval($this->input->get("length"));

          $alunos_insc = $this->Users_model->get_total_alunos_inscritos_disciplinas_mestrado($id_disciplina);

          

          $data = array();

          foreach($alunos_insc->result() as $r) {
               $n_presencas =$this->Users_model->get_num_presencas_aluno_disciplina_mestrado($r->id_disc, $r->id_aluno);
               $n_aulas = $this->Users_model->get_num_aulas_disciplina_mestrado($r->id_disc);
               $assiduidade = ($n_presencas/$n_aulas)*100;
               $data[] = array(
                    $r->num_aluno,
                    $r->nome,
                    $r->disciplina,
                    $r->turma,
                    $n_presencas,
                    $assiduidade.'%'

               );
          }

          $total_disciplinas = sizeof($alunos_insc);
          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $total_disciplinas,
                 "recordsFiltered" => $total_disciplinas,
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
    public function tabela_alunos_inscritos_disciplina_pos_graduacao($id_disciplina)
     {
          $this->load->model('Users_model');
          // Datatables Variables
          $draw = intval($this->input->get("draw"));
          $start = intval($this->input->get("start"));
          $length = intval($this->input->get("length"));

          $alunos_insc = $this->Users_model->get_alunos_inscritos_disciplinas_pos_graduacao($id_disciplina);

          

          $data = array();

          foreach($alunos_insc->result() as $r) {
               $n_presencas =$this->Users_model->get_num_presencas_aluno_disciplina_pos_graduacao($id_disciplina, $r->id_aluno);
               $n_aulas = $this->Users_model->get_num_aulas_disciplina_pos_graduacao($id_disciplina);
               $assiduidade = ($n_presencas/$n_aulas)*100;
               $data[] = array(
                    $r->num_aluno,
                    $r->nome,
                    $r->disciplina,
                    $r->turma,
                    $n_presencas,
                    $assiduidade.'%'

               );
          }
          $total_disciplinas = sizeof($alunos_insc);
          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $total_disciplinas,
                 "recordsFiltered" => $total_disciplinas,
                 "data" => $data
            );
          echo json_encode($output);
          exit();
      }
     public function tabela_total_alunos_inscritos_disciplina_pos_graduacao($id_disciplina)
     {
          $this->load->model('Users_model');
          // Datatables Variables
          $draw = intval($this->input->get("draw"));
          $start = intval($this->input->get("start"));
          $length = intval($this->input->get("length"));

          $alunos_insc = $this->Users_model->get_total_alunos_inscritos_disciplinas_pos_graduacao($id_disciplina);

          

          $data = array();

          foreach($alunos_insc->result() as $r) {
               $n_presencas =$this->Users_model->get_num_presencas_aluno_disciplina_pos_graduacao($r->id_disc, $r->id_aluno);
               $n_aulas = $this->Users_model->get_num_aulas_disciplina_pos_graduacao($r->id_disc);
               $assiduidade = ($n_presencas/$n_aulas)*100;
               $data[] = array(
                    $r->num_aluno,
                    $r->nome,
                    $r->disciplina,
                    $r->turma,
                    $n_presencas,
                    $assiduidade.'%'

               );
          }

          $total_disciplinas = sizeof($alunos_insc);
          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $total_disciplinas,
                 "recordsFiltered" => $total_disciplinas,
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
     public function alertas()
     {
          $this->load->model('Acessos_model');
          // Datatables Variables
          $draw = intval($this->input->get("draw"));
          $start = intval($this->input->get("start"));
          $length = intval($this->input->get("length"));

          $sensores = $this->Acessos_model->sensores_avariados();

          $data = array();

          foreach($sensores as $r) {

               $data[] = array(
                    $r->porta,
                    $r->sentido,
                    $r->data,
                    $r->hora
               );
          }
          $total_sensores = sizeof($sensores);
          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $total_sensores,
                 "recordsFiltered" => $total_sensores,
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
        
}
