<template>
  <div id="app">

	<div class="flex" style="margin-bottom: 40px">
		<button @click="modalCreate=true">Crear Item</button>
	</div>
	  	
	<div v-for="item in items" :key="item.id" class="card selectable mb10 flex" :class="redClass(item)" @click="modalOptions=item">
		<div class="flex-fill">{{item.title}}</div>
		<div>{{item.quantity}} {{item.unit? item.unit : null }}</div>
	</div>
	
	<items-summary :items="items" @OnWarning="Warning"></items-summary>

	<modal v-model="modalOptions">
		<div class="flex column" v-if="modalOptions">
			<button class="mb10" @click="modalStock=modalOptions, modalOptions=false">Agregar o quitar {{modalOptions.title}}</button>
			<button class="mb10" @click="OpenItemDetails(modalOptions.id)">Ver transacciones de {{modalOptions.title}}</button>
			<button @click="deleteItem(modalOptions.id)">Eliminar item {{modalOptions.title}}</button>
		</div>
	</modal>

	<modal v-model="modalCreate" :title="'Nuevo ítem'">
		<div class="flex column" v-if="modalCreate">
			<input v-model="title" type="text" class="form-control mb10" placeholder="Título">
			<input v-model="unit" type="text" class="form-control mb10" placeholder="Unidad de medida">
			<button class="btnSave" @click="saveItem()">guardar</button>
		</div>
	</modal>

	<modal v-model="modalStock" :title="'Agregar ITEM'">
		<div class="flex column" v-if="modalStock">
			<input v-model="stock" type="number" class="form-control mb10" placeholder="Unidad">
			<button class="btnSave" @click="addStock(modalStock.id)">guardar</button>
		</div>
	</modal>

	<modal v-model="modalWarning">
		<div v-if="modalWarning">Hay {{modalWarning.count}} items con bajo stock</div>
	</modal>

	<item-details ref="itemDetails"></item-details>
  </div>
</template>

<script>
import Modal from './components/Modal.vue';
import ItemsSummary from './components/ItemsSummary.vue';
import ItemDetails from './components/ItemDetails.vue';

export default {
	name: 'App',
	components: {
		Modal, ItemsSummary, ItemDetails
	},
	data() {
		return {
			items: [],
			modalOptions: null,
			modalWarning: null,
			modalCreate: null,
			modalStock: null,
			title: null,
			unit: null,
			stock: null
		}
	},
	mounted() {
		axios.get('items').then(res => {
			this.items = res.data;
		}).catch(err => {
			console.log(err);
		});
	},
	methods: {
		saveItem(){
			axios.put('item',{
                'title':this.title,
                'unit':this.unit,
            }).then((res) => {
				const {items, message, status} = res.data;
				if (status) {
					this.items = items;
				}
				alert(message);
				this.modalCreate = false;
				this.title = null;
				this.unit = null;
            })
            .catch(function (error) {
                console.log(error);
            });
		},
		deleteItem(idItem){
			if (confirm('¿Seguro que deseas borrar este ítem?')) {
				axios.delete('item/' + idItem).then(res => {
					const {items, message, status} = res.data;
					if (status) {
						this.items = items;
					}
					alert(message);
					this.modalOptions = false;
				}).catch(err => {
					console.log(err);
				});
			}
		},
		addStock(idItem){
			if (this.stock == 0) {
				alert('Error, la cantidad ingresada es 0.');
				return;
			}

			axios.put('item/'+idItem+'/stock',{
                'quantity':this.stock,
            }).then((res) => {
				const {items, message, status} = res.data;
				if (status) {
					this.items = items;
				}
				alert(message);
				this.modalStock = false;
				this.stock = null;
            })
            .catch(function (error) {
                console.log(error);
            });
		},
		redClass(item) {
			return (item.quantity <= 0) ? 'red' : null;
		},
		Warning(itemsNumber)
		{
			this.modalWarning = {count: itemsNumber};
		},
		OpenItemDetails(idItem){
			this.$refs.itemDetails.Open(idItem);
			this.modalOptions = null;
		}
	}
}
</script>

<style>
html, body {
	background-color: #f7f8f9;
}

#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  color: #2c3e50;
  padding: 20px;
}

.flex {
	display: flex;
}
.column {
	flex-direction: column;
}
.flex-fill {
	flex: 1 1 auto;
}

.mb10 {
	margin-bottom: 10px;
}

.secondary-text {
	color: #AAA;
}
.red {
	color: red;
}

.card {
	padding: 10px; 
	border-radius: 10px;
	box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.2);
	background: white;
	
}
.card.selectable {
	cursor: pointer;
}
.card.selectable:hover {
	outline: 2px solid #2c3e50;
}

.btnSave{
	border-radius: 20px;
	padding-top: 10px;
	padding-bottom: 10px;
	width: 100px;
}

</style>
