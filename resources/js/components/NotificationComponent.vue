<template>
    <div class="container">
      
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
            Swal.fire(
                'Good job!',
                'You clicked the button!',
                'success'
            )
        }
    }
</script>
