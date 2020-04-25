<template>
    <div class="input-group" id="comment">
        <input v-model="comment" type="text" class="form-control comment-input border-0" name="comment" id="textField" placeholder="コメントを追加 ..." autocomplete="off" @keyup="activeSubmit">
        <div class="input-group-append">
            <button class="text-primary btn btn-light" type="submit" :disabled="!activeSubmit">投稿する</button>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            comment: "",
        }
    },

    mounted() {
        this.comment
    },

    computed: {
        activeSubmit: function() {
            if(this.comment.length > 0 && this.comment.replace(/\s+/g, "").length > 0) {
                return true;
            }else{
                return false;
            }
        }
    }

}
</script>
