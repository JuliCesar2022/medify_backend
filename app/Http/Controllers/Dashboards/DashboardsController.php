<?php

namespace App\Http\Controllers\Dashboards;

use App\Http\Controllers\Controller;
use App\Http\Controllers\OpenAi\GenerarFraseDia;
use crocodicstudio\crudbooster\helpers\CRUDBooster;
use Illuminate\Http\Request;

class DashboardsController extends Controller
{
    public function __invoke()
    {
        if(CRUDBooster::myPrivilegeId()){
//            return CRUDBooster::myPrivilegeId();
            if(CRUDBooster::isSuperadmin()){

                return view('Dashboards/Admin/dashboardAdmin');

            }


            return view('Dashboards/Generic/GenericDashboard');

        }

        return redirect('admin/login');
    }
}
