<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <x-mc-modal title="TallStackUi" blur id="modal-id">
                        <div class="space-y-4">
                        <x-mc-input label="Name" icon="users" />
                        <x-mc-input label="Prenom" icon="users" />
                        <x-mc-pin prefix="M-" length="5" />
                        <x-mc-input label="Email" icon="users" />
                        </div>
                        <x-mc-button class="mt-3" x-on:click="$modalClose('modal-id')">
                            Close
                        </x-mc-button>
                    </x-mc-modal>

                    <x-mc-button x-on:click="$modalOpen('modal-id')">
                        Open
                    </x-mc-button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
