<template>
<div style="margin-top: 40px">
    <div>Total Items: {{itemsTotal}}</div>
    <div class="red">Items con bajo stock: {{itemsWarning}}</div>
</div>
</template>

<script>
export default {
    props: {
        items: {
            type: Array
        }
    },
    data() {
        return {
            
        }
    },
    watch: {
        itemsWarning: function (newValue, oldValue){
            if (newValue > 0) {
                this.$emit("OnWarning", newValue);
            }
        }
    },
    computed: {
        itemsTotal({items}) {
            return items.length;
        },
        itemsWarning({items}) {
            const {length} = items.filter(items => items.quantity <= 0 );
            return length;
        }
    },
}
</script>

<style>

</style>