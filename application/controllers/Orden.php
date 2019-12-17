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
				

				$usuario['usuario_operacional'] = $usuario_operacional;

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
			$this->excel->getActiveSheet()->setCellValue("C1", 'Rut Usuario');
			$this->excel->getActiveSheet()->setCellValue("D1", 'Usuario');
			$this->excel->getActiveSheet()->setCellValue("E1", 'Perfil');
			$this->excel->getActiveSheet()->setCellValue("F1", 'Rut Afiliado');
			$this->excel->getActiveSheet()->setCellValue("G1", 'Nombres');
			$this->excel->getActiveSheet()->setCellValue("H1", 'Apellido Paterno');
			$this->excel->getActiveSheet()->setCellValue("I1", 'Apellido Materno');
			$this->excel->getActiveSheet()->setCellValue("J1", 'AFP Origen');
			$this->excel->getActiveSheet()->setCellValue("K1", 'Teléfono');
			$this->excel->getActiveSheet()->setCellValue("L1", 'Folio');
			$this->excel->getActiveSheet()->setCellValue("M1", 'Fecha');
			$this->excel->getActiveSheet()->setCellValue("N1", 'Estado Cédula');
			$this->excel->getActiveSheet()->setCellValue("O1", 'Estado Certificación');
			$this->excel->getActiveSheet()->setCellValue("P1", 'Vía Ingreso');
			
			
	        //Definimos la data del cuerpo.        
	        
	        foreach($traspasos as $registro){
	           //Incrementamos una fila más, para ir a la siguiente.
	           $contador++;
	           //Informacion de las filas de la consulta.

	            $this->excel->getActiveSheet()->setCellValue("A{$contador}", $registro['id_sms']);
				$this->excel->getActiveSheet()->setCellValue("B{$contador}", $registro['sucursal']);
				$this->excel->getActiveSheet()->setCellValue("C{$contador}", $registro['u_rut']);
				$this->excel->getActiveSheet()->setCellValue("D{$contador}", $registro['u_nombres']." ".$registro['u_apellidos']);
				$this->excel->getActiveSheet()->setCellValue("E{$contador}", $registro['pf_nombre']);
				$this->excel->getActiveSheet()->setCellValue("F{$contador}", $registro['rut']);
				$this->excel->getActiveSheet()->setCellValue("G{$contador}", $registro['nombres']);
				$this->excel->getActiveSheet()->setCellValue("H{$contador}", $registro['apellido_paterno']);
				$this->excel->getActiveSheet()->setCellValue("I{$contador}", $registro['apellido_materno']);
				$this->excel->getActiveSheet()->setCellValue("J{$contador}", $registro['institucion']);
				$this->excel->getActiveSheet()->setCellValue("K{$contador}", $registro['telefono']);
				$this->excel->getActiveSheet()->setCellValue("L{$contador}", $registro['folio']);
				$this->excel->getActiveSheet()->setCellValue("M{$contador}", $registro['fecha']);
				$this->excel->getActiveSheet()->setCellValue("N{$contador}", $registro['nombre_resultado_rc']);
				$this->excel->getActiveSheet()->setCellValue("O{$contador}", $registro['certificado']);
				$this->excel->getActiveSheet()->setCellValue("P{$contador}", $registro['via_entrada']);

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