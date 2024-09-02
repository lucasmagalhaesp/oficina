<template>
    <q-btn
        size="lg"
        flat
        dense
        round
        icon="menu"
        aria-label="Menu"
        @click="leftDrawerOpen = !leftDrawerOpen"
    />
    <q-drawer
        v-if="$q.screen.lt.sm"
        v-model="leftDrawerOpen"
        show-if-above
        bordered
        class="bg-cor-padrao1"
    >
      <q-list>
        <q-item-label
            header
            class="menu-mobile text-center"
        >
            <h1 class="text-h4" style="color: #52B240">Oficina 2.0</h1>
        </q-item-label>
        
        <q-separator class="bg-cor-padrao2" />

        <q-item clickable @click="getRota('listagem')">
            <q-item-section avatar>
                <q-icon name="fas fa-list-ol" />
            </q-item-section>
            <q-item-section>Listagem de Orçamentos</q-item-section>
        </q-item>

        <q-separator class="bg-cor-padrao2" />

        <q-item clickable @click="getRota('criar')">
            <q-item-section avatar>
                <q-icon name="fas fa-clipboard" />
            </q-item-section>
            <q-item-section>Cadastrar Orçamento</q-item-section>
        </q-item>

        <q-separator class="bg-cor-padrao2" />

      </q-list>
    </q-drawer>
</template>

<script>
import { router } from "@inertiajs/vue3"
export default {
    data(){
        return {
            leftDrawerOpen: false
        }
    },
    methods:{
        getRota(id){
            let link = "";
            switch(id){
                case "listagem":
                    link = "/orcamentos/listagem";
                    break;
                case "criar":
                    link = "/orcamentos/criar";
                    break;
                default:
                    link = "/";
            }

            this.leftDrawerOpen = false;
            router.visit(link);
        }
    },
}
</script>
<style scoped>
    .q-btn-item >>> .q-icon{
        font-size: inherit
    }

    .q-item__section >>> .q-icon{
        font-size: inherit !important;
        color: #52B240 !important
    }
</style>