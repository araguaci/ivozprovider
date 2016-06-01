<?php


use IvozProvider\Mapper\Sql\MusicOnHold;

class TarificatorWorker extends Iron_Gearman_Worker
{
    protected $_timeout = 10000; // 1000 = 1 second
    protected $_mapper;

    protected function initRegisterFunctions()
    {

        $this->_registerFunction = array(
                'tarificateCalls' => 'tarificateCalls'
        );
    }

    protected function init()
    {
        $this->_mapper = new MusicOnHold();

    }

    protected function timeout()
    {
        $this->_mapper->getDbTable()->getAdapter()->closeConnection();
    }

    public function tarificateCalls(\GearmanJob $serializedJob = null)
    {

        $pks = null;
        if (!is_null($serializedJob)) {
            $job = igbinary_unserialize($serializedJob->workload());
            if ($job) {
                $pks = $job->getPks();
            }
        }

        $callMapper = new \IvozProvider\Mapper\Sql\KamAccCdrs();

        $wheres = array();
        if (is_null($pks)) {
            $wheres[] = "(metered = 0 OR metered IS NULL)";
        } else {
            $wheres[] = "`id` IN (".implode(",", $pks).")";
            $wheres[] = "`invoiceId` IS NULL";
        }

        $numberRegs = $callMapper->countTarificableByQuery($wheres);

        $message = "Number of calls to be metered: ".$numberRegs;
        $this->_logger->log("[GEARMAND][TARIFICATOR] ".$message, \Zend_Log::INFO);

        $interval = 100;
        $offset = 0;
        $factor = ceil($numberRegs/$interval);
        $this->_logger->log("[GEARMAND][TARIFICATOR] Factor: ".$factor, \Zend_Log::INFO);
        $offset = 0;
        $nMetered = 0;
        for($i = 0; $i< $factor; $i++) {
            $this->_logger->log("[GEARMAND][TARIFICATOR] Offset: ".$offset, \Zend_Log::INFO);
            $calls = $callMapper->fetchTarificableList($wheres, "calldate", $interval, $offset);
            foreach ($calls as $call) {
                try {
                    $metered = $call->tarificate();
                    $call->save();
                    if ($call->getExternallyRated() == 1) {
                        $message = "Call with id = ".$call->getPrimaryKey()." whill be metered externally. ";
                    } else {
                        $message = "Cost for call with id = ".$call->getPrimaryKey().": ".$call->getPrice();
                    }
                    if (!is_null($metered)) {
                        $nMetered ++;
                    }
                } catch (Exception $e) {
                    $message = "Cost for call with id = ".$call->getPrimaryKey().": ".$call->getPrice();
                    $message .= "  ERROR SAVING CALL. ERROR WAS: '".$e->getMessage()."'";
                }
                $this->_logger->log("[GEARMAND][TARIFICATOR] ".$message, \Zend_Log::INFO);
            }
        }

        $message = $nMetered." calls metered from ".$numberRegs;
        $this->_logger->log("[GEARMAND][TARIFICATOR] ".$message, \Zend_Log::INFO);
    }

}
