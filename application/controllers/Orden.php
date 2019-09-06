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
			$traspasos = $this->Orden_model->listarTraspasosUsuario($usuario['id_usuario']);
			$usuario['traspasos'] = $traspasos;
			$usuario['controller'] = 'orden';
			$this->load->view('temp/header');
			$this->load->view('temp/menu', $usuario);
			$this->load->view('listarTraspasos', $usuario);
			$this->load->view('temp/footer', $usuario);
		}else
		{
			redirect('Inicio');
		}
	}	

	public function listarTraspasosCall()
	{
		$usuario = $this->session->userdata();
		if(isset($usuario['id_usuario'])){
			$traspasos = $this->Orden_model->listarTraspasosUsuarioCall($usuario['id_usuario']);
			$usuario['traspasos'] = $traspasos;
			$usuario['controller'] = 'orden';
			$this->load->view('temp/header');
			$this->load->view('temp/menu', $usuario);
			$this->load->view('listarTraspasosCall', $usuario);
			$this->load->view('temp/footer', $usuario);
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
	        $archivo = "Contacto_{$contador}.xls";
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