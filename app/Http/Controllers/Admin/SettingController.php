<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Display all settings grouped.
     */
    public function index()
    {
        // Pluck values by key for easy access in the view
        $settings = Setting::pluck('value', 'key');

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update settings (batch).
     */
    public function update(Request $request)
    {
        $request->validate([
            'settings' => ['nullable', 'array'],
            'settings.*' => ['nullable', 'string'],
            'site_logo' => ['nullable', 'image', 'max:2048'],
            'site_favicon' => ['nullable', 'image', 'mimes:ico,png,svg,jpg,jpeg,gif,webp', 'max:1024'],
            'pwa_icon_192' => ['nullable', 'image', 'mimes:png', 'max:2048'],
            'pwa_icon_512' => ['nullable', 'image', 'mimes:png', 'max:2048'],
        ]);

        // Handle file uploads: [input field name => [setting key, group]]
        $fileFields = [
            'site_logo' => ['site_logo', 'general'],
            'site_favicon' => ['site_favicon', 'general'],
            'logo_white' => ['logo_white', 'general'],
            'pwa_icon_192' => ['pwa_icon_192', 'pwa'],
            'pwa_icon_512' => ['pwa_icon_512', 'pwa'],
        ];

        foreach ($fileFields as $inputName => [$settingKey, $group]) {
            if ($request->hasFile($inputName)) {
                // Delete old file if exists
                $oldValue = Setting::get($settingKey);
                if ($oldValue && Storage::disk('public')->exists($oldValue)) {
                    Storage::disk('public')->delete($oldValue);
                }

                $path = $request->file($inputName)->store('settings', 'public');
                Setting::set($settingKey, $path, $group, 'file');
            }
        }

        // Handle text settings
        foreach ($request->input('settings', []) as $key => $value) {
            $group = $this->guessGroup($key);
            Setting::set($key, $value ?? '', $group);
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Configurações atualizadas com sucesso.'
            ]);
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Configurações salvas com sucesso.');
    }

    /**
     * Guess the setting group based on the key prefix.
     */
    protected function guessGroup(string $key): string
    {
        if (str_starts_with($key, 'pwa_') || in_array($key, ['theme_color', 'background_color']))
            return 'pwa';
        if (str_starts_with($key, 'mail_'))
            return 'email';
        if (str_starts_with($key, 'meta_') || str_starts_with($key, 'google_') || str_starts_with($key, 'gtm_'))
            return 'seo';
        if (in_array($key, ['email', 'phone', 'phone2', 'whatsapp', 'google_maps_embed']))
            return 'contato';
        if (in_array($key, ['mission', 'vision', 'values', 'company_description']))
            return 'general';
        if (in_array($key, ['head_scripts', 'body_scripts', 'custom_css', 'maintenance_mode']))
            return 'avancado';

        return 'general';
    }
}
