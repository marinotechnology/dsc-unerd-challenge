<x-app-layout>
    <x-slot name="header">
        @include('customer.partials.profile-header', ['user' => $user, 'participant' => $participant])
    </x-slot>

    <!-- Riwayat Perlombaan Lari (Livewire Component with Realtime Sync) -->
    <div class="space-y-6">
        <livewire:runner-live-status :show-live-status="false" :show-history="true" />
    </div>
</x-app-layout>
