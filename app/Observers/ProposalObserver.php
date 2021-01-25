<?php

namespace App\Observers;

use App\Models\Proposal;
use Illuminate\Support\Facades\Storage;

class ProposalObserver{

    /**
     * Handle the Proposal "created" event.
     *
     * @param  \App\Models\Proposal  $proposal
     * @return void
     */
    public function created(Proposal $proposal)
    {
        //
    }

    /**
     * Handle the Proposal "updated" event.
     *
     * @param  \App\Models\Proposal  $proposal
     * @return void
     */
    public function updated(Proposal $proposal)
    {
        //
    }

    /**
     * Handle the Proposal "deleted" event.
     *
     * @param  \App\Models\Proposal  $proposal
     * @return void
     */
    public function deleted(Proposal $proposal){
        if(Storage::exists("proposal/$proposal->file_proposal")){
        	Storage::delete("proposal/$proposal->file_proposal");
		}
		if(Storage::exists("lembar_sah/ttd_sah/$proposal->lembar_sah")){
			Storage::delete("lembar_sah/ttd_sah/$proposal->lembar_sah");
		}
		if(Storage::exists("lembar_sah/ttd_koor/$proposal->lembar_sah")){
			Storage::delete("lembar_sah/ttd_koor/$proposal->lembar_sah");
		}
    }

    /**
     * Handle the Proposal "restored" event.
     *
     * @param  \App\Models\Proposal  $proposal
     * @return void
     */
    public function restored(Proposal $proposal)
    {
        //
    }

    /**
     * Handle the Proposal "force deleted" event.
     *
     * @param  \App\Models\Proposal  $proposal
     * @return void
     */
    public function forceDeleted(Proposal $proposal)
    {
        //
    }
}
