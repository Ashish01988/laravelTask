<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Child;

class ChildController extends Controller
{
    function create()
    {
        $children = Child::all();
        return view('child.create',compact('children'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'first_name.*' => 'required|string',
            'middle_name.*' => 'nullable|string',
            'last_name.*' => 'required|string',
            'age.*' => 'required|integer',
            'address.*' => 'nullable|string',
            'city.*' => 'nullable|string',
            'state.*' => 'nullable|string',
            'zip_code.*' => 'nullable|string',
            'country.*' => 'nullable|string',
        ]);

        $data = $request->all();

        foreach ($data['first_name'] as $index => $firstName) {
            $childData = [
                'first_name' => $firstName,
                'middle_name' => $data['middle_name'][$index],
                'last_name' => $data['last_name'][$index],
                'age' => $data['age'][$index],
                'address' => $data['address'][$index] ?? null,
                'city' => $data['city'][$index] ?? null,
                'state' => $data['state'][$index] ?? null,
                'zip_code' => $data['zip_code'][$index] ?? null,
                'country' => $data['country'][$index] ?? null,
            ];

            $childId = $data['child_id'][$index] ?? null;

            if ($childId) {
                $child = Child::find($childId);

                if ($child) {
                    $child->update($childData);
                }
            } else {
                Child::create($childData);
            }
        }

        return back()->with('success', 'Child data saved successfully!');
    }





    public function destroy($id)
{
    $child = Child::findOrFail($id);
    $child->delete();

    return back()->with('success', 'Child data deleted successfully!');
}

}
