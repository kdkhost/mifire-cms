<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WhatsappWidgetController extends Controller
{
    public function index()
    {
        $title = Setting::get('whatsapp_widget_title', 'Olá! Como podemos te ajudar?');
        $attendantsJson = Setting::get('whatsapp_widget_attendants', '[]');
        $attendants = json_decode($attendantsJson, true) ?: [];

        return view('admin.whatsapp-widget.index', compact('title', 'attendants'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $attendants = $request->input('attendants', []);

        // Process file uploads if they exist in the input loop
        if ($request->hasFile('attendants')) {
            $files = $request->file('attendants');
            foreach ($files as $index => $attendantFiles) {
                if (isset($attendantFiles['image'])) {
                    $path = $attendantFiles['image']->store('whatsapp_attendants', 'public');
                    $attendants[$index]['image'] = $path;
                }
            }
        }

        // Clean empty entries (requires a name and a whatsapp number at least)
        $attendants = array_filter($attendants, function ($att) {
            return !empty($att['name']) && !empty($att['whatsapp']);
        });

        // Reindex arrays and save settings
        Setting::set('whatsapp_widget_title', $request->input('title'));
        Setting::set('whatsapp_widget_attendants', json_encode(array_values($attendants)));

        return redirect()->back()->with('success', 'Configurações do Atendimento Premium (Widget) salvas com sucesso!');
    }
}
