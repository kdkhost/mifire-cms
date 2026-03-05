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

    public function uploadImage(Request $request)
    {
        $request->validate(['image' => 'required|image|max:2048']);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $path = $request->file('image')->store('whatsapp_attendants', 'public');
            return response()->json([
                'success' => true,
                'path' => $path,
                'url' => asset('storage/' . $path),
            ]);
        }

        return response()->json(['success' => false, 'error' => 'Arquivo inválido'], 422);
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

        // Carregar dados anteriores do banco para preservar imagens existentes
        $oldAttendsJson = Setting::get('whatsapp_widget_attendants', '[]');
        $oldAttendants = json_decode($oldAttendsJson, true) ?: [];

        // Pegar dados textuais do form
        $rawAttendants = $request->input('attendants', []);

        // Construir o array final mesclando antigos + novos
        $attendants = [];
        foreach ($rawAttendants as $index => $att) {
            // Base: dados antigos como fallback (preserva imagem, role, message)
            $base = $oldAttendants[$index] ?? [];

            // Mesclar: dados novos sobrescrevem os antigos (exceto image)
            $merged = array_merge($base, [
                'name' => $att['name'] ?? ($base['name'] ?? ''),
                'role' => $att['role'] ?? ($base['role'] ?? ''),
                'whatsapp' => $att['whatsapp'] ?? ($base['whatsapp'] ?? ''),
                'message' => $att['message'] ?? ($base['message'] ?? ''),
                'image' => $base['image'] ?? null, // sempre preserva imagem antiga
            ]);

            // Se veio imagem nova via hidden field (não vazia), atualiza
            if (!empty($att['image'])) {
                $merged['image'] = $att['image'];
            }

            $attendants[$index] = $merged;
        }

        // Processar uploads de novas imagens (sobrescreve a imagem antiga se houver arquivo)
        if ($request->hasFile('attendants')) {
            foreach ($request->file('attendants') as $index => $attendantFiles) {
                if (isset($attendantFiles['image_upload']) && $attendantFiles['image_upload']->isValid()) {
                    // Deletar imagem antiga do storage se existir
                    if (!empty($attendants[$index]['image'])) {
                        Storage::disk('public')->delete($attendants[$index]['image']);
                    }
                    $path = $attendantFiles['image_upload']->store('whatsapp_attendants', 'public');
                    $attendants[$index]['image'] = $path;
                }
            }
        }

        // Remover atendentes sem nome ou whatsapp
        $attendants = array_values(array_filter($attendants, function ($att) {
            return !empty($att['name']) && !empty($att['whatsapp']);
        }));

        // Salvar todas as configurações
        Setting::set('whatsapp_widget_title', $request->input('title'));
        Setting::set('whatsapp_bg_color', $request->input('widget_bg_color', '#DC2626'));
        Setting::set('whatsapp_text_color', $request->input('widget_text_color', '#ffffff'));
        Setting::set('whatsapp_position', $request->input('widget_position', 'bottom-right'));
        Setting::set('whatsapp_animation', $request->input('widget_animation', 'pulse'));
        Setting::set('whatsapp_widget_attendants', json_encode($attendants));

        return redirect()->back()->with('success', 'Configurações do Atendimento Premium (Widget) salvas com sucesso!');
    }
}
