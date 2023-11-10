<?php

namespace App\Http\Repositories\Epayco\Contracts;

use App\Models\EpaycoDTO;

interface EpaycoContract
{
    public function createLink(int $amount = null);
    public function myWallet();

}
