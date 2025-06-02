@props(['href'])

@php
	$isActive = request()->url() == url($href);
@endphp

<a href="{{ $href }}"
		{{ $attributes->merge([
				'class' => 'nav-link link-body-emphasis px-2' . ($isActive ? ' active fw-bold text-primary' : '')
		]) }}>
	{{ $slot }}
</a>
