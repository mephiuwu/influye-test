<template>
<div>
    <div v-if="value" class="backdrop" @click="Close()">
        <div class="card flex column" @click.stop="">
            <div v-if="title" class="mb10">{{title}}</div>
            <div>
                <slot></slot>

            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    props: {
        title: {
            type: String,
            default: null
        },
        value: {
            type: [Boolean, Object],
            default: null
        }
    },
    data() {
        return {

        }
    },
    methods: {
        Close() {
            this.$emit('input', null);
        }
    }
    
}
</script>

<style>
.backdrop {
    position: absolute;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    background-color: rgba(0,0,0,0.4);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}
.backdrop .card {
    width: 400px;
    max-width: 80%;
    padding: 20px;
}
</style>