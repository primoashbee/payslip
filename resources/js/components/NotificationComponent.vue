<template>
    <div class="container">
      
    </div>
</template>

<script>
import Pusher from 'pusher-js' // import Pusher

    export default {
        mounted() {
            this.subscribe()
        },
        methods: {
            subscribe(){
                let pusher = new Pusher('ada04ff58e3be4c984d2', { cluster: 'ap1' })
                pusher.subscribe('channel-notifcations')
                pusher.bind('event-notify', data => {
                    Swal.fire(
                        'E-Payslip Success',
                        data.message,
                        'success'
                    )
                })
            }
        }
    }
</script>
