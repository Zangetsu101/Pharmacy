<!-- template for the modal component -->
<template>
    <transition name="fade">
        <div class="my-modal-backdrop">
            <div class="my-modal">
                <div class="d-flex">
                    <button class="btn btn-danger btn-sm ml-auto" v-on:click="$emit('close')">x</button>
                </div>
                <div class="my-container">
                    <slot>Example Modal</slot>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
</script>

<style>
    .my-modal-backdrop {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background-color: rgba(0, 0, 0, 0.3);
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .my-modal {
        background: #FFFFFF;
        border-radius: 5px;
        box-shadow: 2px 2px 20px 1px;
        flex-basis: 50vw;
    }

    .my-container {
        padding: 3vh;
    }

    .fade-enter-active, .fade-leave-active {
    transition: opacity .5s;
    }

    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
    opacity: 0;
    }

</style>
