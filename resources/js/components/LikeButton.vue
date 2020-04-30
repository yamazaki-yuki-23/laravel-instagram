<template>
    <div>
        <div v-if="button_check" class="balloon2-left" id="hide">
            <p v-text="message"></p>
        </div>
        <div class="row pl-3">
            <a v-if="status" class="loved hide-text" data-remote="true" @click="delUser">いいねを取り消す</a>
            <a v-else class="love hide-text" data-remote="true" @click="addUser">いいね</a>
            <a v-if="fromLink" class="comment" :href="'/p/'+postId"></a>
            <a v-else class="comment" data-remote="true" href="javascript:focusMethod();"></a>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['userId', 'postId', 'likes', 'fromLink'],

        data() {
            return {
                status: this.likes,
                post: [],
                button_check: false,
                message: "",
            }
        },

        methods: {
            addUser() {
                this.button_check = false;
                this.message = "";
                axios.post('/like/add/' + this.postId)
                .then(response => {
                    this.status = ! this.status;
                    this.button_check = true;
                    this.message = "いいねが押されました";
                    setTimeout(this.fadeout, 3000);
                })
                .catch(errors => {
                    if (errors.response.status == 401) {
                        window.location = '/login';
                    }
                });
            },

            delUser() {
                this.button_check = false;
                this.message = "";
                axios.post('/like/remove/' + this.postId)
                .then(response => {
                    this.status = ! this.status;
                    this.button_check = true;
                    this.message = "いいねが取り消しされました";
                    setTimeout(this.fadeout, 3000);
                })
                .catch(errors => {
                    if (errors.response.status == 401) {
                        window.location = '/login';
                    }
                });
            },
            fadeout(){
                this.button_check = false;
                this.message = "";
            }
        }

    }
</script>
