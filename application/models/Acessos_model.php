<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Acessos_model extends CI_Model {


    function get_ids_acessos() {
        $this->db->select('id');
		$this->db->from('acessos');
		$query = $this->db->get(); 
        return $query->result_array();
    }
    function get_ids_alunos() {
        $this->db->select('id');
		$this->db->from('alunos');
		$query = $this->db->get(); 
        return $query->result_array();
    }
    function get_ids_docentes() {
        $this->db->select('id');
		$this->db->from('docentes');
		$query = $this->db->get(); 
        return $query->result_array();
    }
    function get_ids_nao_docentes() {
        $this->db->select('id');
		$this->db->from('nao_docentes');
		$query = $this->db->get(); 
        return $query->result_array();
    }
    function get_sensores(){
    	$this->db->select('*');
		$this->db->from('sensores');
		$query = $this->db->get(); 
        return $query->result_array();
    }
   
    function gerar_acessos(){
    	$data = $this->input->post('data');
    	$acessos = array();
    	$sensores = $this->get_sensores();
    	$n_acessos = 1000;
    	for ($i = 0; $i < $n_acessos; $i++) {
    		$rand_sensor = array_rand($sensores);

    		if ($i<$n_acessos*0.05) {
    			$hora = "0".mt_rand(0,7).":".str_pad(mt_rand(0,59), 2, "0", STR_PAD_LEFT);
    		}
    		else if ($i<$n_acessos*0.25) {
    			$hora = "0".mt_rand(8,9).":".str_pad(mt_rand(0,59), 2, "0", STR_PAD_LEFT);
    		}
    		else if ($i<$n_acessos*0.5) {
    			$hora = mt_rand(10,13).":".str_pad(mt_rand(0,59), 2, "0", STR_PAD_LEFT);
    		}
    		else if ($i < $n_acessos*0.9) {
    			$hora = mt_rand(14,18).":".str_pad(mt_rand(0,59), 2, "0", STR_PAD_LEFT);
    		}
    		else{
    			$hora = mt_rand(19,23).":".str_pad(mt_rand(0,59), 2, "0", STR_PAD_LEFT);
    		}
    		$acesso = array(
    		'id_sensor' => $sensores[$rand_sensor]['id'],
			'data' => $data,
			'hora' => $hora);
    		array_push($acessos, $acesso);


		}
		$query = $this->db->insert_batch('acessos', $acessos);
		$last_id = $this->db->insert_id();

		if($query){
			$ids_alunos = $this->get_ids_alunos();
			$ids_docentes = $this->get_ids_docentes();
			$ids_nao_docentes = $this->get_ids_nao_docentes();
			$acessos_alunos = array();
			$acessos_docentes = array();
			$acessos_nao_docentes = array();
			$ids_acessos = range($last_id - ($n_acessos-1), $last_id);
			shuffle($ids_acessos);
			$i=0;
			foreach ($ids_acessos as $id_acesso) {
				if ($i< $n_acessos*0.8) {
					$rand_aluno = array_rand($ids_alunos);
					$acesso_aluno = array('id_acesso' => $id_acesso ,
											'id_aluno' => $ids_alunos[$rand_aluno]['id'] );
					array_push($acessos_alunos, $acesso_aluno);
					
				}
				else if($i < $n_acessos*0.95){
					$rand_docente = array_rand($ids_docentes);
					$acesso_docente = array('id_acesso' => $id_acesso ,
											'id_docente' => $ids_docentes[$rand_docente]['id'] );
					array_push($acessos_docentes, $acesso_docente);

				}
				else{
					$rand_nao_docente = array_rand($ids_nao_docentes);
					$acesso_nao_docente = array('id_acesso' => $id_acesso ,
											'id_nao_docente' => $ids_nao_docentes[$rand_nao_docente]['id']);
					array_push($acessos_nao_docentes, $acesso_nao_docente);
				}
				$i++;
			}
			$query1 = $this->db->insert_batch('acessos_alunos', $acessos_alunos);
			$query2 = $this->db->insert_batch('acessos_docentes', $acessos_docentes);
			$query3 = $this->db->insert_batch('acessos_nao_docentes', $acessos_nao_docentes);

			if ($query1 and $query2 and $query3) {
				return true;
			}
			else{
				$this->db->trans_rollback();
				return false;
			}	
		
			
		}
		else{
			$this->db->trans_rollback();
			return false;
		}

    }
    function gerar_acessos_detalhados(){
    	$data = $this->input->post('data');
    	if($this->input->post('hora_final') < $this->input->post('hora_inicial')){
    		    list($hora_inicial, $min_inicial) = explode(":", $this->input->post('hora_inicial'));
    			list($hora_final, $min_final) = explode(":", '23:59');
    	}
    	else{
    		    list($hora_inicial, $min_inicial) = explode(":", $this->input->post('hora_inicial'));
    			list($hora_final, $min_final) = explode(":", $this->input->post('hora_final'));
    	}

    	$n_acessos = $this->input->post('num_acessos');
    	$acessos = array();
    	$sensores = $this->get_sensores();

    	for ($i = 0; $i < $n_acessos; $i++) {
    		$rand_sensor = array_rand($sensores);
    		$horaRandom = mt_rand($hora_inicial,$hora_final);
    		if ($horaRandom<10){
    			if($horaRandom == $hora_inicial){
    				$hora = "0".$horaRandom.":".str_pad(mt_rand($min_inicial,59), 2, "0", STR_PAD_LEFT);
    			}
    			elseif($horaRandom == $hora_final){
    				$hora = "0".$horaRandom.":".str_pad(mt_rand(0,$min_final), 2, "0", STR_PAD_LEFT);

    			}
    			else{
    				$hora = "0".$horaRandom.":".str_pad(mt_rand(0,59), 2, "0", STR_PAD_LEFT);

    			}
 
    		}
    		
    		else{
        		if($horaRandom == $hora_inicial){
    				$hora = $horaRandom.":".str_pad(mt_rand($min_inicial,59), 2, "0", STR_PAD_LEFT);
    			}
    			elseif($horaRandom == $hora_final){
    				$hora = $horaRandom.":".str_pad(mt_rand(0,$min_final), 2, "0", STR_PAD_LEFT);

    			}
    			else{
    				$hora = $horaRandom.":".str_pad(mt_rand(0,59), 2, "0", STR_PAD_LEFT);

    			}
    		}
    		
		

    		$acesso = array(
    		'id_sensor' => $sensores[$rand_sensor]['id'],
			'data' => $data,
			'hora' => $hora);
    		array_push($acessos, $acesso);


		}
		$query = $this->db->insert_batch('acessos', $acessos);
		$last_id = $this->db->insert_id();

		if($query){
			$ids_alunos = $this->get_ids_alunos();
			$ids_docentes = $this->get_ids_docentes();
			$ids_nao_docentes = $this->get_ids_nao_docentes();
			$acessos_alunos = array();
			$acessos_docentes = array();
			$acessos_nao_docentes = array();
			$ids_acessos = range($last_id - ($n_acessos-1), $last_id);
			shuffle($ids_acessos);
			$i=0;
			foreach ($ids_acessos as $id_acesso) {
				if ($i< $n_acessos*0.8) {
					$rand_aluno = array_rand($ids_alunos);
					$acesso_aluno = array('id_acesso' => $id_acesso ,
											'id_aluno' => $ids_alunos[$rand_aluno]['id'] );
					array_push($acessos_alunos, $acesso_aluno);
					
				}
				else if($i < $n_acessos*0.95){
					$rand_docente = array_rand($ids_docentes);
					$acesso_docente = array('id_acesso' => $id_acesso ,
											'id_docente' => $ids_docentes[$rand_docente]['id'] );
					array_push($acessos_docentes, $acesso_docente);

				}
				else{
					$rand_nao_docente = array_rand($ids_nao_docentes);
					$acesso_nao_docente = array('id_acesso' => $id_acesso ,
											'id_nao_docente' => $ids_nao_docentes[$rand_nao_docente]['id']);
					array_push($acessos_nao_docentes, $acesso_nao_docente);
				}
				$i++;
			}
			$query1 = $this->db->insert_batch('acessos_alunos', $acessos_alunos);
			$query2 = $this->db->insert_batch('acessos_docentes', $acessos_docentes);
			$query3 = $this->db->insert_batch('acessos_nao_docentes', $acessos_nao_docentes);

			if ($query1 and $query2 and $query3) {
				return true;
			}
			else{
				$this->db->trans_rollback();
				return false;
			}	
		
			
		}
		else{
			$this->db->trans_rollback();
			return false;
		}

    }

    //ACESSOS Corrigidos ALUNOS
    function ha_novos_acessos_alunos(){
    	$sql = "SELECT count (*) as num
				FROM   acessos_alunos
				WHERE  not EXISTS (SELECT *
                  				 FROM   acessos_alunos_corrigidos
                   				WHERE  acessos_alunos.id_acesso = acessos_alunos_corrigidos.id_acesso);" ;
		$query = $this->db->query($sql);

		$result = $query->row();
      	if($result->num != 0 ) return 1;
      	return 0;  

    }
      function get_acesso_aluno_corrigido_mais_recente($id_aluno){
    		$sql = "SELECT top 1 id_acesso,ac.num_aluno,ac.nome, ac.data, ac.hora, ac.porta,ac.sentido,ac.passou_cartao
				  FROM [dbo].[acessos_alunos_corrigidos] as ac
				  join alunos as al on ac.num_aluno = al.num_aluno
				  where al.id = $id_aluno
				  order by data desc, hora desc, id_acesso desc
				 " ;
			$query = $this->db->query($sql);
			return $query->result_array();
    }
      function get_alunos_com_acessos(){
    		$sql = "SELECT id_aluno
					FROM acessos_alunos as m
					WHERE  not EXISTS (SELECT *
                  				 FROM   acessos_alunos_corrigidos
                   				WHERE  m.id_acesso = acessos_alunos_corrigidos.id_acesso) 
								group by id_aluno;" ;
			$query = $this->db->query($sql);
			return $query->result_array();
    }

		function corrige_acessos_alunos(){
			
    		$acessos_corrigidos = array();
    		$alunos = $this->get_alunos_com_acessos();
    		foreach ($alunos as $aluno ) {
    			$id_aluno = $aluno['id_aluno'];
    			$sql = "SELECT m.id_acesso,al.num_aluno,concat(al.nome, ' ',al.apelido) as nome,s.sentido,  a.data,a.hora,
    							concat(p.edificio, '.',p.piso,'.',p.num_porta) as porta,s.sentido
						FROM acessos_alunos AS m
						  JOIN acessos AS a on a.id = m.id_acesso
						  join sensores as s on s.id = a.id_sensor
						  join portas as p on p.id = s.id_porta
						  join alunos as al on m.id_aluno = al.id
  						 WHERE  not EXISTS (SELECT *
                  				 FROM   acessos_alunos_corrigidos
                   				WHERE  m.id_acesso = acessos_alunos_corrigidos.id_acesso)
                   				 and m.id_aluno = $id_aluno
						ORDER BY a.data DESC, a.hora DESC";
				$query = $this->db->query($sql);
				$result = $query->result_array();
				$acesso_corrido_mais_recente = $this->get_acesso_aluno_corrigido_mais_recente($id_aluno);
				
				if(!empty($acesso_corrido_mais_recente)){
					array_push($result, $acesso_corrido_mais_recente[0]);
				}
				$acessos_corrigido_aluno =  $this->corrige_acessos($result);
				if(!empty($acesso_corrido_mais_recente)){
					$key = array_search($acesso_corrido_mais_recente[0], $acessos_corrigido_aluno);
				
					if($key){
						unset($acessos_corrigido_aluno[$key]);

					}
				}
				
				foreach($acessos_corrigido_aluno as $acesso){
					if($acesso['id_acesso'] > 0){
									$acesso['passou_cartao'] = "Sim";
								}
								else{
									$acesso['passou_cartao'] = "Não";
								} 			
								array_push($acessos_corrigidos, $acesso);
							
				}
    		}
    
    		return $this->insert_alunos_corrigidos($acessos_corrigidos);
		}

		function insert_alunos_corrigidos($array) { 
			foreach ($array as $row) {
				$id_acesso = $row['id_acesso'];
				$num_aluno = $row['num_aluno'];
				$nome = str_replace('\'', '\'\'',$row['nome']);
				$data = $row['data'];
				$hora = $row['hora'];
				$porta = $row['porta'];
				$sentido = $row['sentido'];
				$passou_cartao = $row['passou_cartao'];
			// $query1 = $this->db->empty_table('acessos_alunos_corrigidos');
			// $query2 = $this->db->insert_batch('acessos_alunos_corrigidos', $result);

				$sql = "INSERT INTO acessos_alunos_corrigidos (id_acesso,num_aluno,nome,data,hora,porta,sentido,passou_cartao) values($id_acesso,$num_aluno,'$nome','$data','$hora','$porta','$sentido','$passou_cartao');";
 				$query1 = $this->db->query($sql);
				if (!$query1) {
					$this->db->trans_rollback();
					return false;
				}
			
		
			}
			return true;
	
		
		}

		function acessos_alunos_corrigidos_count()
    {   
       $query = $this->db->select("COUNT(*) as num")->get("acessos_alunos_corrigidos");
        $result = $query->row();
        if(isset($result)) return $result->num;
        return 0;

    }
    
    function acessos_alunos_corrigidos($limit,$start,$col,$dir,$colsearch)
    {   
		$sql = "SELECT num_aluno,nome,data,hora,porta,sentido,passou_cartao
				FROM 
				  acessos_alunos_corrigidos                 
				  WHERE 1=1";

        foreach (array_keys($colsearch) as $key) {

        		$sql.=" AND $key LIKE '".$colsearch[$key]."%' ";
        	
        }
		if ($col == "hora" or $col =="data") {
			$sql.="	ORDER BY 
				data $dir,hora $dir
				OFFSET $start ROWS
				FETCH NEXT $limit ROWS ONLY;";
		}
		else{		  
			$sql.="	ORDER BY 
				$col $dir,data DESC,hora DESC
				OFFSET $start ROWS
				FETCH NEXT $limit ROWS ONLY;";
		}
        $query = $this->db->query($sql);

        if($query->num_rows()>0)
        {
            return $query->result(); 
        }
        else
        {
            return null;
        }
        
    }
   
    function acessos_alunos_corrigidos_search($limit,$start,$search,$col,$dir,$colsearch)
    {
    	$search_s = $search.'%';
		$sql = "SELECT num_aluno,nome,data,hora,porta,sentido,passou_cartao
				FROM 
				  acessos_alunos_corrigidos                 
				  WHERE (nome LIKE '$search_s' OR 
						data LIKE '$search_s' OR 
						porta LIKE '$search_s' or 
						hora LIKE  '$search_s' or
						num_aluno LIKE '$search_s')";
;

        foreach (array_keys($colsearch) as $key) {

        		$sql.=" AND $key LIKE '".$colsearch[$key]."%' ";
        	
        }
				  
		if ($col == "hora" or $col =="data") {
			$sql.="	ORDER BY 
				data $dir,hora $dir
				OFFSET $start ROWS
				FETCH NEXT $limit ROWS ONLY;";
		}
		else{		  
			$sql.="	ORDER BY 
				$col $dir,data DESC,hora DESC
				OFFSET $start ROWS
				FETCH NEXT $limit ROWS ONLY;";
		}

        $query = $this->db->query($sql);

               
        
       
        if($query->num_rows()>0)
        {
            return $query->result();  
        }
        else
        {
            return null;
        }
    }

    function acessos_alunos_corrigidos_search_count($search,$colsearch)
    {
    	$search_s = $search.'%';
		$sql = "SELECT count(*) as num
				FROM 
				  acessos_alunos_corrigidos                 
				  WHERE (nome LIKE '$search_s' OR 
						data LIKE '$search_s' OR 
						porta LIKE '$search_s' or 
						hora LIKE  '$search_s' or
						num_aluno LIKE '$search_s')";
;

        foreach (array_keys($colsearch) as $key) {

        		$sql.=" AND $key LIKE '".$colsearch[$key]."%' ";
        	
        }

      $query = $this->db->query($sql);
      $result = $query->row();
      if(isset($result)) return $result->num;
      return 0;
    }		
    function acessos_alunos_corrigidos_search_column_count($colsearch){
    			$sql = "SELECT count(*) as num
				FROM 
				  acessos_alunos_corrigidos                 
				  WHERE 1=1";

        foreach (array_keys($colsearch) as $key) {

        		$sql.=" AND $key LIKE '".$colsearch[$key]."%' ";
        	
        }
      $query = $this->db->query($sql);
      $result = $query->row();
      if(isset($result)) return $result->num;
      return 0;
    }
    //ACESSOS ALUNOS  
    function acessos_alunos_count()
    {   
      $query = $this->db->select("COUNT(*) as num")->get("acessos_alunos");
      $result = $query->row();
      if(isset($result)) return $result->num;
      return 0;  

    }
    
	function get_acessos_alunos($limit,$start,$col,$dir,$colsearch){

		$sql = "SELECT m.id_acesso,al.num_aluno,concat(al.nome, ' ',al.apelido) as nome,s.sentido as sentido,  
    			a.data,a.hora,concat(p.edificio, '.',p.piso,'.',p.num_porta) as porta
				FROM 
				  acessos_alunos AS m 
				  JOIN acessos AS a on a.id = m.id_acesso
				  join sensores as s on s.id = a.id_sensor
				  join portas as p on p.id = s.id_porta
				  join alunos as al on m.id_aluno = al.id                  
				  WHERE 1=1";

        foreach (array_keys($colsearch) as $key) {

        	if($key == 'porta'){
        		$sql.=" AND concat(p.edificio, '.',p.piso,'.',p.num_porta) LIKE '".$colsearch[$key]."%' ";
        	}
        	elseif ($key == 'nome') {
        		$sql.=" AND concat(al.nome, ' ',al.apelido) LIKE '".$colsearch[$key]."%' ";

        	}
        	else{
        		$sql.=" AND $key LIKE '".$colsearch[$key]."%' ";
        	}
        }
				  
		if ($col == "hora" or $col =="data") {
			$sql.="	ORDER BY 
				data $dir,hora $dir
				OFFSET $start ROWS
				FETCH NEXT $limit ROWS ONLY;";
		}
		else{		  
			$sql.="	ORDER BY 
				$col $dir,data DESC,hora DESC
				OFFSET $start ROWS
				FETCH NEXT $limit ROWS ONLY;";
		}

		$query = $this->db->query($sql);
		if($query->num_rows()>0)
        {
            return $query->result(); 
        }
        else
        {
            return null;
        }
        
	}
	function acessos_alunos_search($limit,$start,$search,$col,$dir,$colsearch)
    {
    	$search_s = $search.'%';
    	$sql = "SELECT m.id_acesso,al.num_aluno,concat(al.nome, ' ',al.apelido) as nome,s.sentido,  
    			a.data,a.hora,concat(p.edificio, '.',p.piso,'.',p.num_porta) as porta,s.sentido
				FROM 
				  acessos_alunos AS m 
				  JOIN acessos AS a on a.id = m.id_acesso
				  join sensores as s on s.id = a.id_sensor
				  join portas as p on p.id = s.id_porta
				  join alunos as al on m.id_aluno = al.id
				WHERE (concat(al.nome, ' ',al.apelido)  LIKE '$search_s' OR 
						data LIKE '$search_s' OR 
						concat (p.edificio, '.',p.piso,'.',p.num_porta) LIKE '$search_s' or 
						hora LIKE  '$search_s' or
						num_aluno LIKE '$search_s')";

		foreach (array_keys($colsearch) as $key) {
        	if($key == 'porta'){
        		$sql.=" AND concat(p.edificio, '.',p.piso,'.',p.num_porta) LIKE '".$colsearch[$key]."%' ";
        	}
        	elseif ($key == 'nome') {
        		$sql.=" AND concat(al.nome, ' ',al.apelido) LIKE '".$colsearch[$key]."%' ";

        	}
        	else{
        		$sql.=" AND $key LIKE '".$colsearch[$key]."%' ";
        	}
        }

       
		if ($col == "hora" or $col =="data") {
			$sql.="	ORDER BY 
				data $dir,hora $dir
				OFFSET $start ROWS
				FETCH NEXT $limit ROWS ONLY;";
		}
		else{		  
			$sql.="	ORDER BY 
				$col $dir,data DESC,hora DESC
				OFFSET $start ROWS
				FETCH NEXT $limit ROWS ONLY;";
		}
       	$query=$this->db->query($sql);

        if($query->num_rows()>0)
        {
            return $query->result();  
        }
        else
        {
            return null;
        }
    }
    function acessos_alunos_search_count($search,$colsearch)
    {
    	$search_s = $search.'%';
    	$sql = "SELECT count(*) as num
				FROM 
				  acessos_alunos AS m 
				  JOIN acessos AS a on a.id = m.id_acesso
				  join sensores as s on s.id = a.id_sensor
				  join portas as p on p.id = s.id_porta
				  join alunos as al on m.id_aluno = al.id
				WHERE (concat(al.nome, ' ',al.apelido)  LIKE '$search_s' OR 
						data LIKE '$search_s' OR 
						concat (p.edificio, '.',p.piso,'.',p.num_porta) LIKE '$search_s' or 
						hora LIKE  '$search_s' or
						num_aluno LIKE '$search_s')";

		foreach (array_keys($colsearch) as $key) {
        	if($key == 'porta'){
        		$sql.=" AND concat(p.edificio, '.',p.piso,'.',p.num_porta) LIKE '".$colsearch[$key]."%' ";
        	}
        	elseif ($key == 'nome') {
        		$sql.=" AND concat(al.nome, ' ',al.apelido) LIKE '".$colsearch[$key]."%' ";

        	}
        	else{
        		$sql.=" AND $key LIKE '".$colsearch[$key]."%' ";
        	}
        }
       ;
       
    	$query = $this->db->query($sql);

      $result = $query->row();
      if(isset($result)) return $result->num;
      return 0;
 	}
 	function acessos_alunos_search_column_count($colsearch)
    {

    	$sql = "SELECT count(*) as num
				FROM 
			  acessos_alunos AS m 
				  JOIN acessos AS a on a.id = m.id_acesso
				  join sensores as s on s.id = a.id_sensor
				  join portas as p on p.id = s.id_porta
				  join alunos as al on m.id_aluno = al.id
                  WHERE 1=1";
        foreach (array_keys($colsearch) as $key) {
        	if($key == 'porta'){
        		$sql.=" AND concat(p.edificio, '.',p.piso,'.',p.num_porta) LIKE '".$colsearch[$key]."%' ";
        	}
        	elseif ($key == 'nome') {
        		$sql.=" AND concat(al.nome, ' ',al.apelido) LIKE '".$colsearch[$key]."%' ";

        	}
        	else{
        		$sql.=" AND $key LIKE '".$colsearch[$key]."%' ";
        	}
        }       
    	$query = $this->db->query($sql);

      $result = $query->row();
      if(isset($result)) return $result->num;
      return 0;
 	}
	  //ACESSOS Docentes

 	 //ACESSOS Corrigidos docentes
    function ha_novos_acessos_docentes(){
    	$sql = "SELECT count (*) as num
				FROM   acessos_docentes
				WHERE  not EXISTS (SELECT *
                  				 FROM   acessos_docentes_corrigidos
                   				WHERE  acessos_docentes.id_acesso = acessos_docentes_corrigidos.id_acesso);" ;
		$query = $this->db->query($sql);

		$result = $query->row();
      	if($result->num != 0 ) return 1;
      	return 0;  

    }
      function get_acesso_docente_corrigido_mais_recente($id_docente){
    		$sql = "SELECT top 1 id_acesso,ac.num_funcionario,ac.nome, ac.data, ac.hora, ac.porta,ac.sentido,ac.passou_cartao
                  FROM [dbo].[acessos_docentes_corrigidos] as ac
                  join funcionarios as fu on  ac.num_funcionario = fu.num_funcionario
                  join docentes as do on do.id_funcionario = fu.id
                  where do.id = $id_docente
                  order by data desc, hora desc, id_acesso desc";
			$query = $this->db->query($sql);
			return $query->result_array();
    }
      function get_docentes_com_acessos(){
    		$sql = "SELECT id_docente
					FROM acessos_docentes as m
					WHERE  not EXISTS (SELECT *
                  				 FROM   acessos_docentes_corrigidos
                   				WHERE  m.id_acesso = acessos_docentes_corrigidos.id_acesso) 
								group by id_docente;" ;
			$query = $this->db->query($sql);
			return $query->result_array();
    }

		function corrige_acessos_docentes(){
			
    		$acessos_corrigidos = array();
    		$docentes = $this->get_docentes_com_acessos();
    		foreach ($docentes as $docente ) {
    			$id_docente = $docente['id_docente'];
    			$sql = "SELECT m.id_acesso,fu.num_funcionario,concat(fu.nome, ' ',fu.apelido) as nome,s.sentido,  a.data,a.hora,
                                concat(p.edificio, '.',p.piso,'.',p.num_porta) as porta,s.sentido
                        FROM acessos_docentes AS m
                          JOIN acessos AS a on a.id = m.id_acesso
                          join sensores as s on s.id = a.id_sensor
                          join portas as p on p.id = s.id_porta
                          join docentes as do on m.id_docente = do.id
                          join funcionarios as fu on do.id_funcionario = fu.id
                         WHERE  not EXISTS (SELECT *
                                 FROM   acessos_docentes_corrigidos
                                WHERE  m.id_acesso = acessos_docentes_corrigidos.id_acesso)
                   				 and m.id_docente = $id_docente
						ORDER BY a.data DESC, a.hora DESC";
				$query = $this->db->query($sql);
				$result = $query->result_array();
				$acesso_corrido_mais_recente = $this->get_acesso_docente_corrigido_mais_recente($id_docente);
				
				if(!empty($acesso_corrido_mais_recente)){
					array_push($result, $acesso_corrido_mais_recente[0]);
				}
				$acessos_corrigido_docente =  $this->corrige_acessos($result);
				if(!empty($acesso_corrido_mais_recente)){
					$key = array_search($acesso_corrido_mais_recente[0], $acessos_corrigido_docente);
				
					if($key){
						unset($acessos_corrigido_docente[$key]);

					}
				}
				
				foreach($acessos_corrigido_docente as $acesso){
					if($acesso['id_acesso'] > 0){
									$acesso['passou_cartao'] = "Sim";
								}
								else{
									$acesso['passou_cartao'] = "Não";
								} 			
								array_push($acessos_corrigidos, $acesso);
							
				}
    		}
    
    		return $this->insert_docentes_corrigidos($acessos_corrigidos);
		}

		function insert_docentes_corrigidos($array) { 
			foreach ($array as $row) {
				$id_acesso = $row['id_acesso'];
				$num_funcionario = $row['num_funcionario'];
				$nome = str_replace('\'', '\'\'',$row['nome']);
				$data = $row['data'];
				$hora = $row['hora'];
				$porta = $row['porta'];
				$sentido = $row['sentido'];
				$passou_cartao = $row['passou_cartao'];
			// $query1 = $this->db->empty_table('acessos_docentes_corrigidos');
			// $query2 = $this->db->insert_batch('acessos_docentes_corrigidos', $result);

				$sql = "INSERT INTO acessos_docentes_corrigidos (id_acesso,num_funcionario,nome,data,hora,porta,sentido,passou_cartao) values($id_acesso,$num_funcionario,'$nome','$data','$hora','$porta','$sentido','$passou_cartao');";
 				$query1 = $this->db->query($sql);
				if (!$query1) {
					$this->db->trans_rollback();
					return false;
				}
			
		
			}
			return true;
	
		
		}

		function acessos_docentes_corrigidos_count()
    {   
       $query = $this->db->select("COUNT(*) as num")->get("acessos_docentes_corrigidos");
        $result = $query->row();
        if(isset($result)) return $result->num;
        return 0;

    }
    
    function acessos_docentes_corrigidos($limit,$start,$col,$dir,$colsearch)
    {   
		$sql = "SELECT num_funcionario,nome,data,hora,porta,sentido,passou_cartao
				FROM 
				  acessos_docentes_corrigidos                 
				  WHERE 1=1";

        foreach (array_keys($colsearch) as $key) {

        		$sql.=" AND $key LIKE '".$colsearch[$key]."%' ";
        	
        }
				  
		if ($col == "hora" or $col =="data") {
				  	# code...
			$sql.="	ORDER BY 
				data $dir,hora $dir
				OFFSET $start ROWS
				FETCH NEXT $limit ROWS ONLY;";
		}
		else{		  
			$sql.="	ORDER BY 
				$col $dir,data $dir,hora $dir
				OFFSET $start ROWS
				FETCH NEXT $limit ROWS ONLY;";
			}

        $query = $this->db->query($sql);
        
        if($query->num_rows()>0)
        {
            return $query->result(); 
        }
        else
        {
            return null;
        }
        
    }
   
    function acessos_docentes_corrigidos_search($limit,$start,$search,$col,$dir,$colsearch)
    {
    	$search_s = $search.'%';
		$sql = "SELECT num_funcionario,nome,data,hora,porta,sentido,passou_cartao
				FROM 
				  acessos_docentes_corrigidos                 
				  WHERE (nome LIKE '$search_s' OR 
						data LIKE '$search_s' OR 
						porta LIKE '$search_s' or 
						hora LIKE  '$search_s' or
						num_funcionario LIKE '$search_s')";
;

        foreach (array_keys($colsearch) as $key) {

        		$sql.=" AND $key LIKE '".$colsearch[$key]."%' ";
        	
        }
				  
		if ($col == "hora" or $col =="data") {
			$sql.="	ORDER BY 
				data $dir,hora $dir
				OFFSET $start ROWS
				FETCH NEXT $limit ROWS ONLY;";
		}
		else{		  
			$sql.="	ORDER BY 
				$col $dir,data DESC,hora DESC
				OFFSET $start ROWS
				FETCH NEXT $limit ROWS ONLY;";
		}

        $query = $this->db->query($sql);
        
       
        if($query->num_rows()>0)
        {
            return $query->result();  
        }
        else
        {
            return null;
        }
    }

    function acessos_docentes_corrigidos_search_count($search,$colsearch)
    {
    	$search_s = $search.'%';
		$sql = "SELECT count(*) as num
				FROM 
				  acessos_docentes_corrigidos                 
				  WHERE (nome LIKE '$search_s' OR 
						data LIKE '$search_s' OR 
						porta LIKE '$search_s' or 
						hora LIKE  '$search_s' or
						num_funcionario LIKE '$search_s')";
;

        foreach (array_keys($colsearch) as $key) {

        		$sql.=" AND $key LIKE '".$colsearch[$key]."%' ";
        	
        }

      $query = $this->db->query($sql);
      $result = $query->row();
      if(isset($result)) return $result->num;
      return 0;
    }
    function acessos_docentes_corrigidos_search_column_count($colsearch){
    			$sql = "SELECT count(*) as num
				FROM 
				  acessos_docentes_corrigidos                 
				  WHERE 1=1";

        foreach (array_keys($colsearch) as $key) {

        		$sql.=" AND $key LIKE '".$colsearch[$key]."%' ";
        	
        }
      $query = $this->db->query($sql);
      $result = $query->row();
      if(isset($result)) return $result->num;
      return 0;
    }
    //ACESSOS docentes  
    function acessos_docentes_count()
    {   
      $query = $this->db->select("COUNT(*) as num")->get("acessos_docentes");
      $result = $query->row();
      if(isset($result)) return $result->num;
      return 0;  

    }
    
	function get_acessos_docentes($limit,$start,$col,$dir,$colsearch){

		$sql = "SELECT m.id_acesso,fu.num_funcionario,concat(fu.nome, ' ',fu.apelido) as nome,s.sentido as sentido,  
                a.data,a.hora,concat(p.edificio, '.',p.piso,'.',p.num_porta) as porta
                FROM 
                  acessos_docentes AS m 
                  JOIN acessos AS a on a.id = m.id_acesso
                  join sensores as s on s.id = a.id_sensor
                  join portas as p on p.id = s.id_porta
                  join docentes as do on m.id_docente = do.id
                  join funcionarios as fu on fu.id = do.id_funcionario
                  WHERE 1=1";
        foreach (array_keys($colsearch) as $key) {
        	if($key == 'porta'){
        		$sql.=" AND concat(p.edificio, '.',p.piso,'.',p.num_porta) LIKE '".$colsearch[$key]."%' ";
        	}
        	elseif ($key == 'nome') {
        		$sql.=" AND concat(fu.nome, ' ',fu.apelido) LIKE '".$colsearch[$key]."%' ";

        	}
        	else{
        		$sql.=" AND $key LIKE '".$colsearch[$key]."%' ";
        	}
        }
				  
		if ($col == "hora" or $col =="data") {
			$sql.="	ORDER BY 
				data $dir,hora $dir
				OFFSET $start ROWS
				FETCH NEXT $limit ROWS ONLY;";
		}
		else{		  
			$sql.="	ORDER BY 
				$col $dir,data DESC,hora DESC
				OFFSET $start ROWS
				FETCH NEXT $limit ROWS ONLY;";
		}
		$query = $this->db->query($sql);
		if($query->num_rows()>0)
        {
            return $query->result(); 
        }
        else
        {
            return null;
        }
        
	}
	function acessos_docentes_search($limit,$start,$search,$col,$dir,$colsearch)
    {
    	$search_s = $search.'%';
    	$sql = "SELECT m.id_acesso,fu.num_funcionario,concat(fu.nome, ' ',fu.apelido) as nome,s.sentido as sentido,  
                a.data,a.hora,concat(p.edificio, '.',p.piso,'.',p.num_porta) as porta
                FROM 
                  acessos_docentes AS m 
                  JOIN acessos AS a on a.id = m.id_acesso
                  join sensores as s on s.id = a.id_sensor
                  join portas as p on p.id = s.id_porta
                  join docentes as do on m.id_docente = do.id
                  join funcionarios as fu on fu.id = do.id_funcionario
				WHERE (concat(fu.nome, ' ',fu.apelido)  LIKE '$search_s' OR 
						data LIKE '$search_s' OR 
						concat (p.edificio, '.',p.piso,'.',p.num_porta) LIKE '$search_s' or 
						hora LIKE  '$search_s' or
						num_funcionario LIKE '$search_s')";
		foreach (array_keys($colsearch) as $key) {
        	if($key == 'porta'){
        		$sql.=" AND concat(p.edificio, '.',p.piso,'.',p.num_porta) LIKE '".$colsearch[$key]."%' ";
        	}
        	elseif ($key == 'nome') {
        		$sql.=" AND concat(fu.nome, ' ',fu.apelido) LIKE '".$colsearch[$key]."%' ";

        	}
        	else{
        		$sql.=" AND $key LIKE '".$colsearch[$key]."%' ";
        	}
        }

		if ($col == "hora" or $col =="data") {
			$sql.="	ORDER BY 
				data $dir,hora $dir
				OFFSET $start ROWS
				FETCH NEXT $limit ROWS ONLY;";
		}
		else{		  
			$sql.="	ORDER BY 
				$col $dir,data DESC,hora DESC
				OFFSET $start ROWS
				FETCH NEXT $limit ROWS ONLY;";
		}
       	$query=$this->db->query($sql);

        if($query->num_rows()>0)
        {
            return $query->result();  
        }
        else
        {
            return null;
        }
    }
    function acessos_docentes_search_count($search, $colsearch)
    {
    	$search_s = $search.'%';
    	$sql = "SELECT count(*) as num
				FROM 
                  acessos_docentes AS m 
                  JOIN acessos AS a on a.id = m.id_acesso
                  join sensores as s on s.id = a.id_sensor
                  join portas as p on p.id = s.id_porta
                  join docentes as do on m.id_docente = do.id
                  join funcionarios as fu on fu.id = do.id_funcionario
				WHERE (concat(fu.nome, ' ',fu.apelido)  LIKE '$search_s' OR 
						data LIKE '$search_s' OR 
						concat (p.edificio, '.',p.piso,'.',p.num_porta) LIKE '$search_s' or 
						hora LIKE  '$search_s' or
						num_funcionario LIKE '$search_s')";
       	foreach (array_keys($colsearch) as $key) {
        	if($key == 'porta'){
        		$sql.=" AND concat(p.edificio, '.',p.piso,'.',p.num_porta) LIKE '".$colsearch[$key]."%' ";
        	}
        	elseif ($key == 'nome') {
        		$sql.=" AND concat(fu.nome, ' ',fu.apelido) LIKE '".$colsearch[$key]."%' ";

        	}
        	else{
        		$sql.=" AND $key LIKE '".$colsearch[$key]."%' ";
        	}
        }
       
    	$query = $this->db->query($sql);

      $result = $query->row();
      if(isset($result)) return $result->num;
      return 0;
 	}
 	function acessos_docentes_search_column_count($colsearch)
    {

    	$sql = "SELECT count(*) as num
				FROM 
                  acessos_docentes AS m 
                  JOIN acessos AS a on a.id = m.id_acesso
                  join sensores as s on s.id = a.id_sensor
                  join portas as p on p.id = s.id_porta
                  join docentes as do on m.id_docente = do.id
                  join funcionarios as fu on fu.id = do.id_funcionario
                  WHERE 1=1";
        foreach (array_keys($colsearch) as $key) {
        	if($key == 'porta'){
        		$sql.=" AND concat(p.edificio, '.',p.piso,'.',p.num_porta) LIKE '".$colsearch[$key]."%' ";
        	}
        	elseif ($key == 'nome') {
        		$sql.=" AND concat(fu.nome, ' ',fu.apelido) LIKE '".$colsearch[$key]."%' ";

        	}
        	else{
        		$sql.=" AND $key LIKE '".$colsearch[$key]."%' ";
        	}
        }       
    	$query = $this->db->query($sql);

      $result = $query->row();
      if(isset($result)) return $result->num;
      return 0;
 	}

 	// -------------------------------------------------
     //ACESSOS Corrigidos nao_docentes
    function ha_novos_acessos_nao_docentes(){
        $sql = "SELECT count (*) as num
                FROM   acessos_nao_docentes
                WHERE  not EXISTS (SELECT *
                                 FROM   acessos_nao_docentes_corrigidos
                                WHERE  acessos_nao_docentes.id_acesso = acessos_nao_docentes_corrigidos.id_acesso);" ;
        $query = $this->db->query($sql);

        $result = $query->row();
        if($result->num != 0 ) return 1;
        return 0;  

    }
      function get_acesso_nao_docente_corrigido_mais_recente($id_nao_docente){
            $sql = "SELECT top 1 id_acesso,ac.num_funcionario,ac.nome, ac.data, ac.hora, ac.porta,ac.sentido,ac.passou_cartao
                  FROM [dbo].[acessos_nao_docentes_corrigidos] as ac
                  join funcionarios as fu on  ac.num_funcionario = fu.num_funcionario
                  join nao_docentes as do on do.id_funcionario = fu.id
                  where do.id = $id_nao_docente
                  order by data desc, hora desc, id_acesso desc";
            $query = $this->db->query($sql);
            return $query->result_array();
    }
      function get_nao_docentes_com_acessos(){
            $sql = "SELECT id_nao_docente
                    FROM acessos_nao_docentes as m
                    WHERE  not EXISTS (SELECT *
                                 FROM   acessos_nao_docentes_corrigidos
                                WHERE  m.id_acesso = acessos_nao_docentes_corrigidos.id_acesso) 
                                group by id_nao_docente;" ;
            $query = $this->db->query($sql);
            return $query->result_array();
    }

        function corrige_acessos_nao_docentes(){
            
            $acessos_corrigidos = array();
            $nao_docentes = $this->get_nao_docentes_com_acessos();
            foreach ($nao_docentes as $nao_docente ) {
                $id_nao_docente = $nao_docente['id_nao_docente'];
                $sql = "SELECT m.id_acesso,fu.num_funcionario,concat(fu.nome, ' ',fu.apelido) as nome,s.sentido,  a.data,a.hora,
                                concat(p.edificio, '.',p.piso,'.',p.num_porta) as porta,s.sentido
                        FROM acessos_nao_docentes AS m
                          JOIN acessos AS a on a.id = m.id_acesso
                          join sensores as s on s.id = a.id_sensor
                          join portas as p on p.id = s.id_porta
                          join nao_docentes as do on m.id_nao_docente = do.id
                          join funcionarios as fu on do.id_funcionario = fu.id
                         WHERE  not EXISTS (SELECT *
                                 FROM   acessos_nao_docentes_corrigidos
                                WHERE  m.id_acesso = acessos_nao_docentes_corrigidos.id_acesso)
                                 and m.id_nao_docente = $id_nao_docente
                        ORDER BY a.data DESC, a.hora DESC";
                $query = $this->db->query($sql);
                $result = $query->result_array();
                $acesso_corrido_mais_recente = $this->get_acesso_nao_docente_corrigido_mais_recente($id_nao_docente);
                
                if(!empty($acesso_corrido_mais_recente)){
                    array_push($result, $acesso_corrido_mais_recente[0]);
                }
                $acessos_corrigido_nao_docente =  $this->corrige_acessos($result);
                if(!empty($acesso_corrido_mais_recente)){
                    $key = array_search($acesso_corrido_mais_recente[0], $acessos_corrigido_nao_docente);
                
                    if($key){
                        unset($acessos_corrigido_nao_docente[$key]);

                    }
                }
                
                foreach($acessos_corrigido_nao_docente as $acesso){
                    if($acesso['id_acesso'] > 0){
                                    $acesso['passou_cartao'] = "Sim";
                                }
                                else{
                                    $acesso['passou_cartao'] = "Não";
                                }           
                                array_push($acessos_corrigidos, $acesso);
                            
                }
            }
    
            return $this->insert_nao_docentes_corrigidos($acessos_corrigidos);
        }

        function insert_nao_docentes_corrigidos($array) { 
            foreach ($array as $row) {
                $id_acesso = $row['id_acesso'];
                $num_funcionario = $row['num_funcionario'];
                $nome = str_replace('\'', '\'\'',$row['nome']);
                $data = $row['data'];
                $hora = $row['hora'];
                $porta = $row['porta'];
                $sentido = $row['sentido'];
                $passou_cartao = $row['passou_cartao'];
            // $query1 = $this->db->empty_table('acessos_nao_docentes_corrigidos');
            // $query2 = $this->db->insert_batch('acessos_nao_docentes_corrigidos', $result);

                $sql = "INSERT INTO acessos_nao_docentes_corrigidos (id_acesso,num_funcionario,nome,data,hora,porta,sentido,passou_cartao) values($id_acesso,$num_funcionario,'$nome','$data','$hora','$porta','$sentido','$passou_cartao');";
                $query1 = $this->db->query($sql);
                if (!$query1) {
                    $this->db->trans_rollback();
                    return false;
                }
            
        
            }
            return true;
    
        
        }

        function acessos_nao_docentes_corrigidos_count()
    {   
       $query = $this->db->select("COUNT(*) as num")->get("acessos_nao_docentes_corrigidos");
        $result = $query->row();
        if(isset($result)) return $result->num;
        return 0;

    }
    
    function acessos_nao_docentes_corrigidos($limit,$start,$col,$dir,$colsearch)
    {   
		$sql = "SELECT num_funcionario,nome,data,hora,porta,sentido,passou_cartao
				FROM 
				  acessos_nao_docentes_corrigidos                 
				  WHERE 1=1";

        foreach (array_keys($colsearch) as $key) {

        		$sql.=" AND $key LIKE '".$colsearch[$key]."%' ";
        	
        }
				  
		if ($col == "hora" or $col =="data") {
			$sql.="	ORDER BY 
				data $dir,hora $dir
				OFFSET $start ROWS
				FETCH NEXT $limit ROWS ONLY;";
		}
		else{		  
			$sql.="	ORDER BY 
				$col $dir,data DESC,hora DESC
				OFFSET $start ROWS
				FETCH NEXT $limit ROWS ONLY;";
		}

        $query = $this->db->query($sql);
        
        if($query->num_rows()>0)
        {
            return $query->result(); 
        }
        else
        {
            return null;
        }
    }
   
    function acessos_nao_docentes_corrigidos_search($limit,$start,$search,$col,$dir,$colsearch)
    {
    	$search_s = $search.'%';
		$sql = "SELECT num_funcionario,nome,data,hora,porta,sentido,passou_cartao
				FROM 
				  acessos_nao_docentes_corrigidos                 
				  WHERE (nome LIKE '$search_s' OR 
						data LIKE '$search_s' OR 
						porta LIKE '$search_s' or 
						hora LIKE  '$search_s' or
						num_funcionario LIKE '$search_s')";
;

        foreach (array_keys($colsearch) as $key) {

        		$sql.=" AND $key LIKE '".$colsearch[$key]."%' ";
        	
        }
				  
		if ($col == "hora" or $col =="data") {
			$sql.="	ORDER BY 
				data $dir,hora $dir
				OFFSET $start ROWS
				FETCH NEXT $limit ROWS ONLY;";
		}
		else{		  
			$sql.="	ORDER BY 
				$col $dir,data DESC,hora DESC
				OFFSET $start ROWS
				FETCH NEXT $limit ROWS ONLY;";
		}

        $query = $this->db->query($sql);
        
       
        if($query->num_rows()>0)
        {
            return $query->result();  
        }
        else
        {
            return null;
        }
    }

    function acessos_nao_docentes_corrigidos_search_count($search,$colsearch)
    {
		$search_s = $search.'%';
		$sql = "SELECT count(*) as num
				FROM 
				  acessos_nao_docentes_corrigidos                 
				  WHERE (nome LIKE '$search_s' OR 
						data LIKE '$search_s' OR 
						porta LIKE '$search_s' or 
						hora LIKE  '$search_s' or
						num_funcionario LIKE '$search_s')";

        foreach (array_keys($colsearch) as $key) {

        		$sql.=" AND $key LIKE '".$colsearch[$key]."%' ";
        	
        }

      $query = $this->db->query($sql);
      $result = $query->row();
      if(isset($result)) return $result->num;
      return 0;
    }

     function acessos_nao_docentes_corrigidos_search_column_count($colsearch){
    			$sql = "SELECT count(*) as num
				FROM 
				  acessos_nao_docentes_corrigidos                 
				  WHERE 1=1";

        foreach (array_keys($colsearch) as $key) {

        		$sql.=" AND $key LIKE '".$colsearch[$key]."%' ";
        	
        }
      $query = $this->db->query($sql);
      $result = $query->row();
      if(isset($result)) return $result->num;
      return 0;
    }
    //ACESSOS nao_docentes  
    function acessos_nao_docentes_count()
    {   
      $query = $this->db->select("COUNT(*) as num")->get("acessos_nao_docentes");
      $result = $query->row();
      if(isset($result)) return $result->num;
      return 0;  

    }
    
    function get_acessos_nao_docentes($limit,$start,$col,$dir,$colsearch){

        $sql = "SELECT m.id_acesso,fu.num_funcionario,concat(fu.nome, ' ',fu.apelido) as nome,s.sentido as sentido,  
                a.data,a.hora,concat(p.edificio, '.',p.piso,'.',p.num_porta) as porta
                FROM 
                  acessos_nao_docentes AS m 
                  JOIN acessos AS a on a.id = m.id_acesso
                  join sensores as s on s.id = a.id_sensor
                  join portas as p on p.id = s.id_porta
                  join nao_docentes as do on m.id_nao_docente = do.id
                  join funcionarios as fu on fu.id = do.id_funcionario
                  WHERE 1=1";
        foreach (array_keys($colsearch) as $key) {
        	if($key == 'porta'){
        		$sql.=" AND concat(p.edificio, '.',p.piso,'.',p.num_porta) LIKE '".$colsearch[$key]."%' ";
        	}
        	elseif ($key == 'nome') {
        		$sql.=" AND concat(fu.nome, ' ',fu.apelido) LIKE '".$colsearch[$key]."%' ";

        	}
        	else{
        		$sql.=" AND $key LIKE '".$colsearch[$key]."%' ";
        	}
        }

		if ($col == "hora" or $col =="data") {
			$sql.="	ORDER BY 
				data $dir,hora $dir
				OFFSET $start ROWS
				FETCH NEXT $limit ROWS ONLY;";
		}
		else{		  
			$sql.="	ORDER BY 
				$col $dir,data DESC,hora DESC
				OFFSET $start ROWS
				FETCH NEXT $limit ROWS ONLY;";
		}
        $query = $this->db->query($sql);
        if($query->num_rows()>0)
        {
            return $query->result(); 
        }
        else
        {
            return null;
        }
        
    }
    function acessos_nao_docentes_search($limit,$start,$search,$col,$dir,$colsearch)
    {
        $search_s = $search.'%';
        $sql = "SELECT m.id_acesso,fu.num_funcionario,concat(fu.nome, ' ',fu.apelido) as nome,s.sentido as sentido,  
                a.data,a.hora,concat(p.edificio, '.',p.piso,'.',p.num_porta) as porta
                FROM 
                  acessos_nao_docentes AS m 
                  JOIN acessos AS a on a.id = m.id_acesso
                  join sensores as s on s.id = a.id_sensor
                  join portas as p on p.id = s.id_porta
                  join nao_docentes as do on m.id_nao_docente = do.id
                  join funcionarios as fu on fu.id = do.id_funcionario
                WHERE (concat(fu.nome, ' ',fu.apelido)  LIKE '$search_s' OR 
                        data LIKE '$search_s' OR 
                        concat (p.edificio, '.',p.piso,'.',p.num_porta) LIKE '$search_s' or 
                        hora LIKE  '$search_s' or
                        num_funcionario LIKE '$search_s')";
       
     		foreach (array_keys($colsearch) as $key) {
        	if($key == 'porta'){
        		$sql.=" AND concat(p.edificio, '.',p.piso,'.',p.num_porta) LIKE '".$colsearch[$key]."%' ";
        	}
        	elseif ($key == 'nome') {
        		$sql.=" AND concat(fu.nome, ' ',fu.apelido) LIKE '".$colsearch[$key]."%' ";

        	}
        	else{
        		$sql.=" AND $key LIKE '".$colsearch[$key]."%' ";
        	}
        }

		if ($col == "hora" or $col =="data") {
			$sql.="	ORDER BY 
				data $dir,hora $dir
				OFFSET $start ROWS
				FETCH NEXT $limit ROWS ONLY;";
		}
		else{		  
			$sql.="	ORDER BY 
				$col $dir,data DESC,hora DESC
				OFFSET $start ROWS
				FETCH NEXT $limit ROWS ONLY;";
		}
        $query=$this->db->query($sql);

        if($query->num_rows()>0)
        {
            return $query->result();  
        }
        else
        {
            return null;
        }
    }
    function acessos_nao_docentes_search_count($search,$colsearch)
    {
        $search_s = $search.'%';
        $sql = "SELECT count(*) as num
                FROM 
                  acessos_nao_docentes AS m 
                  JOIN acessos AS a on a.id = m.id_acesso
                  join sensores as s on s.id = a.id_sensor
                  join portas as p on p.id = s.id_porta
                  join nao_docentes as do on m.id_nao_docente = do.id
                  join funcionarios as fu on fu.id = do.id_funcionario
                WHERE (concat(fu.nome, ' ',fu.apelido)  LIKE '$search_s' OR 
                        data LIKE '$search_s' OR 
                        concat (p.edificio, '.',p.piso,'.',p.num_porta) LIKE '$search_s' or 
                        hora LIKE  '$search_s' or
                        num_funcionario LIKE '$search_s')";
        foreach (array_keys($colsearch) as $key) {
        	if($key == 'porta'){
        		$sql.=" AND concat(p.edificio, '.',p.piso,'.',p.num_porta) LIKE '".$colsearch[$key]."%' ";
        	}
        	elseif ($key == 'nome') {
        		$sql.=" AND concat(fu.nome, ' ',fu.apelido) LIKE '".$colsearch[$key]."%' ";

        	}
        	else{
        		$sql.=" AND $key LIKE '".$colsearch[$key]."%' ";
        	}
        }
       
        $query = $this->db->query($sql);

      $result = $query->row();
      if(isset($result)) return $result->num;
      return 0;
    }
     	function acessos_nao_docentes_search_column_count($colsearch)
    {

    	$sql = "SELECT count(*) as num
				FROM 
                  acessos_nao_docentes AS m 
                  JOIN acessos AS a on a.id = m.id_acesso
                  join sensores as s on s.id = a.id_sensor
                  join portas as p on p.id = s.id_porta
                  join nao_docentes as do on m.id_nao_docente = do.id
                  join funcionarios as fu on fu.id = do.id_funcionario
                  WHERE 1=1";
        foreach (array_keys($colsearch) as $key) {
        	if($key == 'porta'){
        		$sql.=" AND concat(p.edificio, '.',p.piso,'.',p.num_porta) LIKE '".$colsearch[$key]."%' ";
        	}
        	elseif ($key == 'nome') {
        		$sql.=" AND concat(fu.nome, ' ',fu.apelido) LIKE '".$colsearch[$key]."%' ";

        	}
        	else{
        		$sql.=" AND $key LIKE '".$colsearch[$key]."%' ";
        	}
        }       
    	$query = $this->db->query($sql);

      $result = $query->row();
      if(isset($result)) return $result->num;
      return 0;
 	}

    //------------------------------------------------------


		function get_tabela_acessos_user_aluno(){
			
    		$acessos_corrigidos = array();

    		$id_aluno = $this->session->userdata('id');
    		$sql = "SELECT m.id_acesso,al.num_aluno,concat(al.nome, ' ',al.apelido) as nome,s.sentido,  a.data,a.hora,
    							concat(p.edificio, '.',p.piso,'.',p.num_porta) as porta,s.sentido
						FROM acessos_alunos AS m
						  JOIN acessos AS a on a.id = m.id_acesso
						  join sensores as s on s.id = a.id_sensor
						  join portas as p on p.id = s.id_porta
						  join alunos as al on m.id_aluno = al.id
  						where m.id_aluno = $id_aluno
						ORDER BY a.data DESC, a.hora DESC";
			$query = $this->db->query($sql);
			if($query->num_rows() == 0){
				return array();
			}
			else{
				$result = $query->result_array();
			
				array_push($acessos_corrigidos, $this->corrige_acessos($result));
    			return $this->array_flatten($acessos_corrigidos);
    		}
		}
		function get_tabela_acessos_user_docente(){
			
    		$acessos_corrigidos = array();

    		$id_funcionario = $this->session->userdata('id');
  			$sql = "SELECT m.id_acesso,fu.num_funcionario,concat(fu.nome, ' ',fu.apelido) as nome,s.sentido,  
    			a.data,a.hora,concat(p.edificio, '.',p.piso,'.',p.num_porta) as porta,s.sentido
				FROM 
				  acessos_docentes AS m
				  JOIN acessos AS a on a.id = m.id_acesso
				  join sensores as s on s.id = a.id_sensor
				  join portas as p on p.id = s.id_porta
				  join docentes as do on m.id_docente = do.id
				  join funcionarios as fu on do.id_funcionario = fu.id
				where fu.id = $id_funcionario
				ORDER BY 
				a.data DESC, a.hora DESC";
			$query = $this->db->query($sql);
			if($query->num_rows() == 0){
				return array();
			}
			else{
				$result = $query->result_array();
			
				array_push($acessos_corrigidos, $this->corrige_acessos($result));
    			return $this->array_flatten($acessos_corrigidos);
    		}
		}
	/*ACESSOS USER ALUNO*/
	 function acessos_user_aluno_count()
    {   
      $id_aluno = $this->session->userdata('id');
      $sql = "SELECT COUNT(*) as num from acessos_alunos where id_aluno = $id_aluno";
      $query = $this->db->query($sql);
      $result = $query->row();
      if(isset($result)) return $result->num;
      return 0;  

    }
    
	function get_acessos_user_aluno($limit,$start,$col,$dir,$colsearch){
		$id_aluno = $this->session->userdata('id');
		$sql = "SELECT m.id_acesso,al.num_aluno,concat(al.nome, ' ',al.apelido) as nome,s.sentido as sentido,  
    			a.data,a.hora,concat(p.edificio, '.',p.piso,'.',p.num_porta) as porta
				FROM 
				  acessos_alunos AS m 
				  JOIN acessos AS a on a.id = m.id_acesso
				  join sensores as s on s.id = a.id_sensor
				  join portas as p on p.id = s.id_porta
				  join alunos as al on m.id_aluno = al.id                  
				  WHERE 1=1 and al.id = $id_aluno";

        foreach (array_keys($colsearch) as $key) {

        	if($key == 'porta'){
        		$sql.=" AND concat(p.edificio, '.',p.piso,'.',p.num_porta) LIKE '".$colsearch[$key]."%' ";
        	}
        	elseif ($key == 'nome') {
        		$sql.=" AND concat(al.nome, ' ',al.apelido) LIKE '".$colsearch[$key]."%' ";

        	}
        	else{
        		$sql.=" AND $key LIKE '".$colsearch[$key]."%' ";
        	}
        }
				  
		if ($col == "hora" or $col =="data") {
			$sql.="	ORDER BY 
				data $dir,hora $dir
				OFFSET $start ROWS
				FETCH NEXT $limit ROWS ONLY;";
		}
		else{		  
			$sql.="	ORDER BY 
				$col $dir,data DESC,hora DESC
				OFFSET $start ROWS
				FETCH NEXT $limit ROWS ONLY;";
		}
		$query = $this->db->query($sql);
		if($query->num_rows()>0)
        {
            return $query->result(); 
        }
        else
        {
            return null;
        }
        
	}
	function acessos_user_aluno_search($limit,$start,$search,$col,$dir,$colsearch)
    {
    	$id_aluno = $this->session->userdata('id');
    	$search_s = $search.'%';
    	$sql = "SELECT m.id_acesso,al.num_aluno,concat(al.nome, ' ',al.apelido) as nome,s.sentido,  
    			a.data,a.hora,concat(p.edificio, '.',p.piso,'.',p.num_porta) as porta,s.sentido
				FROM 
				  acessos_alunos AS m 
				  JOIN acessos AS a on a.id = m.id_acesso
				  join sensores as s on s.id = a.id_sensor
				  join portas as p on p.id = s.id_porta
				  join alunos as al on m.id_aluno = al.id
				WHERE (concat(al.nome, ' ',al.apelido)  LIKE '$search_s' OR 
						data LIKE '$search_s' OR 
						concat (p.edificio, '.',p.piso,'.',p.num_porta) LIKE '$search_s' or 
						hora LIKE  '$search_s' or
						num_aluno LIKE '$search_s') and al.id = $id_aluno";

		foreach (array_keys($colsearch) as $key) {
        	if($key == 'porta'){
        		$sql.=" AND concat(p.edificio, '.',p.piso,'.',p.num_porta) LIKE '".$colsearch[$key]."%' ";
        	}
        	elseif ($key == 'nome') {
        		$sql.=" AND concat(al.nome, ' ',al.apelido) LIKE '".$colsearch[$key]."%' ";

        	}
        	else{
        		$sql.=" AND $key LIKE '".$colsearch[$key]."%' ";
        	}
        }

       
		if ($col == "hora" or $col =="data") {
			$sql.="	ORDER BY 
				data $dir,hora $dir
				OFFSET $start ROWS
				FETCH NEXT $limit ROWS ONLY;";
		}
		else{		  
			$sql.="	ORDER BY 
				$col $dir,data DESC,hora DESC
				OFFSET $start ROWS
				FETCH NEXT $limit ROWS ONLY;";
		}
       	$query=$this->db->query($sql);

        if($query->num_rows()>0)
        {
            return $query->result();  
        }
        else
        {
            return null;
        }
    }
    function acessos_user_aluno_search_count($search,$colsearch)
    {
    	$id_aluno = $this->session->userdata('id');
    	$search_s = $search.'%';
    	$sql = "SELECT count(*) as num
				FROM 
				  acessos_alunos AS m 
				  JOIN acessos AS a on a.id = m.id_acesso
				  join sensores as s on s.id = a.id_sensor
				  join portas as p on p.id = s.id_porta
				  join alunos as al on m.id_aluno = al.id
				WHERE (concat(al.nome, ' ',al.apelido)  LIKE '$search_s' OR 
						data LIKE '$search_s' OR 
						concat (p.edificio, '.',p.piso,'.',p.num_porta) LIKE '$search_s' or 
						hora LIKE  '$search_s' or
						num_aluno LIKE '$search_s') and al.id = $id_aluno";

		foreach (array_keys($colsearch) as $key) {
        	if($key == 'porta'){
        		$sql.=" AND concat(p.edificio, '.',p.piso,'.',p.num_porta) LIKE '".$colsearch[$key]."%' ";
        	}
        	elseif ($key == 'nome') {
        		$sql.=" AND concat(al.nome, ' ',al.apelido) LIKE '".$colsearch[$key]."%' ";

        	}
        	else{
        		$sql.=" AND $key LIKE '".$colsearch[$key]."%' ";
        	}
        }
       ;
       
    	$query = $this->db->query($sql);

      $result = $query->row();
      if(isset($result)) return $result->num;
      return 0;
 	}
 	function acessos_user_aluno_search_column_count($colsearch)
    {
    	$id_aluno = $this->session->userdata('id');
    	$sql = "SELECT count(*) as num
				FROM 
			  acessos_alunos AS m 
				  JOIN acessos AS a on a.id = m.id_acesso
				  join sensores as s on s.id = a.id_sensor
				  join portas as p on p.id = s.id_porta
				  join alunos as al on m.id_aluno = al.id
                  WHERE 1=1 and al.id = $id_aluno";
        foreach (array_keys($colsearch) as $key) {
        	if($key == 'porta'){
        		$sql.=" AND concat(p.edificio, '.',p.piso,'.',p.num_porta) LIKE '".$colsearch[$key]."%' ";
        	}
        	elseif ($key == 'nome') {
        		$sql.=" AND concat(al.nome, ' ',al.apelido) LIKE '".$colsearch[$key]."%' ";

        	}
        	else{
        		$sql.=" AND $key LIKE '".$colsearch[$key]."%' ";
        	}
        }       
    	$query = $this->db->query($sql);

      $result = $query->row();
      if(isset($result)) return $result->num;
      return 0;
 	}
	/*---------------------*/
	/*ACESSOS USER DOCENTE*/

	 function acessos_user_docente_count()
    {   
      $id = $this->session->userdata('id');
      $sql = "SELECT COUNT(*) as num FROM acessos_docentes as m
                        join docentes as do on m.id_docente = do.id
                        join funcionarios as fu on fu.id = do.id_funcionario
					 where fu.id = $id";
      $query = $this->db->query($sql);
      $result = $query->row();
      if(isset($result)) return $result->num;
      return 0;  

    }
    
	function get_acessos_user_docente($limit,$start,$col,$dir,$colsearch){
		$id = $this->session->userdata('id');
		$sql = "SELECT m.id_acesso,fu.num_funcionario,concat(fu.nome, ' ',fu.apelido) as nome,s.sentido as sentido,  
                a.data,a.hora,concat(p.edificio, '.',p.piso,'.',p.num_porta) as porta
                FROM 
                  acessos_docentes AS m 
                  JOIN acessos AS a on a.id = m.id_acesso
                  join sensores as s on s.id = a.id_sensor
                  join portas as p on p.id = s.id_porta
                  join docentes as do on m.id_docente = do.id
                  join funcionarios as fu on fu.id = do.id_funcionario
                  WHERE 1=1 and fu.id=$id";
        foreach (array_keys($colsearch) as $key) {
        	if($key == 'porta'){
        		$sql.=" AND concat(p.edificio, '.',p.piso,'.',p.num_porta) LIKE '".$colsearch[$key]."%' ";
        	}
        	elseif ($key == 'nome') {
        		$sql.=" AND concat(fu.nome, ' ',fu.apelido) LIKE '".$colsearch[$key]."%' ";

        	}
        	else{
        		$sql.=" AND $key LIKE '".$colsearch[$key]."%' ";
        	}
        }
				  
		if ($col == "hora" or $col =="data") {
			$sql.="	ORDER BY 
				data $dir,hora $dir
				OFFSET $start ROWS
				FETCH NEXT $limit ROWS ONLY;";
		}
		else{		  
			$sql.="	ORDER BY 
				$col $dir,data DESC,hora DESC
				OFFSET $start ROWS
				FETCH NEXT $limit ROWS ONLY;";
		}
		$query = $this->db->query($sql);
		if($query->num_rows()>0)
        {
            return $query->result(); 
        }
        else
        {
            return null;
        }
        
	}
	function acessos_user_docente_search($limit,$start,$search,$col,$dir,$colsearch)
    {

    	$id = $this->session->userdata('id');
    	$search_s = $search.'%';
    	$sql = "SELECT m.id_acesso,fu.num_funcionario,concat(fu.nome, ' ',fu.apelido) as nome,s.sentido as sentido,  
                a.data,a.hora,concat(p.edificio, '.',p.piso,'.',p.num_porta) as porta
                FROM 
                  acessos_docentes AS m 
                  JOIN acessos AS a on a.id = m.id_acesso
                  join sensores as s on s.id = a.id_sensor
                  join portas as p on p.id = s.id_porta
                  join docentes as do on m.id_docente = do.id
                  join funcionarios as fu on fu.id = do.id_funcionario
				WHERE (concat(fu.nome, ' ',fu.apelido)  LIKE '$search_s' OR 
						data LIKE '$search_s' OR 
						concat (p.edificio, '.',p.piso,'.',p.num_porta) LIKE '$search_s' or 
						hora LIKE  '$search_s' or
						num_funcionario LIKE '$search_s') and fu.id=$id";
		foreach (array_keys($colsearch) as $key) {
        	if($key == 'porta'){
        		$sql.=" AND concat(p.edificio, '.',p.piso,'.',p.num_porta) LIKE '".$colsearch[$key]."%' ";
        	}
        	elseif ($key == 'nome') {
        		$sql.=" AND concat(fu.nome, ' ',fu.apelido) LIKE '".$colsearch[$key]."%' ";

        	}
        	else{
        		$sql.=" AND $key LIKE '".$colsearch[$key]."%' ";
        	}
        }

       
		if ($col == "hora" or $col =="data") {
			$sql.="	ORDER BY 
				data $dir,hora $dir
				OFFSET $start ROWS
				FETCH NEXT $limit ROWS ONLY;";
		}
		else{		  
			$sql.="	ORDER BY 
				$col $dir,data DESC,hora DESC
				OFFSET $start ROWS
				FETCH NEXT $limit ROWS ONLY;";
		}
       	$query=$this->db->query($sql);

        if($query->num_rows()>0)
        {
            return $query->result();  
        }
        else
        {
            return null;
        }
    }
    function acessos_user_docente_search_count($search, $colsearch)
    {
    	$id = $this->session->userdata('id');
    	$search_s = $search.'%';
    	$sql = "SELECT count(*) as num
				FROM 
                  acessos_docentes AS m 
                  JOIN acessos AS a on a.id = m.id_acesso
                  join sensores as s on s.id = a.id_sensor
                  join portas as p on p.id = s.id_porta
                  join docentes as do on m.id_docente = do.id
                  join funcionarios as fu on fu.id = do.id_funcionario
				WHERE (concat(fu.nome, ' ',fu.apelido)  LIKE '$search_s' OR 
						data LIKE '$search_s' OR 
						concat (p.edificio, '.',p.piso,'.',p.num_porta) LIKE '$search_s' or 
						hora LIKE  '$search_s' or
						num_funcionario LIKE '$search_s') and fu.id=$id";
       	foreach (array_keys($colsearch) as $key) {
        	if($key == 'porta'){
        		$sql.=" AND concat(p.edificio, '.',p.piso,'.',p.num_porta) LIKE '".$colsearch[$key]."%' ";
        	}
        	elseif ($key == 'nome') {
        		$sql.=" AND concat(fu.nome, ' ',fu.apelido) LIKE '".$colsearch[$key]."%' ";

        	}
        	else{
        		$sql.=" AND $key LIKE '".$colsearch[$key]."%' ";
        	}
        }
       
    	$query = $this->db->query($sql);

      $result = $query->row();
      if(isset($result)) return $result->num;
      return 0;
 	}
 	function acessos_user_docente_search_column_count($colsearch)
    {
		$id = $this->session->userdata('id');
    	$sql = "SELECT count(*) as num
				FROM 
                  acessos_docentes AS m 
                  JOIN acessos AS a on a.id = m.id_acesso
                  join sensores as s on s.id = a.id_sensor
                  join portas as p on p.id = s.id_porta
                  join docentes as do on m.id_docente = do.id
                  join funcionarios as fu on fu.id = do.id_funcionario
                  WHERE 1=1 and fu.id=$id";
        foreach (array_keys($colsearch) as $key) {
        	if($key == 'porta'){
        		$sql.=" AND concat(p.edificio, '.',p.piso,'.',p.num_porta) LIKE '".$colsearch[$key]."%' ";
        	}
        	elseif ($key == 'nome') {
        		$sql.=" AND concat(fu.nome, ' ',fu.apelido) LIKE '".$colsearch[$key]."%' ";

        	}
        	else{
        		$sql.=" AND $key LIKE '".$colsearch[$key]."%' ";
        	}
        }       
    	$query = $this->db->query($sql);

      $result = $query->row();
      if(isset($result)) return $result->num;
      return 0;
 	}
	/*----------------------------*/
	function corrige_acessos($acessos_por_pessoa){
		$copia_acessos = $acessos_por_pessoa;
		if(sizeof($acessos_por_pessoa) > 1){
			for ($i=0; $i <sizeof($acessos_por_pessoa)-1 ; $i++) { 
			 	if($acessos_por_pessoa[$i]['sentido'] == "Entrada"){
			 		if($acessos_por_pessoa[$i+1]['sentido'] == "Entrada"){ // temos que simular uma saida
			 				$copia_acesso=$acessos_por_pessoa[$i+1];
			 				$copia_acesso['sentido'] = "Saida";
			 				$copia_acesso['hora'] = $this->sum_time($copia_acesso['hora'], '+');
			 				$copia_acesso['id_acesso'] = -$copia_acesso['id_acesso'];
			 				array_push( $copia_acessos, $copia_acesso ); // VOLTARA A EXPERIMENTAR ARRAY_SPLICE
			 				
			 				
			 		}
			 		else{
			 			continue;
			 		}
			 		
			 	}
			 	else{
			 		if($acessos_por_pessoa[$i+1]['sentido'] == "Saida"){ // temos que simular uma entrada
			 				$copia_acesso2=$acessos_por_pessoa[$i];
			 				$copia_acesso2['sentido'] = "Entrada";
			 				$copia_acesso2['hora'] = $this->sum_time($copia_acesso2['hora'], '-');

			 				$copia_acesso2['id_acesso'] = -$copia_acesso2['id_acesso'];
			 				array_push( $copia_acessos, $copia_acesso2); 
	

			 		}
			 		else if($acessos_por_pessoa[$i+1]['sentido'] == "Entrada"){
			 			if($acessos_por_pessoa[$i]['porta'] != $acessos_por_pessoa[$i+1]['porta'] ){
			 				$copia_acesso= $acessos_por_pessoa[$i+1];
			 				$copia_acesso['sentido'] = "Saida";
			 				$copia_acesso['hora'] = $this->sum_time($copia_acesso['hora'], '+');
			 				$copia_acesso['id_acesso'] = -$copia_acesso['id_acesso'];

			 				$copia_acesso2=$acessos_por_pessoa[$i];
			 				$copia_acesso2['sentido'] = "Entrada";
			 				$copia_acesso2['hora'] = $this->sum_time($copia_acesso2['hora'], '-');
			 				$copia_acesso2['id_acesso'] = -$copia_acesso2['id_acesso'];
			 				array_push( $copia_acessos, $copia_acesso ); 
			 				array_push( $copia_acessos, $copia_acesso2); 
			 			}
			 		}
			 		else if(sizeof($acessos_por_pessoa) == $i+1){ // se nao há mais acessos
			 			$copia_acesso=$acessos_por_pessoa[$i];
			 			$copia_acesso['sentido'] = "Entrada";
			 			$copia_acesso['hora'] = $this->sum_time($copia_acesso['hora'], '-');
			 			$copia_acesso['id_acesso'] = -$copia_acesso['id_acesso'];
			 			array_push( $copia_acessos, $copia_acesso ); 
			 	
			 		}
			 	}
			 } 
			}
		else{
			if($acessos_por_pessoa[0]['sentido'] == "Saida"){
				$copia_acesso=$acessos_por_pessoa[0];
		 		$copia_acesso['sentido'] = "Entrada";
		 		$copia_acesso['hora'] = $this->sum_time($copia_acesso['hora'], '-');
		 		$copia_acesso['id_acesso'] = -$copia_acesso['id_acesso'];
		 		array_push($copia_acessos, $copia_acesso);
			}
		}
			
			return $copia_acessos;

		} 
	
    	public function acessos24(){
			date_default_timezone_set("Europe/Lisbon");
			$datas = array(date("Y-m-d H",strtotime("+1 hour")));
			for ($i=0; $i < 23; $i++) { 
				$d=strtotime("-".$i." hour");
				array_push($datas, date("Y-m-d H", $d));
			}
			$acessos = array();
			foreach ($datas as $data ) {
				list($d, $h) = explode(' ', $data);
				$search_s = $h.'%';
				$sql = "SELECT count (*) as num
				FROM   acessos
				WHERE  data = '$d' and hora LIKE '$search_s';" ;
				$query = $this->db->query($sql);
				$result = $query->row();
     			if(isset($result)){ $acessos[$h.':00'] = $result->num;}
     			 else{$acessos[$h] = 0;  }

			}
			return array_reverse($acessos);
			    		 
    	}
    	public function acessos6m(){
			date_default_timezone_set("Europe/Lisbon");
			$datas = array();
			for ($i=0; $i < 7; $i++) { 
				$d=strtotime("-".$i." month");
				array_push($datas, date("Y-m", $d));
			}

			$acessos = array();
			foreach ($datas as $data ) {
				list($ano, $mes) = explode('-', $data);
				$search_s = $data.'%';
				$sql = "SELECT count (*) as num
				FROM   acessos
				WHERE  data LIKE '$search_s';" ;
				$query = $this->db->query($sql);
				$result = $query->row();
     			if(isset($result)){ $acessos[$this->get_mes($mes)] = $result->num;}
     			 else{$acessos[$h] = 0;  }

			}
			return array_reverse($acessos);
			    		 
    	}
   		function get_mes($num){
   			switch (intval($num)) {
			    case 1:
			        return 'Janeiro';
			        break;
			    case 2:
			         return 'Fevereiro';
			        break;
			    case 3:
			         return 'Março';
			        break;
			    case 4:
			        return 'Abril';
			        break;
			    case 5:
			         return 'Maio';
			        break;
			    case 6:
			         return 'Junho';
			        break;
			    case 7:
			        return 'Julho';
			        break;
			    case 8:
			         return 'Agosto';
			        break;
			    case 9:
			         return 'Setembro';
			        break;
			    case 10:
			        return 'Outubro';
			        break;
			    case 11:
			         return 'Novembro';
			        break;
			    case 12:
			         return 'Dezembro';
			        break;			
			    default:
					return "indefenido";
				}
   		}
		function array_flatten($array) { 
				$result = array();
				foreach ($array as $acessosPessoa) {
						# code...
					
					if(sizeof($acessosPessoa>1)){
						foreach ($acessosPessoa as $acesso) {
					
							 array_push($result, $acesso);
							 			
							 
						}
					 }
					 else{
					 	array_push($result, $acessosPessoa);
					 }
				
				}
				return $result;
		}
		function sum_time($horas, $op){
			list($h, $m) = explode(':', '00:01');
			if($op == '+'){
				return date('H:i', strtotime($horas) + $h*60*60 + $m*60); 
			}
			else{
				return date('H:i', strtotime($horas) - $h*60*60 - $m*60); 

			}
		}
		public function sensores_avariados(){
			date_default_timezone_set("Europe/Lisbon"); 
			$umMesAntes = date("Y-m-d",strtotime("-1 month"));
			$sql = "SELECT id from sensores
				WHERE  not EXISTS (SELECT *
                  					FROM   acessos
                					WHERE  data > '$umMesAntes' and sensores.id=acessos.id_sensor);";
			$query = $this->db->query($sql);
			if($query->num_rows() == 0){
				return array();
			}
			else{
				$data= array();
				foreach ($query->result() as $sensor ) {
					$id_sensor = $sensor->id;
					$sql2 = "SELECT top 1 concat(p.edificio, '.',p.piso,'.',p.num_porta) as porta, sentido,data,hora 
						from acessos
						join sensores as s on s.id=acessos.id_sensor
						join portas as p on p.id= s.id_porta
						 where id_sensor = $id_sensor
									order by data Desc, hora desc;";
					$query2 = $this->db->query($sql2);
					if($query2->num_rows() != 1){
						 return false;
					}
					else{
						array_push($data, $query2->result()[0]) ;
					}
				}
				return $data;
				
			}
		}
	function get_num_acessos_hj(){
		date_default_timezone_set("Europe/Lisbon"); 
		$hoje = date("Y-m-d",strtotime("today"));
		$ontem = date("Y-m-d",strtotime("yesterday"));
		$hora = date("G:i");
		if(sizeof($hora)<=4){
			$hora = "0".$hora;
		}
		$sql = "SELECT COUNT(*) AS num from acessos
				where (data = '$ontem' and hora >= '$hora') or (data = '$hoje' and hora <= '$hora') ";
		$query = $this->db->query($sql);
		$result = $query->row();
      	if(isset($result)) return $result->num;
        return 0;
	}
	function get_num_acessos_corrigidos_hj(){
		$total = 0;
		date_default_timezone_set("Europe/Lisbon");
		$hoje = date("Y-m-d",strtotime("today"));
		$ontem = date("Y-m-d",strtotime("yesterday"));
		$hora = date("G:i"); 
		$sql = "SELECT COUNT(*) AS num from acessos_alunos_corrigidos
				where ((data = '$ontem' and hora >= '$hora') or (data = '$hoje' and hora <= '$hora')) and id_acesso < 0";
		$query = $this->db->query($sql);
		$result = $query->row();
		if(isset($result)) $total+=$result->num;
		$sql = "SELECT COUNT(*) AS num from acessos_docentes_corrigidos
				where ((data = '$ontem' and hora >= '$hora') or (data = '$hoje' and hora <= '$hora')) and id_acesso < 0";
		$query = $this->db->query($sql);
		$result = $query->row();
		if(isset($result)) $total+=$result->num;
		$sql = "SELECT COUNT(*) AS num from acessos_nao_docentes_corrigidos
				where ((data = '$ontem' and hora >= '$hora') or (data = '$hoje' and hora <= '$hora')) and id_acesso < 0";		
		$query = $this->db->query($sql);
		$result = $query->row();
		if(isset($result)) $total+=$result->num;
      	
      	return $total;
	}
	function get_num_vezes_aluno_nao_passou_cartao_24h(){
		date_default_timezone_set("Europe/Lisbon");
		$hoje = date("Y-m-d",strtotime("today"));
		$ontem = date("Y-m-d",strtotime("yesterday"));
		$hora = date("G:i");
		if(sizeof($hora)<=4){
			$hora = "0".$hora;
		}
		$sql = "SELECT num_aluno, count(*) as num from acessos_alunos_corrigidos
		where ((data = '$ontem' and hora >= '$hora') or (data = '$hoje' and hora <= '$hora')) and id_acesso < 0
		group by num_aluno";
		$query = $this->db->query($sql);
		return $query->result();
	}
	function get_top10_alunos(){
		$sql = "SELECT top 10 concat(a.num_aluno,':',al.nome, ' ',al.apelido)as aluno, count(a.num_aluno) as num from acessos_alunos_corrigidos as a
		join alunos as al on a.num_aluno = al.num_aluno
		where id_acesso < 0
		group by a.num_aluno,apelido,al.nome
		order by num desc";
		$query = $this->db->query($sql);
		$result = array();
		foreach ($query->result() as $row) {
			$result[$row->aluno] = $row->num;
		}
		return $result;
	}
	function get_top1_aluno_mes(){
		date_default_timezone_set("Europe/Lisbon");
		$data = date("Y-m-d",strtotime("-1 month"));
		$sql = "SELECT top 1 concat(a.num_aluno,':',al.nome, ' ',al.apelido)as aluno, count(a.num_aluno) as num from acessos_alunos_corrigidos as a
		join alunos as al on a.num_aluno = al.num_aluno
		where id_acesso < 0 and data > '$data'
		group by a.num_aluno,apelido,al.nome
		order by num desc";
		$query = $this->db->query($sql);
		return $query->result()[0]->aluno;

	}
	function get_top1_aluno_semana(){
		date_default_timezone_set("Europe/Lisbon");
		$data = date("Y-m-d",strtotime("-1 week"));
		$sql = "SELECT top 1 concat(a.num_aluno,':',al.nome, ' ',al.apelido)as aluno, count(a.num_aluno) as num from acessos_alunos_corrigidos as a
		join alunos as al on a.num_aluno = al.num_aluno
		where id_acesso < 0 and data > '$data'
		group by a.num_aluno,apelido,al.nome
		order by num desc";
		$query = $this->db->query($sql);
		return $query->result()[0]->aluno;
	}
	public function user_docente_acessos24(){
			$id = $this->session->userdata("id");
			$this->db->select('id');
			$this->db->from('docentes');
			$this->db->where('id_funcionario',$id);
			$query = $this->db->get();
			$id_docente = $query->result_array()[0]['id'];
			date_default_timezone_set("Europe/Lisbon");
			$datas = array(date("Y-m-d H",strtotime("+1 hour")));
			for ($i=0; $i < 23; $i++) { 
				$d=strtotime("-".$i." hour");
				array_push($datas, date("Y-m-d H", $d));
			}
			$acessos = array();
			foreach ($datas as $data ) {
				list($d, $h) = explode(' ', $data);
				$search_s = $h.'%';
				$sql = "SELECT count (*) as num
				FROM   acessos as a
				join acessos_docentes as ad on a.id=ad.id_acesso
				WHERE  data = '$d' and hora LIKE '$search_s' and id_docente= $id_docente;" ;
				$query = $this->db->query($sql);
				$result = $query->row();
     			if(isset($result)){ $acessos[$h.':00'] = $result->num;}
     			 else{$acessos[$h] = 0;  }

			}
			return array_reverse($acessos);
			    		 
    	}
    	public function user_aluno_acessos24(){
			$id = $this->session->userdata("id");
			date_default_timezone_set("Europe/Lisbon");
			$datas = array(date("Y-m-d H",strtotime("+1 hour")));
			for ($i=0; $i < 23; $i++) { 
				$d=strtotime("-".$i." hour");
				array_push($datas, date("Y-m-d H", $d));
			}
			$acessos = array();
			foreach ($datas as $data ) {
				list($d, $h) = explode(' ', $data);
				$search_s = $h.'%';
				$sql = "SELECT count (*) as num
				FROM   acessos as a
				join acessos_alunos as ad on a.id=ad.id_acesso
				WHERE  data = '$d' and hora LIKE '$search_s' and id_aluno= $id;" ;
				$query = $this->db->query($sql);
				$result = $query->row();
     			if(isset($result)){ $acessos[$h.':00'] = $result->num;}
     			 else{$acessos[$h] = 0;  }

			}
			return array_reverse($acessos);
			    		 
    	}
    function get_num_acessos_semana_user_docente(){
    	$id =  $this->session->userdata('id');
    	$this->db->select('id');
		$this->db->from('docentes');
		$this->db->where('id_funcionario',$id);
		$query = $this->db->get();
		$id_docente = $query->result_array()[0]['id'];
		date_default_timezone_set("Europe/Lisbon"); 
		$hoje = date("Y-m-d",strtotime("today"));
		$ontem = date("Y-m-d",strtotime("yesterday"));
		$hora = date("G:i");
		if(sizeof($hora)<=4){
			$hora = "0".$hora;
		}
		$sql = "SELECT COUNT(*) AS num from acessos_docentes as ad
						join acessos as a on a.id = ad.id_acesso
				where ((data = '$ontem' and hora >= '$hora') or (data = '$hoje' and hora <= '$hora')) and id_docente =$id_docente";
		$query = $this->db->query($sql);
		$result = $query->row();
      	if(isset($result)) return $result->num;
        return 0;
	}
  function get_num_vezes_docente_n_passou_cartao_semana(){
  	$id =  $this->session->userdata('id');
    	$this->db->select('num_funcionario');
		$this->db->from('funcionarios');
		$this->db->where('id',$id);
		$query = $this->db->get();
		$num_funcionario = $query->result_array()[0]['num_funcionario'];
		date_default_timezone_set("Europe/Lisbon"); 
		$umaSemanaAtras = date("Y-m-d",strtotime("-1 week"));
  		$sql = "SELECT count(*) as num from acessos_docentes_corrigidos 
					where data>='$umaSemanaAtras' and num_funcionario=$num_funcionario and id_acesso < 0;";
		$query = $this->db->query($sql);
		$result = $query->row();
      	if(isset($result)) return $result->num;
        return 0;
  }	
      function get_num_acessos_semana_user_aluno(){
    	$id =  $this->session->userdata('id');
		date_default_timezone_set("Europe/Lisbon"); 
		$hoje = date("Y-m-d",strtotime("today"));
		$ontem = date("Y-m-d",strtotime("yesterday"));
		$hora = date("G:i");
		if(sizeof($hora)<=4){
			$hora = "0".$hora;
		}
		$sql = "SELECT COUNT(*) AS num from acessos_alunos as ad
						join acessos as a on a.id = ad.id_acesso
				where ((data = '$ontem' and hora >= '$hora') or (data = '$hoje' and hora <= '$hora')) and id_docente =$id";
		$query = $this->db->query($sql);
		$result = $query->row();
      	if(isset($result)) return $result->num;
        return 0;
	}
	function get_num_vezes_aluno_n_passou_cartao_semana(){
  		$id =  $this->session->userdata('id');
    	$this->db->select('num_aluno');
		$this->db->from('alunos');
		$this->db->where('id',$id);
		$query = $this->db->get();
		$num_aluno = $query->result_array()[0]['num_aluno'];
		date_default_timezone_set("Europe/Lisbon"); 
		$umaSemanaAtras = date("Y-m-d",strtotime("-1 week"));
  		$sql = "SELECT count(*) as num from acessos_alunos_corrigidos 
					where data>='$umaSemanaAtras' and num_aluno=$num_aluno and id_acesso < 0;";
		$query = $this->db->query($sql);
		$result = $query->row();
      	if(isset($result)) return $result->num;
        return 0;
  }	
}
?>