<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
//use http\Client\Curl\User;
use App\Http\Repositories\Wallet\WalletController;
use App\Models\Briefcase;
use App\Models\PaymentAttempts;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class GeneratePaymentLink extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    function geneateLink( $id, $amount )
    {

        try {

            $user = User::where('id',$id)->first();

            if($user){

               $payments = PaymentAttempts::where('userID',$id)->where('status',null)->latest()->first();
               $difMinutes = self::minutesDifference($payments->created_at);

               if( $payments && $difMinutes <= 30 && $payments->amount == $amount ){
                   return ['success'=>true, 'pay'=>$payments,'new'=>false];
               }

               $PaymentAttempts = new PaymentAttempts();
               $PaymentAttempts->userID = $id;
               $PaymentAttempts->amount = $amount;
               $PaymentAttempts->save();

               $payRef = $user->document.$PaymentAttempts->id;
               $PaymentAttempts = PaymentAttempts::where('_id',$PaymentAttempts->id)->first();
               $PaymentAttempts->payRef = $payRef;
               $PaymentAttempts->update();

                $response = self::generateLinkEpayco(
                    self::login()->token,
                    $amount,
                    [
                        "description"=> "Recarga del usuario.",
                        "title"=>"Dservices",
                        "email"=>$user->email_aux??"info@doriaire.com",
                        "payRef"=>$payRef,
                        "urlResponse"=>env('APP_URL')."/api/v1/complete_transaction/".$id,
                    ]
                );

                $PaymentAttempts = PaymentAttempts::where('_id',$PaymentAttempts->id)->first();
                $PaymentAttempts->payLink = $response->data->routeLink;
                $PaymentAttempts->update();

               return ['success'=>true, 'pay'=>PaymentAttempts::where('_id',$PaymentAttempts->id)->first(),"new"=>true];

            }


        } catch (\Exception $e) {

            return ['success'=>false, 'payLink'=>null];

        }

    }

    function checkEpaycoStatus($id){

        $payments = PaymentAttempts::where('userID',$id)
            ->where('status',"!=",PaymentAttempts::ACEPTADA)
            ->where('status',"!=",PaymentAttempts::CANCELADA)
            ->where('status',"!=",PaymentAttempts::ABANDONADA)
            ->where('status',"!=",PaymentAttempts::FALLIDA)
            ->where('status',"!=",PaymentAttempts::NO_PAGADO)
            ->where('status',"!=",PaymentAttempts::RECHAZADA)
            ->where('status',"!=",PaymentAttempts::PAGADO)
            ->where('status',"!=",PaymentAttempts::APROBADA)
            ->whereBetween('created_at', [
                now()->subWeeks(3),
                now()
            ])->get();


        if(count($payments) > 0){
            $token = self::login()->token;
        }
        foreach ($payments as $pay){


//            dd();
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer '.$token,
            ])->post('https://apify.epayco.co/transaction',['filter' => ['referenceClient' => $pay->payRef]]);

            $referenses = json_decode($response)->data->data;

            if (count($referenses) >= 1) {

               if( $referenses[0]->status == PaymentAttempts::PAGADO || $referenses[0]->status == PaymentAttempts::APROBADA || $referenses[0]->status == PaymentAttempts::ACEPTADA  ){

                  // Update Wallet
                  WalletController::make($id,$pay->amount,WalletController::IN,"Recarga desde la App.");

               }

                $PaymentAttempts = PaymentAttempts::where('_id',$pay->id)->first();
                $PaymentAttempts->status = $referenses[0]->status;
                $PaymentAttempts->update();

            }

        }

        $wallet =  WalletController::getWallet($id);

        if( $wallet->technical_id == null  ){



            $wallet = WalletController::createWallet($id);


        }

        return $wallet;

    }

    private function login()
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://apify.epayco.co/login',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Content-Type: application/json',
                'Authorization: Basic ' . env('AUTHORIZATION_EPAYCO'),
                'username: ' . env('USERNAME_EPAYCO'),
                'password: ' . env('PASSWORD_EPAYCO')
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response);

    }

    private function generateLinkEpayco($token, $gandTotal, $data)
    {

//        dd($data['description']);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://apify.epayco.co/collection/link/create',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
              "quantity": 1,
              "onePayment":true,
              "amount": "'. $gandTotal .'",
              "currency": "COP",
              "id": "0",
              "reference": "'. $data['payRef'] .'",
              "base": "0",
              "description": "'. $data['description'] .'",
              "title": "'. $data['title'] .'",
              "typeSell": "1",
              "tax": "0",
              "email": "'. $data['email'] .'",
              "urlResponse": "'. $data['urlResponse'] .'"
            }',
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Content-Type: application/json',
                'Authorization: Bearer ' . $token
            )
        ));

        $response = curl_exec($curl);

//        dd($response);
        curl_close($curl);
        return json_decode($response);
    }


    private function minutesDifference($date) {
        $now = Carbon::now();
        $givenDate = Carbon::parse($date);
        return $now->diffInMinutes($givenDate);
    }

}
