<template>
    <div>
        <div class="overflow-auto mt-2" :id="'comment-post-'+postId" style="max-height:200px;">
            <div v-if="getComment">
                <span v-for="comment in comments" v-bind:key="comment.id">
                    <div class="mt-1">
                        <span v-if="comment['user_id'] +'==='+ userId" class="delete-comment pr-4" @click="deleteComment(comment['id'])"></span>
                        <span>
                            <strong>
                                <a class="no-text-decoration black-color" :href="'/profile/'+comment['user_id']">{{ comment['user']['username'] }}</a>
                            </strong>
                        </span>
                        <span>{{ comment['comment'] }}</span>
                    </div>
                </span>
            </div>
        </div>
        <a class="light-color post-time no-text-decoration" :href="'/p/'+postId">{{ created_at }}</a>
        <div v-if="complete" class="balloon1-left" id="hide">
            <p v-text="complete_message"></p>
        </div>
        <hr>
        <div class="row actions" :id="'comment-form-post-'+postId">
            <div class="w-100" id="new_comment">
                <div v-if="error" class="pl-3"><p class="text-danger">{{ errorText }}</p></div>
                <div class="input-group" id="comment">
                    <input v-model="comment" type="text" class="form-control comment-input border-0" name="comment" id="textField" placeholder="コメントを追加 ..." autocomplete="off">
                    <div class="input-group-append">
                        <button class="text-primary btn btn-light" type="submit" :disabled="!activeSubmit" v-on:click="commentSubmit">投稿する</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['postId', 'created_at', 'userId'],
    data() {
        return {
            comment: "",
            error:false,
            complete:false,
            complete_message:"",
            errorText:"",
            comments:[],
        }
    },

    computed: {
        activeSubmit: function() {
            if(this.comment.length > 0 && this.comment.replace(/\s+/g, "").length > 0) {
                return true;
            }else{
                return false;
            }
        },
        getComment() {
            axios.get('/comments/'+this.postId)
            .then(response => {
                this.comments = response.data;
            })
            return true;
        }

    },

    methods: {
        commentSubmit() {
            this.error = false;
            this.complete = false;
            this.errorText = "";
            if(this.comment.replace(/\s+/g, "").length == 0){
                this.errorText = "コメントを入力して下さい";
                this.error = true;
            }else{
                axios.post('/comments/'+ this.postId,{
                    comment: this.comment,
                    post_id: this.postId,
                })
                .then(response => {
                    this.comments = response.data;
                    this.comment = "";
                    this.complete = true;
                    this.complete_message = "投稿が完了しました";
                    setTimeout(this.fadeout, 3000);
                })
            }
        },
        deleteComment(id){
            this.complete = false;
            axios.post('/comments/'+ id + '/delete',{
                post_id: this.postId,
                comment_id: id,
            })
            .then(response => {
                this.comments = response.data;
                this.complete = true;
                this.complete_message="削除が完了しました";
                setTimeout(this.fadeout, 3000);
            })
        },
        fadeout(){
            this.complete = false;
            this.complete_message = "";
        }
    }

}
</script>
