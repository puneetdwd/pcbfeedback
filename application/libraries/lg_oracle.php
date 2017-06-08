<?php 

    function get_barcode_details($barcode_no) {
        $conn = oci_connect('viewer', 'viewer', '(DESCRIPTION= (ADDRESS=(PROTOCOL=tcp)(HOST=192.168.20.140)(PORT=1521)) (CONNECT_DATA= (SERVICE_NAME=ilcomdb) (INSTANCE_NAME=ilcomdb)))');
        if (!$conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $stid = oci_parse($conn, "SELECT org_name, insdttm, wo_name, mtrlid, modlid, sffx_name, wo_qty, barcode_no, buyer_serial_no, pcsgname
            FROM INTF.V_GMES_ILCOMDB_LB_HISTORY WHERE barcode_no = '".$barcode_no."'");

        oci_execute($stid);
        $row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
        
        oci_free_statement($stid);
        oci_close($conn);
        return $row;

    }

    function get_barcode_details_set($barcode_no) {
        $conn = oci_connect('viewer', 'viewer', '(DESCRIPTION= (ADDRESS=(PROTOCOL=tcp)(HOST=192.168.20.140)(PORT=1521)) (CONNECT_DATA= (SERVICE_NAME=ilcomdb) (INSTANCE_NAME=ilcomdb)))');
        if (!$conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $stid = oci_parse($conn, "SELECT org_name, insdttm, wo_name, mtrlid, modlid, sffx_name, wo_qty, barcode_no, buyer_serial_no, pcsgname
            FROM INTF.V_GMES_ILCOMDB_LB_HISTORY WHERE buyer_serial_no = '".$barcode_no."'");

        oci_execute($stid);
        $row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
        
        oci_free_statement($stid);
        oci_close($conn);
        return $row;

    }

    function get_barcode_details_wo_serial($wo_name, $serial_no) {
        $conn = oci_connect('viewer', 'viewer', '(DESCRIPTION= (ADDRESS=(PROTOCOL=tcp)(HOST=192.168.20.140)(PORT=1521)) (CONNECT_DATA= (SERVICE_NAME=ilcomdb) (INSTANCE_NAME=ilcomdb)))');
        if (!$conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $stid = oci_parse($conn, "SELECT org_name, insdttm, wo_name, mtrlid, modlid, sffx_name, wo_qty, barcode_no, lbl_serial_no \"BUYER_SERIAL_NO\", pcsgname
            FROM INTF.V_GMES_ILCOMDB_LB_HISTORY WHERE wo_name = '".$wo_name."' AND lbl_serial_no = '".$serial_no."'");

        oci_execute($stid);
        $row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
        
        oci_free_statement($stid);
        oci_close($conn);
        return $row;

    }

    function get_production_plan($date) {
        $conn = oci_connect('viewer', 'viewer', '(DESCRIPTION= (ADDRESS=(PROTOCOL=tcp)(HOST=192.168.20.140)(PORT=1521)) (CONNECT_DATA= (SERVICE_NAME=ilcomdb) (INSTANCE_NAME=ilcomdb)))');
        if (!$conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $stid = oci_parse($conn, "SELECT t.PRDTN_YMD, t.DEMAND_ID, t.MODLID, t.SFFX_NAME, t.DILY_PRDTN_QTY, t.PCSGNAME, t.PCSGID
        FROM INTF.V_ILCOMDB_PRODUCTION_PLN_PUNE t WHERE t.PRDTN_YMD='".$date."' AND t.SFFX_NAME IS NOT NULL AND t.DILY_PRDTN_QTY > 0");

        oci_execute($stid);
        $result = array();
        while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
            $temp = array();
            $temp['production_date']    = $row['PRDTN_YMD'];
            $temp['workorder']          = $row['DEMAND_ID'];
            $temp['model_name']         = $row['MODLID'];
            $temp['suffix_name']        = $row['SFFX_NAME'];
            $temp['lot_qty']            = $row['DILY_PRDTN_QTY'];
            $temp['line']               = $row['PCSGNAME'];
            $temp['gmes_line_id']       = $row['PCSGID'];
            
            $result[] = $temp;
        }
        
        oci_free_statement($stid);
        oci_close($conn);
        return $result;
    }
    
    function gmes_insert($headers, $data, $table) {
        $sql = 'INSERT INTO '.$table.' ('.implode(', ', $headers).') VALUES ';
        
        $values = array();
        foreach($data as $index => $row) {
            $values[] = "('".implode("', '", $row)."')";
        }
        
        $sql = $sql.implode(', ', $values);
        
        $conn = oci_connect('viewer', 'viewer', '(DESCRIPTION= (ADDRESS=(PROTOCOL=tcp)(HOST=192.168.20.140)(PORT=1521)) (CONNECT_DATA= (SERVICE_NAME=ilcomdb) (INSTANCE_NAME=ilcomdb)))');
        if (!$conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        
        $stid = oci_parse($conn, $sql);

        $result = oci_execute($stid);
        
        if(!$result) {
            return false;
        }
        
        $stid = oci_parse($conn, 'COMMIT');
        oci_execute($stid);
        
        oci_free_statement($stid);
        oci_close($conn);
        
        return true;
    }
    
    function get_woid($org_id, $wo_name) {
        $conn = oci_connect('viewer', 'viewer', '(DESCRIPTION= (ADDRESS=(PROTOCOL=tcp)(HOST=192.168.20.140)(PORT=1521)) (CONNECT_DATA= (SERVICE_NAME=ilcomdb) (INSTANCE_NAME=ilcomdb)))');
        if (!$conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $stid = oci_parse($conn, "SELECT WOID FROM INTF.V_ILCOMDB_PRDPLN_MST_PUNE WHERE ORG_ID = '".$org_id."' AND MFG_ORDER = '".$wo_name."'");

        oci_execute($stid);
        $woid = '';
        while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
            $temp = array();
            $woid    = $row['WOID'];
        }
        
        oci_free_statement($stid);
        oci_close($conn);
        return $woid;
    }
?>