<template>
    <div>
        <button class="btn btn-primary" @click="addFollower()" :disabled="saving">
            Follow
        </button>
    </div>
</template>

<script>
    export default {
    name : "FriendToggle",
    props : ['userId'],
        mounted() {
        },
        data(){
            return{
            saving: false,
            };
        },
        methods : {
            AddFollower(){
                this.saving = true;
                axios.post('/api/user/${this.userId}/add_friend')
                .then(response => {
                this.saving = false;
                })
                .catch(error => {
                this.saving = false;
                })
            }
        }
    }
</script>
