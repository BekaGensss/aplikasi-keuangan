<section class="space-y-6 p-6 bg-white rounded-3xl soft-shadow animate-fadeIn delay-100">
    <header>
        <h2 class="text-2xl font-bold text-gray-900">
            {{ __('Hapus Akun Anda') }}
        </h2>

        <p class="mt-2 text-sm text-gray-600">
            {{ __('Setelah akun Anda dihapus, semua sumber daya dan data yang terkait akan terhapus secara permanen. Sebelum melanjutkan, harap unduh data atau informasi yang ingin Anda simpan.') }}
        </p>
    </header>

    <x-danger-button
        class="py-3 px-6 rounded-xl font-bold transition-all duration-300 transform active:scale-95"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Hapus Akun') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8">
            @csrf
            @method('delete')

            <div class="text-center">
                <h2 class="text-2xl font-bold text-gray-900">
                    {{ __('Anda yakin ingin menghapus akun Anda?') }}
                </h2>

                <p class="mt-2 text-sm text-gray-600">
                    {{ __('Setelah akun Anda dihapus, semua sumber daya dan data akan terhapus secara permanen. Silakan masukkan kata sandi Anda untuk mengonfirmasi.') }}
                </p>
            </div>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Kata Sandi') }}" class="sr-only" />

                <div class="relative">
                    <x-text-input
                        id="password"
                        name="password"
                        type="password"
                        class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:ring-indigo-500 focus:border-indigo-500 transition duration-300"
                        placeholder="{{ __('Kata Sandi') }}"
                    />
                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')" class="py-3 px-6 rounded-xl font-semibold transition-all duration-300 transform active:scale-95">
                    {{ __('Batal') }}
                </x-secondary-button>

                <x-danger-button class="ms-3 py-3 px-6 rounded-xl font-bold transition-all duration-300 transform active:scale-95">
                    {{ __('Hapus Akun') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>