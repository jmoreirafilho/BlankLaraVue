
import Home from './views/Home.vue';

import Usuarios from './views/usuarios/Search.vue';
import Perfil from './views/perfis/Search.vue';
import Clientes from './views/clientes/Search.vue';

export const routes = [
  { path: '/home', name: 'Início', component: Home },
  { path: '/usuarios', name: 'Usuarios', component: Usuarios },
  { path: '/perfis', name: 'Perfis', component: Perfil },
  { path: '/clientes', name: 'Clientes', component: Clientes }

]