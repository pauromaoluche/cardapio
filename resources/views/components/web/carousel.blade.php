@props([
    'items' => 0,
])

<div id="carouselImages" class="carousel slide">
    <div class="carousel-indicators">
        @for ($i = 0; $i < $items; $i++)
            <button type="button" data-bs-target="#carouselImages" data-bs-slide-to="{{ $i }}" class="@if ($i === 0) active @endif" aria-current="true"
                aria-label="Slide {{ $i+1 }}"></button>
        @endfor
    </div>
    <div class="carousel-inner">
        {{ $slot }}
    </div>
    <button class="carousel-control-prev carousel-icon-custom" type="button" data-bs-target="#carouselImages" data-bs-slide="prev" wire:ignore>
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next carousel-icon-custom" type="button" data-bs-target="#carouselImages" data-bs-slide="next" wire:ignore>
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
