<?php  
class Users_model extends CI_model{
	
	public function password_update()
	{
		
		
		$query = $this->db->get('funcionarios');
		$alunosid = $query->result();
		
		foreach ($alunosid as $row ) {
		
			$password = "ptiptr";
				
			$options = [
			    'cost' => 4
			];
			$hash = password_hash($password,PASSWORD_BCRYPT,$options);
			$sql = "UPDATE funcionarios set password = '$hash' where id=$row->id";
			$query = $this->db->query($sql);
		}
		return "ok";
	}

	public function can_log_in(){
		$password = $this->input->post('password');
		$this->db->where('email',$this->input->post('email'));
		$query = $this->db->get('alunos');
		$this->db->where('email',$this->input->post('email'));
		$query2 = $this->db->get('funcionarios');
		if($query->num_rows()==1){
			$hash_aluno = $query->result()[0]->password;
			if(password_verify($password ,$hash_aluno)){
				return true;
			}
			else{
				return false;
			}
		}
		else if ($query2->num_rows()==1) {
			$hash_funcionario = $query2->result()[0]->password;
			if (password_verify($password ,$hash_funcionario)) {
				return true;
			}
			else{
				return false;
			}
		}
		else{
			return false;
		}
	}

     function is_aluno($email){
        $this->db->where('email',$email);
        $query = $this->db->get('alunos');
     
		if($query->num_rows()==1){
				return true;
		}
		else
			return false;
	}
	  function is_admin($id){
        $this->db->where('id_funcionario',$id);
        $query = $this->db->get('admin');
     
		if($query->num_rows()==1){
				return true;
		}
		else
			return false;
	}
	function is_docente($id){
        $this->db->where('id_funcionario',$id);
        $query = $this->db->get('docentes');
     
		if($query->num_rows()==1){
				return true;
		}
		else
			return false;
	}
    function get_alunoInfo($email){
        $this->db->where('email',$email);
        $query = $this->db->get('alunos');       
        foreach ($query->result() as $row)
            {
            	$userInfo = json_decode(json_encode($row), True);
            	unset($userInfo["password"]);
                return $userInfo;
            }
          
		return "Aluno Nao Encontrado";
	}
	function get_funcionarioInfo($email){
        $this->db->where('email',$email);
        $query = $this->db->get('funcionarios');       
        foreach ($query->result() as $row)
            {
            	$userInfo = json_decode(json_encode($row), True);
            	unset($userInfo["password"]);
                return $userInfo;
            }
          
		return "Funcionario Nao Encontrado";
	}
//ALUNOS TABELA
	function get_alunos() {
   	
		$sql = "SELECT a.num_aluno,concat(a.nome, ' ',a.apelido) as nome,a.email,a.num_cc, d.designacao as departamento
			FROM 
			  alunos AS a
			  JOIN departamentos AS d on d.id = a.id_departamento

			ORDER BY 
			a.num_aluno";
		return $this->db->query($sql);

    }
    public function get_total_alunos()
	{
      $query = $this->db->select("COUNT(*) as num")->get("alunos");
      $result = $query->row();
      if(isset($result)) return $result->num;
      return 0;
 	}
 // DOCENTES TABELA
	function get_docentes() {
   	
		$sql = "SELECT a.num_funcionario,concat(a.nome, ' ',a.apelido) as nome,
			a.email,a.num_cc, d.designacao as departamento
				FROM 
				  docentes AS do
				  JOIN departamentos AS d on d.id = do.id_departamento
				  join funcionarios as a on do.id_funcionario = a.id

				ORDER BY 
				a.num_funcionario";
		return $this->db->query($sql);

    }
    public function get_total_docentes()
	{
      $query = $this->db->select("COUNT(*) as num")->get("docentes");
      $result = $query->row();
      if(isset($result)) return $result->num;
      return 0;
 	}
    function get_departamentos(){
    	$this->db->select('id,designacao');
		$this->db->from('departamentos');
		$query = $this->db->get(); 
        return $query->result_array();
    }

    function get_departamentos_alunos(){
    	$alunos_departamentos = array();
    	$alunos = $this->get_alunos();
    	foreach ($alunos as $aluno) {
    		 $this->db->select('designacao');
			 $this->db->from('departamentos');
			 $this->db->where('id',$aluno['id_departamento']);
			 $query = $this->db->get();
			 $designacao = $query->result_array()[0]['designacao'];
			 unset($aluno['id_departamento']);
			 $aluno['departamento'] = $designacao;
			 array_push($alunos_departamentos, $aluno);
    	}
    	return $alunos_departamentos;
    }

    function get_num_alunos_por_departamento(){
    	$alunos_por_departamentos = array();
    	$departamentos = $this->get_departamentos();
    	foreach ($departamentos as $departamento) {
    		$this->db->select('id');
			$this->db->from('alunos');
			$this->db->where('id_departamento',$departamento['id']);
			$query = $this->db->get();
			$alunos_por_departamentos[$departamento['designacao']] = $query->num_rows();

    	}
    	
    	return $alunos_por_departamentos;
    }

    function get_departamentos_docentes(){
    	$docentes_departamentos = array();
    	$docentes = $this->get_docentes();
    	foreach ($docentes as $docente) {
    		 $this->db->select('designacao');
			 $this->db->from('departamentos');
			 $this->db->where('id',$docente['id_departamento']);
			 $query = $this->db->get();
			 $designacao = $query->result_array()[0]['designacao'];
			 unset($docente['id_departamento']);
			 $docente['departamento'] = $designacao;
			 array_push($docentes_departamentos, $docente);
    	}
    	return $docentes_departamentos;
    }


    function get_disciplinas_licenciatura_docente() {
    	$id =  $this->session->userdata('id');
    	$this->db->select('id');
		$this->db->from('docentes');
		$this->db->where('id_funcionario',$id);
		$query = $this->db->get();
		$id_docente = $query->result_array()[0]['id'];

   	
		$sql = "SELECT dl.id as id,dl.designacao as disciplina, concat(fu.nome , ' ',fu.apelido) as regente,semestre, ects,tu.designacao as turma,ano_lectivo, l.designacao as licenciatura FROM disciplinas_licenciatura as dl
					JOIN aulas_disciplinas_licenciaturas as al on dl.id = al.id_disciplina_licenciatura
					join funcionarios as fu on dl.id_regente = fu.id
					join turmas_licenciatura as tu on dl.id_turma = tu.id
					join licenciaturas as l on l.id = tu.id_licenciatura
					join lecciona_disciplinas_licenciatura as ldl on ldl.id_disciplina_licenciatura = dl.id
					where ldl.id_docente = $id_docente
					group by dl.id,dl.designacao,fu.nome, fu.apelido, semestre,ects, tu.designacao,l.ano_lectivo,l.designacao;";

		return $this->db->query($sql);

    }
      function get_disciplinas_mestrado_docente() {
    	$id =  $this->session->userdata('id');
    	$this->db->select('id');
		$this->db->from('docentes');
		$this->db->where('id_funcionario',$id);
		$query = $this->db->get();
		$id_docente = $query->result_array()[0]['id'];

   	
		$sql = "SELECT dl.id as id, dl.designacao as disciplina, concat(fu.nome , ' ',fu.apelido) as regente,semestre, ects,tu.designacao as turma, ano_lectivo, l.designacao as mestrado FROM disciplinas_mestrado as dl
					JOIN aulas_disciplinas_mestrados as al on dl.id = al.id_disciplina_mestrado
					join funcionarios as fu on dl.id_regente = fu.id
					join turmas_mestrado as tu on dl.id_turma = tu.id
					join mestrados as l on l.id = tu.id_mestrado
					join lecciona_disciplinas_mestrado as ldl on ldl.id_disciplina_mestrado = dl.id
					where ldl.id_docente = $id_docente
					group by dl.id,dl.designacao,fu.nome, fu.apelido, semestre,ects, tu.designacao,l.ano_lectivo,l.designacao;";

		return $this->db->query($sql);

    }
    function get_disciplinas_pos_graduacao_docente() {
    	$id =  $this->session->userdata('id');
    	$this->db->select('id');
		$this->db->from('docentes');
		$this->db->where('id_funcionario',$id);
		$query = $this->db->get();
		$id_docente = $query->result_array()[0]['id'];

   	
		$sql = "SELECT dl.id as id, dl.designacao as disciplina, concat(fu.nome , ' ',fu.apelido) as regente,semestre, ects,tu.designacao as turma, ano_lectivo, l.designacao as pos_graduacao FROM disciplinas_pos_graduacoes as dl
					JOIN aulas_disciplinas_pos_graduacoes as al on dl.id = al.id_disciplina_pos_graduacao
					join funcionarios as fu on dl.id_regente = fu.id
					join turmas_pos_graduacoes as tu on dl.id_turma = tu.id
					join pos_graduacoes as l on l.id = tu.id_pos_graduacao
					join lecciona_disciplinas_pos_graduacao as ldl on ldl.id_disciplina_pos_graduacao = dl.id
					where ldl.id_docente = $id_docente
					group by dl.id,dl.designacao,fu.nome, fu.apelido, semestre,ects, tu.designacao,l.ano_lectivo,l.designacao;";

		return $this->db->query($sql);

    }
        function get_aulas_licenciatura_docente() {
    	$id =  $this->session->userdata('id');
    	$this->db->select('id');
		$this->db->from('docentes');
		$this->db->where('id_funcionario',$id);
		$query = $this->db->get();
		$id_docente = $query->result_array()[0]['id'];

   	
		$sql = "SELECT dl.id, dl.designacao as disciplina, tu.designacao as turma, data, concat(hora_inicial , '-',hora_final) as horario, concat(p.edificio, '.',p.piso,'.',p.num_porta) as sala from aulas_disciplinas_licenciaturas as aul
			JOIN disciplinas_licenciatura as dl on dl.id = aul.id_disciplina_licenciatura
			join turmas_licenciatura as tu on dl.id_turma = tu.id
			join lecciona_disciplinas_licenciatura as ldl on ldl.id_disciplina_licenciatura = dl.id
			join salas as sal on aul.id_sala = sal.id
			join portas as p on sal.id_porta = p.id
			where ldl.id_docente = $id_docente
			order by data desc, hora_inicial desc";

		return $this->db->query($sql);

    }
     function get_aulas_mestrado_docente() {
    	$id =  $this->session->userdata('id');
    	$this->db->select('id');
		$this->db->from('docentes');
		$this->db->where('id_funcionario',$id);
		$query = $this->db->get();
		$id_docente = $query->result_array()[0]['id'];
 	
		$sql = "SELECT dl.id, dl.designacao as disciplina, tu.designacao as turma, data, concat(hora_inicial , '-',hora_final) as horario, concat(p.edificio, '.',p.piso,'.',p.num_porta) as sala from aulas_disciplinas_mestrados as aul
			JOIN disciplinas_mestrado as dl on dl.id = aul.id_disciplina_mestrado
			join turmas_mestrado as tu on dl.id_turma = tu.id
			join lecciona_disciplinas_mestrado as ldl on ldl.id_disciplina_mestrado = dl.id
			join salas as sal on aul.id_sala = sal.id
			join portas as p on sal.id_porta = p.id
			where ldl.id_docente = $id_docente
			order by data desc, hora_inicial desc";

		return $this->db->query($sql);

    }
      function get_aulas_pos_graduacoes_docente() {
    	$id =  $this->session->userdata('id');
    	$this->db->select('id');
		$this->db->from('docentes');
		$this->db->where('id_funcionario',$id);
		$query = $this->db->get();
		$id_docente = $query->result_array()[0]['id'];
 	
		$sql = "SELECT dl.id, dl.designacao as disciplina, tu.designacao as turma, data, concat(hora_inicial , '-',hora_final) as horario, concat(p.edificio, '.',p.piso,'.',p.num_porta) as sala from aulas_disciplinas_pos_graduacoes as aul
			JOIN disciplinas_pos_graduacoes as dl on dl.id = aul.id_disciplina_pos_graduacao
			join turmas_pos_graduacoes as tu on dl.id_turma = tu.id
			join lecciona_disciplinas_pos_graduacao as ldl on ldl.id_disciplina_pos_graduacao = dl.id
			join salas as sal on aul.id_sala = sal.id
			join portas as p on sal.id_porta = p.id
			where ldl.id_docente = 301
			order by data desc, hora_inicial desc";

		return $this->db->query($sql);

    }

    function get_num_alunos_inscritos_disciplina_licenciatura($id_disciplina){
     	$this->db->select(' count(*) as num');
		$this->db->from('alunos_inscritos_licenciatura');
		$this->db->where('id_disciplina',$id_disciplina);
		$query = $this->db->get();
	    $result = $query->row();
	    if(isset($result)) return $result->num;
	    	return 0;
    }
    function get_num_alunos_inscritos_disciplina_licenciatura_total($designacao){
		$sql = "SELECT count(*) as num from alunos_inscritos_licenciatura as ail
				JOIN disciplinas_licenciatura as dl on dl.id = ail.id_disciplina
				where dl.designacao = '$designacao'";
		$query = $this->db->query($sql);
	    $result = $query->row();
	    if(isset($result)) return $result->num;
	    	return 0;
    }
    function get_num_alunos_inscritos_disciplina_mestrado($id_disciplina){
     	$this->db->select(' count(*) as num');
		$this->db->from('alunos_inscritos_mestrado');
		$this->db->where('id_disciplina',$id_disciplina);
		$query = $this->db->get();
	    $result = $query->row();
	    if(isset($result)) return $result->num;
	    	return 0;
    }
    function get_num_alunos_inscritos_disciplina_mestrado_total($designacao){
		$sql = "SELECT count(*) as num from alunos_inscritos_mestrado as ail
				JOIN disciplinas_mestrado as dl on dl.id = ail.id_disciplina
				where dl.designacao = '$designacao'";
		$query = $this->db->query($sql);
	    $result = $query->row();
	    if(isset($result)) return $result->num;
	    	return 0;
    }
    function get_num_alunos_inscritos_disciplina_pos_graduacao($id_disciplina){
     	$this->db->select(' count(*) as num');
		$this->db->from('alunos_inscritos_pos_graduacoes');
		$this->db->where('id_disciplina',$id_disciplina);
		$query = $this->db->get();
	    $result = $query->row();
	    if(isset($result)) return $result->num;
	    	return 0;
    }
    function get_num_alunos_inscritos_disciplina_pos_graduacao_total($designacao){
		$sql = "SELECT count(*) as num from alunos_inscritos_pos_graduacoes as ail
				JOIN disciplinas_pos_graduacoes as dl on dl.id = ail.id_disciplina
				where dl.designacao = '$designacao'";
		$query = $this->db->query($sql);
	    $result = $query->row();
	    if(isset($result)) return $result->num;
	    	return 0;
    }
    function get_aulas_disciplina_licenciatura($id){
    $sql = "SELECT aul.id as id_aula,dl.id, dl.designacao as disciplina, tu.designacao as turma, data, concat(hora_inicial , '-',hora_final) as horario, concat(p.edificio, '.',p.piso,'.',p.num_porta) as sala from aulas_disciplinas_licenciaturas as aul
			JOIN disciplinas_licenciatura as dl on dl.id = aul.id_disciplina_licenciatura
			join turmas_licenciatura as tu on dl.id_turma = tu.id
			join lecciona_disciplinas_licenciatura as ldl on ldl.id_disciplina_licenciatura = dl.id
			join salas as sal on aul.id_sala = sal.id
			join portas as p on sal.id_porta = p.id
			where aul.id_disciplina_licenciatura = $id
			order by data asc, hora_inicial asc";
		return $this->db->query($sql);

    }
    function get_aulas_disciplina_mestrado($id){
    	$sql = "SELECT aul.id as id_aula,dl.id, dl.designacao as disciplina, tu.designacao as turma, data, concat(hora_inicial , '-',hora_final) as horario, concat(p.edificio, '.',p.piso,'.',p.num_porta) as sala from aulas_disciplinas_mestrados as aul
			JOIN disciplinas_mestrado as dl on dl.id = aul.id_disciplina_mestrado
			join turmas_mestrado as tu on dl.id_turma = tu.id
			join lecciona_disciplinas_mestrado as ldl on ldl.id_disciplina_mestrado = dl.id
			join salas as sal on aul.id_sala = sal.id
			join portas as p on sal.id_porta = p.id
			where aul.id_disciplina_mestrado = $id
			order by data asc, hora_inicial asc";
		return $this->db->query($sql);

    }
    function get_aulas_disciplina_pos_graduacao($id){
    	$sql = "SELECT aul.id as id_aula,dl.id, dl.designacao as disciplina, tu.designacao as turma, data, concat(hora_inicial , '-',hora_final) as horario, concat(p.edificio, '.',p.piso,'.',p.num_porta) as sala from aulas_disciplinas_pos_graduacoes as aul
			JOIN disciplinas_pos_graduacoes as dl on dl.id = aul.id_disciplina_pos_graduacao
			join turmas_pos_graduacoes as tu on dl.id_turma = tu.id
			join lecciona_disciplinas_pos_graduacao as ldl on ldl.id_disciplina_pos_graduacao = dl.id
			join salas as sal on aul.id_sala = sal.id
			join portas as p on sal.id_porta = p.id
			where aul.id_disciplina_pos_graduacao = $id
			order by data asc, hora_inicial asc";

		return $this->db->query($sql);

    }
    function get_presencas_aula_licenciatura($id_aula){
    	$sql ="SELECT aac.num_aluno, aac.nome, hora as hora_de_entrada,concat(adl.hora_inicial, '-', adl.hora_final) as hora_de_aula
				FROM 
	acessos_alunos_corrigidos as aac
				  join alunos on alunos.num_aluno = aac.num_aluno
				  join portas as p on concat(p.edificio, '.',p.piso,'.',p.num_porta) = aac.porta
				  join salas as sal on sal.id_porta = p.id
				  join aulas_disciplinas_licenciaturas as adl on sal.id = adl.id_sala
				  join disciplinas_licenciatura as dl on dl.id = adl.id_disciplina_licenciatura
				  join alunos_inscritos_licenciatura as ail on ail.id_disciplina = dl.id
				  where aac.data = adl.data and (aac.hora > adl.hora_inicial and aac.hora < adl.hora_final) and sentido = 'Entrada' and aac.id_acesso > 0 and ail.id_aluno = alunos.id and adl.id=$id_aula;";	
		return $this->db->query($sql);
    }
    function get_presencas_aula_mestrado($id_aula){
    	$sql ="SELECT aac.num_aluno, aac.nome, hora as hora_de_entrada,concat(adl.hora_inicial, '-', adl.hora_final) as hora_de_aula
				FROM 
	acessos_alunos_corrigidos as aac
				  join alunos on alunos.num_aluno = aac.num_aluno
				  join portas as p on concat(p.edificio, '.',p.piso,'.',p.num_porta) = aac.porta
				  join salas as sal on sal.id_porta = p.id
				  join aulas_disciplinas_mestrados as adl on sal.id = adl.id_sala
				  join disciplinas_mestrado as dl on dl.id = adl.id_disciplina_mestrado
				  join alunos_inscritos_mestrado as ail on ail.id_disciplina = dl.id
				  where aac.data = adl.data and (aac.hora > adl.hora_inicial and aac.hora < adl.hora_final) and sentido = 'Entrada' and aac.id_acesso > 0 and ail.id_aluno = alunos.id and adl.id=$id_aula;";	
		return $this->db->query($sql);
    }
    function get_presencas_aula_pos_graduacao($id_aula){
    	$sql ="SELECT aac.num_aluno, aac.nome, hora as hora_de_entrada,concat(adl.hora_inicial, '-', adl.hora_final) as hora_de_aula
				FROM 
	acessos_alunos_corrigidos as aac
				  join alunos on alunos.num_aluno = aac.num_aluno
				  join portas as p on concat(p.edificio, '.',p.piso,'.',p.num_porta) = aac.porta
				  join salas as sal on sal.id_porta = p.id
				  join aulas_disciplinas_pos_graduacoes as adl on sal.id = adl.id_sala
				  join disciplinas_pos_graduacoes as dl on dl.id = adl.id_disciplina_pos_graduacao
				  join alunos_inscritos_pos_graduacoes as ail on ail.id_disciplina = dl.id
				  where aac.data = adl.data and (aac.hora > adl.hora_inicial and aac.hora < adl.hora_final) and sentido = 'Entrada' and aac.id_acesso > 0 and ail.id_aluno = alunos.id and adl.id=$id_aula;";	
		return $this->db->query($sql);
    }
    function get_designacao_disciplina_licenciatura($id_disciplina){
    	$this->db->select('designacao');
		$this->db->from('disciplinas_licenciatura');
		$this->db->where('id',$id_disciplina);
		$query = $this->db->get();
	    $result = $query->row();
	    if(isset($result)) return $result->designacao;
	    	return 0;
    }
    function get_designacao_disciplina_mestrado($id_disciplina){
    	$this->db->select('designacao');
		$this->db->from('disciplinas_mestrado');
		$this->db->where('id',$id_disciplina);
		$query = $this->db->get();
	    $result = $query->row();
	    if(isset($result)) return $result->designacao;
	    	return 0;
    }
    function get_designacao_disciplina_pos_graduacao($id_disciplina){
    	$this->db->select('designacao');
		$this->db->from('disciplinas_pos_graduacoes');
		$this->db->where('id',$id_disciplina);
		$query = $this->db->get();
	    $result = $query->row();
	    if(isset($result)) return $result->designacao;
	    	return 0;
    }

    function get_alunos_inscritos_disciplinas_licenciatura($id_disciplina){
    	$sql = "SELECT a.id as id_aluno, a.num_aluno, concat(a.nome,' ',a.apelido) as nome, dl.designacao as disciplina ,t.designacao as turma FROM alunos_inscritos_licenciatura as ail
		join disciplinas_licenciatura as dl on dl.id= ail.id_disciplina
		join alunos as a on a.id = ail.id_aluno
		join turmas_licenciatura as t on t.id = dl.id_turma
		where id_disciplina = $id_disciplina";
		return $this->db->query($sql);
    }
    function get_num_presencas_aluno_disciplina_licenciatura($id_disciplina, $id_aluno){
    	$sql = "SELECT COUNT(*) AS n_presencas
				FROM 
				acessos_alunos_corrigidos as aac
				  join alunos on alunos.num_aluno = aac.num_aluno
				  join portas as p on concat(p.edificio, '.',p.piso,'.',p.num_porta) = aac.porta
				  join salas as sal on sal.id_porta = p.id
				  join aulas_disciplinas_licenciaturas as adl on sal.id = adl.id_sala
				  join disciplinas_licenciatura as dl on dl.id = adl.id_disciplina_licenciatura
				  join alunos_inscritos_licenciatura as ail on ail.id_disciplina = dl.id
				  where aac.data = adl.data and (aac.hora > adl.hora_inicial and aac.hora < adl.hora_final) and sentido = 'Entrada' and aac.id_acesso > 0 and ail.id_aluno = alunos.id and dl.id = $id_disciplina and alunos.id = $id_aluno ;";
		$query = $this->db->query($sql);
	    $result = $query->row();
	    if(isset($result)) return $result->n_presencas;
	    	return 0;

    }
    function get_num_aulas_disciplina_licenciatura($id_disciplina){
     	$this->db->select(' count(*) as num');
		$this->db->from('aulas_disciplinas_licenciaturas');
		$this->db->where('id_disciplina_licenciatura',$id_disciplina);
		$query = $this->db->get();
	    $result = $query->row();
	    if(isset($result)) return $result->num;
	    	return 0;
    }
    function get_total_alunos_inscritos_disciplinas_licenciatura($id_disciplina){
    	$designacao = $this->get_designacao_disciplina_licenciatura($id_disciplina);
    	$sql = "SELECT dl.id as id_disc,a.id as id_aluno, a.num_aluno, concat(a.nome,' ',a.apelido) as nome, dl.designacao as disciplina ,t.designacao as turma FROM alunos_inscritos_licenciatura as ail
		join disciplinas_licenciatura as dl on dl.id= ail.id_disciplina
		join alunos as a on a.id = ail.id_aluno
		join turmas_licenciatura as t on t.id = dl.id_turma
		where dl.designacao = '$designacao'";
		return $this->db->query($sql);
    }
     function get_alunos_inscritos_disciplinas_mestrado($id_disciplina){
    	$sql = "SELECT a.id as id_aluno, a.num_aluno, concat(a.nome,' ',a.apelido) as nome, dl.designacao as disciplina ,t.designacao as turma FROM alunos_inscritos_mestrado as ail
		join disciplinas_mestrado as dl on dl.id= ail.id_disciplina
		join alunos as a on a.id = ail.id_aluno
		join turmas_mestrado as t on t.id = dl.id_turma
		where id_disciplina = $id_disciplina";
		return $this->db->query($sql);
    }
    function get_num_presencas_aluno_disciplina_mestrado($id_disciplina, $id_aluno){
    	$sql = "SELECT COUNT(*) AS n_presencas
				FROM 
				acessos_alunos_corrigidos as aac
				  join alunos on alunos.num_aluno = aac.num_aluno
				  join portas as p on concat(p.edificio, '.',p.piso,'.',p.num_porta) = aac.porta
				  join salas as sal on sal.id_porta = p.id
				  join aulas_disciplinas_mestrados as adl on sal.id = adl.id_sala
				  join disciplinas_mestrado as dl on dl.id = adl.id_disciplina_mestrado
				  join alunos_inscritos_mestrado as ail on ail.id_disciplina = dl.id
				  where aac.data = adl.data and (aac.hora > adl.hora_inicial and aac.hora < adl.hora_final) and sentido = 'Entrada' and aac.id_acesso > 0 and ail.id_aluno = alunos.id and dl.id = $id_disciplina and alunos.id = $id_aluno ;";
		$query = $this->db->query($sql);
	    $result = $query->row();
	    if(isset($result)) return $result->n_presencas;
	    	return 0;

    }
    function get_num_aulas_disciplina_mestrado($id_disciplina){
    	$dataHj = date("Y-m-d",strtotime("today"));
     	$this->db->select(' count(*) as num');
		$this->db->from('aulas_disciplinas_mestrados');
		$this->db->where('id_disciplina_mestrado',$id_disciplina);
		$this->db->where('data <=', $dataHj);
		$query = $this->db->get();
	    $result = $query->row();
	    if(isset($result)) return $result->num;
	    	return 0;
    }
    function get_total_alunos_inscritos_disciplinas_mestrado($id_disciplina){
    	$designacao = $this->get_designacao_disciplina_mestrado($id_disciplina);
    	$sql = "SELECT dl.id as id_disc,a.id as id_aluno, a.num_aluno, concat(a.nome,' ',a.apelido) as nome, dl.designacao as disciplina ,t.designacao as turma FROM alunos_inscritos_mestrado as ail
		join disciplinas_mestrado as dl on dl.id= ail.id_disciplina
		join alunos as a on a.id = ail.id_aluno
		join turmas_mestrado as t on t.id = dl.id_turma
		where dl.designacao = '$designacao'";
		return $this->db->query($sql);
    }
    function get_alunos_inscritos_disciplinas_pos_graduacao($id_disciplina){
    	$sql = "SELECT a.id as id_aluno, a.num_aluno, concat(a.nome,' ',a.apelido) as nome, dl.designacao as disciplina ,t.designacao as turma FROM alunos_inscritos_pos_graduacoes as ail
		join disciplinas_pos_graduacoes as dl on dl.id= ail.id_disciplina
		join alunos as a on a.id = ail.id_aluno
		join turmas_pos_graduacoes as t on t.id = dl.id_turma
		where id_disciplina = $id_disciplina";
		return $this->db->query($sql);
    }
    function get_num_presencas_aluno_disciplina_pos_graduacao($id_disciplina, $id_aluno){
    	$sql = "SELECT COUNT(*) AS n_presencas
				FROM 
				acessos_alunos_corrigidos as aac
				  join alunos on alunos.num_aluno = aac.num_aluno
				  join portas as p on concat(p.edificio, '.',p.piso,'.',p.num_porta) = aac.porta
				  join salas as sal on sal.id_porta = p.id
				  join aulas_disciplinas_pos_graduacoes as adl on sal.id = adl.id_sala
				  join disciplinas_pos_graduacoes as dl on dl.id = adl.id_disciplina_pos_graduacao
				  join alunos_inscritos_pos_graduacoes as ail on ail.id_disciplina = dl.id
				  where aac.data = adl.data and (aac.hora > adl.hora_inicial and aac.hora < adl.hora_final) and sentido = 'Entrada' and aac.id_acesso > 0 and ail.id_aluno = alunos.id and dl.id = $id_disciplina and alunos.id = $id_aluno ;";
		$query = $this->db->query($sql);
	    $result = $query->row();
	    if(isset($result)) return $result->n_presencas;
	    	return 0;

    }
    function get_num_aulas_disciplina_pos_graduacao($id_disciplina){
    	$dataHj = date("Y-m-d",strtotime("today"));
     	$this->db->select(' count(*) as num');
		$this->db->from('aulas_disciplinas_pos_graduacoes');
		$this->db->where('id_disciplina_pos_graduacao',$id_disciplina);
		$this->db->where('data <=', $dataHj);
		$query = $this->db->get();
	    $result = $query->row();
	    if(isset($result)) return $result->num;
	    	return 0;
    }
    function get_total_alunos_inscritos_disciplinas_pos_graduacao($id_disciplina){
    	$designacao = $this->get_designacao_disciplina_pos_graduacao($id_disciplina);
    	$sql = "SELECT dl.id as id_disc,a.id as id_aluno, a.num_aluno, concat(a.nome,' ',a.apelido) as nome, dl.designacao as disciplina ,t.designacao as turma FROM alunos_inscritos_pos_graduacoes as ail
		join disciplinas_pos_graduacoes as dl on dl.id= ail.id_disciplina
		join alunos as a on a.id = ail.id_aluno
		join turmas_pos_graduacoes as t on t.id = dl.id_turma
		where dl.designacao = '$designacao'";
		return $this->db->query($sql);
    }
    
    function get_num_total_presencas_disciplina_licenciatura($id_disciplina){
    	$sql = "SELECT dl.designacao, count(*) AS n_presencas
				FROM 
				acessos_alunos_corrigidos as aac
				  join alunos on alunos.num_aluno = aac.num_aluno
				  join portas as p on concat(p.edificio, '.',p.piso,'.',p.num_porta) = aac.porta
				  join salas as sal on sal.id_porta = p.id
				  join aulas_disciplinas_licenciaturas as adl on sal.id = adl.id_sala
				  join disciplinas_licenciatura as dl on dl.id = adl.id_disciplina_licenciatura
				  join alunos_inscritos_licenciatura as ail on ail.id_disciplina = dl.id
				  where aac.data = adl.data and (aac.hora > adl.hora_inicial and aac.hora < adl.hora_final) and sentido = 'Entrada' and aac.id_acesso > 0 and ail.id_aluno = alunos.id and dl.id = $id_disciplina
				  group by dl.designacao;";
	  $query = $this->db->query($sql);
	   if ($query->num_rows()==1) {
	    return $query->result()[0]->n_presencas;
	   }
	   else{return 0;}
    }
    function get_num_total_presencas_disciplina_mestrado($id_disciplina){
    	$sql = "SELECT dl.designacao, count(*) AS n_presencas
				FROM 
				acessos_alunos_corrigidos as aac
				  join alunos on alunos.num_aluno = aac.num_aluno
				  join portas as p on concat(p.edificio, '.',p.piso,'.',p.num_porta) = aac.porta
				  join salas as sal on sal.id_porta = p.id
				  join aulas_disciplinas_mestrados as adl on sal.id = adl.id_sala
				  join disciplinas_mestrado as dl on dl.id = adl.id_disciplina_mestrado
				  join alunos_inscritos_mestrado as ail on ail.id_disciplina = dl.id
				  where aac.data = adl.data and (aac.hora > adl.hora_inicial and aac.hora < adl.hora_final) and sentido = 'Entrada' and aac.id_acesso > 0 and ail.id_aluno = alunos.id and dl.id = $id_disciplina
				  group by dl.designacao;";
		$query = $this->db->query($sql);
	   if ($query->num_rows()==1) {
	    return $query->result()[0]->n_presencas;
	   }
	   else{return 0;}
	 
    }
    function get_num_total_presencas_disciplina_posgraduacao($id_disciplina){
    	$sql = "SELECT dl.designacao, count(*) AS n_presencas
				FROM 
				acessos_alunos_corrigidos as aac
				  join alunos on alunos.num_aluno = aac.num_aluno
				  join portas as p on concat(p.edificio, '.',p.piso,'.',p.num_porta) = aac.porta
				  join salas as sal on sal.id_porta = p.id
				  join aulas_disciplinas_pos_graduacoes as adl on sal.id = adl.id_sala
				  join disciplinas_pos_graduacoes as dl on dl.id = adl.id_disciplina_pos_graduacao
				  join alunos_inscritos_pos_graduacoes as ail on ail.id_disciplina = dl.id
				  where aac.data = adl.data and (aac.hora > adl.hora_inicial and aac.hora < adl.hora_final) and sentido = 'Entrada' and aac.id_acesso > 0 and ail.id_aluno = alunos.id and dl.id = $id_disciplina
				  group by dl.designacao;";
	 $query = $this->db->query($sql);
	   if ($query->num_rows()==1) {
	    return $query->result()[0]->n_presencas;
	   }
	   else{return 0;}
    }
    function get_percentagem_por_disciplina_user_docente(){
    	$id = $this->session->userdata("id");
    	$this->db->select('id');
		$this->db->from('docentes');
		$this->db->where('id_funcionario',$id);
		$query = $this->db->get();
		$id_docente = $query->result_array()[0]['id'];
		$sql = "SELECT id_disciplina_licenciatura as id, dl.designacao,t.designacao as turma from lecciona_disciplinas_licenciatura as ldl
				join disciplinas_licenciatura as dl on dl.id = ldl.id_disciplina_licenciatura
				join turmas_licenciatura as t on t.id =dl.id_turma 
				where id_docente = $id_docente";
	  $disciplinas_licenciatura = $this->db->query($sql);
	  $data = array();
	  foreach ($disciplinas_licenciatura->result() as $disciplina) {
	  		$data[] = array(
	  				"designacao" => $disciplina->designacao,
	  				"turma" => $disciplina->turma,
                    "total_presencas" =>
                    $this->get_num_total_presencas_disciplina_licenciatura($disciplina->id),
                    "total_presencas_possiveis" =>$this->get_num_aulas_disciplina_licenciatura($disciplina->id) * $this->get_num_alunos_inscritos_disciplina_licenciatura($disciplina->id)
	  				);
	  }
	  $sql = "SELECT id_disciplina_mestrado as id, dl.designacao,t.designacao as turma from lecciona_disciplinas_mestrado as ldl
				join disciplinas_mestrado as dl on dl.id = ldl.id_disciplina_mestrado
				join turmas_mestrado as t on t.id =dl.id_turma 
				where id_docente = $id_docente";
	  $disciplinas_mestrado = $this->db->query($sql);
	  foreach ($disciplinas_mestrado->result() as $disciplina) {
	  		$data[] = array(
	  				"designacao" => $disciplina->designacao,
	  				"turma" => $disciplina->turma,
                    "total_presencas" =>
                    $this->get_num_total_presencas_disciplina_mestrado($disciplina->id),
                    "total_presencas_possiveis" =>$this->get_num_aulas_disciplina_mestrado($disciplina->id) * $this->get_num_alunos_inscritos_disciplina_mestrado($disciplina->id)
	  				);
	  }
	   $sql = "SELECT id_disciplina_pos_graduacao as id, dl.designacao,t.designacao as turma from lecciona_disciplinas_pos_graduacao as ldl
				join disciplinas_pos_graduacoes as dl on dl.id = ldl.id_disciplina_pos_graduacao
				join turmas_pos_graduacoes t on t.id =dl.id_turma 
				where id_docente = $id_docente";
	  $disciplinas_pg = $this->db->query($sql);
	  foreach ($disciplinas_pg->result() as $disciplina) {
	  		$data[] = array(
	  				"designacao" => $disciplina->designacao,
	  				"turma" => $disciplina->turma,
                    "total_presencas" =>
                    $this->get_num_total_presencas_disciplina_posgraduacao($disciplina->id),
                    "total_presencas_possiveis" =>$this->get_num_aulas_disciplina_pos_graduacao($disciplina->id) * $this->get_num_alunos_inscritos_disciplina_pos_graduacao($disciplina->id)
	  				);
	  }
	  return $data;

    }
    function get_avg_percentagem_por_disciplina_user_docente(){
    	$disciplinas = $this->get_percentagem_por_disciplina_user_docente();
    	$soma=0;
    	foreach ($disciplinas as $disciplina) {
    			$soma += round($disciplina["total_presencas"]/$disciplina["total_presencas_possiveis"] * 100,3);
    	}
    	return round($soma/sizeof($disciplinas),3);
    }
        function get_percentagem_por_disciplina_user_docente2($id){
    	
    	$this->db->select('id');
		$this->db->from('docentes');
		$this->db->where('id_funcionario',$id);
		$query = $this->db->get();
		$id_docente = $query->result_array()[0]['id'];
		$sql = "SELECT id_disciplina_licenciatura as id, dl.designacao,t.designacao as turma from lecciona_disciplinas_licenciatura as ldl
				join disciplinas_licenciatura as dl on dl.id = ldl.id_disciplina_licenciatura
				join turmas_licenciatura as t on t.id =dl.id_turma 
				where id_docente = $id_docente";
	  $disciplinas_licenciatura = $this->db->query($sql);
	  $data = array();
	  foreach ($disciplinas_licenciatura->result() as $disciplina) {
	  	if($this->get_num_alunos_inscritos_disciplina_licenciatura($disciplina->id) == 0){continue;}
	  		$data[] = array(
	  				"designacao" => $disciplina->designacao,
	  				"turma" => $disciplina->turma,
                    "total_presencas" =>
                    $this->get_num_total_presencas_disciplina_licenciatura($disciplina->id),
                    "total_presencas_possiveis" =>$this->get_num_aulas_disciplina_licenciatura($disciplina->id) * $this->get_num_alunos_inscritos_disciplina_licenciatura($disciplina->id)
	  				);
	  	}
	  return $data;

    }
 
     function get_ids_docentes() {
        $sql = "SELECT id_docente as id,d.id_funcionario as id_funcionario,nome,apelido from lecciona_disciplinas_licenciatura as ldl
join docentes as d on d.id = ldl.id
join funcionarios as f on f.id = d.id_funcionario

group by id_docente,nome,apelido,d.id_funcionario;";
		$query = $this->db->query($sql); 
        return $query->result();
    }
    function get_nome_funcionario($id){
    	$this->db->select('nome,apelido');
		$this->db->from('funcionarios');
		$this->db->where('id',$id);
		$query = $this->db->get(); 
        return $query->result()[0];
    }
     function get_avg_percentagem_por_disciplina_docentes2(){
     	$docentes = $this->get_ids_docentes();
     	$data = array();
     	foreach ($docentes as $docente) {
     		$nome =$this->get_nome_funcionario($docente->id_funcionario);
     		$nomeCom = $nome->nome." ".$nome->apelido;
     		$disciplinas = $this->get_percentagem_por_disciplina_user_docente2($docente->id);
    		$soma=0;
    		foreach ($disciplinas as $disciplina) {
    			$soma += round($disciplina["total_presencas"]/$disciplina["total_presencas_possiveis"] * 100,3);
    		}
    		if(sizeof($disciplinas)>0){
    			$data[$nomeCom] = round($soma/sizeof($disciplinas),3);
    		}
     	}
    	
    	return $data;
    }
    function get_num_aulas_hoje(){
    	$dataHj = date("Y-m-d",strtotime("today"));
    	$id =  $this->session->userdata('id');
    	$this->db->select('id');
		$this->db->from('docentes');
		$this->db->where('id_funcionario',$id);
		$query = $this->db->get();
		$id_docente = $query->result_array()[0]['id'];
		$soma = 0;
    	$sql ="SELECT count(*) as num from aulas_disciplinas_licenciaturas as adl
					join lecciona_disciplinas_licenciatura as ldl on ldl.id_disciplina_licenciatura = adl.id_disciplina_licenciatura
					where data='$dataHj' and ldl.id_docente=$id_docente;";
	  $query = $this->db->query($sql);
	  $result = $query->row();
      if(isset($result)) $soma += $result->num;
      $soma += 0;

      $sql ="SELECT count(*) as num from aulas_disciplinas_mestrados as adl
					join lecciona_disciplinas_mestrado as ldl on ldl.id_disciplina_mestrado = adl.id_disciplina_mestrado
					where data='$dataHj' and ldl.id_docente=$id_docente;";
	   $result = $query->row();
      if(isset($result)) $soma += $result->num;
      $soma += 0;
      $query = $this->db->query($sql);
      $sql ="SELECT count(*) as num from aulas_disciplinas_pos_graduacoes as adl
					join lecciona_disciplinas_pos_graduacao as ldl on ldl.id_disciplina_pos_graduacao= adl.id_disciplina_pos_graduacao
					where data='$dataHj' and ldl.id_docente=$id_docente;";
		$query = $this->db->query($sql);
	   $result = $query->row();
      if(isset($result)) $soma += $result->num;
      $soma += 0;

      return $soma;
    }
    function get_disciplinas_licenciatura_user_aluno() {
    	$id =  $this->session->userdata('id');
   	
		$sql = "SELECT dl.id as id,dl.designacao as disciplina, concat(fu.nome , ' ',fu.apelido) as regente,semestre, ects,tu.designacao as turma,ano_lectivo, l.designacao as licenciatura FROM disciplinas_licenciatura as dl
					JOIN aulas_disciplinas_licenciaturas as al on dl.id = al.id_disciplina_licenciatura
					join funcionarios as fu on dl.id_regente = fu.id
					join turmas_licenciatura as tu on dl.id_turma = tu.id
					join licenciaturas as l on l.id = tu.id_licenciatura
					join alunos_inscritos_licenciatura as ldl on ldl.id_disciplina = dl.id
					where ldl.id_aluno = $id
					group by dl.id,dl.designacao,fu.nome, fu.apelido, semestre,ects, tu.designacao,l.ano_lectivo,l.designacao;";

		return $this->db->query($sql);

    }
    function get_disciplinas_mestrado_user_aluno() {
    	$id =  $this->session->userdata('id');
   	
		$sql = "SELECT dl.id as id,dl.designacao as disciplina, concat(fu.nome , ' ',fu.apelido) as regente,semestre, ects,tu.designacao as turma,ano_lectivo, l.designacao as mestrado FROM disciplinas_mestrado as dl
					JOIN aulas_disciplinas_mestrados as al on dl.id = al.id_disciplina_mestrado
					join funcionarios as fu on dl.id_regente = fu.id
					join turmas_mestrado as tu on dl.id_turma = tu.id
					join mestrados as l on l.id = tu.id_mestrado
					join alunos_inscritos_mestrado as ldl on ldl.id_disciplina = dl.id
					where ldl.id_aluno = $id
					group by dl.id,dl.designacao,fu.nome, fu.apelido, semestre,ects, tu.designacao,l.ano_lectivo,l.designacao;";

		return $this->db->query($sql);

    }
    function get_disciplinas_pos_graduacao_user_aluno() {
    	$id =  $this->session->userdata('id');
   	
		$sql = "SELECT dl.id as id,dl.designacao as disciplina, concat(fu.nome , ' ',fu.apelido) as regente,semestre, ects,tu.designacao as turma,ano_lectivo, l.designacao as pos_graduacoe FROM disciplinas_pos_graduacoes as dl
					JOIN aulas_disciplinas_pos_graduacoes as al on dl.id = al.id_disciplina_pos_graduacao
					join funcionarios as fu on dl.id_regente = fu.id
					join turmas_pos_graduacoes as tu on dl.id_turma = tu.id
					join pos_graduacoes as l on l.id = tu.id_pos_graduacao
					join alunos_inscritos_pos_graduacoes as ldl on ldl.id_disciplina = dl.id
					where ldl.id_aluno = $id
					group by dl.id,dl.designacao,fu.nome, fu.apelido, semestre,ects, tu.designacao,l.ano_lectivo,l.designacao;";
					
		return $this->db->query($sql);

    }
    function ve_se_user_aluno_presente_aula_disciplina_licenciatura($id_aula){
    	$id_aluno = $this->session->userdata("id");
    	$sql = "SELECT count(*) as num
				FROM 
	acessos_alunos_corrigidos as aac
				  join alunos on alunos.num_aluno = aac.num_aluno
				  join portas as p on concat(p.edificio, '.',p.piso,'.',p.num_porta) = aac.porta
				  join salas as sal on sal.id_porta = p.id
				  join aulas_disciplinas_licenciaturas as adl on sal.id = adl.id_sala
				  join disciplinas_licenciatura as dl on dl.id = adl.id_disciplina_licenciatura
				  join alunos_inscritos_licenciatura as ail on ail.id_disciplina = dl.id
					  where aac.data = adl.data and (aac.hora > adl.hora_inicial and aac.hora < adl.hora_final) and sentido = 'Entrada' and aac.id_acesso > 0 and ail.id_aluno = alunos.id and adl.id=$id_aula and alunos.id = $id_aluno;";
	    $query = $this->db->query($sql);
		$result = $query->row();
      	if(isset($result)) return $result->num;
        return 0;
    }
    function ve_se_user_aluno_presente_aula_disciplina_mestrado($id_aula){
    	$id_aluno = $this->session->userdata("id");
    	$sql = "SELECT count(*) as num
				FROM 
	acessos_alunos_corrigidos as aac
				  join alunos on alunos.num_aluno = aac.num_aluno
				  join portas as p on concat(p.edificio, '.',p.piso,'.',p.num_porta) = aac.porta
				  join salas as sal on sal.id_porta = p.id
				  join aulas_disciplinas_mestrados as adl on sal.id = adl.id_sala
				  join disciplinas_mestrado as dl on dl.id = adl.id_disciplina_mestrado
				  join alunos_inscritos_mestrado as ail on ail.id_disciplina = dl.id
					  where aac.data = adl.data and (aac.hora > adl.hora_inicial and aac.hora < adl.hora_final) and sentido = 'Entrada' and aac.id_acesso > 0 and ail.id_aluno = alunos.id and adl.id=$id_aula and alunos.id = $id_aluno;";
	    $query = $this->db->query($sql);
	    $result = $query->row();
      	if(isset($result)) return $result->num;
        return 0;
    }
        function ve_se_user_aluno_presente_aula_disciplina_pos_graduacao($id_aula){
    	$id_aluno = $this->session->userdata("id");
    	$sql = "SELECT count(*) as num
				FROM 
	acessos_alunos_corrigidos as aac
				  join alunos on alunos.num_aluno = aac.num_aluno
				  join portas as p on concat(p.edificio, '.',p.piso,'.',p.num_porta) = aac.porta
				  join salas as sal on sal.id_porta = p.id
				  join aulas_disciplinas_pos_graduacoes as adl on sal.id = adl.id_sala
				  join disciplinas_pos_graduacoes as dl on dl.id = adl.id_disciplina_pos_graduacao
				  join alunos_inscritos_pos_graduacoes as ail on ail.id_disciplina = dl.id
					  where aac.data = adl.data and (aac.hora > adl.hora_inicial and aac.hora < adl.hora_final) and sentido = 'Entrada' and aac.id_acesso > 0 and ail.id_aluno = alunos.id and adl.id=$id_aula and alunos.id = $id_aluno;";
	    $query = $this->db->query($sql);
	    $result = $query->row();
      	if(isset($result)) return $result->num;
        return 0;
    }
        function get_num_aulas_hoje_aluno(){
    	$dataHj = date("Y-m-d",strtotime("today"));
    	$id =  $this->session->userdata('id');
		$soma = 0;
    	$sql ="SELECT count(*) as num from aulas_disciplinas_licenciaturas as adl
					join alunos_inscritos_licenciatura as ldl on ldl.id_disciplina = adl.id_disciplina_licenciatura
					where data='$dataHj' and ldl.id_aluno=$id;";
	  $query = $this->db->query($sql);
	  $result = $query->row();
      if(isset($result)) $soma += $result->num;
      $soma += 0;

      $sql ="SELECT count(*) as num from aulas_disciplinas_mestrados as adl
					join alunos_inscritos_mestrado as ldl on ldl.id_disciplina = adl.id_disciplina_mestrado
					where data='$dataHj' and ldl.id_aluno=$id;";
	   $result = $query->row();
      if(isset($result)) $soma += $result->num;
      $soma += 0;
      $query = $this->db->query($sql);
      $sql ="SELECT count(*) as num from aulas_disciplinas_pos_graduacoes as adl
					join alunos_inscritos_pos_graduacoes as ldl on ldl.id_disciplina = adl.id_disciplina_pos_graduacao
					where data='$dataHj' and ldl.id_aluno=$id;";
		$query = $this->db->query($sql);
	   $result = $query->row();
      if(isset($result)) $soma += $result->num;
      $soma += 0;

      return $soma;
    }
     function get_percentagem_por_disciplina_user_aluno(){
    	$id =  $this->session->userdata('id');
		$sql = "SELECT id_disciplina as id, dl.designacao,t.designacao as turma from alunos_inscritos_licenciatura as ldl
				join disciplinas_licenciatura as dl on dl.id = ldl.id_disciplina
				join turmas_licenciatura as t on t.id =dl.id_turma 
				where id_aluno = $id";
	  $disciplinas_licenciatura = $this->db->query($sql);
	  $data = array();
	  foreach ($disciplinas_licenciatura->result() as $disciplina) {
	  		$data[] = array(
	  				"designacao" => $disciplina->designacao,
	  				"turma" => $disciplina->turma,
                    "total_presencas" =>
                    $this->get_num_total_presencas_aluno_disciplina_licenciatura($disciplina->id),
                    "num_aulas_disciplina" =>$this->get_num_aulas_disciplina_licenciatura($disciplina->id)
	  				);
	  }
	  $sql = "SELECT id_disciplina as id, dl.designacao,t.designacao as turma from alunos_inscritos_mestrado as ldl
				join disciplinas_mestrado as dl on dl.id = ldl.id_disciplina
				join turmas_mestrado as t on t.id =dl.id_turma 
				where id_aluno = $id;";
	  $disciplinas_mestrado = $this->db->query($sql);
	  foreach ($disciplinas_mestrado->result() as $disciplina) {
	  		$data[] = array(
	  				"designacao" => $disciplina->designacao,
	  				"turma" => $disciplina->turma,
                    "total_presencas" =>
                    $this->get_num_total_presencas_aluno_disciplina_mestrado($disciplina->id),
                    "num_aulas_disciplina" =>$this->get_num_aulas_disciplina_mestrado($disciplina->id)
                );
	  	}
	   $sql = "SELECT id_disciplina as id, dl.designacao,t.designacao as turma from alunos_inscritos_pos_graduacoes as ldl
				join disciplinas_pos_graduacoes as dl on dl.id = ldl.id_disciplina
				join turmas_pos_graduacoes as t on t.id =dl.id_turma 
				where id_aluno = $id;";
	  $disciplinas_pg = $this->db->query($sql);
	  foreach ($disciplinas_pg->result() as $disciplina) {
	  		$data[] = array(
	  				"designacao" => $disciplina->designacao,
	  				"turma" => $disciplina->turma,
                    "total_presencas" =>
                    $this->get_num_total_presencas_aluno_disciplina_posgraduacao($disciplina->id),
                    "num_aulas_disciplina" =>$this->get_num_aulas_disciplina_pos_graduacao($disciplina->id)
	  				);
	  }
	  return $data;

    }

    function get_avg_percentagem_por_disciplina_user_aluno(){
    	$disciplinas = $this->get_percentagem_por_disciplina_user_aluno();
    	$soma=0;
    	foreach ($disciplinas as $disciplina) {
    			$soma += round($disciplina["total_presencas"]/$disciplina["num_aulas_disciplina"] * 100,3);
    	}
    	return round($soma/sizeof($disciplinas),3);
    }
    function get_num_total_presencas_aluno_disciplina_licenciatura($id_disciplina){
    	$id =  $this->session->userdata('id');

    	$sql = "SELECT dl.designacao, count(*) AS n_presencas
				FROM 
				acessos_alunos_corrigidos as aac
				  join alunos on alunos.num_aluno = aac.num_aluno
				  join portas as p on concat(p.edificio, '.',p.piso,'.',p.num_porta) = aac.porta
				  join salas as sal on sal.id_porta = p.id
				  join aulas_disciplinas_licenciaturas as adl on sal.id = adl.id_sala
				  join disciplinas_licenciatura as dl on dl.id = adl.id_disciplina_licenciatura
				  join alunos_inscritos_licenciatura as ail on ail.id_disciplina = dl.id
				  where aac.data = adl.data and (aac.hora > adl.hora_inicial and aac.hora < adl.hora_final) and sentido = 'Entrada' and aac.id_acesso > 0 and ail.id_aluno = alunos.id and dl.id = $id_disciplina and alunos.id=$id
				  group by dl.designacao;";
	  $query = $this->db->query($sql);
	   if ($query->num_rows()==1) {
	    return $query->result()[0]->n_presencas;
	   }
	   else{return 0;}
    }
    function get_num_total_presencas__aluno_disciplina_mestrado($id_disciplina){
    	$id =  $this->session->userdata('id');

    	$sql = "SELECT dl.designacao, count(*) AS n_presencas
				FROM 
				acessos_alunos_corrigidos as aac
				  join alunos on alunos.num_aluno = aac.num_aluno
				  join portas as p on concat(p.edificio, '.',p.piso,'.',p.num_porta) = aac.porta
				  join salas as sal on sal.id_porta = p.id
				  join aulas_disciplinas_mestrados as adl on sal.id = adl.id_sala
				  join disciplinas_mestrado as dl on dl.id = adl.id_disciplina_mestrado
				  join alunos_inscritos_mestrado as ail on ail.id_disciplina = dl.id
				  where aac.data = adl.data and (aac.hora > adl.hora_inicial and aac.hora < adl.hora_final) and sentido = 'Entrada' and aac.id_acesso > 0 and ail.id_aluno = alunos.id and dl.id = $id_disciplina and alunos.id=$id
				  group by dl.designacao;";
		$query = $this->db->query($sql);
	   if ($query->num_rows()==1) {
	    return $query->result()[0]->n_presencas;
	   }
	   else{return 0;}
	 
    }
    function get_num_total_presencas_aluno_disciplina_posgraduacao($id_disciplina){
    	$id =  $this->session->userdata('id');

    	$sql = "SELECT dl.designacao, count(*) AS n_presencas
				FROM 
				acessos_alunos_corrigidos as aac
				  join alunos on alunos.num_aluno = aac.num_aluno
				  join portas as p on concat(p.edificio, '.',p.piso,'.',p.num_porta) = aac.porta
				  join salas as sal on sal.id_porta = p.id
				  join aulas_disciplinas_pos_graduacoes as adl on sal.id = adl.id_sala
				  join disciplinas_pos_graduacoes as dl on dl.id = adl.id_disciplina_pos_graduacao
				  join alunos_inscritos_pos_graduacoes as ail on ail.id_disciplina = dl.id
				  where aac.data = adl.data and (aac.hora > adl.hora_inicial and aac.hora < adl.hora_final) and sentido = 'Entrada' and aac.id_acesso > 0 and ail.id_aluno = alunos.id and dl.id = $id_disciplina and alunos.id=$id
				  group by dl.designacao;";
	 $query = $this->db->query($sql);
	   if ($query->num_rows()==1) {
	    return $query->result()[0]->n_presencas;
	   }
	   else{return 0;}
    }

}
?>