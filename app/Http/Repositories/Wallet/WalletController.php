<?php

namespace App\Http\Repositories\Wallet;

use App\Models\Briefcase;
use App\Models\Movement;
use FontLib\Table\Type\cmap;

class WalletController
{

    const IN = "IN";
    const OUT = "OUT";
    const TRANSACTION_SUCCESS = "TRANSACTION_SUCCESS";
    const INSUFFICIENT_BALANCE = "INSUFFICIENT_BALANCE";
    const ERROR = "ERROR";

    private static function movement(string $id,int $amount,string $type, $reason = "Transacción iterna."): bool
    {

        try {
            $wallet = Briefcase::where('technical_id', $id)->first();

            $movement = new Movement();
            $movement->technical_id = $id;
            $movement->current_balance = $wallet->current_amount ?? 0;
            $movement->amount =  $amount;
            $movement->reason = $reason;
            $movement->type = $type;
            $movement->save();

            return true;
        }catch (\Exception $exception){
            return false;
        }

    }
   public static function make(string $id,int $amount, string $type, $reason = "Transacción iterna." ): array
    {
        $wallet = self::getWallet($id);

        if ($wallet) {

            if($type == self::IN){
                $wallet->current_amount += $amount;
                $wallet->update();
                self::movement($id, $amount,$type,$reason);
                return ["success" => true, "message"=>self::TRANSACTION_SUCCESS];

            }else if($type == self::OUT){

                $saldo = $wallet->current_amount - $amount;

                if ($saldo >= 0){
                    $wallet->current_amount -= $amount;
                    $wallet->update();
                    self::movement($id, $amount,$type,$reason);
                    return ["success" => true, "message"=>self::TRANSACTION_SUCCESS];
                }

                if($saldo < 0){

                    return ["success" => false, "message"=>self::INSUFFICIENT_BALANCE];

                }

            }

            return ["success" => false, "message"=>self::ERROR];


        } else {

            self::createWallet($id);
            return self::make($id,$amount,$type);

        }

        return ["success" => false, "message"=>self::ERROR];

    }


    public static function createWallet($userID){

        $wallet = new Briefcase();
        $wallet->technical_id = $userID;
        $wallet->current_amount = 0;
        $wallet->save();
        return self::getWallet($userID);

    }

    public static function getWallet($userID){

        $wallet = Briefcase::where('technical_id', $userID)->first();
        return $wallet;

    }
}
