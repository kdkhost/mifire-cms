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
        $settings = Setting::all()->groupBy('group');

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
            $setting = Setting::where('key', $key)->first();
            if ($setting) {
                $setting->update(['value' => $value]);
            } else {
                Setting::set($key, $value);
            }
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Configurações salvas com sucesso.');
    }
}
