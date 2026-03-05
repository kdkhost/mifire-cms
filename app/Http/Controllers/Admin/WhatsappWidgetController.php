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
        $widgetBgColor = Setting::get('whatsapp_bg_color', '#DC2626');
        $widgetTextColor = Setting::get('whatsapp_text_color', '#ffffff');
        $widgetPosition = Setting::get('whatsapp_position', 'bottom-right');
        $widgetAnimation = Setting::get('whatsapp_animation', 'pulse');

        return view('admin.whatsapp-widget.index', compact('title', 'attendants', 'widgetBgColor', 'widgetTextColor', 'widgetPosition', 'widgetAnimation'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'widget_bg_color' => 'nullable|string|max:20',
            'widget_text_color' => 'nullable|string|max:20',
            'widget_position' => 'nullable|string|max:20',
            'widget_animation' => 'nullable|string|max:20',
        ]);

        $attendants = $request->input('attendants', []);

        // Process file uploads if they exist in the input loop
        if ($request->hasFile('attendants')) {
            $files = $request->file('attendants');
            foreach ($files as $index => $attendantFiles) {
                if (isset($attendantFiles['image_upload'])) {
                    $path = $attendantFiles['image_upload']->store('whatsapp_attendants', 'public');
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
        Setting::set('whatsapp_bg_color', $request->input('widget_bg_color', '#DC2626'));
        Setting::set('whatsapp_text_color', $request->input('widget_text_color', '#ffffff'));
        Setting::set('whatsapp_position', $request->input('widget_position', 'bottom-right'));
        Setting::set('whatsapp_animation', $request->input('widget_animation', 'pulse'));
        Setting::set('whatsapp_widget_attendants', json_encode(array_values($attendants)));

        return redirect()->back()->with('success', 'Configurações do Atendimento Premium (Widget) salvas com sucesso!');
    }
}
