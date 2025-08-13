document.addEventListener('livewire:initialized', () => {

    Livewire.on('swal:message', (event) => {
        const data = event[0];
        Swal.fire({
            title: data.title || 'Atenção!',
            text: data.text || '',
            icon: data.icon || 'info',
            confirmButtonText: data.confirmButtonText || 'Ok'
        });
    });

    Livewire.on('swal:confirm', (event) => {
        const data = event[0];
        Swal.fire({
            title: data.title || 'Tem certeza?',
            text: data.text || 'Você não poderá reverter isso!',
            icon: data.icon || 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: data.confirmButtonText || 'Sim, continuar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch([data.onConfirmedEvent], [data.onConfirmedParams] || {});
            }
        });
    });
});
