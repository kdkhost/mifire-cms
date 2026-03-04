<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

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

        // Limpar dados vazios
        $departments = array_filter($departments, function ($dept) {
            return !empty($dept['name']);
        });

        // Reindexar e salvar
        Setting::set('contact_departments', json_encode(array_values($departments)));

        return redirect()->back()->with('success', 'Departamentos atualizados com sucesso!');
    }
}
