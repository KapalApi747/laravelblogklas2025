<x-mail::message>
    {{-- Header --}}
    # Nieuw bericht van de website
    <div class="bg-red">
        {{-- Contactgegevens --}}
        Naam: {{ $data['name'] }}
        Email: {{ $data['email'] }}
    </div>


    {{-- Bericht --}}
    Bericht:
    <x-mail::panel>
        {{ $data['message'] }}
    </x-mail::panel>

    Bedankt,<br>
    {{ config('app.name') }}
</x-mail::message>
