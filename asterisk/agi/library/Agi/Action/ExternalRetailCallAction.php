<?php

namespace Agi\Action;
use Ivoz\Provider\Domain\Model\Feature\Feature;

/**
 * @class ExternalRetailCallAction
 *
 * @brief Manage outgoing external calls generated by a retail account
 *
 */
class ExternalRetailCallAction extends ExternalCallAction
{
    protected $_number;

    public function setDestination($number)
    {
        $this->_number = $number;
        return $this;
    }

    public function process()
    {
        /** @var \Ivoz\Provider\Domain\Model\RetailAccount\RetailAccountInterface $retail */
        $retail = $this->agi->getChannelCaller();
        $number = $this->_number;

        // Get company from the caller
        $company = $retail->getCompany();

        // Check if the diversion header contains a valid number
        if ($this->agi->getRedirecting('count')) {
            $diversionNum = $this->agi->getRedirecting('from-num');
            $ddi = $retail->getDDI($diversionNum);
            if (empty($ddi)) {
                // Not a Retail Account DDI. Remove it.
                $this->agi->error("Removing invalid diversion header from %s", $diversionNum);
                $this->agi->setRedirecting('count', 0);
            } else {
                $this->agi->verbose("Allowing valid diversion header from %s", $diversionNum);

                // FIXME, please kamuser, give me the numbers in E.164
                $this->agi->setRedirecting('from-num', $ddi->getDDIE164());
            }
        } else {
            // Allow identification from any Retail Account DDI
            $callerIdNum = $$this->agi->getCallerIdNum();
            $ddi = $retail->getDDI($callerIdNum);
            if (!empty($ddi)) {
                $this->agi->notice("Retail account \e[0;36m%s [retail%d]\e[0;93m presented origin matches account DDI %s [ddi%d].",
                        $retail->getName(), $retail->getId(), $ddi->getDDIE164(), $ddi->getId());
                // FIXME, please kamuser, give me the numbers in E.164
                $this->agi->setCallerIdNum($ddi->getDDIE164());
            }
        }

        // Check if outgoing call can be tarificated
        if (!$this->checkTarificable($number)) {
            $this->agi->error("Destination %s can not be billed.", $number);
            // Play error notification over progress
            if ($company->hasFeature(Feature::PROGRESS)) {
                $this->agi->progress("ivozprovider/notBillable");
            }
            $this->agi->decline();
            return;
        }

        // Update caller displayed number
        if (!isset($ddi)) {
            $ddi = $retail->getOutgoingDDI();
            if ($ddi) {
                $callerIdNum = $this->agi->getCallerIdNum();
                $this->agi->notice("Using fallback DDI %s [ddi%d] for retail \e[0;36m%s retail%d]\e[0;93m because %s does not match any DDI.",
                    $ddi->getDDIE164(), $ddi->getId(), $retail->getName(), $retail->getId(), $callerIdNum);
                $this->agi->setCallerIdNum($ddi->getDDIE164());
            } else {
                $this->agi->error("Retail Account %s [retail%d] has not OutgoingDDI configured", $retail->getName(), $retail->getId());
                $this->agi->decline();
                return;
            }
        }

        // Check if DDI has recordings enabled
        $this->checkDDIRecording($ddi);
        // Check if DDI belong to platform
        $this->checkDDIBounced($number);

        // Call the PSJIP endpoint
        $this->agi->setVariable("DIAL_DST", "PJSIP/" . $number . '@proxytrunks');
        $this->agi->setVariable("DIAL_OPTS", "");
        $this->agi->setVariable("DIAL_TIMEOUT", "");
        $this->agi->redirect('call-world', $number);
    }
}
