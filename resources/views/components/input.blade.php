@props(['type' => 'text', 'id', 'name', 'placeholder', 'value' => null, 'class' => ''])

<input type="{{$type}}" id="{{$id}}" placeholder="{{$placeholder}}" name="{{$name}}" value="{{$value ?? ''}}"
       class="input-field bg-slate-900 border-slate-800 text-slate-100 placeholder:text-slate-500 focus-visible:ring-indigo-500 dark:bg-input/30 border-input selection:bg-primary selection:text-primary-foreground focus:border-indigo-500 {{$class}}">
