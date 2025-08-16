<div class="login-container">
    <div class="login-card">
        <div class="logo-section">
            <div class="logo">
                <i class="bi bi-shop"></i>
            </div>
            <h1 class="logo-text">FoodAdmin</h1>
            <p class="logo-subtitle">Faça login para continuar</p>
        </div>

        <form id="loginForm" wire:submit.prevent="login">
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <div class="input-group">
                    <i class="bi bi-envelope input-group-icon"></i>
                    <input type="email" id="email" name="email" class="form-control" placeholder="seu@email.com"
                        wire:model.defer="email">
                </div>
                @error('email')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Senha</label>
                <div class="input-group">
                    <i class="bi bi-lock input-group-icon"></i>
                    <input type="password" id="password" name="password" class="form-control" placeholder="••••••••"
                        wire:model.defer="password">
                </div>
                @error('password')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            @error('validation')
                <div class="alert alert-danger" id="errorAlert">
                    <i class="bi bi-exclamation-circle"></i>
                    <span id="errorMessage">{{ $message }}</span>
                </div>
            @enderror

            <div class="checkbox-group">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Lembrar-me</label>
            </div>

            <button type="submit" class="btn btn-primary" id="loginBtn">
                <span class="btn-text">Entrar</span>
            </button>
        </form>
    </div>
</div>
