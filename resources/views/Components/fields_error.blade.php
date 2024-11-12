@props(['name'])
@error($name)
<p class="text-sm text-red-600 font-bold">{{ $message }}</p>
@enderror
