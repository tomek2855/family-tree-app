<div class="mt-4">
    <label for="form-{{ $input->name }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">
        @if($input->getAttribute('placeholder'))
            {{ $input->getAttribute('placeholder') }}

            @if($input->getAttribute('required'))
                <span class="text-red-500">*</span>
            @endif
        @endif
    </label>

    <select
        id="form-{{ $input->name }}"
        name="{{ $input->name }}"
        class="w-1/3 {{ $input->class }}"
        @if($input->value)value="{{ $input->value }}" @endif
        @if($input->getAttribute('placeholder'))placeholder="{{ $input->getAttribute('placeholder') }}"@endif
        @if($input->getAttribute('required'))required="{{ $input->getAttribute('required') }}"@endif
    >
        @foreach($input->getOptions() as $key => $option)
            <option value="{{ $key }}">{{ $option }}</option>
        @endforeach
    </select>

    @error($input->name)
    <div>
        <span class="text-red-500">{{ $message }}</span>
    </div>
    @enderror
</div>
