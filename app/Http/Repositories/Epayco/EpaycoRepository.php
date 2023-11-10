<?php

namespace App\Http\Repositories\Epayco;

use App\Http\Controllers\Api\GeneratePaymentLink;
use App\Http\Repositories\Epayco\Contracts\EpaycoContract;
use App\Models\Briefcase;
use App\Models\EpaycoDTO;
use App\Models\MonthlyValue;
use App\Models\Movement;
use App\Models\Payment;
use App\Models\User;
use Epayco\Epayco;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use PHPUnit\Util\Exception;
use Ramsey\Uuid\Rfc4122\UuidV4;

class EpaycoRepository implements EpaycoContract
{
    private $epayco;

    /**
     * @param Epayco $epayco
     */
    public function __construct(Epayco $epayco)
    {
        $this->epayco = $epayco;
    }


    public function createLink(int $amount = null)
    {

        $userId = Auth::id();
        $monthlyValue = MonthlyValue::query()->where('status', true)->first();
        return (new GeneratePaymentLink())->geneateLink($userId,$amount!=null? $amount: $monthlyValue->value);

    }

    public function myWallet(){
        $userId = Auth::id();
        return (new GeneratePaymentLink())->checkEpaycoStatus($userId);
    }



}
