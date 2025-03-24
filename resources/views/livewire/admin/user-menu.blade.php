<div class="relative" id="user-menu-component">

    <button id="user-menu-button" class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
        <div class="flex items-center">
            <img class="h-8 w-8 rounded-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&color=7F9CF5&background=EBF4FF" alt="{{ $user->name }}">
            <span class="ml-2">{{ $user->name }}</span>
        </div>
        <div class="ml-1">
            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </div>
    </button>
    <div id="user-menu-dropdown" class="hidden absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50">
        <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
            Perfil
        </a>
        <a href="{{ route('admin.settings') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
            Configurações
        </a>
        <button wire:click="logout" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
            Sair
        </button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Inicializando menu do usuário com JavaScript puro');
        
        const menuButton = document.getElementById('user-menu-button');
        const menuDropdown = document.getElementById('user-menu-dropdown');
        
        if (menuButton && menuDropdown) {
            console.log('Elementos do menu encontrados');
            
            // Função para alternar a visibilidade do dropdown
            function toggleDropdown() {
                console.log('Botão do menu clicado');
                if (menuDropdown.classList.contains('hidden')) {
                    menuDropdown.classList.remove('hidden');
                    console.log('Menu aberto');
                } else {
                    menuDropdown.classList.add('hidden');
                    console.log('Menu fechado');
                }
            }
            
            // Adicionar evento de clique ao botão
            menuButton.addEventListener('click', function(event) {
                event.stopPropagation();
                toggleDropdown();
            });
            
            // Fechar o dropdown quando clicar fora dele
            document.addEventListener('click', function(event) {
                if (!menuButton.contains(event.target) && !menuDropdown.contains(event.target)) {
                    menuDropdown.classList.add('hidden');
                }
            });
        } else {
            console.error('Elementos do menu não encontrados');
        }
    });
</script> 