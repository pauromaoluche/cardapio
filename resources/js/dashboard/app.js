
import '../bootstrap';
import './bootstrap';
import 'bootstrap';
import './sweetalert-listeners';


window.initSidebarToggle = function() {
        const toggleBtn = document.querySelector('.sidebar-toggle');
        const mainContent = document.querySelector('.main-content');
        const sidebar = document.getElementById('sidebar');

        handleSidebarToggle();
        function handleSidebarToggle() {
            sidebar.classList.toggle('close-sidebar');
            mainContent.classList.toggle('full-width');
        }
}

function verifyResolution() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.querySelector('.main-content');
      const resolution = 1024;

    if (window.innerWidth <= resolution) {
        sidebar.classList.add('close-sidebar');
        mainContent.classList.add('full-width');
    } else {
    sidebar.classList.remove('close-sidebar');
    mainContent.classList.remove('full-width');
  }
}

document.addEventListener('click', (event) => {
     const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.querySelector('.sidebar-toggle');
    const resolutionForClose = 799;

      if (window.innerWidth <= resolutionForClose &&
        !sidebar.classList.contains('close-sidebar') &&
        !sidebar.contains(event.target) &&
        !toggleBtn.contains(event.target)) {

        initSidebarToggle();
    }
});

document.addEventListener('livewire:navigated', () => {
    // 1. Chama a verificação de resolução
    verifyResolution();

    // 2. Adiciona a lógica para fechar a sidebar
    // const sidebar = document.getElementById('sidebar');
    // const mainContent = document.querySelector('.main-content');

    // // Se a sidebar não estiver fechada, ela será fechada.
    // if (!sidebar.classList.contains('close-sidebar')) {
    //     sidebar.classList.add('close-sidebar');
    //     mainContent.classList.add('full-width');
    // }
});



document.addEventListener('DOMContentLoaded', verifyResolution);

window.addEventListener('resize', verifyResolution);
