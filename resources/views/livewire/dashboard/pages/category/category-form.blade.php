<div>
    @if (session()->has('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @elseif (session()->has('error'))
        <div class="alert alert-danger mt-3">
            {{ session('error') }}
        </div>
    @endif
    <div class="card">
        <div class="card-header bg-custom text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-tags me-2"></i>
                {{ $category ? 'Editar' : 'Criar' }} Categoria
            </h5>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="save">
                <div class="mb-3">
                    <label for="name" class="form-label">
                        Nome <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control" id="name" placeholder="Ex: Lanches"
                        wire:model.live="form.name">
                    @error('form.name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="d-flex justify-content-end">
                    <x-btn-group-form route="{{ route('dashboard.category') }}" />
                </div>
            </form>
        </div>
    </div>
</div>
