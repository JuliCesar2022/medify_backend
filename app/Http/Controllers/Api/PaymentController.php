<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Epayco\Contracts\EpaycoContract;

class PaymentController extends Controller
{
    private $epaycoRepository;

    /**
     * @param $epaycoRepository
     */
    public function __construct(
        EpaycoContract $epaycoRepository
    )
    {
        $this->epaycoRepository = $epaycoRepository;
    }



    public function linkPse(string $amount)
    {
        return $this->epaycoRepository->createLink($amount);

    }

    public function myWallet()
    {
        return $this->epaycoRepository->myWallet();
    }
}
