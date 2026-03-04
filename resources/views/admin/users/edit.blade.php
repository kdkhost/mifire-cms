@extends('admin.layout')

@section('title', 'Editar Usuário')

@section('content')
<div x-data="userForm()">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Editar Usuário</h1>
            <p class="text-sm text-gray-500 mt-1">{{ $user->name }}</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Voltar
        </a>
    </div>

    <div class="max-w-2xl space-y-6">
        {{-- Dados Pessoais --}}
        <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-4 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 pb-3 border-b border-gray-100">Dados Pessoais</h3>

                {{-- Avatar --}}
                <div x-data="{ preview: '{{ $user->avatar ? asset('storage/' . $user->avatar) : '' }}' }">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Avatar</label>
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center overflow-hidden">
                            <template x-if="preview">
                                <img :src="preview" class="w-full h-full object-cover">
                            </template>
                            <template x-if="!preview">
                                <div class="w-full h-full bg-red-100 flex items-center justify-center text-red-600 font-bold text-xl">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            </template>
                        </div>
                        <label class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50 cursor-pointer transition-colors">
                            Alterar imagem
                            <input type="file" name="avatar" accept="image/*" class="hidden"
                                   @change="const reader = new FileReader(); reader.onload = (e) => preview = e.target.result; reader.readAsDataURL($event.target.files[0]);">
                        </label>
                    </div>
                    @error('avatar') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nome <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-mail <span class="text-red-500">*</span></label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Telefone</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500"
                           placeholder="(00) 00000-0000">
                    @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-4 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 pb-3 border-b border-gray-100">Permissões</h3>
                <div class="flex items-center justify-between">
                    <div>
                        <label class="text-sm font-medium text-gray-700">Administrador</label>
                        <p class="text-xs text-gray-500 mt-0.5">Terá acesso total ao painel</p>
                    </div>
                    <button type="button" @click="isAdmin = !isAdmin"
                            :class="isAdmin ? 'bg-red-600' : 'bg-gray-300'"
                            class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors">
                        <span :class="isAdmin ? 'translate-x-6' : 'translate-x-1'"
                              class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform"></span>
                    </button>
                    <input type="hidden" name="is_admin" :value="isAdmin ? 1 : 0">
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <label class="text-sm font-medium text-gray-700">Ativo</label>
                        <p class="text-xs text-gray-500 mt-0.5">Permite o acesso ao sistema</p>
                    </div>
                    <button type="button" @click="isActive = !isActive"
                            :class="isActive ? 'bg-red-600' : 'bg-gray-300'"
                            class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors">
                        <span :class="isActive ? 'translate-x-6' : 'translate-x-1'"
                              class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform"></span>
                    </button>
                    <input type="hidden" name="is_active" :value="isActive ? 1 : 0">
                </div>
            </div>

            {{-- Info --}}
            <div class="bg-gray-50 rounded-xl border border-gray-200 p-6 mb-6">
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-400 text-xs uppercase tracking-wider">Criado em</span>
                        <p class="text-gray-700 mt-0.5">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <span class="text-gray-400 text-xs uppercase tracking-wider">Último login</span>
                        <p class="text-gray-700 mt-0.5">{{ $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : 'Nunca' }}</p>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-6 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors shadow-sm">
                    Salvar Alterações
                </button>
            </div>
        </form>

        {{-- Alterar Senha --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 pb-3 border-b border-gray-100 mb-4">Alterar Senha</h3>
            <form action="{{ route('admin.users.change-password', $user) }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1">Nova Senha <span class="text-red-500">*</span></label>
                        <input type="password" name="password" id="new_password" required minlength="8"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        @error('password', 'changePassword') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmar Nova Senha <span class="text-red-500">*</span></label>
                        <input type="password" name="password_confirmation" id="new_password_confirmation" required minlength="8"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="px-6 py-2 bg-gray-800 text-white text-sm font-medium rounded-lg hover:bg-gray-900 transition-colors shadow-sm">
                            Alterar Senha
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function userForm() {
        return {
            isAdmin: {{ old('is_admin', $user->is_admin) ? 'true' : 'false' }},
            isActive: {{ old('is_active', $user->is_active) ? 'true' : 'false' }}
        }
    }
</script>
@endpush
@endsection
