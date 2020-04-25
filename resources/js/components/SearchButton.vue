<template>
    <div class="col-10 offset-1" :key="activateSubmit">
        <div class="form-group">
            <label for="category">検索カテゴリー</label>
            <select class="form-control" v-model="category">
                <option disabled value="">選択してください</option>
                <option>ユーザー名</option>
                <option>タグ</option>
            </select>
        </div>
        <div class="form-group">
            <label for="name">キーワード</label>
            <input class="form-control" type="search" placeholder="検索キーワードを入力してください" aria-label="Search" v-model="keyword">
        </div>
        <h4 class="text-danger mt-3">{{ alert }}</h4>
        <div v-if="status">
            <div class="row" v-if="category === 'タグ'">
                <div class="col-4 pt-4" v-for="item in items" :key="item.id">
                    <a :href="'p/'+item.id">
                        <img :src="'/storage/'+item.image"  class="w-100">
                    </a>
                </div>
            </div>
            <div v-else>
                <div class="pt-4">
                    <table class="table table-hover">
                        <tr><th>#</th><th>ユーザー名</th><th>アイコン</th></tr>
                        <tr v-for="(item, index) in items" :key="item.id">
                            <td>{{ index + 1 }}</td>
                            <td>
                                <a :href="'profile/'+item.id" class="card-link">
                                    <img v-if="item.profile['image']" :src="'/storage/'+item.profile['image']" class="post-profile-icon round-img">
                                    <img v-else src="/storage/profile/Psy0tMpnjUQIbumb25Csi1XLLdhLV2QWT2R3K4Zh.jpeg" class="post-profile-icon round-img">
                                </a>
                            </td>
                            <td><a class="card-link" :href="'profile/'+item.id">{{ item.username }}</a></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
    export default {
        data() {
            return {
                keyword: '',
                category: '',
                alert: '',
                status: false,
                items: [],
            }
        },

        beforeCreate(){
            keyword="";
            category="";
        },

        computed: {
            activateSubmit() {
                //カテゴリーとキーワードに値が入っているかどうかのチェック
                if(this.category.length > 0 && this.keyword.length > 0){
                    this.search();
                }else{
                    this.status = false;
                }
            }
        },

        methods: {
            search(){
                this.status = false;
                axios.post('/search/keyword',{
                    category: this.category,
                    keyword: this.keyword,
                })
                .then(response => {
                    this.items = response.data;
                    this.alert = "";
                    console.log(this.items);
                    //返却データが空の場合は、警告文を表示する
                    if(this.items.length == 0){
                        this.status = false;
                        this.alert = "一致する結果はありませんでした。";
                    }else{
                        this.status = true;
                        // console.log(this.items);
                    }
                })
                .catch(errors => {
                    if(errors.response.status == 500) {
                        this.alert = "エラーが発生しました";
                    }
                })
            },
        },
    }
</script>
