<x-guest-layout>
    <x-slot name="title">
        {{ config('app.name', 'Laravel') }} - Autorización
    </x-slot>

    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <h2 class="text-3xl text-gray-700 mb-6">Solicitud de autorización</h2>

        <!-- Introduction -->
        <p><strong>{{ $client->name }}</strong> está solicitando permiso para acceder a su cuenta.</p>

        <!-- Scope List -->
        @if (count($scopes) > 0)
            <div class="font-medium text-blue-600">
                <p class="font-bold">A esta aplicación le será posible:</p>

                <ul class="mt-3 list-disc list-inside text-sm text-blue-600">
                    @foreach ($scopes as $scope)
                        <li>{{ $scope->description }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="flex items-center justify-end mt-4">
            <!-- Authorize Button -->
            <form method="POST" action="{{ route('passport.authorizations.approve') }}">
                @csrf

                <input type="hidden" name="state" value="{{ $request->state }}">
                <input type="hidden" name="client_id" value="{{ $client->id }}">
                <input type="hidden" name="auth_token" value="{{ $authToken }}">

                <x-button color="green" class="ml-3">
                    Autorizar
                </x-button>
            </form>

            <!-- Cancel Button -->
            <form method="POST" action="{{ route('passport.authorizations.deny') }}">
                @csrf
                @method('DELETE')

                <input type="hidden" name="state" value="{{ $request->state }}">
                <input type="hidden" name="client_id" value="{{ $client->id }}">
                <input type="hidden" name="auth_token" value="{{ $authToken }}">

                <x-button color="red" class="ml-3">
                    Cancelar
                </x-button>
            </form>
        </div>
    </x-auth-card>
</x-guest-layout>
