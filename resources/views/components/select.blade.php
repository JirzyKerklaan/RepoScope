@php
    $baseClasses = "input-field w-fit! pl-4! bg-slate-900 border-slate-800 text-slate-100 placeholder:text-slate-500 focus-visible:ring-indigo-500 dark:bg-input/30 border-input selection:bg-primary selection:text-primary-foreground focus:border-indigo-500";
    $classes = trim(($class ?? '') . ' ' . $baseClasses);
@endphp

<select name="{{ $name }}" id="{{ $name }}" {{ $attributes->merge(['class' => $classes]) }}>
    @foreach($options as $value => $label)
        <option value="{{ $value }}" @selected($value == $selected)>{{ $label }}</option>
    @endforeach
</select>
