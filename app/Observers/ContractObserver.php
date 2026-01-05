<?php

namespace App\Observers;

use App\Models\Contract;
use App\Events\ContractCreated;
use App\Events\ContractDeleted;

class ContractObserver
{
    public function created(Contract $contract): void
    {
        ContractCreated::dispatch($contract);
    }

    public function deleted(Contract $contract): void
    {
        ContractDeleted::dispatch($contract->id);
    }
}