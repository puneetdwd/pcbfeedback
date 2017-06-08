<?php 
    include_once 'PHPExcel/IOFactory.php';
    
    /**  Define a Read Filter class implementing PHPExcel_Reader_IReadFilter  */
    class chunkReadFilter implements PHPExcel_Reader_IReadFilter {
        private $_startRow = 0;

        private $_endRow = 0;
        private $_columns = array();

        /**  Set the list of rows that we want to read  */
        public function setRows($startRow, $chunkSize) {
            $this->_startRow	= $startRow;
            $this->_endRow		= $startRow + $chunkSize;
        }
        
        /**  Set the list of rows that we want to read  */
        public function setCols($cols) {
            $this->_columns	    = $cols;
        }

        public function readCell($column, $row, $worksheetName = '') {
            //  Only read the heading row, and the rows that are configured in $this->_startRow and $this->_endRow abc
            if (in_array($column, $this->_columns)) {
                return true;
            }
            return false;
        }
    }

?>