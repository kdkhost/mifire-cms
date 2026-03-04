@extends('admin.layout')

@section('title', 'Editar Endereço')

@section('content')
    <div x-data="addressForm()">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Editar Endereço</h1>
                <p class="text-sm text-gray-500 mt-1">{{ $address->label }}</p>
            </div>
            <a href="{{ route('admin.addresses.index') }}"
                class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Voltar
            </a>
        </div>

        <form action="{{ route('admin.addresses.update', $address) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="max-w-2xl space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-4">
                    <div>
                        <label for="label" class="block text-sm font-medium text-gray-700 mb-1">Rótulo <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="label" id="label" value="{{ old('label', $address->label) }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        @error('label') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Endereço <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="address" id="address" value="{{ old('address', $address->address) }}"
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500"
                            placeholder="Rua, número (Deixe vazio ou use '.' para Departamentos)">
                        @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="complement" class="block text-sm font-medium text-gray-700 mb-1">E-mail do Setor / Complemento</label>
                        <input type="text" name="complement" id="complement"
                            value="{{ old('complement', $address->complement) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500"
                            placeholder="ex: comercial@exemplo.com.br ou Sala 101">
                        @error('complement') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700 mb-1">Cidade <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="city" id="city" value="{{ old('city', $address->city) }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            @error('city') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="state" class="block text-sm font-medium text-gray-700 mb-1">Estado <span
                                    class="text-red-500">*</span></label>
                            <select name="state" id="state" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">
                                <option value="">Selecione</option>
                                @foreach(['AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO'] as $uf)
                                    <option value="{{ $uf }}" {{ old('state', $address->state) === $uf ? 'selected' : '' }}>
                                        {{ $uf }}</option>
                                @endforeach
                            </select>
                            @error('state') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="zip_code" class="block text-sm font-medium text-gray-700 mb-1">CEP <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="zip_code" id="zip_code"
                                value="{{ old('zip_code', $address->zip_code) }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                placeholder="00000-000" data-mask="cep">
                            @error('zip_code') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Telefone</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone', $address->phone) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                placeholder="(00) 0000-0000" data-mask="phone">
                            @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="phone2" class="block text-sm font-medium text-gray-700 mb-1">WhatsApp / Celular</label>
                            <input type="text" name="phone2" id="phone2" value="{{ old('phone2', $address->phone2) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                placeholder="(00) 00000-0000" data-mask="phone">
                            @error('phone2') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="text-sm font-medium text-gray-700">Ativo</label>
                        <button type="button" @click="isActive = !isActive" :class="isActive ? 'bg-red-600' : 'bg-gray-300'"
                            class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors">
                            <span :class="isActive ? 'translate-x-6' : 'translate-x-1'"
                                class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform"></span>
                        </button>
                        <input type="hidden" name="is_active" :value="isActive ? 1 : 0">
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="px-6 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors shadow-sm">
                        Salvar Alterações
                    </button>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            function addressForm() {
                return { isActive: {{ old('is_active', $address->is_active) ? 'true' : 'false' }} }
            }
        </script>
    @endpush
@endsection