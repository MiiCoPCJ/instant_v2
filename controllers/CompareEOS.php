<?php

namespace controllers;
require_once(__dir__.'/../init.php');
use common\Controller;

class CompareEOS extends Controller
{
    //比较3分钟数据，获取涨幅
    public function Compare()
    {
        //$sql = 'select max(`time`) as `time`,`price` from `eos`';
        //$last = $this->db->QueryOne($sql);
        $noticeTime = 0;
        $noticePoint = 0;

        set_time_limit(0);
        do{
            $last = json_decode($this->redis->lPop('eos'),true);

            if($last==null||!$last){
              sleep(0.5);
              continue;
            }

            $time = $last['time'];
            $price = $last['price'];
            $preTime = $time-180;

            $pre = $this->db->QueryOne('select `time`,`price` from `eos` where `time` = '.$preTime);
            //不存在具体时间戳数据处理
            if(empty($pre)){
                $pre = $this->db->QueryOne('select `time`,`price` from `eos` where `time` <= '.$preTime.' order by time DESC limie 1');
            }

            if(empty($pre)){
              continue;
            }
            $comparePrice = $pre['price'];
            if(empty($comparePrice)){
              continue;
            }
            $ratio = round(($price-$comparePrice)/$price*100,8);

            //提醒
            //$msg = date('Y-m-d H:i:s',time()).' 3分钟涨幅: '.$ratio;
            $msg = 'price: '.$price.' comparePrice: '.$comparePrice.' || time: '.$time.' || '.$pre['time'].' || 3分钟涨幅: '.$ratio.' ### '.date('Y-m-d H:i:s',$time);


            if($ratio>=1.5){
                //提醒3次，每次隔1分钟
                if($noticePoint<3){
                  if(($time-60)>$noticeTime){
                    $noticeTime = $time;
                    $noticePoint++;
                    $this->func->log_file($msg);
                    $this->func->wechatMSG($msg);
                    $this->func->phoneMSG();
                  }
                }else{
                  break;
                }

            }

            $this->func->log_file($msg);
        }while(true);

    }


}

$compare = new CompareEOS();
$compare->Compare();
