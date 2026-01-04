<?php

namespace App\Observers;

use App\Models\ContractAmendment;

class ContractAmendmentObserver
{
    /**
     * Handle the ContractAmendment "created" event.
     */
    public function created(ContractAmendment $contractAmendment): void
    {
        $this->updateContractExpiry($contractAmendment);
    }

    /**
     * Handle the ContractAmendment "updated" event.
     */
    public function updated(ContractAmendment $contractAmendment): void
    {
        $this->updateContractExpiry($contractAmendment);
    }

    protected function updateContractExpiry(ContractAmendment $contractAmendment): void
    {
        $contract = $contractAmendment->contract;
        
        // Update the contract's expiry date to the latest amendment's date
        // only if the amendment date is newer than current expiry
        if ($contractAmendment->new_expiry_date->gt($contract->expiry_date)) {
            $contract->update([
                'expiry_date' => $contractAmendment->new_expiry_date
            ]);
        }
    }
}