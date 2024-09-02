<template>
  <q-layout view="hHh lpR fFf">

    <q-header elevated class="bg-cor-padrao1 q-px-lg" height-hint="98">
      <q-toolbar :style="$q.screen.lt.sm ? 'padding: 0' : ''">
          <h6 style="margin: 0; color: #52B240" :class="$q.screen.lt.sm ? 'nome-empresa' : ''">Oficina 2.0</h6>
        <q-space />
        <template v-if="!$q.screen.lt.sm">
          <q-tabs no-caps inline-label class="desktop-only menu">
            <!-- <q-btn flat no-caps stretch label="Home" @click="getRota('home')" icon="fas fa-home" /> -->
            <q-btn flat no-caps stretch label="Listar Orçamentos" @click="getRota('listagem')" icon="fas fa-list-ol" />
            <q-btn flat no-caps stretch label="Cadastrar Orçamento" @click="getRota('criar')" icon="fas fa-clipboard" />
          </q-tabs>
          <q-space />
        </template>
        <template v-else>
          <MenuMobile />
        </template>
      </q-toolbar>
    </q-header>


    <q-page-container>
      <q-page>
        <slot />
      </q-page>
    </q-page-container>

    <q-footer elevated class="bg-cor-padrao2 q-px-lg">
      <q-toolbar>
        <q-toolbar-title v-if="!$q.screen.lt.sm && !logado">
            Oficina 2.0
        </q-toolbar-title>
        <q-toolbar-title class="text-subtitle2" :class="$q.screen.lt.sm ? 'text-center' : 'text-right'">
            Copyright {{ new Date().getFullYear() }} - Todos os direitos reservados
        </q-toolbar-title>
      </q-toolbar>
    </q-footer>

  </q-layout>
</template>

<script>
import { router } from "@inertiajs/vue3"
import MenuMobile from "./MenuMobile.vue"
export default {
  components:{ MenuMobile },
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
    font-size: 1.6em;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
  .q-btn-item >>> .q-icon{
      font-size: inherit
  }
</style>