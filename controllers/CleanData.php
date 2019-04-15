<?php

namespace controllers;
require_once(__dir__.'/../init.php');
use common\Controller;



class CleanData extends Controller
{

    //获取okex的Api数据
    public function Clean()
    {
      $time = time();
      $sql = "delete from `eos` where time<".($time-3600);
      $result = $this->db->Execute($sql);
      $msg = "time: ".date('Y-m-d H:i:s',$time).' '.$sql;
      $this->func->log_file($msg,false,'delete_data.log');
    }


}

$clean = new CleanData();
$clean->Clean();
