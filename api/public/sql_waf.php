<?php
 function check_input($ipt)
	{
        $ipt = str_ireplace("=", "sql_waf", $ipt);
        $ipt = str_ireplace("<", "sql_waf", $ipt);
        $ipt = str_ireplace(">", "sql_waf", $ipt);
        return $ipt;
	}
?>