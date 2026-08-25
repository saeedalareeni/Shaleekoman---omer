<?php

namespace App\Http\Controllers\Owner;
use App\Http\Controllers\Controller;

use App\Models\ChaletPrice;
use Illuminate\Http\Request;
use App\Models\Chalet;

class ChaletPriceController extends Controller {


    public function index($id)
    {
        $chalet = Chalet::where('id', $id)->where('owner_id', auth()->id())->first();
        
        if (!$chalet) {
            abort(404, 'العقار غير موجود');
        }
        
        // Retrieve the price
        $price = $chalet->default_day_price;
        return view('owners.pages.chalets.prices', compact('chalet', 'price'));
    }



    public function getPrices(Chalet $chalet)
    {
        $prices = [];
        $start = now()->startOfDay(); // بداية اليوم الحالى
        $end = now()->addYears(1)->endOfYear(); // نهاية السنة المقبلة

        // Retrieve custom prices from the database
        $customPrices = ChaletPrice::where('chalet_id', $chalet->id)
            ->whereBetween('date', [$start, $end])
            ->get()
            ->keyBy('date');

        for ($date = $start; $date <= $end; $date->addDay()) {
            $dateString = $date->toDateString();

            // تحقق مما إذا كان هناك سعر مخصص لهذا التاريخ
            if ($customPrices->has($dateString)) {
                $price = $customPrices->get($dateString)->price;
                $isCustom = true;
            } else {
                $price = $chalet->default_day_price;
                $isCustom = false;
            }

            $prices[] = [
                'date' => $dateString,
                'price' => $price,
                'custom' => $isCustom,
            ];
        }

        return response()->json($prices);
    }






    // تحديث سعر اليوم أو أكثر من يوم
    // أو تحديث شهر كامل
    public function updatePrices(Request $request, Chalet $chalet)
    {
        $dates = explode(',', $request->input('dates'));
        $price = $request->input('price');
        $month = $request->input('month');
        $priceMonth = $request->input('price_month');

        if ($month) {
            // Handle month update
            $startDate = \Carbon\Carbon::createFromFormat('Y-m', $month)->startOfMonth();
            $endDate = \Carbon\Carbon::createFromFormat('Y-m', $month)->endOfMonth();

            $currentDate = $startDate->copy();
            while ($currentDate <= $endDate) {
                ChaletPrice::updateOrCreate(
                    ['chalet_id' => $chalet->id, 'date' => $currentDate->toDateString()],
                    ['price' => $priceMonth]
                );
                $currentDate->addDay();
            }
        } else {
            // Handle selected dates update
            foreach ($dates as $date) {
                ChaletPrice::updateOrCreate(
                    ['chalet_id' => $chalet->id, 'date' => $date],
                    ['price' => $price]
                );
            }
        }

        return redirect()->route('owner.chalets.prices.index', $chalet->id)->with('success', 'تم تحديث الأسعار بنجاح');
    }




    // تحديد سعر أيام محددة
    public function updatePricesRecurrence(Request $request, Chalet $chalet)
    {
        $weekday = $request->input('weekday');
        $months = (int) $request->input('months');
        $price = $request->input('price_recurrence');

        $startDate = now();
        $endDate = $startDate->copy()->addMonths($months);

        while ($startDate <= $endDate) {
            // Find the first occurrence of the specified weekday
            $currentDate = $startDate->copy();
            while ($currentDate->dayOfWeek != $weekday) {
                $currentDate->addDay();
            }

            // Update the price for the found date
            ChaletPrice::updateOrCreate(
                ['chalet_id' => $chalet->id, 'date' => $currentDate->toDateString()],
                ['price' => $price]
            );

            // Move to the next occurrence of the same weekday in the next week
            $startDate->addWeek();
        }

        return redirect()->route('owner.chalets.prices.index', $chalet->id)->with('success', 'تم تحديث الأسعار للأيام المحددة بنجاح');
    }






}

