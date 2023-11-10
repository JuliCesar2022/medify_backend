<?php

namespace App\Http\Controllers;

use App\Http\Repositories\Wallet\WalletController;
use App\Models\Movement;
use App\Models\User;
use crocodicstudio\crudbooster\helpers\CRUDBooster;
use Illuminate\Http\Request;

class WalletControllerView extends Controller
{
    static function index($technical_id){


        if(!CRUDBooster::isSuperadmin()){
            return redirect('admin');

        }

        $user = User::where('id',$technical_id)->first();
        $wallet = WalletController::getWallet($technical_id);
        $moviments = Movement::where('technical_id', $technical_id )->latest()->get();

//        dd($moviments);

        return view('Wallet/Wallet', compact('user','wallet','moviments'));


    }

    static function makeMoviment(){

      if(!CRUDBooster::isSuperadmin()){
          return redirect('admin');
      }
          WalletController::make(Request()->user_id,Request()->cantidad, Request()->accion, Request()->rason);
          return redirect('/admin/usersApp/set-wallet/'.Request()->user_id);
    }
}
