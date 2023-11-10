<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMonthlyValueRequest;
use App\Http\Requests\UpdateMonthlyValueRequest;
use App\Models\MonthlyValue;
use Illuminate\Support\Facades\Cache;

class MonthlyValueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Cache::rememberForever('monthlyValue', function () {
            return MonthlyValue::query()->get();
        });
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreMonthlyValueRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMonthlyValueRequest $request)
    {
        $code_status = true;
        $randCode = 0;
        while ($code_status) {
            $randCode = rand(000000, 999999);
            $code = MonthlyValue::query()->where('promo_code', $randCode)->get();
            if ($code) {
                $code_status = false;
            }
        }

        $monthlyValue = new MonthlyValue();
        $monthlyValue->name = $request->name;
        $monthlyValue->value = $request->value;
        $monthlyValue->promo_code = $randCode;
        $monthlyValue->user_id = (int)Auth::id();
        $monthlyValue->save();

        Cache::forget('monthlyValue');

        return $monthlyValue;
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\MonthlyValue $monthlyValue
     * @return \Illuminate\Http\Response
     */
    public function show(MonthlyValue $monthlyValue)
    {
        return $monthlyValue;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateMonthlyValueRequest $request
     * @param \App\Models\MonthlyValue $monthlyValue
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMonthlyValueRequest $request, MonthlyValue $monthlyValue)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\MonthlyValue $monthlyValue
     * @return \Illuminate\Http\Response
     */
    public function destroy(MonthlyValue $monthlyValue)
    {
        //
    }
}
