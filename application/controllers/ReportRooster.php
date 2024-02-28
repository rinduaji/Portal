<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReportRooster extends CI_Controller {

	function __construct(){
		parent::__construct();		
		$this->load->model('m_report_rooster');
        $this->load->model('m_notif');
		$this->load->model('m_notif_inbox');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$this->load->library('pagination');
		$data['jabatan_user'] = $this->session->userdata('jabatan');

		if($this->input->post('cari')) {
			$data['cari'] = $this->input->post('cari');
			// $this->session->set_userdata('cari',$data['cari']);
		}
		else {
			$data['cari'] = null;
			// $data['cari'] = $this->session->userdata('cari');
		}

		if($this->input->post('date_awal')) {
			$data['date_awal'] = $this->input->post('date_awal');
			$periode = date("Ym", strtotime($data['date_awal']));
		}
		else {
			$data['date_awal'] = null;
			$periode = date("Ym");
		}

		if($this->input->post('date_akhir')) {
			$data['date_akhir'] = $this->input->post('date_akhir');
		}
		else {
			$data['date_akhir'] = null;
		}

		if($this->input->post('jabatan')) {
			$data['jabatan'] = $this->input->post('jabatan');
		}
		else {
			$data['jabatan'] = null;
		}
		
		// print_r($data['jabatan_user']);
		
		if($this->input->post('exportExcel') !== NULL) {
			// $periode = date('Y',strtotime($data['date_awal'])).''.date('m',strtotime($data['date_awal']));
			// print_r($periode);
			
			if($data['jabatan_user'] != 'ADMIN' && $data['jabatan_user'] != 'DUKTEK') {
				$this->createExcel($data['cari'],$data['date_awal'],$data['date_akhir'],$data['jabatan_user'],$periode);
			}
			else {
				$this->createExcel($data['cari'],$data['date_awal'],$data['date_akhir'],$data['jabatan'],$periode);
			}
		}
		if($this->input->post('exportExcelAsli') !== NULL) {
			// $this->createExcelJabatan($data['cari'],$data['date_awal'],$data['date_akhir'],$data['jabatan']);
			if($data['jabatan_user'] != 'ADMIN' && $data['jabatan_user'] != 'DUKTEK') {
				$this->createExcelAsli($data['cari'],$data['date_awal'],$data['date_akhir'],$data['jabatan_user'],$periode);
			}
			else {
				$this->createExcelAsli($data['cari'],$data['date_awal'],$data['date_akhir'],$data['jabatan'],$periode);
			}
		}
		else {
			if($this->input->post('btnSearch')) {
				
					$jumlah_data = $this->m_report_rooster->jumlah_data_rooster($data['cari'],$data['date_awal'],$data['date_akhir'],$data['jabatan']);
					$data['data_report_rooster'] = $this->m_report_rooster->data_report_rooster($data['cari'],$data['date_awal'],$data['date_akhir'],$data['jabatan']);
				
			}
			$data['list_jabatan'] = $this->m_report_rooster->getJabatan();
			$data['list_pola'] = $this->m_report_rooster->getPola();
	
			$data['total_notif'] = $this->m_notif->totalNotif($this->session->userdata('user_id'));
			$data['data_notif'] = $this->m_notif->dataNotif($this->session->userdata('user_id'));
	
			$data['total_notif_inbox'] = $this->m_notif_inbox->totalNotif($this->session->userdata('username'));
			$data['data_notif_inbox'] = $this->m_notif_inbox->dataNotif($this->session->userdata('username'));

			$this->load->view('header',$data);
			$this->load->view('admin/report_rooster_view',$data);
			$this->load->view('footer');
		}
    } 

	public function edit(){
		$report_rooster = $this->m_report_rooster;
		$id = $this->input->post('id');
		$data = array(
			'pola' => $this->input->post('pola')
		);
		
        $validation = $this->form_validation;
		$validation->set_rules($report_rooster->rules());

        if ($validation->run()) {
			$this->m_report_rooster->update($id,$data);
			$this->session->set_flashdata('success', 'Data Berhasil diubah');
        }
		else {
			$this->session->set_flashdata('gagal', 'Data Gagal diubah');
		}
		redirect(site_url('ReportRooster'));
	}

	public function get_by_id($id) {
		$where = array('id' => $id);
		$data = $this->m_report_rooster->get_id($where);
		echo json_encode($data);
	}

	public function hapus() {
		$id= $this->input->post('id');
		if($this->m_report_rooster->delete($id)) {
			$this->session->set_flashdata('success', 'Data Berhasil dihapus');
		}
		else {
			$this->session->set_flashdata('gagal', 'Data Gagal dihapus');
		}
		redirect(site_url('ReportRooster'));
	}
	
	public function createExcel($cari = NULL, $date_awal = NULL, $date_akhir = NULL, $jabatan = NULL, $periode = NULL) {
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
		$style_col_libur = [
		  'font' => [
			'bold' => true,
			'color' => ['rgb' => 'FFFFFF']
		  ], // Set font nya jadi bold
		  'fill' => [
			'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => ['rgb' => 'b5443c']
		  ],
		  'alignment' => [
			'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
			'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  ],
		  'borders' => [
			'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
			'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
			'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
			'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
		  ]
		];
		$style_col_jam = [
			'font' => [
				'bold' => true,
				// 'color' => ['rgb' => 'FFFFFF']
			], // Set font nya jadi bold
			'fill' => [
			  'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
			  'startColor' => ['rgb' => 'f0dd0c']
			],
			'alignment' => [
			  'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
			  'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			],
			'borders' => [
			  'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
			  'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
			  'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
			  'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
			]
		  ];
		  $style_col = [
			'font' => ['bold' => true], // Set font nya jadi bold
			'alignment' => [
			  'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
			  'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			],
			'borders' => [
			  'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
			  'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
			  'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
			  'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
			]
		  ];
		// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
		$style_row_libur = [
		  'font' => [
			'color' => ['rgb' => 'FFFFFF']
		  ], // Set font nya jadi bold
		  'fill' => [
			'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => ['rgb' => 'b5443c']
		  ],
		  'alignment' => [
			'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  ],
		  'borders' => [
			'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
			'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
			'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
			'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
		  ]
		];
		$style_row_x_ct = [
			'font' => [
			//   'color' => ['rgb' => 'FFFFFF']
			], // Set font nya jadi bold
			'fill' => [
			  'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
			  'startColor' => ['rgb' => '0cd1f0']
			],
			'alignment' => [
			  'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			],
			'borders' => [
			  'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
			  'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
			  'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
			  'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
			]
		  ];
		  $style_row_jam = [
			'font' => [
				'bold' => true
				//   'color' => ['rgb' => 'FFFFFF']
				], // Set font nya jadi bold
				'fill' => [
				  'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
				  'startColor' => ['rgb' => 'f0dd0c']
				],
			'alignment' => [
			  'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			],
			'borders' => [
			  'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
			  'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
			  'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
			  'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
			]
		  ];
		$style_row = [
			'alignment' => [
			  'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			],
			'borders' => [
			  'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
			  'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
			  'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
			  'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
			]
		  ];

		$bulan = date('m', strtotime($periode));
		$tahun = date('Y', strtotime($periode));
		// $bulan_format = $date->format('m');
		// $tahun = DateTime::createFromFormat('Y-m-d', $date_awal);
		// $tahun_format = $date->format('Y');
		$count_date = cal_days_in_month(CAL_GREGORIAN,$bulan,$tahun);
		// print_r($count_date);
		$array_sabtu_minggu = array();
		for ($i=1; $i <= $count_date; $i++) {
			if($i < 9) {
				$tanggal = sprintf("%02d", $i);;
			}
			else {
				$tanggal = $i;
			}

			$nama_hari =  date("l",strtotime($tahun.'-'.$bulan.'-'.$tanggal));
			if($nama_hari == 'Sunday' || $nama_hari == 'Saturday') {
				array_push($array_sabtu_minggu,$tanggal);
			}
		}
		// print_r($array_sabtu_minggu);

		$sheet->setCellValue('A1', "DATA ROOSTER UPDATE ".$jabatan); // Set kolom A1 dengan tulisan "DATA SISWA"
		$sheet->setCellValue('A2', "PERIODE : ");
		$sheet->setCellValue('B2', $periode);  // Set kolom A1 dengan tulisan "DATA SISWA"
		$sheet->mergeCells('A1:E1'); // Set Merge Cell pada kolom A1 sampai E1
		$sheet->mergeCells('AM4:AO4');
		$sheet->getStyle('AM4')->getFont()->setBold(true);
		$sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1
		$sheet->getStyle('A2')->getFont()->setBold(true);
		$sheet->getStyle('B2')->getFont()->setBold(true);
		$sheet->getStyle('AM6')->getFont()->setBold(true);
		$sheet->getStyle('AN6')->getFont()->setBold(true);
		$sheet->getStyle('AO6')->getFont()->setBold(true);
		// Buat header tabel nya pada baris ke 3
		$sheet->setCellValue('A4', "NO"); // Set kolom A3 dengan tulisan "NO"
		$sheet->setCellValue('B4', "LOGIN"); // Set kolom B3 dengan tulisan "NIS"
		$sheet->setCellValue('C4', "NAMA"); // Set kolom C3 dengan tulisan "NAMA"
		$sheet->setCellValue('D4', "AREA"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
		$sheet->setCellValue('E4', "JABATAN"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
		$sheet->setCellValue('F4', "01"); // Set kolom E3 dengan tulisan "ALAMAT"
		$sheet->setCellValue('G4', "02"); // Set kolom A3 dengan tulisan "NO"
		$sheet->setCellValue('H4', "03"); // Set kolom B3 dengan tulisan "NIS"
		$sheet->setCellValue('I4', "04"); // Set kolom C3 dengan tulisan "NAMA"
		$sheet->setCellValue('J4', "05"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
		$sheet->setCellValue('K4', "06"); // Set kolom E3 dengan tulisan "ALAMAT"
		$sheet->setCellValue('L4', "07"); // Set kolom A3 dengan tulisan "NO"
		$sheet->setCellValue('M4', "08"); // Set kolom B3 dengan tulisan "NIS"
		$sheet->setCellValue('N4', "09"); // Set kolom C3 dengan tulisan "NAMA"
		$sheet->setCellValue('O4', "10"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
		$sheet->setCellValue('P4', "11"); // Set kolom E3 dengan tulisan "ALAMAT"
		$sheet->setCellValue('Q4', "12"); // Set kolom E3 dengan tulisan "ALAMAT"
		$sheet->setCellValue('R4', "13"); // Set kolom A3 dengan tulisan "NO"
		$sheet->setCellValue('S4', "14"); // Set kolom B3 dengan tulisan "NIS"
		$sheet->setCellValue('T4', "15"); // Set kolom C3 dengan tulisan "NAMA"
		$sheet->setCellValue('U4', "16"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
		$sheet->setCellValue('V4', "17"); // Set kolom E3 dengan tulisan "ALAMAT"
		$sheet->setCellValue('W4', "18"); // Set kolom A3 dengan tulisan "NO"
		$sheet->setCellValue('X4', "19"); // Set kolom B3 dengan tulisan "NIS"
		$sheet->setCellValue('Y4', "20"); // Set kolom C3 dengan tulisan "NAMA"
		$sheet->setCellValue('Z4', "21"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
		$sheet->setCellValue('AA4', "22"); // Set kolom E3 dengan tulisan "ALAMAT"
		$sheet->setCellValue('AB4', "23"); // Set kolom E3 dengan tulisan "ALAMAT"
		$sheet->setCellValue('AC4', "24"); // Set kolom A3 dengan tulisan "NO"
		$sheet->setCellValue('AD4', "25"); // Set kolom B3 dengan tulisan "NIS"
		$sheet->setCellValue('AE4', "26"); // Set kolom C3 dengan tulisan "NAMA"
		$sheet->setCellValue('AF4', "27"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
		$sheet->setCellValue('AG4', "28"); // Set kolom E3 dengan tulisan "ALAMAT"
		$sheet->setCellValue('AH4', "29"); // Set kolom A3 dengan tulisan "NO"
		$sheet->setCellValue('AI4', "30"); // Set kolom B3 dengan tulisan "NIS"
		$sheet->setCellValue('AJ4', "31"); // Set kolom C3 dengan tulisan "NAMA"
		$sheet->setCellValue('AM4', "KETERANGAN SHIFT / POLA : "); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
		$sheet->setCellValue('AM6', "POLA"); // Set kolom E3 dengan tulisan "ALAMAT"
		$sheet->setCellValue('AN6', "JAM MASUK");
		$sheet->setCellValue('AO6', "JAM PULANG");
		// Apply style header yang telah kita buat tadi ke masing-masing kolom header
		$sheet->getStyle('A4')->applyFromArray($style_col_jam);
		$sheet->getStyle('B4')->applyFromArray($style_col_jam);
		$sheet->getStyle('C4')->applyFromArray($style_col_jam);
		$sheet->getStyle('D4')->applyFromArray($style_col_jam);
		$sheet->getStyle('E4')->applyFromArray($style_col_jam);
		$sheet->getStyle('F4')->applyFromArray((in_array("01",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('G4')->applyFromArray((in_array("02",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('H4')->applyFromArray((in_array("03",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('I4')->applyFromArray((in_array("04",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('J4')->applyFromArray((in_array("05",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('K4')->applyFromArray((in_array("06",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('L4')->applyFromArray((in_array("07",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('M4')->applyFromArray((in_array("08",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('N4')->applyFromArray((in_array("09",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('O4')->applyFromArray((in_array("10",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('P4')->applyFromArray((in_array("11",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('Q4')->applyFromArray((in_array("12",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('R4')->applyFromArray((in_array("13",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('S4')->applyFromArray((in_array("14",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('T4')->applyFromArray((in_array("15",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('U4')->applyFromArray((in_array("16",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('V4')->applyFromArray((in_array("17",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('W4')->applyFromArray((in_array("18",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('X4')->applyFromArray((in_array("19",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('Y4')->applyFromArray((in_array("20",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('Z4')->applyFromArray((in_array("21",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('AA4')->applyFromArray((in_array("22",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('AB4')->applyFromArray((in_array("23",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('AC4')->applyFromArray((in_array("24",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('AD4')->applyFromArray((in_array("25",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('AE4')->applyFromArray((in_array("26",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('AF4')->applyFromArray((in_array("27",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('AG4')->applyFromArray((in_array("28",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('AH4')->applyFromArray((in_array("29",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('AI4')->applyFromArray((in_array("30",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('AJ4')->applyFromArray((in_array("31",$array_sabtu_minggu) ? $style_col_libur : $style_col));

		$sheet->getStyle('AM6')->applyFromArray($style_col_jam);
		$sheet->getStyle('AN6')->applyFromArray($style_col_jam);
		$sheet->getStyle('AO6')->applyFromArray($style_col_jam);
		// Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
		$report_rooster = $this->m_report_rooster->data_export_rooster($cari,$date_awal,$date_akhir,$jabatan);
		$no = 1; // Untuk penomoran tabel, di awal set dengan 1
		$numrow = 5; // Set baris pertama untuk isi tabel adalah baris ke 4
		foreach($report_rooster as $data){ // Lakukan looping pada variabel siswa
			// print_r($data);
		  $sheet->setCellValue('A'.$numrow, $no);
		  $sheet->setCellValue('B'.$numrow, $data->login);
		  $sheet->setCellValue('C'.$numrow, $data->nama);
		  $sheet->setCellValue('D'.$numrow, $data->area);
		  $sheet->setCellValue('E'.$numrow, $data->jabatan);
		  $sheet->setCellValue('F'.$numrow, $data->tgl_01);
		  $sheet->setCellValue('G'.$numrow, $data->tgl_02);
		  $sheet->setCellValue('H'.$numrow, $data->tgl_03);
		  $sheet->setCellValue('I'.$numrow, $data->tgl_04);
		  $sheet->setCellValue('J'.$numrow, $data->tgl_05);
		  $sheet->setCellValue('K'.$numrow, $data->tgl_06);
		  $sheet->setCellValue('L'.$numrow, $data->tgl_07);
		  $sheet->setCellValue('M'.$numrow, $data->tgl_08);
		  $sheet->setCellValue('N'.$numrow, $data->tgl_09);
		  $sheet->setCellValue('O'.$numrow, $data->tgl_10);
		  $sheet->setCellValue('P'.$numrow, $data->tgl_11);
		  $sheet->setCellValue('Q'.$numrow, $data->tgl_12);
		  $sheet->setCellValue('R'.$numrow, $data->tgl_13);
		  $sheet->setCellValue('S'.$numrow, $data->tgl_14);
		  $sheet->setCellValue('T'.$numrow, $data->tgl_15);
		  $sheet->setCellValue('U'.$numrow, $data->tgl_16);
		  $sheet->setCellValue('V'.$numrow, $data->tgl_17);
		  $sheet->setCellValue('W'.$numrow, $data->tgl_18);
		  $sheet->setCellValue('X'.$numrow, $data->tgl_19);
		  $sheet->setCellValue('Y'.$numrow, $data->tgl_20);
		  $sheet->setCellValue('Z'.$numrow, $data->tgl_21);
		  $sheet->setCellValue('AA'.$numrow, $data->tgl_22);
		  $sheet->setCellValue('AB'.$numrow, $data->tgl_23);
		  $sheet->setCellValue('AC'.$numrow, $data->tgl_24);
		  $sheet->setCellValue('AD'.$numrow, $data->tgl_25);
		  $sheet->setCellValue('AE'.$numrow, $data->tgl_26);
		  $sheet->setCellValue('AF'.$numrow, $data->tgl_27);
		  $sheet->setCellValue('AG'.$numrow, $data->tgl_28);
		  $sheet->setCellValue('AH'.$numrow, $data->tgl_29);
		  $sheet->setCellValue('AI'.$numrow, $data->tgl_30);
		  $sheet->setCellValue('AJ'.$numrow, $data->tgl_31);
		  
		  // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
		  $sheet->getStyle('A'.$numrow)->applyFromArray($style_row);
		  $sheet->getStyle('B'.$numrow)->applyFromArray($style_row);
		  $sheet->getStyle('C'.$numrow)->applyFromArray($style_row);
		  $sheet->getStyle('D'.$numrow)->applyFromArray($style_row);
		  $sheet->getStyle('E'.$numrow)->applyFromArray($style_row);
		  $sheet->getStyle('F'.$numrow)->applyFromArray((($data->tgl_01 == 'X' || $data->tgl_01 == 'CT') ? $style_row_x_ct : ((in_array("01",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('G'.$numrow)->applyFromArray((($data->tgl_02 == 'X' || $data->tgl_02 == 'CT') ? $style_row_x_ct : ((in_array("02",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('H'.$numrow)->applyFromArray((($data->tgl_03 == 'X' || $data->tgl_03 == 'CT') ? $style_row_x_ct : ((in_array("03",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('I'.$numrow)->applyFromArray((($data->tgl_04 == 'X' || $data->tgl_04 == 'CT') ? $style_row_x_ct : ((in_array("04",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('J'.$numrow)->applyFromArray((($data->tgl_05 == 'X' || $data->tgl_05 == 'CT') ? $style_row_x_ct : ((in_array("05",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('K'.$numrow)->applyFromArray((($data->tgl_06 == 'X' || $data->tgl_06 == 'CT') ? $style_row_x_ct : ((in_array("06",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('L'.$numrow)->applyFromArray((($data->tgl_07 == 'X' || $data->tgl_07 == 'CT') ? $style_row_x_ct : ((in_array("07",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('M'.$numrow)->applyFromArray((($data->tgl_08 == 'X' || $data->tgl_08 == 'CT') ? $style_row_x_ct : ((in_array("08",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('N'.$numrow)->applyFromArray((($data->tgl_09 == 'X' || $data->tgl_09 == 'CT') ? $style_row_x_ct : ((in_array("09",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('O'.$numrow)->applyFromArray((($data->tgl_10 == 'X' || $data->tgl_10 == 'CT') ? $style_row_x_ct : ((in_array("10",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('P'.$numrow)->applyFromArray((($data->tgl_11 == 'X' || $data->tgl_11 == 'CT') ? $style_row_x_ct : ((in_array("11",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('Q'.$numrow)->applyFromArray((($data->tgl_12 == 'X' || $data->tgl_12 == 'CT') ? $style_row_x_ct : ((in_array("12",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('R'.$numrow)->applyFromArray((($data->tgl_13 == 'X' || $data->tgl_13 == 'CT') ? $style_row_x_ct : ((in_array("13",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('S'.$numrow)->applyFromArray((($data->tgl_14 == 'X' || $data->tgl_14 == 'CT') ? $style_row_x_ct : ((in_array("14",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('T'.$numrow)->applyFromArray((($data->tgl_15 == 'X' || $data->tgl_15 == 'CT') ? $style_row_x_ct : ((in_array("15",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('U'.$numrow)->applyFromArray((($data->tgl_16 == 'X' || $data->tgl_16 == 'CT') ? $style_row_x_ct : ((in_array("16",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('V'.$numrow)->applyFromArray((($data->tgl_17 == 'X' || $data->tgl_17 == 'CT') ? $style_row_x_ct : ((in_array("17",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('W'.$numrow)->applyFromArray((($data->tgl_18 == 'X' || $data->tgl_18 == 'CT') ? $style_row_x_ct : ((in_array("18",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('X'.$numrow)->applyFromArray((($data->tgl_19 == 'X' || $data->tgl_19 == 'CT') ? $style_row_x_ct : ((in_array("19",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('Y'.$numrow)->applyFromArray((($data->tgl_20 == 'X' || $data->tgl_20 == 'CT') ? $style_row_x_ct : ((in_array("20",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('Z'.$numrow)->applyFromArray((($data->tgl_21 == 'X' || $data->tgl_21 == 'CT') ? $style_row_x_ct : ((in_array("21",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('AA'.$numrow)->applyFromArray((($data->tgl_22 == 'X' || $data->tgl_22 == 'CT') ? $style_row_x_ct : ((in_array("22",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('AB'.$numrow)->applyFromArray((($data->tgl_23 == 'X' || $data->tgl_23 == 'CT') ? $style_row_x_ct : ((in_array("23",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('AC'.$numrow)->applyFromArray((($data->tgl_24 == 'X' || $data->tgl_24 == 'CT') ? $style_row_x_ct : ((in_array("24",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('AD'.$numrow)->applyFromArray((($data->tgl_25 == 'X' || $data->tgl_25 == 'CT') ? $style_row_x_ct : ((in_array("25",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('AE'.$numrow)->applyFromArray((($data->tgl_26 == 'X' || $data->tgl_26 == 'CT') ? $style_row_x_ct : ((in_array("26",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('AF'.$numrow)->applyFromArray((($data->tgl_27 == 'X' || $data->tgl_27 == 'CT') ? $style_row_x_ct : ((in_array("27",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('AG'.$numrow)->applyFromArray((($data->tgl_28 == 'X' || $data->tgl_28 == 'CT') ? $style_row_x_ct : ((in_array("28",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('AH'.$numrow)->applyFromArray((($data->tgl_29 == 'X' || $data->tgl_29 == 'CT') ? $style_row_x_ct : ((in_array("29",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('AI'.$numrow)->applyFromArray((($data->tgl_30 == 'X' || $data->tgl_30 == 'CT') ? $style_row_x_ct : ((in_array("30",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('AJ'.$numrow)->applyFromArray((($data->tgl_31 == 'X' || $data->tgl_31 == 'CT') ? $style_row_x_ct : ((in_array("31",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  
		  $no++; // Tambah 1 setiap kali looping
		  $numrow++; // Tambah 1 setiap kali looping
		}

		$report_pola = $this->m_report_rooster->getPolaJam();
		$nomor = 1; // Untuk penomoran tabel, di awal set dengan 1
		$nomorbaris = 7; // Set baris pertama untuk isi tabel adalah baris ke 4
		foreach($report_pola as $data_pola){ // Lakukan looping pada variabel siswa
			// print_r($data);
		  $sheet->setCellValue('AM'.$nomorbaris, $data_pola->pola);
		  $sheet->setCellValue('AN'.$nomorbaris, $data_pola->masuk);
		  $sheet->setCellValue('AO'.$nomorbaris, $data_pola->pulang);
		  
		  // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
		  $sheet->getStyle('AM'.$nomorbaris)->applyFromArray($style_row_jam);
		  $sheet->getStyle('AN'.$nomorbaris)->applyFromArray($style_row);
		  $sheet->getStyle('AO'.$nomorbaris)->applyFromArray($style_row);
		  
		  $nomor++; // Tambah 1 setiap kali looping
		  $nomorbaris++; // Tambah 1 setiap kali looping
		}
		// Set width kolom
		$sheet->getColumnDimension('A')->setWidth(10); // Set width kolom A
		$sheet->getColumnDimension('B')->setWidth(10); // Set width kolom B
		$sheet->getColumnDimension('C')->setWidth(40); // Set width kolom C
		$sheet->getColumnDimension('D')->setWidth(20); // Set width kolom D
		$sheet->getColumnDimension('E')->setWidth(25); // Set width kolom E
		$sheet->getColumnDimension('F')->setWidth(10);
		$sheet->getColumnDimension('G')->setWidth(10);
		$sheet->getColumnDimension('H')->setWidth(10);
		$sheet->getColumnDimension('I')->setWidth(10);
		$sheet->getColumnDimension('J')->setWidth(10);
		$sheet->getColumnDimension('K')->setWidth(10);
		$sheet->getColumnDimension('L')->setWidth(10);
		$sheet->getColumnDimension('M')->setWidth(10);
		$sheet->getColumnDimension('N')->setWidth(10);
		$sheet->getColumnDimension('O')->setWidth(10);
		$sheet->getColumnDimension('P')->setWidth(10);
		$sheet->getColumnDimension('Q')->setWidth(10);
		$sheet->getColumnDimension('R')->setWidth(10);
		$sheet->getColumnDimension('S')->setWidth(10);
		$sheet->getColumnDimension('T')->setWidth(10);
		$sheet->getColumnDimension('U')->setWidth(10);
		$sheet->getColumnDimension('V')->setWidth(10);
		$sheet->getColumnDimension('W')->setWidth(10);
		$sheet->getColumnDimension('X')->setWidth(10);
		$sheet->getColumnDimension('Y')->setWidth(10);
		$sheet->getColumnDimension('Z')->setWidth(10);
		$sheet->getColumnDimension('AA')->setWidth(10);
		$sheet->getColumnDimension('AB')->setWidth(10);
		$sheet->getColumnDimension('AC')->setWidth(10);
		$sheet->getColumnDimension('AD')->setWidth(10);
		$sheet->getColumnDimension('AE')->setWidth(10);
		$sheet->getColumnDimension('AF')->setWidth(10);
		$sheet->getColumnDimension('AG')->setWidth(10);
		$sheet->getColumnDimension('AH')->setWidth(10);
		$sheet->getColumnDimension('AI')->setWidth(10);
		$sheet->getColumnDimension('AJ')->setWidth(10);
		
		$sheet->getColumnDimension('AM')->setWidth(10);
		$sheet->getColumnDimension('AN')->setWidth(15);
		$sheet->getColumnDimension('AO')->setWidth(15);
		// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
		$sheet->getDefaultRowDimension()->setRowHeight(-1);
		// Set orientasi kertas jadi LANDSCAPE
		$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
		// Set judul file excel nya
		$sheet->setTitle("Laporan Data Rooster");
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Data Rooster.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');		   
    }

	public function createExcelAsli($cari = NULL, $date_awal = NULL, $date_akhir = NULL, $jabatan = NULL, $periode = NULL) {
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
		$style_col_libur = [
		  'font' => [
			'bold' => true,
			'color' => ['rgb' => 'FFFFFF']
		  ], // Set font nya jadi bold
		  'fill' => [
			'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => ['rgb' => 'b5443c']
		  ],
		  'alignment' => [
			'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
			'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  ],
		  'borders' => [
			'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
			'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
			'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
			'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
		  ]
		];
		$style_col_jam = [
			'font' => [
				'bold' => true,
				// 'color' => ['rgb' => 'FFFFFF']
			], // Set font nya jadi bold
			'fill' => [
			  'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
			  'startColor' => ['rgb' => 'f0dd0c']
			],
			'alignment' => [
			  'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
			  'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			],
			'borders' => [
			  'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
			  'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
			  'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
			  'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
			]
		  ];
		  $style_col = [
			'font' => ['bold' => true], // Set font nya jadi bold
			'alignment' => [
			  'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
			  'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			],
			'borders' => [
			  'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
			  'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
			  'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
			  'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
			]
		  ];
		// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
		$style_row_libur = [
		  'font' => [
			'color' => ['rgb' => 'FFFFFF']
		  ], // Set font nya jadi bold
		  'fill' => [
			'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => ['rgb' => 'b5443c']
		  ],
		  'alignment' => [
			'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  ],
		  'borders' => [
			'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
			'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
			'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
			'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
		  ]
		];
		$style_row_x_ct = [
			'font' => [
			//   'color' => ['rgb' => 'FFFFFF']
			], // Set font nya jadi bold
			'fill' => [
			  'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
			  'startColor' => ['rgb' => '0cd1f0']
			],
			'alignment' => [
			  'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			],
			'borders' => [
			  'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
			  'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
			  'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
			  'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
			]
		  ];
		  $style_row_jam = [
			'font' => [
				'bold' => true
				//   'color' => ['rgb' => 'FFFFFF']
				], // Set font nya jadi bold
				'fill' => [
				  'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
				  'startColor' => ['rgb' => 'f0dd0c']
				],
			'alignment' => [
			  'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			],
			'borders' => [
			  'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
			  'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
			  'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
			  'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
			]
		  ];
		$style_row = [
			'alignment' => [
			  'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			],
			'borders' => [
			  'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
			  'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
			  'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
			  'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
			]
		  ];

		$bulan = date('m', strtotime($periode));
		$tahun = date('Y', strtotime($periode));
		// $bulan_format = $date->format('m');
		// $tahun = DateTime::createFromFormat('Y-m-d', $date_awal);
		// $tahun_format = $date->format('Y');
		$count_date = cal_days_in_month(CAL_GREGORIAN,$bulan,$tahun);
		// print_r($count_date);
		$array_sabtu_minggu = array();
		for ($i=1; $i <= $count_date; $i++) {
			if($i < 9) {
				$tanggal = sprintf("%02d", $i);;
			}
			else {
				$tanggal = $i;
			}

			$nama_hari =  date("l",strtotime($tahun.'-'.$bulan.'-'.$tanggal));
			if($nama_hari == 'Sunday' || $nama_hari == 'Saturday') {
				array_push($array_sabtu_minggu,$tanggal);
			}
		}
		// print_r($array_sabtu_minggu);

		$sheet->setCellValue('A1', "DATA ROOSTER UPDATE ".$jabatan); // Set kolom A1 dengan tulisan "DATA SISWA"
		$sheet->setCellValue('A2', "PERIODE : ");
		$sheet->setCellValue('B2', $periode);  // Set kolom A1 dengan tulisan "DATA SISWA"
		$sheet->mergeCells('A1:E1'); // Set Merge Cell pada kolom A1 sampai E1
		$sheet->mergeCells('AM4:AO4');
		$sheet->getStyle('AM4')->getFont()->setBold(true);
		$sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1
		$sheet->getStyle('A2')->getFont()->setBold(true);
		$sheet->getStyle('B2')->getFont()->setBold(true);
		$sheet->getStyle('AM6')->getFont()->setBold(true);
		$sheet->getStyle('AN6')->getFont()->setBold(true);
		$sheet->getStyle('AO6')->getFont()->setBold(true);
		// Buat header tabel nya pada baris ke 3
		$sheet->setCellValue('A4', "NO"); // Set kolom A3 dengan tulisan "NO"
		$sheet->setCellValue('B4', "LOGIN"); // Set kolom B3 dengan tulisan "NIS"
		$sheet->setCellValue('C4', "NAMA"); // Set kolom C3 dengan tulisan "NAMA"
		$sheet->setCellValue('D4', "AREA"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
		$sheet->setCellValue('E4', "JABATAN"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
		$sheet->setCellValue('F4', "01"); // Set kolom E3 dengan tulisan "ALAMAT"
		$sheet->setCellValue('G4', "02"); // Set kolom A3 dengan tulisan "NO"
		$sheet->setCellValue('H4', "03"); // Set kolom B3 dengan tulisan "NIS"
		$sheet->setCellValue('I4', "04"); // Set kolom C3 dengan tulisan "NAMA"
		$sheet->setCellValue('J4', "05"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
		$sheet->setCellValue('K4', "06"); // Set kolom E3 dengan tulisan "ALAMAT"
		$sheet->setCellValue('L4', "07"); // Set kolom A3 dengan tulisan "NO"
		$sheet->setCellValue('M4', "08"); // Set kolom B3 dengan tulisan "NIS"
		$sheet->setCellValue('N4', "09"); // Set kolom C3 dengan tulisan "NAMA"
		$sheet->setCellValue('O4', "10"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
		$sheet->setCellValue('P4', "11"); // Set kolom E3 dengan tulisan "ALAMAT"
		$sheet->setCellValue('Q4', "12"); // Set kolom E3 dengan tulisan "ALAMAT"
		$sheet->setCellValue('R4', "13"); // Set kolom A3 dengan tulisan "NO"
		$sheet->setCellValue('S4', "14"); // Set kolom B3 dengan tulisan "NIS"
		$sheet->setCellValue('T4', "15"); // Set kolom C3 dengan tulisan "NAMA"
		$sheet->setCellValue('U4', "16"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
		$sheet->setCellValue('V4', "17"); // Set kolom E3 dengan tulisan "ALAMAT"
		$sheet->setCellValue('W4', "18"); // Set kolom A3 dengan tulisan "NO"
		$sheet->setCellValue('X4', "19"); // Set kolom B3 dengan tulisan "NIS"
		$sheet->setCellValue('Y4', "20"); // Set kolom C3 dengan tulisan "NAMA"
		$sheet->setCellValue('Z4', "21"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
		$sheet->setCellValue('AA4', "22"); // Set kolom E3 dengan tulisan "ALAMAT"
		$sheet->setCellValue('AB4', "23"); // Set kolom E3 dengan tulisan "ALAMAT"
		$sheet->setCellValue('AC4', "24"); // Set kolom A3 dengan tulisan "NO"
		$sheet->setCellValue('AD4', "25"); // Set kolom B3 dengan tulisan "NIS"
		$sheet->setCellValue('AE4', "26"); // Set kolom C3 dengan tulisan "NAMA"
		$sheet->setCellValue('AF4', "27"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
		$sheet->setCellValue('AG4', "28"); // Set kolom E3 dengan tulisan "ALAMAT"
		$sheet->setCellValue('AH4', "29"); // Set kolom A3 dengan tulisan "NO"
		$sheet->setCellValue('AI4', "30"); // Set kolom B3 dengan tulisan "NIS"
		$sheet->setCellValue('AJ4', "31"); // Set kolom C3 dengan tulisan "NAMA"
		$sheet->setCellValue('AM4', "KETERANGAN SHIFT / POLA : "); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
		$sheet->setCellValue('AM6', "POLA"); // Set kolom E3 dengan tulisan "ALAMAT"
		$sheet->setCellValue('AN6', "JAM MASUK");
		$sheet->setCellValue('AO6', "JAM PULANG");
		// Apply style header yang telah kita buat tadi ke masing-masing kolom header
		$sheet->getStyle('A4')->applyFromArray($style_col_jam);
		$sheet->getStyle('B4')->applyFromArray($style_col_jam);
		$sheet->getStyle('C4')->applyFromArray($style_col_jam);
		$sheet->getStyle('D4')->applyFromArray($style_col_jam);
		$sheet->getStyle('E4')->applyFromArray($style_col_jam);
		$sheet->getStyle('F4')->applyFromArray((in_array("01",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('G4')->applyFromArray((in_array("02",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('H4')->applyFromArray((in_array("03",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('I4')->applyFromArray((in_array("04",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('J4')->applyFromArray((in_array("05",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('K4')->applyFromArray((in_array("06",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('L4')->applyFromArray((in_array("07",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('M4')->applyFromArray((in_array("08",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('N4')->applyFromArray((in_array("09",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('O4')->applyFromArray((in_array("10",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('P4')->applyFromArray((in_array("11",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('Q4')->applyFromArray((in_array("12",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('R4')->applyFromArray((in_array("13",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('S4')->applyFromArray((in_array("14",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('T4')->applyFromArray((in_array("15",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('U4')->applyFromArray((in_array("16",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('V4')->applyFromArray((in_array("17",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('W4')->applyFromArray((in_array("18",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('X4')->applyFromArray((in_array("19",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('Y4')->applyFromArray((in_array("20",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('Z4')->applyFromArray((in_array("21",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('AA4')->applyFromArray((in_array("22",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('AB4')->applyFromArray((in_array("23",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('AC4')->applyFromArray((in_array("24",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('AD4')->applyFromArray((in_array("25",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('AE4')->applyFromArray((in_array("26",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('AF4')->applyFromArray((in_array("27",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('AG4')->applyFromArray((in_array("28",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('AH4')->applyFromArray((in_array("29",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('AI4')->applyFromArray((in_array("30",$array_sabtu_minggu) ? $style_col_libur : $style_col));
		$sheet->getStyle('AJ4')->applyFromArray((in_array("31",$array_sabtu_minggu) ? $style_col_libur : $style_col));

		$sheet->getStyle('AM6')->applyFromArray($style_col_jam);
		$sheet->getStyle('AN6')->applyFromArray($style_col_jam);
		$sheet->getStyle('AO6')->applyFromArray($style_col_jam);
		// Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
		$report_rooster = $this->m_report_rooster->data_export_rooster_asli($cari,$date_awal,$date_akhir,$jabatan);
		$no = 1; // Untuk penomoran tabel, di awal set dengan 1
		$numrow = 5; // Set baris pertama untuk isi tabel adalah baris ke 4
		foreach($report_rooster as $data){ // Lakukan looping pada variabel siswa
			// print_r($data);
		  $sheet->setCellValue('A'.$numrow, $no);
		  $sheet->setCellValue('B'.$numrow, $data->login);
		  $sheet->setCellValue('C'.$numrow, $data->nama);
		  $sheet->setCellValue('D'.$numrow, $data->area);
		  $sheet->setCellValue('E'.$numrow, $data->jabatan);
		  $sheet->setCellValue('F'.$numrow, $data->tgl_01);
		  $sheet->setCellValue('G'.$numrow, $data->tgl_02);
		  $sheet->setCellValue('H'.$numrow, $data->tgl_03);
		  $sheet->setCellValue('I'.$numrow, $data->tgl_04);
		  $sheet->setCellValue('J'.$numrow, $data->tgl_05);
		  $sheet->setCellValue('K'.$numrow, $data->tgl_06);
		  $sheet->setCellValue('L'.$numrow, $data->tgl_07);
		  $sheet->setCellValue('M'.$numrow, $data->tgl_08);
		  $sheet->setCellValue('N'.$numrow, $data->tgl_09);
		  $sheet->setCellValue('O'.$numrow, $data->tgl_10);
		  $sheet->setCellValue('P'.$numrow, $data->tgl_11);
		  $sheet->setCellValue('Q'.$numrow, $data->tgl_12);
		  $sheet->setCellValue('R'.$numrow, $data->tgl_13);
		  $sheet->setCellValue('S'.$numrow, $data->tgl_14);
		  $sheet->setCellValue('T'.$numrow, $data->tgl_15);
		  $sheet->setCellValue('U'.$numrow, $data->tgl_16);
		  $sheet->setCellValue('V'.$numrow, $data->tgl_17);
		  $sheet->setCellValue('W'.$numrow, $data->tgl_18);
		  $sheet->setCellValue('X'.$numrow, $data->tgl_19);
		  $sheet->setCellValue('Y'.$numrow, $data->tgl_20);
		  $sheet->setCellValue('Z'.$numrow, $data->tgl_21);
		  $sheet->setCellValue('AA'.$numrow, $data->tgl_22);
		  $sheet->setCellValue('AB'.$numrow, $data->tgl_23);
		  $sheet->setCellValue('AC'.$numrow, $data->tgl_24);
		  $sheet->setCellValue('AD'.$numrow, $data->tgl_25);
		  $sheet->setCellValue('AE'.$numrow, $data->tgl_26);
		  $sheet->setCellValue('AF'.$numrow, $data->tgl_27);
		  $sheet->setCellValue('AG'.$numrow, $data->tgl_28);
		  $sheet->setCellValue('AH'.$numrow, $data->tgl_29);
		  $sheet->setCellValue('AI'.$numrow, $data->tgl_30);
		  $sheet->setCellValue('AJ'.$numrow, $data->tgl_31);
		  
		  // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
		  $sheet->getStyle('A'.$numrow)->applyFromArray($style_row);
		  $sheet->getStyle('B'.$numrow)->applyFromArray($style_row);
		  $sheet->getStyle('C'.$numrow)->applyFromArray($style_row);
		  $sheet->getStyle('D'.$numrow)->applyFromArray($style_row);
		  $sheet->getStyle('E'.$numrow)->applyFromArray($style_row);
		  $sheet->getStyle('F'.$numrow)->applyFromArray((($data->tgl_01 == 'X' || $data->tgl_01 == 'CT') ? $style_row_x_ct : ((in_array("01",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('G'.$numrow)->applyFromArray((($data->tgl_02 == 'X' || $data->tgl_02 == 'CT') ? $style_row_x_ct : ((in_array("02",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('H'.$numrow)->applyFromArray((($data->tgl_03 == 'X' || $data->tgl_03 == 'CT') ? $style_row_x_ct : ((in_array("03",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('I'.$numrow)->applyFromArray((($data->tgl_04 == 'X' || $data->tgl_04 == 'CT') ? $style_row_x_ct : ((in_array("04",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('J'.$numrow)->applyFromArray((($data->tgl_05 == 'X' || $data->tgl_05 == 'CT') ? $style_row_x_ct : ((in_array("05",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('K'.$numrow)->applyFromArray((($data->tgl_06 == 'X' || $data->tgl_06 == 'CT') ? $style_row_x_ct : ((in_array("06",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('L'.$numrow)->applyFromArray((($data->tgl_07 == 'X' || $data->tgl_07 == 'CT') ? $style_row_x_ct : ((in_array("07",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('M'.$numrow)->applyFromArray((($data->tgl_08 == 'X' || $data->tgl_08 == 'CT') ? $style_row_x_ct : ((in_array("08",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('N'.$numrow)->applyFromArray((($data->tgl_09 == 'X' || $data->tgl_09 == 'CT') ? $style_row_x_ct : ((in_array("09",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('O'.$numrow)->applyFromArray((($data->tgl_10 == 'X' || $data->tgl_10 == 'CT') ? $style_row_x_ct : ((in_array("10",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('P'.$numrow)->applyFromArray((($data->tgl_11 == 'X' || $data->tgl_11 == 'CT') ? $style_row_x_ct : ((in_array("11",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('Q'.$numrow)->applyFromArray((($data->tgl_12 == 'X' || $data->tgl_12 == 'CT') ? $style_row_x_ct : ((in_array("12",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('R'.$numrow)->applyFromArray((($data->tgl_13 == 'X' || $data->tgl_13 == 'CT') ? $style_row_x_ct : ((in_array("13",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('S'.$numrow)->applyFromArray((($data->tgl_14 == 'X' || $data->tgl_14 == 'CT') ? $style_row_x_ct : ((in_array("14",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('T'.$numrow)->applyFromArray((($data->tgl_15 == 'X' || $data->tgl_15 == 'CT') ? $style_row_x_ct : ((in_array("15",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('U'.$numrow)->applyFromArray((($data->tgl_16 == 'X' || $data->tgl_16 == 'CT') ? $style_row_x_ct : ((in_array("16",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('V'.$numrow)->applyFromArray((($data->tgl_17 == 'X' || $data->tgl_17 == 'CT') ? $style_row_x_ct : ((in_array("17",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('W'.$numrow)->applyFromArray((($data->tgl_18 == 'X' || $data->tgl_18 == 'CT') ? $style_row_x_ct : ((in_array("18",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('X'.$numrow)->applyFromArray((($data->tgl_19 == 'X' || $data->tgl_19 == 'CT') ? $style_row_x_ct : ((in_array("19",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('Y'.$numrow)->applyFromArray((($data->tgl_20 == 'X' || $data->tgl_20 == 'CT') ? $style_row_x_ct : ((in_array("20",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('Z'.$numrow)->applyFromArray((($data->tgl_21 == 'X' || $data->tgl_21 == 'CT') ? $style_row_x_ct : ((in_array("21",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('AA'.$numrow)->applyFromArray((($data->tgl_22 == 'X' || $data->tgl_22 == 'CT') ? $style_row_x_ct : ((in_array("22",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('AB'.$numrow)->applyFromArray((($data->tgl_23 == 'X' || $data->tgl_23 == 'CT') ? $style_row_x_ct : ((in_array("23",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('AC'.$numrow)->applyFromArray((($data->tgl_24 == 'X' || $data->tgl_24 == 'CT') ? $style_row_x_ct : ((in_array("24",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('AD'.$numrow)->applyFromArray((($data->tgl_25 == 'X' || $data->tgl_25 == 'CT') ? $style_row_x_ct : ((in_array("25",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('AE'.$numrow)->applyFromArray((($data->tgl_26 == 'X' || $data->tgl_26 == 'CT') ? $style_row_x_ct : ((in_array("26",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('AF'.$numrow)->applyFromArray((($data->tgl_27 == 'X' || $data->tgl_27 == 'CT') ? $style_row_x_ct : ((in_array("27",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('AG'.$numrow)->applyFromArray((($data->tgl_28 == 'X' || $data->tgl_28 == 'CT') ? $style_row_x_ct : ((in_array("28",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('AH'.$numrow)->applyFromArray((($data->tgl_29 == 'X' || $data->tgl_29 == 'CT') ? $style_row_x_ct : ((in_array("29",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('AI'.$numrow)->applyFromArray((($data->tgl_30 == 'X' || $data->tgl_30 == 'CT') ? $style_row_x_ct : ((in_array("30",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  $sheet->getStyle('AJ'.$numrow)->applyFromArray((($data->tgl_31 == 'X' || $data->tgl_31 == 'CT') ? $style_row_x_ct : ((in_array("31",$array_sabtu_minggu)) ? $style_row_libur : $style_row)));
		  
		  $no++; // Tambah 1 setiap kali looping
		  $numrow++; // Tambah 1 setiap kali looping
		}

		$report_pola = $this->m_report_rooster->getPolaJam();
		$nomor = 1; // Untuk penomoran tabel, di awal set dengan 1
		$nomorbaris = 7; // Set baris pertama untuk isi tabel adalah baris ke 4
		foreach($report_pola as $data_pola){ // Lakukan looping pada variabel siswa
			// print_r($data);
		  $sheet->setCellValue('AM'.$nomorbaris, $data_pola->pola);
		  $sheet->setCellValue('AN'.$nomorbaris, $data_pola->masuk);
		  $sheet->setCellValue('AO'.$nomorbaris, $data_pola->pulang);
		  
		  // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
		  $sheet->getStyle('AM'.$nomorbaris)->applyFromArray($style_row_jam);
		  $sheet->getStyle('AN'.$nomorbaris)->applyFromArray($style_row);
		  $sheet->getStyle('AO'.$nomorbaris)->applyFromArray($style_row);
		  
		  $nomor++; // Tambah 1 setiap kali looping
		  $nomorbaris++; // Tambah 1 setiap kali looping
		}
		// Set width kolom
		$sheet->getColumnDimension('A')->setWidth(10); // Set width kolom A
		$sheet->getColumnDimension('B')->setWidth(10); // Set width kolom B
		$sheet->getColumnDimension('C')->setWidth(40); // Set width kolom C
		$sheet->getColumnDimension('D')->setWidth(20); // Set width kolom D
		$sheet->getColumnDimension('E')->setWidth(25); // Set width kolom E
		$sheet->getColumnDimension('F')->setWidth(10);
		$sheet->getColumnDimension('G')->setWidth(10);
		$sheet->getColumnDimension('H')->setWidth(10);
		$sheet->getColumnDimension('I')->setWidth(10);
		$sheet->getColumnDimension('J')->setWidth(10);
		$sheet->getColumnDimension('K')->setWidth(10);
		$sheet->getColumnDimension('L')->setWidth(10);
		$sheet->getColumnDimension('M')->setWidth(10);
		$sheet->getColumnDimension('N')->setWidth(10);
		$sheet->getColumnDimension('O')->setWidth(10);
		$sheet->getColumnDimension('P')->setWidth(10);
		$sheet->getColumnDimension('Q')->setWidth(10);
		$sheet->getColumnDimension('R')->setWidth(10);
		$sheet->getColumnDimension('S')->setWidth(10);
		$sheet->getColumnDimension('T')->setWidth(10);
		$sheet->getColumnDimension('U')->setWidth(10);
		$sheet->getColumnDimension('V')->setWidth(10);
		$sheet->getColumnDimension('W')->setWidth(10);
		$sheet->getColumnDimension('X')->setWidth(10);
		$sheet->getColumnDimension('Y')->setWidth(10);
		$sheet->getColumnDimension('Z')->setWidth(10);
		$sheet->getColumnDimension('AA')->setWidth(10);
		$sheet->getColumnDimension('AB')->setWidth(10);
		$sheet->getColumnDimension('AC')->setWidth(10);
		$sheet->getColumnDimension('AD')->setWidth(10);
		$sheet->getColumnDimension('AE')->setWidth(10);
		$sheet->getColumnDimension('AF')->setWidth(10);
		$sheet->getColumnDimension('AG')->setWidth(10);
		$sheet->getColumnDimension('AH')->setWidth(10);
		$sheet->getColumnDimension('AI')->setWidth(10);
		$sheet->getColumnDimension('AJ')->setWidth(10);
		
		$sheet->getColumnDimension('AM')->setWidth(10);
		$sheet->getColumnDimension('AN')->setWidth(15);
		$sheet->getColumnDimension('AO')->setWidth(15);
		// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
		$sheet->getDefaultRowDimension()->setRowHeight(-1);
		// Set orientasi kertas jadi LANDSCAPE
		$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
		// Set judul file excel nya
		$sheet->setTitle("Laporan Data Rooster");
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Data Rooster.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');			   
    }

	public function createExcelJabatan($cari = NULL, $date_awal = NULL, $date_akhir = NULL, $jabatan = NULL) {
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
		$style_col = [
		  'font' => ['bold' => true], // Set font nya jadi bold
		  'alignment' => [
			'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
			'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  ],
		  'borders' => [
			'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
			'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
			'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
			'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
		  ]
		];
		// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
		$style_row = [
		  'alignment' => [
			'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  ],
		  'borders' => [
			'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
			'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
			'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
			'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
		  ]
		];

		// $bulan = date('Y-m-d', strtotime($date_awal));
		// $bulan_format = $date->format('m');
		// $tahun = DateTime::createFromFormat('Y-m-d', $date_awal);
		// $tahun_format = $date->format('Y');

		$sheet->setCellValue('A1', "DATA ROOSTER JABATAN ".$jabatan); // Set kolom A1 dengan tulisan "DATA SISWA"
		$sheet->setCellValue('A2', "TANGGAL : ");
		$sheet->setCellValue('C2', $date_awal);
		$sheet->setCellValue('D2', "SAMPAI");
		$sheet->setCellValue('E2', $date_akhir);
		// $sheet->setCellValue('B2', $periode);  // Set kolom A1 dengan tulisan "DATA SISWA"
		$sheet->mergeCells('A1:E1'); // Set Merge Cell pada kolom A1 sampai E1
		$sheet->mergeCells('A2:B2');
		// $sheet->mergeCells('AM4:AO4');
		$sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1
		$sheet->getStyle('A2')->getFont()->setBold(true);
		$sheet->getStyle('C2')->getFont()->setBold(true);
		$sheet->getStyle('D2')->getFont()->setBold(true);
		$sheet->getStyle('E2')->getFont()->setBold(true);
		// Buat header tabel nya pada baris ke 3
		$sheet->setCellValue('A4', "NO"); // Set kolom A3 dengan tulisan "NO"
		$sheet->setCellValue('B4', "PERIODE"); // Set kolom B3 dengan tulisan "NIS"
		$sheet->setCellValue('C4', "TANGGAL"); // Set kolom C3 dengan tulisan "NAMA"
		$sheet->setCellValue('D4', "NAMA"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
		$sheet->setCellValue('E4', "LOGIN"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
		$sheet->setCellValue('F4', "JABATAN"); // Set kolom E3 dengan tulisan "ALAMAT"
		$sheet->setCellValue('G4', "AREA"); // Set kolom A3 dengan tulisan "NO"
		$sheet->setCellValue('H4', "POLA"); // Set kolom B3 dengan tulisan "NIS"
		$sheet->setCellValue('I4', "JAM MASUK"); // Set kolom C3 dengan tulisan "NAMA"
		$sheet->setCellValue('J4', "JAM ISTIRAHAT 1"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
		$sheet->setCellValue('K4', "JAM ISTIRAHAT 2"); // Set kolom E3 dengan tulisan "ALAMAT"
		$sheet->setCellValue('L4', "JAM ISTIRAHAT 3"); // Set kolom A3 dengan tulisan "NO"
		$sheet->setCellValue('M4', "JAM ISTIRAHAT 4"); // Set kolom B3 dengan tulisan "NIS"
		$sheet->setCellValue('N4', "JAM PULANG"); // Set kolom C3 dengan tulisan "NAMA"
		$sheet->setCellValue('O4', "KETERANGAN"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
		// Apply style header yang telah kita buat tadi ke masing-masing kolom header
		$sheet->getStyle('A4')->applyFromArray($style_col);
		$sheet->getStyle('B4')->applyFromArray($style_col);
		$sheet->getStyle('C4')->applyFromArray($style_col);
		$sheet->getStyle('D4')->applyFromArray($style_col);
		$sheet->getStyle('E4')->applyFromArray($style_col);
		$sheet->getStyle('F4')->applyFromArray($style_col);
		$sheet->getStyle('G4')->applyFromArray($style_col);
		$sheet->getStyle('H4')->applyFromArray($style_col);
		$sheet->getStyle('I4')->applyFromArray($style_col);
		$sheet->getStyle('J4')->applyFromArray($style_col);
		$sheet->getStyle('K4')->applyFromArray($style_col);
		$sheet->getStyle('L4')->applyFromArray($style_col);
		$sheet->getStyle('M4')->applyFromArray($style_col);
		$sheet->getStyle('N4')->applyFromArray($style_col);
		$sheet->getStyle('O4')->applyFromArray($style_col);
		// Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
		$report_rooster = $this->m_report_rooster->data_report_rooster($cari,$date_awal,$date_akhir,$jabatan);
		$no = 1; // Untuk penomoran tabel, di awal set dengan 1
		$numrow = 5; // Set baris pertama untuk isi tabel adalah baris ke 4
		foreach($report_rooster as $data){ // Lakukan looping pada variabel siswa
			// print_r($data);
		  $sheet->setCellValue('A'.$numrow, $no);
		  $sheet->setCellValue('B'.$numrow, $data->periode);
		  $sheet->setCellValue('C'.$numrow, $data->tgl_masuk);
		  $sheet->setCellValue('D'.$numrow, $data->user2);
		  $sheet->setCellValue('E'.$numrow, $data->user1);
		  $sheet->setCellValue('F'.$numrow, $data->user3);
		  $sheet->setCellValue('G'.$numrow, $data->user5);
		  $sheet->setCellValue('H'.$numrow, $data->pola);
		  $sheet->setCellValue('I'.$numrow, $data->masuk);
		  $sheet->setCellValue('J'.$numrow, $data->ist1);
		  $sheet->setCellValue('K'.$numrow, $data->ist2);
		  $sheet->setCellValue('L'.$numrow, $data->ist3);
		  $sheet->setCellValue('M'.$numrow, $data->ist4);
		  $sheet->setCellValue('N'.$numrow, $data->pulang);
		  $sheet->setCellValue('O'.$numrow, $data->keterangan);

		  // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
		  $sheet->getStyle('A'.$numrow)->applyFromArray($style_row);
		  $sheet->getStyle('B'.$numrow)->applyFromArray($style_row);
		  $sheet->getStyle('C'.$numrow)->applyFromArray($style_row);
		  $sheet->getStyle('D'.$numrow)->applyFromArray($style_row);
		  $sheet->getStyle('E'.$numrow)->applyFromArray($style_row);
		  $sheet->getStyle('F'.$numrow)->applyFromArray($style_row);
		  $sheet->getStyle('G'.$numrow)->applyFromArray($style_row);
		  $sheet->getStyle('H'.$numrow)->applyFromArray($style_row);
		  $sheet->getStyle('I'.$numrow)->applyFromArray($style_row);
		  $sheet->getStyle('J'.$numrow)->applyFromArray($style_row);
		  $sheet->getStyle('K'.$numrow)->applyFromArray($style_row);
		  $sheet->getStyle('L'.$numrow)->applyFromArray($style_row);
		  $sheet->getStyle('M'.$numrow)->applyFromArray($style_row);
		  $sheet->getStyle('N'.$numrow)->applyFromArray($style_row);
		  $sheet->getStyle('O'.$numrow)->applyFromArray($style_row);
		  
		  $no++; // Tambah 1 setiap kali looping
		  $numrow++; // Tambah 1 setiap kali looping
		}
		// Set width kolom
		$sheet->getColumnDimension('A')->setWidth(5); // Set width kolom A
		$sheet->getColumnDimension('B')->setWidth(10); // Set width kolom B
		$sheet->getColumnDimension('C')->setWidth(15); // Set width kolom C
		$sheet->getColumnDimension('D')->setWidth(40); // Set width kolom D
		$sheet->getColumnDimension('E')->setWidth(10); // Set width kolom E
		$sheet->getColumnDimension('F')->setWidth(25);
		$sheet->getColumnDimension('G')->setWidth(25);
		$sheet->getColumnDimension('H')->setWidth(10);
		$sheet->getColumnDimension('I')->setWidth(10);
		$sheet->getColumnDimension('J')->setWidth(10);
		$sheet->getColumnDimension('K')->setWidth(10);
		$sheet->getColumnDimension('L')->setWidth(10);
		$sheet->getColumnDimension('M')->setWidth(10);
		$sheet->getColumnDimension('N')->setWidth(10);
		$sheet->getColumnDimension('O')->setWidth(40);
		// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
		$sheet->getDefaultRowDimension()->setRowHeight(-1);
		// Set orientasi kertas jadi LANDSCAPE
		$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
		// Set judul file excel nya
		$sheet->setTitle("Laporan Data Rooster");
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Data Rooster.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');		   
    }
	
	public function createExcelJabatan1($cari = NULL, $date_awal = NULL, $date_akhir = NULL, $jabatan = NULL) {
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
		$style_col = [
		  'font' => ['bold' => true], // Set font nya jadi bold
		  'alignment' => [
			'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
			'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  ],
		  'borders' => [
			'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
			'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
			'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
			'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
		  ]
		];
		// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
		$style_row = [
		  'alignment' => [
			'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  ],
		  'borders' => [
			'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
			'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
			'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
			'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
		  ]
		];

		// $bulan = date('Y-m-d', strtotime($date_awal));
		// $bulan_format = $date->format('m');
		// $tahun = DateTime::createFromFormat('Y-m-d', $date_awal);
		// $tahun_format = $date->format('Y');

		$sheet->setCellValue('A1', "DATA ROOSTER JABATAN ".$jabatan); // Set kolom A1 dengan tulisan "DATA SISWA"
		$sheet->setCellValue('A2', "TANGGAL : ");
		$sheet->setCellValue('B2', $date_awal);  // Set kolom A1 dengan tulisan "DATA SISWA"
		$sheet->setCellValue('C2', 'SAMPAI');  // Set kolom A1 dengan tulisan "DATA SISWA"
		$sheet->setCellValue('D2', $date_akhir);
		$sheet->mergeCells('A1:E1'); // Set Merge Cell pada kolom A1 sampai E1
		
		$sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1
		$sheet->getStyle('A2')->getFont()->setBold(true);
		$sheet->getStyle('B2')->getFont()->setBold(true);
		$sheet->getStyle('C2')->getFont()->setBold(true);
		$sheet->getStyle('D2')->getFont()->setBold(true);
		// Buat header tabel nya pada baris ke 3
		$sheet->setCellValue('A4', "NO"); // Set kolom A3 dengan tulisan "NO"
		$sheet->setCellValue('B4', "TANGGAL"); // Set kolom B3 dengan tulisan "NIS"
		$sheet->setCellValue('C4', "NAMA"); // Set kolom C3 dengan tulisan "NAMA"
		$sheet->setCellValue('D4', "LOGIN"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
		$sheet->setCellValue('E4', "AREA"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
		$sheet->setCellValue('F4', "JABATAN"); // Set kolom E3 dengan tulisan "ALAMAT"
		$sheet->setCellValue('G4', "POLA"); // Set kolom A3 dengan tulisan "NO"
		$sheet->setCellValue('H4', "JAM MASUK"); // Set kolom B3 dengan tulisan "NIS"
		$sheet->setCellValue('I4', "JAM ISTIRAHAT 1"); // Set kolom C3 dengan tulisan "NAMA"
		$sheet->setCellValue('J4', "JAM ISTIRAHAT 2"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
		$sheet->setCellValue('K4', "JAM ISTIRAHAT 3"); // Set kolom E3 dengan tulisan "ALAMAT"
		$sheet->setCellValue('L4', "JAM ISTIRAHAT 3"); // Set kolom A3 dengan tulisan "NO"
		$sheet->setCellValue('M4', "KETERANGAN"); // Set kolom B3 dengan tulisan "NIS"

		// Apply style header yang telah kita buat tadi ke masing-masing kolom header
		$sheet->getStyle('A4')->applyFromArray($style_col);
		$sheet->getStyle('B4')->applyFromArray($style_col);
		$sheet->getStyle('C4')->applyFromArray($style_col);
		$sheet->getStyle('D4')->applyFromArray($style_col);
		$sheet->getStyle('E4')->applyFromArray($style_col);
		$sheet->getStyle('F4')->applyFromArray($style_col);
		$sheet->getStyle('G4')->applyFromArray($style_col);
		$sheet->getStyle('H4')->applyFromArray($style_col);
		$sheet->getStyle('I4')->applyFromArray($style_col);
		$sheet->getStyle('J4')->applyFromArray($style_col);
		$sheet->getStyle('K4')->applyFromArray($style_col);
		$sheet->getStyle('L4')->applyFromArray($style_col);
		$sheet->getStyle('M4')->applyFromArray($style_col);
		// Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
		// $report_rooster = $this->m_report_rooster->data_report_rooster($cari,$date_awal,$date_akhir,$jabatan);
		// $no = 1; // Untuk penomoran tabel, di awal set dengan 1
		// $numrow = 5; // Set baris pertama untuk isi tabel adalah baris ke 4
		// foreach($report_rooster as $data){ // Lakukan looping pada variabel siswa
		// 	// print_r($data);
		//   $sheet->setCellValue('A'.$numrow, $no);
		//   $sheet->setCellValue('B'.$numrow, $data->tgl_masuk);
		//   $sheet->setCellValue('C'.$numrow, $data->user2);
		//   $sheet->setCellValue('D'.$numrow, $data->user1);
		//   $sheet->setCellValue('E'.$numrow, $data->user3);
		//   $sheet->setCellValue('F'.$numrow, $data->user5);
		//   $sheet->setCellValue('G'.$numrow, $data->pola);
		//   $sheet->setCellValue('H'.$numrow, $data->masuk);
		//   $sheet->setCellValue('I'.$numrow, $data->ist1);
		//   $sheet->setCellValue('J'.$numrow, $data->ist2);
		//   $sheet->setCellValue('K'.$numrow, $data->ist3);
		//   $sheet->setCellValue('L'.$numrow, $data->ist4);
		//   $sheet->setCellValue('M'.$numrow, $data->keterangan);
		  
		//   // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
		//   $sheet->getStyle('A'.$numrow)->applyFromArray($style_row);
		//   $sheet->getStyle('B'.$numrow)->applyFromArray($style_row);
		//   $sheet->getStyle('C'.$numrow)->applyFromArray($style_row);
		//   $sheet->getStyle('D'.$numrow)->applyFromArray($style_row);
		//   $sheet->getStyle('E'.$numrow)->applyFromArray($style_row);
		//   $sheet->getStyle('F'.$numrow)->applyFromArray($style_row);
		//   $sheet->getStyle('G'.$numrow)->applyFromArray($style_row);
		//   $sheet->getStyle('H'.$numrow)->applyFromArray($style_row);
		//   $sheet->getStyle('I'.$numrow)->applyFromArray($style_row);
		//   $sheet->getStyle('J'.$numrow)->applyFromArray($style_row);
		//   $sheet->getStyle('K'.$numrow)->applyFromArray($style_row);
		//   $sheet->getStyle('L'.$numrow)->applyFromArray($style_row);
		//   $sheet->getStyle('M'.$numrow)->applyFromArray($style_row);
		  
		//   $no++; // Tambah 1 setiap kali looping
		//   $numrow++; // Tambah 1 setiap kali looping
		// }

		// Set width kolom
		$sheet->getColumnDimension('A')->setWidth(5); // Set width kolom A
		$sheet->getColumnDimension('B')->setWidth(40); // Set width kolom B
		$sheet->getColumnDimension('C')->setWidth(10); // Set width kolom C
		$sheet->getColumnDimension('D')->setWidth(20); // Set width kolom D
		$sheet->getColumnDimension('E')->setWidth(25); // Set width kolom E
		$sheet->getColumnDimension('F')->setWidth(10);
		$sheet->getColumnDimension('G')->setWidth(20);
		$sheet->getColumnDimension('H')->setWidth(20);
		$sheet->getColumnDimension('I')->setWidth(20);
		$sheet->getColumnDimension('J')->setWidth(20);
		$sheet->getColumnDimension('K')->setWidth(20);
		$sheet->getColumnDimension('L')->setWidth(20);
		$sheet->getColumnDimension('M')->setWidth(40);
		// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
		$sheet->getDefaultRowDimension()->setRowHeight(-1);
		// Set orientasi kertas jadi LANDSCAPE
		$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
		// Set judul file excel nya
		$sheet->setTitle("Laporan Data Rooster Jabatan");
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Data Rooster Jabatan.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');		   
    }
}