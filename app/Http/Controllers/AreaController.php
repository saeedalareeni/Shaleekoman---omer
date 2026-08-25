<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Chalet;
use App\Models\ChaletImage;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AreaController extends Controller
{

    public function index(Request $request)
    {
        $cities = City::all();

        $query = $request->input('query');
        $areas = Area::query()
            ->when($query, function ($queryBuilder, $query) {
                return $queryBuilder->where('name', 'like', "%{$query}%")
                    ->orWhere('name_en', 'like', "%{$query}%");
            })
            ->paginate(10);

        return view('backend.pages.areas.index', compact('areas','cities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_ar'            => 'required|string|max:255',
            'name_en'            => 'required|string|max:255',
            'city_id'            => 'required',
        ]);
        $area = new Area();
        $area->name_ar = $request->name_ar;
        $area->name_en = $request->name_en;
        $area->city_id = $request->city_id;
        $area->save();
        toast('  تم الاضافة بنجاح','success');
        return redirect()->back();
    }


    public function update(Request $request, Area $area)
    {
        $request->validate([
            'name_ar'            => 'required|string|max:255',
            'name_en'            => 'required|string|max:255',
            'city_id'            => 'required',
        ]);
        $area->name_ar = $request->name_ar;
        $area->name_en = $request->name_en;
        $area->city_id = $request->city_id;
        $area->save();
        toast('  تم التحديث  بنجاح','success');
        return redirect()->back();

    }

    // public function getareas($id)
    // {
    //     $list_section = Area::where("city_id", $id)->pluck("name_ar","name_en", "id");
    //     return $list_section;
    // }
    public function getareas($id)
{
    $areas = Area::where('city_id', $id)
                 ->select('id', 'name_ar', 'name_en')
                 ->get();

    $areaOptions = [];
    foreach ($areas as $area) {
        $areaOptions[$area->id] = app()->getLocale() == 'ar' ? $area->name_ar : $area->name_en;
    }

    return response()->json($areaOptions);
}



    public function destroy($id)
    {
        $area = Area::findOrFail($id);
        if($area->chalets->count()>0){
            toast('لا يمكن الحذف المنطقة مرتبة بالشاليهات','error');
        }
        else{
            toast('تم حذف المنطقة بنجاح','success');
            $area->delete();
        }
        return redirect()->back();

    }

}
