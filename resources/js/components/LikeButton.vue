<template>
    <div>
        <a v-if="status" class="loved hide-text" data-remote="true" @click="delUser">いいねを取り消す</a>
        <a v-else class="love hide-text" data-remote="true" @click="addUser">いいね</a>
    </div>
</template>

<script>
    export default {
        props: ['userId', 'postId', 'likes'],

        mounted() {
            console.log('Component mounted.')
        },

        data() {
            return {
                status: this.likes,
                post: [],
            }
        },

        methods: {
            addUser() {
                axios.post('/like/add/' + this.postId)
                .then(response => {
                    this.status = ! this.status;

                    console.log(response.data);
                })
                .catch(errors => {
                    if (errors.response.status == 401) {
                        window.location = '/login';
                    }
                });
            },

            delUser() {
                axios.post('/like/remove/' + this.postId)
                .then(response => {
                    this.status = ! this.status;

                    console.log(response.data);
                })
                .catch(errors => {
                    if (errors.response.status == 401) {
                        window.location = '/login';
                    }
                });
            }
        }

    }
</script>
