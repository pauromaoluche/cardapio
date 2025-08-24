<footer class="bg-orange text-white pt-4 pb-3">
    <div class="container">
        <div class="row">
            <!-- Informações da Lanchonete -->
            <div class="col-md-6 mb-3">
                <h5 class="font-weight-bold">Lanchonete do Chef</h5>
                <p class="mb-1"><strong>Email:</strong> {{ config_get('email') }}</p>
                <p class="mb-1"><strong>Telefone:</strong> {{ config_get('phone') }}</p>
                <p class="mb-0"><strong>Endereço:</strong> {{ config_get('address') }}</p>
            </div>

            <!-- Informações da Empresa Desenvolvedora -->
            <div class="col-md-6 mb-3 text-md-right">
                <h5 class="font-weight-bold">Desenvolvido por</h5>
                <p class="mb-1"><strong>Nome:</strong> Pedro Pauluci</p>
                <p class="mb-1"><strong>Email:</strong> desenvpauluci@gmail.com</p>
            </div>
        </div>

        <hr class="border-light">

        <!-- Copyright -->
        <div class="text-center">
            <small>&copy; 2025 Lanchonete do Chef - Todos os direitos reservados</small>
        </div>
    </div>
</footer>
