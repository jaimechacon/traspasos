<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orden extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Orden_model');
		$this->load->library('excel');
	}

	public function index()
	{
		$usuario = $this->session->userdata();
		if(isset($usuario['id_usuario'])){

			if (isset($usuario['pf_analista']) && $usuario['pf_analista'] === "5"){
				redirect('Orden/listarTraspasosCall');
			} else {
				redirect('Orden/listarTraspasos');
			}
		}else
		{
			redirect('Inicio');
		}
	}

	public function listarTraspasos()
	{
		$usuario = $this->session->userdata();
		if(isset($usuario['id_usuario'])){
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			     
			     $id_sucursal = "null";
			     $id_usuario_vendedor = "null";
			     $fecha_desde = "null";
			     $fecha_hasta = "null";
			     $id_estado_rc = "null";
			     $id_estado_c = "null";

				if(!is_null($this->input->post('id_sucursal')) && $this->input->post('id_sucursal') != "-1" 
				#	&& $this->input->post('id_sucursal') != ""
				)
					$id_sucursal = (trim($this->input->post('id_sucursal')) == "" ? "''" : $this->input->post('id_sucursal'));

				if(!is_null($this->input->post('id_usuario_vendedor')) && $this->input->post('id_usuario_vendedor') != "-1" #&& $this->input->post('id_usuario_vendedor') != ""
				)
					$id_usuario_vendedor = (trim($this->input->post('id_usuario_vendedor')) == "" ? "''" : $this->input->post('id_usuario_vendedor'));

				if(!is_null($this->input->post('fecha_desde')) && $this->input->post('fecha_desde') != "-1" && $this->input->post('fecha_desde') != "")
					$fecha_desde = $this->input->post('fecha_desde');

				if(!is_null($this->input->post('fecha_hasta')) && $this->input->post('fecha_hasta') != "-1" && $this->input->post('fecha_hasta') != "")
					$fecha_hasta = $this->input->post('fecha_hasta');

				if(!is_null($this->input->post('id_estado_rc')) && $this->input->post('id_estado_rc') != "-1" && $this->input->post('id_estado_rc') != "")
					$id_estado_rc = $this->input->post('id_estado_rc');

				if(!is_null($this->input->post('id_estado_c')) && $this->input->post('id_estado_c') != "-1" && $this->input->post('id_estado_c') != "")
					$id_estado_c = $this->input->post('id_estado_c');
				

				$traspasos = $this->Orden_model->listarTraspasosUsuario($usuario['id_usuario'], $id_sucursal, $id_usuario_vendedor, $fecha_desde, $fecha_hasta, $id_estado_rc, $id_estado_c, "null");

				if(isset($traspasos))
				{
					
					$mensaje = '';
					$resultado = 1;
					$datos = array('mensaje' =>$mensaje, 'resultado' => $resultado, 'tabla' => $traspasos);
					echo json_encode($datos);
				}else{
					$mensaje = 'Ocurrió un error al obtener las ordenes de traspasos.';
					$resultado = 0;
					$datos = array('mensaje' =>$mensaje, 'resultado' => $resultado, 'tabla' => $traspasos);
					echo json_encode($datos);
				}
			}else
			{
				$sucursales = $this->Orden_model->listarSucursalesUsuCall($usuario["id_usuario"]);
				if($sucursales)
					$usuario["sucursales"] = $sucursales;

				mysqli_next_result($this->db->conn_id);
				$vendedores = $this->Orden_model->listarVendedorUsuCall($usuario["id_usuario"]);
				if($vendedores)
					$usuario["vendedores"] = $vendedores;
		
				mysqli_next_result($this->db->conn_id);
				$estadosC = $this->Orden_model->listarCertificadosUsuCall($usuario["id_usuario"]);
				if($estadosC)
					$usuario["estadosC"] = $estadosC;

				$usuario_operacional = (sizeof($sucursales) > 1 ? true : false);

				$usuario_supervisor = (sizeof($vendedores) > 1 ? true : false);
				

				$usuario['usuario_operacional'] = $usuario_operacional;
				$usuario['usuario_supervisor'] = $usuario_supervisor;

				mysqli_next_result($this->db->conn_id);
				$traspasos = $this->Orden_model->listarTraspasosUsuario($usuario['id_usuario'], "null", "null", "null", "null", "null", "null", "null");
				$usuario['traspasos'] = $traspasos;
				$usuario['controller'] = 'orden';
				$this->load->view('temp/header');
				$this->load->view('temp/menu', $usuario);
				$this->load->view('listarTraspasos', $usuario);
				$this->load->view('temp/footer', $usuario);
			}
		}else
		{
			redirect('Inicio');
		}
	}	

	public function listarTraspasosCall()
	{
		$usuario = $this->session->userdata();
		if(isset($usuario['id_usuario'])){

			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			     
			     $id_sucursal = "null";
			     $id_usuario_vendedor = "null";
			     $fecha_desde = "null";
			     $fecha_hasta = "null";
			     $id_estado_rc = "null";
			     $id_estado_c = "null";

				if(!is_null($this->input->post('id_sucursal')) && $this->input->post('id_sucursal') != "-1" 
				#	&& $this->input->post('id_sucursal') != ""
				)
					$id_sucursal = (trim($this->input->post('id_sucursal')) == "" ? "''" : $this->input->post('id_sucursal'));

				if(!is_null($this->input->post('id_usuario_vendedor')) && $this->input->post('id_usuario_vendedor') != "-1" #&& $this->input->post('id_usuario_vendedor') != ""
				)
					$id_usuario_vendedor = (trim($this->input->post('id_usuario_vendedor')) == "" ? "''" : $this->input->post('id_usuario_vendedor'));

				if(!is_null($this->input->post('fecha_desde')) && $this->input->post('fecha_desde') != "-1" && $this->input->post('fecha_desde') != "")
					$fecha_desde = $this->input->post('fecha_desde');

				if(!is_null($this->input->post('fecha_hasta')) && $this->input->post('fecha_hasta') != "-1" && $this->input->post('fecha_hasta') != "")
					$fecha_hasta = $this->input->post('fecha_hasta');

				if(!is_null($this->input->post('id_estado_rc')) && $this->input->post('id_estado_rc') != "-1" && $this->input->post('id_estado_rc') != "")
					$id_estado_rc = $this->input->post('id_estado_rc');

				if(!is_null($this->input->post('id_estado_c')) && $this->input->post('id_estado_c') != "-1" && $this->input->post('id_estado_c') != "")
					$id_estado_c = $this->input->post('id_estado_c');
				

				$traspasos = $this->Orden_model->listarTraspasosUsuarioCall($usuario['id_usuario'], $id_sucursal, $id_usuario_vendedor, $fecha_desde, $fecha_hasta, $id_estado_rc, $id_estado_c);
				if(isset($traspasos))
				{
					
					$mensaje = '';
					$resultado = 1;
					$datos = array('mensaje' =>$mensaje, 'resultado' => $resultado, 'tabla' => $traspasos);
					echo json_encode($datos);
				}else{
					$mensaje = 'Ocurrió un error al obtener las ordenes de traspasos.';
					$resultado = 0;
					$datos = array('mensaje' =>$mensaje, 'resultado' => $resultado, 'tabla' => $traspasos);
					echo json_encode($datos);
				}
			}else
			{
				$sucursales = $this->Orden_model->listarSucursalesUsuCall($usuario["id_usuario"]);
				if($sucursales)
					$usuario["sucursales"] = $sucursales;

				mysqli_next_result($this->db->conn_id);
				$vendedores = $this->Orden_model->listarVendedorUsuCall($usuario["id_usuario"]);
				if($vendedores)
					$usuario["vendedores"] = $vendedores;

				mysqli_next_result($this->db->conn_id);
				$estadosC = $this->Orden_model->listarCertificadosUsuCall($usuario["id_usuario"]);
				if($estadosC)
					$usuario["estadosC"] = $estadosC;

				mysqli_next_result($this->db->conn_id);
				$traspasos = $this->Orden_model->listarTraspasosUsuarioCall($usuario['id_usuario'], "null", "null", "null", "null", "null", "null");
				$usuario['traspasos'] = $traspasos;
				$usuario['controller'] = 'orden';
				$usuario['usu_admin'] = $traspasos[0]['usu_admin'];
				$this->load->view('temp/header');
				$this->load->view('temp/menu', $usuario);
				$this->load->view('listarTraspasosCall', $usuario);
				$this->load->view('temp/footer', $usuario);
			}			
		}else
		{
			redirect('Inicio');
		}
	}

	public function exportarexcelNeotel(){
		$usuario = $this->session->userdata();
		$datos = [];
		if($this->session->userdata('id_usuario'))
		{
			$idSucursal = "null";
			$idUsuarioVendedor = "null";
			$id_estado_rc = "null";
			$fecha_inicio = "null";
			$fecha_fin = "null";
			$id_estado_certificacion = "null";
			$por_defecto = 1;

			$registrosOT = $this->Orden_model->insertCRMNeotel($idSucursal, $idUsuarioVendedor, $id_estado_rc, $fecha_inicio, $fecha_fin, $id_estado_certificacion, $usuario["id_usuario"], $por_defecto);
			
			$this->excel->getActiveSheet()->setTitle('Contactos');
			#var_dump($institucion, $hospital, $proveedor, $mes, $anio);
			#var_dump($pagos);
	        //Contador de filas
	        $contador = 1;

	        /*
	        //Le aplicamos ancho las columnas.
	        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
	        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
	        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
	        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
	        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
	        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
	        $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
	        $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
			
	        $this->excel->getActiveSheet()->getStyle('A7:I7')
	        ->getFill()
	        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
	        ->getStartColor()
	        ->setRGB('006CB8');*/

	        //$this->excel->getActiveSheet()->getRowDimension(6)->setRowHeight(20);
			//$this->excel->getActiveSheet()->mergeCells("A1:I5");

			//$style = array('alignment' => array(
            //				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            //			    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
        	//'font' => array('size' => 12, 'color' => array('rgb' => 'ffffff')));

        	//$styleTitulo = array('alignment' => array(
            //				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            //			    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
        	//'font' => array('size' => 20, 'bold' => true, 'color' => array('rgb' => '006CB8')));

        	//$this->excel->getActiveSheet()->getStyle('A1:I5')->applyFromArray($styleTitulo);
        	
        	/*$this->excel->getActiveSheet()->setCellValue("A1", 'Listado de Pagos Tesoreria');

			//apply the style on column A row 1 to Column B row 1
			 $this->excel->getActiveSheet()->getStyle('A7:I7')->applyFromArray($style);

			$gdImage = imagecreatefrompng(base_url()."assets/img/logo.png");
			$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
			$objDrawing->setImageResource($gdImage);
			$objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
			$objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
			$objDrawing->setHeight(100);
			$objDrawing->setwidth(100);
			$objDrawing->setCoordinates('A1');

			$objDrawing->setWorksheet($this->excel->getActiveSheet());

			$this->excel->getActiveSheet()->getStyle('A6');
	        */
	        $this->excel->getActiveSheet()->setCellValue("A1", 'ID');
			$this->excel->getActiveSheet()->setCellValue("B1", 'Nombre Completo');
			$this->excel->getActiveSheet()->setCellValue("C1", 'Apellido_1');
			$this->excel->getActiveSheet()->setCellValue("D1", 'Apellido_2');
			$this->excel->getActiveSheet()->setCellValue("E1", 'Rut_Cliente');
			$this->excel->getActiveSheet()->setCellValue("F1", 'Fecha_cambio');
			$this->excel->getActiveSheet()->setCellValue("G1", 'AFP_actual');
			$this->excel->getActiveSheet()->setCellValue("H1", 'Num_Movil_Cliente');
			
			
	        //Definimos la data del cuerpo.        
	        
	        foreach($registrosOT as $registro){
	           //Incrementamos una fila más, para ir a la siguiente.
	           $contador++;
	           //Informacion de las filas de la consulta.

	            $this->excel->getActiveSheet()->setCellValue("A{$contador}", $registro['id_crm_neotel']);
				$this->excel->getActiveSheet()->setCellValue("B{$contador}", $registro['nombres']);
				$this->excel->getActiveSheet()->setCellValue("C{$contador}", $registro['apellido_paterno']);
				$this->excel->getActiveSheet()->setCellValue("D{$contador}", $registro['apellido_materno']);
				$this->excel->getActiveSheet()->setCellValue("E{$contador}", $registro['rut']);
				$this->excel->getActiveSheet()->setCellValue("F{$contador}", $registro['fecha_cambio_estado']);
				$this->excel->getActiveSheet()->setCellValue("G{$contador}", $registro['institucion']);
				$this->excel->getActiveSheet()->setCellValue("H{$contador}", $registro['telefono']);
	        }

	        //Le ponemos un nombre al archivo que se va a generar.
	        $archivo = "OT_automatico_{$contador}.xls";
	        header('Content-Type: application/force-download');
	        header('Content-Disposition: attachment;filename="'.$archivo.'"');
	        header('Cache-Control: max-age=0');

	        #$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
	        //Hacemos una salida al navegador con el archivo Excel.
	        $objWriter->save('php://output'); 
		}
		else
		{
			redirect('Login');
		}
    }

    public function exportarexcelNeotelFiltroComercial(){
		$usuario = $this->session->userdata();
		$datos = [];
		if($this->session->userdata('id_usuario'))
		{
			$idSucursal = "null";
			$idUsuarioVendedor = "null";
			$id_estado_rc = "null";
			$fecha_desde = "null";
			$fecha_hasta = "null";
			$id_estado_certificacion = "null";
			$por_defecto=0;


			if(!is_null($this->input->get('idsucursal')) && $this->input->get('idsucursal') != "-1" && $this->input->get('idsucursal') != "")
				$idSucursal = $this->input->get('idsucursal');

			if(!is_null($this->input->get('idvendedor')) && $this->input->get('idvendedor') != "-1" && $this->input->get('idvendedor') != "")
				$idUsuarioVendedor = $this->input->get('idvendedor');

			if(!is_null($this->input->get('fechadesde')) && $this->input->get('fechadesde') != "-1" && $this->input->get('fechadesde') != "")
				$fecha_desde = $this->input->get('fechadesde');

			if(!is_null($this->input->get('fechahasta')) && $this->input->get('fechahasta') != "-1" && $this->input->get('fechahasta') != "")
				$fecha_hasta = $this->input->get('fechahasta');

			if(!is_null($this->input->get('idestadorc')) && $this->input->get('idestadorc') != "-1" && $this->input->get('idestadorc') != "")
				$id_estado_rc = $this->input->get('idestadorc');

			if(!is_null($this->input->get('idestadoc')) && $this->input->get('idestadoc') != "-1" && $this->input->get('idestadoc') != "")
				$id_estado_certificacion = $this->input->get('idestadoc');
			
			$registrosOT = $this->Orden_model->listarTraspasosUsuarioCall($usuario['id_usuario'], $idSucursal, $idUsuarioVendedor, $fecha_desde, $fecha_hasta, $id_estado_rc, $id_estado_certificacion);
			
			$this->excel->getActiveSheet()->setTitle('Registros OT');
			
	        //Contador de filas
	        $contador = 1;

	        $this->excel->getActiveSheet()->setCellValue("A1", 'ID_USUARIO');
			$this->excel->getActiveSheet()->setCellValue("B1", 'U_NOMBRES');
			$this->excel->getActiveSheet()->setCellValue("C1", 'U_APELLIDOS');
			$this->excel->getActiveSheet()->setCellValue("D1", 'U_CELULAR');
			$this->excel->getActiveSheet()->setCellValue("E1", 'U_EMAIL');
			$this->excel->getActiveSheet()->setCellValue("F1", 'U_RUT');
			$this->excel->getActiveSheet()->setCellValue("G1", 'ID_EMPRESA');
			$this->excel->getActiveSheet()->setCellValue("H1", 'U_COD_USUARIO');
			$this->excel->getActiveSheet()->setCellValue("I1", 'ID_PERFIL');
			$this->excel->getActiveSheet()->setCellValue("J1", 'PF_NOMBRE');
			$this->excel->getActiveSheet()->setCellValue("K1", 'ID_SMS');
			$this->excel->getActiveSheet()->setCellValue("L1", 'USERNAME');
			$this->excel->getActiveSheet()->setCellValue("M1", 'ANI');
			$this->excel->getActiveSheet()->setCellValue("N1", 'DNIS');
			$this->excel->getActiveSheet()->setCellValue("O1", 'MESSAGE_SMS');
			$this->excel->getActiveSheet()->setCellValue("P1", 'OTHER_MESSAGES');
			$this->excel->getActiveSheet()->setCellValue("Q1", 'ID_ESTADO');
			$this->excel->getActiveSheet()->setCellValue("R1", 'OBSERVACION');
			$this->excel->getActiveSheet()->setCellValue("S1", 'FECHA_CREACION_SMS_IVR');
			$this->excel->getActiveSheet()->setCellValue("T1", 'RC_VALIDACION');
			$this->excel->getActiveSheet()->setCellValue("U1", 'RC_RESULTADO');
			$this->excel->getActiveSheet()->setCellValue("V1", 'NOMBRE_RESULTADO_RC');
			$this->excel->getActiveSheet()->setCellValue("W1", 'PR_VALIDACION');
			$this->excel->getActiveSheet()->setCellValue("X1", 'PR_RESULTADO');
			$this->excel->getActiveSheet()->setCellValue("Y1", 'RUT');
			$this->excel->getActiveSheet()->setCellValue("Z1", 'SERIE');
			$this->excel->getActiveSheet()->setCellValue("AA1", 'NOMBRES');
			$this->excel->getActiveSheet()->setCellValue("AB1", 'APELLIDO_PATERNO');
			$this->excel->getActiveSheet()->setCellValue("AC1", 'APELLIDO_MATERNO');
			$this->excel->getActiveSheet()->setCellValue("AD1", 'INSTITUCION');
			$this->excel->getActiveSheet()->setCellValue("AE1", 'GENERO');
			$this->excel->getActiveSheet()->setCellValue("AF1", 'FECHA_NACIMIENTO');
			$this->excel->getActiveSheet()->setCellValue("AG1", 'FECHA_INGRESO_PREVIRED');
			$this->excel->getActiveSheet()->setCellValue("AH1", 'FECHA_SUBSCRIPCION_PREVIRED');
			$this->excel->getActiveSheet()->setCellValue("AI1", 'FECHA_INCORPORACION_PREVIRED');
			$this->excel->getActiveSheet()->setCellValue("AJ1", 'TIPO_SOLICITUD_PREVIRED');
			$this->excel->getActiveSheet()->setCellValue("AK1", 'SITUACION_AFILIADO');
			$this->excel->getActiveSheet()->setCellValue("AL1", 'ID_TIPO_DOCUMENTO');
			$this->excel->getActiveSheet()->setCellValue("AM1", 'TIPO_DOCUMENTO');
			$this->excel->getActiveSheet()->setCellValue("AN1", 'FOLIO');
			$this->excel->getActiveSheet()->setCellValue("AO1", 'TELEFONO');
			$this->excel->getActiveSheet()->setCellValue("AP1", 'ID_IVR_NEOTEL');
			$this->excel->getActiveSheet()->setCellValue("AQ1", 'VIA_ENTRADA');
			$this->excel->getActiveSheet()->setCellValue("AR1", 'SUCURSAL');
			$this->excel->getActiveSheet()->setCellValue("AS1", 'ID_CERTIFICADO');
			$this->excel->getActiveSheet()->setCellValue("AT1", 'CERTIFICADO');
			$this->excel->getActiveSheet()->setCellValue("AU1", 'FECHA_CERTIFICADO');
			
	        //Definimos la data del cuerpo.        
	        
	        foreach($registrosOT as $registro){
	           //Incrementamos una fila más, para ir a la siguiente.
	           $contador++;
	           //Informacion de las filas de la consulta.
	           //var_dump($registro);
	            $this->excel->getActiveSheet()->setCellValue("A{$contador}", $registro['id_usuario']);
				$this->excel->getActiveSheet()->setCellValue("B{$contador}", $registro['u_nombres']);
				$this->excel->getActiveSheet()->setCellValue("C{$contador}", $registro['u_apellidos']);
				$this->excel->getActiveSheet()->setCellValue("D{$contador}", $registro['u_celular']);
				$this->excel->getActiveSheet()->setCellValue("E{$contador}", $registro['u_email']);
				$this->excel->getActiveSheet()->setCellValue("F{$contador}", $registro['u_rut']);
				$this->excel->getActiveSheet()->setCellValue("G{$contador}", $registro['id_empresa']);
				$this->excel->getActiveSheet()->setCellValue("H{$contador}", $registro['u_cod_usuario']);
				$this->excel->getActiveSheet()->setCellValue("I{$contador}", $registro['id_perfil']);
				$this->excel->getActiveSheet()->setCellValue("J{$contador}", $registro['pf_nombre']);
				$this->excel->getActiveSheet()->setCellValue("K{$contador}", $registro['id_sms']);
				$this->excel->getActiveSheet()->setCellValue("L{$contador}", $registro['username']);
				$this->excel->getActiveSheet()->setCellValue("M{$contador}", $registro['ani']);
				$this->excel->getActiveSheet()->setCellValue("N{$contador}", $registro['dnis']);
				$this->excel->getActiveSheet()->setCellValue("O{$contador}", $registro['message']);
				$this->excel->getActiveSheet()->setCellValue("P{$contador}", $registro['other_messages']);
				$this->excel->getActiveSheet()->setCellValue("Q{$contador}", $registro['id_estado']);
				$this->excel->getActiveSheet()->setCellValue("R{$contador}", $registro['observacion']);
				$this->excel->getActiveSheet()->setCellValue("S{$contador}", $registro['fecha']);
				$this->excel->getActiveSheet()->setCellValue("T{$contador}", $registro['rc_validacion']);
				$this->excel->getActiveSheet()->setCellValue("U{$contador}", $registro['rc_resultado']);
				$this->excel->getActiveSheet()->setCellValue("V{$contador}", $registro['nombre_resultado_rc']);
				$this->excel->getActiveSheet()->setCellValue("W{$contador}", $registro['pr_validacion']);
				$this->excel->getActiveSheet()->setCellValue("X{$contador}", $registro['pr_resultado']);
				$this->excel->getActiveSheet()->setCellValue("Y{$contador}", $registro['rut']);
				$this->excel->getActiveSheet()->setCellValue("Z{$contador}", $registro['serie']);
				$this->excel->getActiveSheet()->setCellValue("AA{$contador}", $registro['nombres']);
				$this->excel->getActiveSheet()->setCellValue("AB{$contador}", $registro['apellido_paterno']);
				$this->excel->getActiveSheet()->setCellValue("AC{$contador}", $registro['apellido_materno']);
				$this->excel->getActiveSheet()->setCellValue("AD{$contador}", $registro['institucion']);
				$this->excel->getActiveSheet()->setCellValue("AE{$contador}", $registro['genero']);
				$this->excel->getActiveSheet()->setCellValue("AF{$contador}", $registro['fecha_nacimiento']);
				$this->excel->getActiveSheet()->setCellValue("AG{$contador}", $registro['fecha_ingreso_previred']);
				$this->excel->getActiveSheet()->setCellValue("AH{$contador}", $registro['fecha_subscripcion_previred']);
				$this->excel->getActiveSheet()->setCellValue("AI{$contador}", $registro['fecha_incorporacion_previred']);
				$this->excel->getActiveSheet()->setCellValue("AJ{$contador}", $registro['tipo_solicitud_previred']);
				$this->excel->getActiveSheet()->setCellValue("AK{$contador}", $registro['situacion_afiliado']);
				$this->excel->getActiveSheet()->setCellValue("AL{$contador}", $registro['id_tipo_documento']);
				$this->excel->getActiveSheet()->setCellValue("AM{$contador}", $registro['tipo_documento']);
				$this->excel->getActiveSheet()->setCellValue("AN{$contador}", $registro['folio']);
				$this->excel->getActiveSheet()->setCellValue("AO{$contador}", $registro['telefono']);
				$this->excel->getActiveSheet()->setCellValue("AP{$contador}", $registro['id_ivr_neotel']);
				$this->excel->getActiveSheet()->setCellValue("AQ{$contador}", $registro['via_entrada']);
				$this->excel->getActiveSheet()->setCellValue("AR{$contador}", $registro['sucursal']);
				$this->excel->getActiveSheet()->setCellValue("AS{$contador}", $registro['id_certificado']);
				$this->excel->getActiveSheet()->setCellValue("AT{$contador}", $registro['certificado']);
				$this->excel->getActiveSheet()->setCellValue("AU{$contador}", $registro['fecha_certificacion']);
	        }

	        //Le ponemos un nombre al archivo que se va a generar.
	        $archivo = "Reporte_Comercial_OT_{$contador}.xls";
	        //header('Content-Type: application/force-download');
	        header('Content-Type: application/vnd.ms-excel');
	        header('Content-Disposition: attachment;filename="'.$archivo.'"');
	        header('Cache-Control: max-age=0');



	        #$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
	        //Hacemos una salida al navegador con el archivo Excel.
	        $objWriter->save('php://output');
		}
		else
		{
			redirect('Login');
		}
    }

    public function exportarexcelNeotelFiltro(){
		$usuario = $this->session->userdata();
		$datos = [];
		if($this->session->userdata('id_usuario'))
		{
			$idSucursal = "null";
			$idUsuarioVendedor = "null";
			$id_estado_rc = "null";
			$fecha_desde = "null";
			$fecha_hasta = "null";
			$id_estado_certificacion = "null";
			$por_defecto=0;


			if(!is_null($this->input->get('idsucursal')) && $this->input->get('idsucursal') != "-1" && $this->input->get('idsucursal') != "")
				$idSucursal = $this->input->get('idsucursal');

			if(!is_null($this->input->get('idvendedor')) && $this->input->get('idvendedor') != "-1" && $this->input->get('idvendedor') != "")
				$idUsuarioVendedor = $this->input->get('idvendedor');

			if(!is_null($this->input->get('fechadesde')) && $this->input->get('fechadesde') != "-1" && $this->input->get('fechadesde') != "")
				$fecha_desde = $this->input->get('fechadesde');

			if(!is_null($this->input->get('fechahasta')) && $this->input->get('fechahasta') != "-1" && $this->input->get('fechahasta') != "")
				$fecha_hasta = $this->input->get('fechahasta');

			if(!is_null($this->input->get('idestadorc')) && $this->input->get('idestadorc') != "-1" && $this->input->get('idestadorc') != "")
				$id_estado_rc = $this->input->get('idestadorc');

			if(!is_null($this->input->get('idestadoc')) && $this->input->get('idestadoc') != "-1" && $this->input->get('idestadoc') != "")
				$id_estado_certificacion = $this->input->get('idestadoc');
			

			$registrosOT = $this->Orden_model->insertCRMNeotel($idSucursal, $idUsuarioVendedor, $id_estado_rc, $fecha_desde, $fecha_hasta, $id_estado_certificacion, $usuario["id_usuario"], $por_defecto);
			
			$this->excel->getActiveSheet()->setTitle('Contactos');
			#var_dump($institucion, $hospital, $proveedor, $mes, $anio);
			#var_dump($pagos);
	        //Contador de filas
	        $contador = 1;

	        /*
	        //Le aplicamos ancho las columnas.
	        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
	        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
	        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
	        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
	        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
	        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
	        $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
	        $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
			
	        $this->excel->getActiveSheet()->getStyle('A7:I7')
	        ->getFill()
	        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
	        ->getStartColor()
	        ->setRGB('006CB8');*/

	        //$this->excel->getActiveSheet()->getRowDimension(6)->setRowHeight(20);
			//$this->excel->getActiveSheet()->mergeCells("A1:I5");

			//$style = array('alignment' => array(
            //				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            //			    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
        	//'font' => array('size' => 12, 'color' => array('rgb' => 'ffffff')));

        	//$styleTitulo = array('alignment' => array(
            //				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            //			    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
        	//'font' => array('size' => 20, 'bold' => true, 'color' => array('rgb' => '006CB8')));

        	//$this->excel->getActiveSheet()->getStyle('A1:I5')->applyFromArray($styleTitulo);
        	
        	/*$this->excel->getActiveSheet()->setCellValue("A1", 'Listado de Pagos Tesoreria');

			//apply the style on column A row 1 to Column B row 1
			 $this->excel->getActiveSheet()->getStyle('A7:I7')->applyFromArray($style);

			$gdImage = imagecreatefrompng(base_url()."assets/img/logo.png");
			$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
			$objDrawing->setImageResource($gdImage);
			$objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
			$objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
			$objDrawing->setHeight(100);
			$objDrawing->setwidth(100);
			$objDrawing->setCoordinates('A1');

			$objDrawing->setWorksheet($this->excel->getActiveSheet());

			$this->excel->getActiveSheet()->getStyle('A6');
	        */
	        $this->excel->getActiveSheet()->setCellValue("A1", 'ID');
			$this->excel->getActiveSheet()->setCellValue("B1", 'Nombre Completo');
			$this->excel->getActiveSheet()->setCellValue("C1", 'Apellido_1');
			$this->excel->getActiveSheet()->setCellValue("D1", 'Apellido_2');
			$this->excel->getActiveSheet()->setCellValue("E1", 'Rut_Cliente');
			$this->excel->getActiveSheet()->setCellValue("F1", 'Fecha_cambio');
			$this->excel->getActiveSheet()->setCellValue("G1", 'AFP_actual');
			$this->excel->getActiveSheet()->setCellValue("H1", 'Num_Movil_Cliente');
			
			
	        //Definimos la data del cuerpo.        
	        
	        foreach($registrosOT as $registro){
	           //Incrementamos una fila más, para ir a la siguiente.
	           $contador++;
	           //Informacion de las filas de la consulta.

	            $this->excel->getActiveSheet()->setCellValue("A{$contador}", $registro['id_crm_neotel']);
				$this->excel->getActiveSheet()->setCellValue("B{$contador}", $registro['nombres']);
				$this->excel->getActiveSheet()->setCellValue("C{$contador}", $registro['apellido_paterno']);
				$this->excel->getActiveSheet()->setCellValue("D{$contador}", $registro['apellido_materno']);
				$this->excel->getActiveSheet()->setCellValue("E{$contador}", $registro['rut']);
				$this->excel->getActiveSheet()->setCellValue("F{$contador}", $registro['fecha_cambio_estado']);
				$this->excel->getActiveSheet()->setCellValue("G{$contador}", $registro['institucion']);
				$this->excel->getActiveSheet()->setCellValue("H{$contador}", $registro['telefono']);
	        }

	        //Le ponemos un nombre al archivo que se va a generar.
	        $archivo = "OT_filtros_{$contador}.xls";
	        header('Content-Type: application/force-download');
	        header('Content-Disposition: attachment;filename="'.$archivo.'"');
	        header('Cache-Control: max-age=0');

	        #$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
	        //Hacemos una salida al navegador con el archivo Excel.
	        $objWriter->save('php://output'); 
		}
		else
		{
			redirect('Login');
		}
    }	

     public function exportarexcelUsuarioFiltro(){
		$usuario = $this->session->userdata();
		$datos = [];
		if($this->session->userdata('id_usuario'))
		{
			 $id_sucursal = "null";
		     $id_usuario_vendedor = "null";
		     $fecha_desde = "null";
		     $fecha_hasta = "null";
		     $id_estado_rc = "null";
		     $id_estado_c = "null";

			if(!is_null($this->input->get('idsucursal')) && $this->input->get('idsucursal') != "-1" 
			#	&& $this->input->get('id_sucursal') != ""
			)
				$id_sucursal = (trim($this->input->get('idsucursal')) == "" ? "''" : $this->input->get('idsucursal'));

			if(!is_null($this->input->get('idvendedor')) && $this->input->get('idvendedor') != "-1" #&& $this->input->get('id_usuario_vendedor') != ""
			)
				$id_usuario_vendedor = (trim($this->input->get('idvendedor')) == "" ? "''" : $this->input->get('idvendedor'));

			if(!is_null($this->input->get('fechadesde')) && $this->input->get('fechadesde') != "-1" && $this->input->get('fechadesde') != "")
				$fecha_desde = $this->input->get('fechadesde');

			if(!is_null($this->input->get('fechahasta')) && $this->input->get('fechahasta') != "-1" && $this->input->get('fechahasta') != "")
				$fecha_hasta = $this->input->get('fechahasta');

			if(!is_null($this->input->get('idestadorc')) && $this->input->get('idestadorc') != "-1" && $this->input->get('idestadorc') != "")
				$id_estado_rc = $this->input->get('idestadorc');

			if(!is_null($this->input->get('idestadoc')) && $this->input->get('idestadoc') != "-1" && $this->input->get('idestadoc') != "")
				$id_estado_c = $this->input->get('idestadoc');

			$traspasos = $this->Orden_model->listarTraspasosUsuario($usuario['id_usuario'], $id_sucursal, $id_usuario_vendedor, $fecha_desde, $fecha_hasta, $id_estado_rc, $id_estado_c, "null");

			
			$this->excel->getActiveSheet()->setTitle('Orden de Traspasos');
	        $contador = 1;
	        $this->excel->getActiveSheet()->setCellValue("A1", 'ID OT');
			$this->excel->getActiveSheet()->setCellValue("B1", 'Sucursal');
			$this->excel->getActiveSheet()->setCellValue("C1", 'Celular Origen');
			$this->excel->getActiveSheet()->setCellValue("D1", 'Rut Usuario');
			$this->excel->getActiveSheet()->setCellValue("E1", 'Usuario');
			$this->excel->getActiveSheet()->setCellValue("F1", 'Perfil');
			$this->excel->getActiveSheet()->setCellValue("G1", 'Rut Afiliado');
			$this->excel->getActiveSheet()->setCellValue("H1", 'Nombres');
			$this->excel->getActiveSheet()->setCellValue("I1", 'Apellido Paterno');
			$this->excel->getActiveSheet()->setCellValue("J1", 'Apellido Materno');
			$this->excel->getActiveSheet()->setCellValue("K1", 'AFP Origen');
			$this->excel->getActiveSheet()->setCellValue("L1", 'Teléfono');
			$this->excel->getActiveSheet()->setCellValue("M1", 'Folio');
			$this->excel->getActiveSheet()->setCellValue("N1", 'Fecha');
			$this->excel->getActiveSheet()->setCellValue("O1", 'Estado Cédula');
			$this->excel->getActiveSheet()->setCellValue("P1", 'Estado Certificación');
			$this->excel->getActiveSheet()->setCellValue("Q1", 'Vía Ingreso');
			
			
	        //Definimos la data del cuerpo.        
	        
	        foreach($traspasos as $registro){
	           //Incrementamos una fila más, para ir a la siguiente.
	           $contador++;
	           //Informacion de las filas de la consulta.

	            $this->excel->getActiveSheet()->setCellValue("A{$contador}", $registro['id_sms']);
				$this->excel->getActiveSheet()->setCellValue("B{$contador}", $registro['sucursal']);
				$this->excel->getActiveSheet()->setCellValue("C{$contador}", $registro['ani']);
				$this->excel->getActiveSheet()->setCellValue("D{$contador}", $registro['u_rut']);
				$this->excel->getActiveSheet()->setCellValue("E{$contador}", $registro['u_nombres']." ".$registro['u_apellidos']);
				$this->excel->getActiveSheet()->setCellValue("F{$contador}", $registro['pf_nombre']);
				$this->excel->getActiveSheet()->setCellValue("G{$contador}", $registro['rut']);
				$this->excel->getActiveSheet()->setCellValue("H{$contador}", $registro['nombres']);
				$this->excel->getActiveSheet()->setCellValue("I{$contador}", $registro['apellido_paterno']);
				$this->excel->getActiveSheet()->setCellValue("J{$contador}", $registro['apellido_materno']);
				$this->excel->getActiveSheet()->setCellValue("K{$contador}", $registro['institucion']);
				$this->excel->getActiveSheet()->setCellValue("L{$contador}", $registro['telefono']);
				$this->excel->getActiveSheet()->setCellValue("M{$contador}", $registro['folio']);
				$this->excel->getActiveSheet()->setCellValue("N{$contador}", $registro['fecha']);
				$this->excel->getActiveSheet()->setCellValue("O{$contador}", $registro['nombre_resultado_rc']);
				$this->excel->getActiveSheet()->setCellValue("P{$contador}", $registro['certificado']);
				$this->excel->getActiveSheet()->setCellValue("Q{$contador}", $registro['via_entrada']);

	        }

	        //Le ponemos un nombre al archivo que se va a generar.
	        $archivo = "OT_{$contador}.xls";
	        header('Content-Type: application/force-download');
	        header('Content-Disposition: attachment;filename="'.$archivo.'"');
	        header('Cache-Control: max-age=0');

	        #$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
	        //Hacemos una salida al navegador con el archivo Excel.
	        $objWriter->save('php://output'); 
		}
		else
		{
			redirect('Login');
		}
    }	

    public function exportarexcelUsuarioFiltroSuper(){
		$usuario = $this->session->userdata();
		$datos = [];
		if($this->session->userdata('id_usuario'))
		{
			 $id_sucursal = "null";
		     $id_usuario_vendedor = "null";
		     $fecha_desde = "null";
		     $fecha_hasta = "null";
		     $id_estado_rc = "null";
		     $id_estado_c = "null";

			if(!is_null($this->input->get('idsucursal')) && $this->input->get('idsucursal') != "-1" 
			#	&& $this->input->get('id_sucursal') != ""
			)
				$id_sucursal = (trim($this->input->get('idsucursal')) == "" ? "''" : $this->input->get('idsucursal'));

			if(!is_null($this->input->get('idvendedor')) && $this->input->get('idvendedor') != "-1" #&& $this->input->get('id_usuario_vendedor') != ""
			)
				$id_usuario_vendedor = (trim($this->input->get('idvendedor')) == "" ? "''" : $this->input->get('idvendedor'));

			if(!is_null($this->input->get('fechadesde')) && $this->input->get('fechadesde') != "-1" && $this->input->get('fechadesde') != "")
				$fecha_desde = $this->input->get('fechadesde');

			if(!is_null($this->input->get('fechahasta')) && $this->input->get('fechahasta') != "-1" && $this->input->get('fechahasta') != "")
				$fecha_hasta = $this->input->get('fechahasta');

			if(!is_null($this->input->get('idestadorc')) && $this->input->get('idestadorc') != "-1" && $this->input->get('idestadorc') != "")
				$id_estado_rc = $this->input->get('idestadorc');

			if(!is_null($this->input->get('idestadoc')) && $this->input->get('idestadoc') != "-1" && $this->input->get('idestadoc') != "")
				$id_estado_c = $this->input->get('idestadoc');

			$traspasos = $this->Orden_model->listarTraspasosUsuario($usuario['id_usuario'], $id_sucursal, $id_usuario_vendedor, $fecha_desde, $fecha_hasta, $id_estado_rc, $id_estado_c, "null");

			
			$this->excel->getActiveSheet()->setTitle('Orden de Traspasos');
	        $contador = 1;
	        //$this->excel->getActiveSheet()->setCellValue("A1", 'ID OT');
			//$this->excel->getActiveSheet()->setCellValue("B1", 'Sucursal');
			//$this->excel->getActiveSheet()->setCellValue("C1", 'Celular Origen');
			
			//$this->excel->getActiveSheet()->setCellValue("F1", 'Perfil');
			$this->excel->getActiveSheet()->setCellValue("A1", 'Folio');
			$this->excel->getActiveSheet()->setCellValue("B1", 'Rut Afiliado');
			$this->excel->getActiveSheet()->setCellValue("C1", 'AFP Origen');
			$this->excel->getActiveSheet()->setCellValue("D1", 'Fecha');
			$this->excel->getActiveSheet()->setCellValue("E1", 'Usuario');
			//$this->excel->getActiveSheet()->setCellValue("H1", 'Nombres');
			//$this->excel->getActiveSheet()->setCellValue("I1", 'Apellido Paterno');
			//$this->excel->getActiveSheet()->setCellValue("J1", 'Apellido Materno');
			//$this->excel->getActiveSheet()->setCellValue("L1", 'Teléfono');			
			//$this->excel->getActiveSheet()->setCellValue("O1", 'Estado Cédula');
			//$this->excel->getActiveSheet()->setCellValue("P1", 'Estado Certificación');
			//$this->excel->getActiveSheet()->setCellValue("Q1", 'Vía Ingreso');
			
			
	        //Definimos la data del cuerpo.        
	        
	        foreach($traspasos as $registro){
	           //Incrementamos una fila más, para ir a la siguiente.
	           $contador++;
	           //Informacion de las filas de la consulta.
	           
	           $this->excel->getActiveSheet()->setCellValue("A{$contador}", $registro['folio']);
	           $this->excel->getActiveSheet()->setCellValue("B{$contador}", $registro['rut']);
	           $this->excel->getActiveSheet()->setCellValue("C{$contador}", $registro['institucion']);
	           $this->excel->getActiveSheet()->setCellValue("D{$contador}", $registro['fecha']);
	           $this->excel->getActiveSheet()->setCellValue("E{$contador}", $registro['u_nombres']." ".$registro['u_apellidos']);
	            //$this->excel->getActiveSheet()->setCellValue("A{$contador}", $registro['id_sms']);
				//$this->excel->getActiveSheet()->setCellValue("B{$contador}", $registro['sucursal']);
				//$this->excel->getActiveSheet()->setCellValue("C{$contador}", $registro['ani']);
				//$this->excel->getActiveSheet()->setCellValue("D{$contador}", $registro['u_rut']);
				//$this->excel->getActiveSheet()->setCellValue("E{$contador}", $registro['u_nombres']." ".$registro['u_apellidos']);
				//$this->excel->getActiveSheet()->setCellValue("F{$contador}", $registro['pf_nombre']);
				//$this->excel->getActiveSheet()->setCellValue("H{$contador}", $registro['nombres']);
				//$this->excel->getActiveSheet()->setCellValue("I{$contador}", $registro['apellido_paterno']);
				//$this->excel->getActiveSheet()->setCellValue("J{$contador}", $registro['apellido_materno']);
				//$this->excel->getActiveSheet()->setCellValue("L{$contador}", $registro['telefono']);
				//$this->excel->getActiveSheet()->setCellValue("O{$contador}", $registro['nombre_resultado_rc']);
				//$this->excel->getActiveSheet()->setCellValue("P{$contador}", $registro['certificado']);
				//$this->excel->getActiveSheet()->setCellValue("Q{$contador}", $registro['via_entrada']);
	        }

	        //Le ponemos un nombre al archivo que se va a generar.
	        $archivo = "OT_{$contador}.xls";
	        header('Content-Type: application/force-download');
	        header('Content-Disposition: attachment;filename="'.$archivo.'"');
	        header('Cache-Control: max-age=0');

	        #$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
	        //Hacemos una salida al navegador con el archivo Excel.
	        $objWriter->save('php://output'); 
		}
		else
		{
			redirect('Login');
		}
    }	

}