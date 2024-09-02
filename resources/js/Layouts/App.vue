<template>
  <q-layout view="hHh lpR fFf">

    <q-header elevated class="bg-blue-grey-13 text-white q-px-lg" height-hint="98">
      <q-toolbar :style="$q.screen.lt.sm ? 'padding: 0' : ''">
            <!-- <q-avatar>
              <img :src="`${caminhoURL}imagens/logo.png`">
            </q-avatar> -->
          <h6 style="margin: 0" :class="$q.screen.lt.sm ? 'nome-empresa' : ''">Oficina 2.0</h6>
        <q-space />
        <template v-if="!$q.screen.lt.sm">
          <q-tabs no-caps inline-label class="desktop-only">
            <q-btn flat no-caps stretch label="Home" @click="getRota('home')" icon="fas fa-home" />
            <q-btn flat no-caps stretch label="Listar Orçamentos" @click="getRota('listagem')" icon="fas fa-list-ol" />
            <q-btn flat no-caps stretch label="Cadastrar Orçamento" @click="getRota('criar')" icon="fas fa-list-ol" />
          </q-tabs>
          <q-space />
        </template>
        <template v-else>
          <!-- <MenuMobile v-if="logado" @fazerLogout="logout" /> -->
        </template>
      </q-toolbar>
    </q-header>


    <q-page-container>
      <!-- <router-view /> -->
      <q-page>
        <slot />
      </q-page>
    </q-page-container>

    <q-footer elevated class="bg-blue-grey-5 text-white q-px-lg">
      <q-toolbar>
        <q-toolbar-title v-if="!$q.screen.lt.sm && !logado">
            Oficina 2.0
        </q-toolbar-title>
        <q-toolbar-title v-if="!$q.screen.lt.sm" class="justify-center text-subtitle2">
            Copyright {{ new Date().getFullYear() }} - Todos os direitos reservados
        </q-toolbar-title>

        <q-toolbar-title class="text-white justify-center" :class="$q.screen.lt.sm ? 'text-center' : 'text-right'">
            
        </q-toolbar-title>
      </q-toolbar>
    </q-footer>

  </q-layout>
</template>

<script>
import { usePage, router, Link } from "@inertiajs/vue3"
export default {
  methods:{
    getRota(id){
      let link = "";
      switch(id){
        case "home":
          link = "/";
          break;
        case "listagem":
          link = "/orcamentos/listagem";
          break;
        case "criar":
          link = "/orcamentos/criar";
          break;
        default:
          link = "/";
      }

      router.visit(link);
    }
  }
}
</script>

<style scoped>
  .nome-empresa{
    font-size: 0.9em;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
  .q-btn-item >>> .q-icon{
      font-size: inherit
  }
</style>