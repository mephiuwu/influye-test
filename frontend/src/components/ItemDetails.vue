<template>
    <div>
        <modal v-model="modal" :title="'Transacciones de ITEM'">
            <div v-for="record in list" :key="record.id">
                <p>{{record.quantity}} {{stateTransactions(record.details.from, record.details.to)}} (de {{record.details.from}} a {{record.details.to}})</p>
            </div>
			<button class="btnSave" @click="modal=null">Cerrar</button>
        </modal>
    </div>
</template>

<script>
import Modal from './Modal.vue';

export default {
    components: {
		Modal
	},
    data() {
        return {
            modal: null,
			list: [],
        }
    },
    methods: {
        Open(id_item){
            axios.get('transactions/'+id_item).then(res => {
				const {transactions, message, status} = res.data;
                const data = Object.assign({}, transactions);
                this.list = data;
                this.modal = true;
            }).catch(err => {
                console.log(err);
            });
        },
        stateTransactions(from, to) {
            return (from > to) ? 'quitado' : 'agregado'
        },
    },
}
</script>