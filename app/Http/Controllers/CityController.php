<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class CityController extends Controller
{

    public function index(Request $request)
    {
        $query = $request->input('query');
        // بناء الاستعلام للبحث في قاعدة البيانات
        $cities = City::query()
            ->when($query, function ($queryBuilder, $query) {
                return $queryBuilder->where('name', 'like', "%{$query}%")
                    ->orWhere('name_en', 'like', "%{$query}%");
            })
            ->paginate(10); // تحديد عدد العناصر في كل صفحة

        return view('backend.pages.cities.index', compact('cities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_ar'            => 'required|string|max:255',
            'name_en'            => 'required|string|max:255',
        ]);

        $city = new City();
        if ($image = $request->file('image')){
            $path = 'images/owners/';
            $filename = time().$image->getClientOriginalName();
            $image->move($path, $filename);
            $city->image = $path.$filename;
        }


        $city->name_ar = $request->name_ar;
        $city->name_en = $request->name_en;
        $city->save();
        toast('  تم الاضافة بنجاح','success');
        return redirect()->back();
    }


    public function update(Request $request, City $city)
    {
        $request->validate([
            'name_ar'            => 'required|string|max:255',
            'name_en'            => 'required|string|max:255',
        ]);

       // $city = new City();
        if ($image = $request->file('image')){
            $path = 'images/owners/';
            $filename = time().$image->getClientOriginalName();
            $image->move($path, $filename);
            $city->image = $path.$filename;
        }

        $city->name_ar = $request->name_ar;
        $city->name_en = $request->name_en;
        $city->save();
        toast('  تم التحديث  بنجاح','success');
        return redirect()->back();

    }


    public function getAreas(Request $request)
    {
        $cityId = $request->input('city_id');
        $areas = Area::where('city_id', $cityId)->get();

        $formattedAreas = $areas->map(function ($area) {
            return [
                'id' => $area->id,
                'name' => App::getLocale() === 'ar' ? $area->name_ar : $area->name_en,
                'city_name' => App::getLocale() === 'ar' ? $area->city->name_ar : $area->city->name_en,
            ];
        });

        return response()->json($formattedAreas);
    }
    public function destroy($id)
    {
        $city = City::findOrFail($id);
        if($city->areas->count()>0){
            toast('لا يمكن الحذف المدينة مرتبة بالشاليهات','error');
        }
        else{
            toast('تم حذف المدينة بنجاح','success');
            $city->delete();
        }
        return redirect()->back();
    }

}
