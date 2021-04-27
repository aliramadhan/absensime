<div x-data class="flex flex-col p-2">
    <input
        x-ref="input"
        type="text"
        class="m-1 text-sm leading-2 flex-grow form-input py-1 "
        wire:change="doTextFilter('{{ $index }}', $event.target.value)"
        x-on:change="$refs.input.value = ''"
    />
    <div class="flex flex-wrap max-w-48 space-x-1">
        @foreach($this->activeTextFilters[$index] ?? [] as $key => $value)
        <button wire:click="removeTextFilter('{{ $index }}', '{{ $key }}')" class="m-1 pl-2 flex items-center uppercase tracking-wide bg-gray-500 text-white hover:bg-red-600 rounded-full focus:outline-none text-xs space-x-1">
            <span>{{ $this->getDisplayValue($index, $value) }}</span>
            <x-icons.x-circle />
        </button>
        @endforeach
    </div>
</div>
