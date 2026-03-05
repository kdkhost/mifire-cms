<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContactDepartmentController extends Controller
{
    public function index()
    {
        $departmentsJson = Setting::get('contact_departments', '[]');
        $departments = json_decode($departmentsJson, true) ?: [];

        return view('admin.contact-departments.index', compact('departments'));
    }

    public function store(Request $request)
    {
        $departments = $request->input('departments', []);

        // Process file uploads if they exist alongside input loop
        if ($request->hasFile('departments')) {
            $files = $request->file('departments');
            foreach ($files as $index => $departmentFiles) {
                if (isset($departmentFiles['image'])) {
                    $path = $departmentFiles['image']->store('departments', 'public');
                    $departments[$index]['image'] = $path;
                }
            }
        }

        // Clean empty entries (requires a name)
        $departments = array_filter($departments, function ($dept) {
            return !empty($dept['name']);
        });

        // Reindex and save
        Setting::set('contact_departments', json_encode(array_values($departments)));

        return redirect()->back()->with('success', 'Departamentos atualizados com sucesso!');
    }
}
