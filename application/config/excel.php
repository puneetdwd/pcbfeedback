<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['defaultStyle'] = array(
    'font' => array(
        'name' => 'Arial',
        'size' => '9',
    ),
    'alignment' => array(
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    ),
    'borders' => array(
        'inside'     => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array(
                'rgb' => 'FFFFFF'
            )
        ),
        'outline'     => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array(
                'rgb' => 'FFFFFF'
            )
        )
    )
);

$config['headerStyle'] = array(
    'font' => array(
        'size' => '10',
        'bold' => true,
        'color' => array('rgb' => 'FFFFFF'),
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
            'rgb' => '428BCA',
        ),
    ),
);

$config['greyHeaderStyle'] = array(
    'font' => array(
        'size' => '10',
        'bold' => true,
        'color' => array('rgb' => 'FFFFFF'),
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
            'rgb' => 'AAAAAA',
        ),
    ),
);

$config['successRow'] = array(
    'font' => array(
        'color' => array('rgb' => '3C763D'),
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
            'rgb' => 'DFF0D8',
        ),
    ),
);
$config['successBoldRow'] = array(
    'font' => array(
        'bold' => true,
        'color' => array('rgb' => '3C763D'),
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
            'rgb' => 'DFF0D8',
        ),
    ),
);
$config['errorRow'] = array(
    'font' => array(
        'color' => array('rgb' => 'A94442'),
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
            'rgb' => 'F2DEDE',
        ),
    ),
);
$config['errorBoldRow'] = array(
    'font' => array(
        'bold' => true,
        'color' => array('rgb' => 'A94442'),
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
            'rgb' => 'F2DEDE',
        ),
    ),
);
$config['infoRow'] = array(
    'font' => array(
        'color' => array('rgb' => '31708F'),
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
            'rgb' => 'D9EDF7',
        ),
    ),
);
$config['infoBoldRow'] = array(
    'font' => array(
        'bold' => true,
        'color' => array('rgb' => '31708F'),
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
            'rgb' => 'D9EDF7',
        ),
    ),
);
$config['warningRow'] = array(
    'font' => array(
        'color' => array('rgb' => '8A6D3B'),
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
            'rgb' => 'FAEBCC',
        ),
    ),
);
$config['warningBoldRow'] = array(
    'font' => array(
        'bold' => true,
        'color' => array('rgb' => '8A6D3B'),
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
            'rgb' => 'FAEBCC',
        ),
    ),
);