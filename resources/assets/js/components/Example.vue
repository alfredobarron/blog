<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                            <textarea rows="2" class="form-control" v-model="post" v-show="type == 1" placeholder="¿Que quieres publicar?"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="url" class="form-control" v-model="post" v-show="type == 2" placeholder="Escribe la url de la imagen">
                        </div>
                        <div class="form-group">
                            <input type="url" class="form-control" v-model="post" v-show="type == 3" placeholder="Escribe la url del video">
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <a href="#" class="btn btn-default" @click="toogle(1)">
                                    <span class="glyphicon glyphicon-font" aria-hidden="true"></span>
                                </a>
                                <a href="#" class="btn btn-default" @click="toogle(2)">
                                    <span class="glyphicon glyphicon-picture" aria-hidden="true"></span>
                                </a>
                                <a href="#" class="btn btn-default" @click="toogle(3)">
                                    <span class="glyphicon glyphicon-facetime-video" aria-hidden="true"></span>
                                </a>
                            </div>
                            <div class="col-xs-6 text-right">
                                <button type="button" class="btn btn-default" @click="publish">Publicar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" v-for="post in posts">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <p class="lead" v-show="post.type == 1">{{post.post}}</p>
                        <div class="embed-responsive embed-responsive-4by3" v-show="post.type == 3">
                            <iframe class="embed-responsive-item" :src="post.post"></iframe>
                        </div>
                        <img class="img-responsive" v-show="post.type == 2" :src="post.post">
                    </div>

                    <div class="panel-footer">
                        <span class="glyphicon glyphicon-heart" aria-hidden="true"></span>
                        <small>{{post.user.name}}</small>
                        <small class="pull-right">{{post.created_at | ago}}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import moment from 'moment';
    export default {
        data() {
            return {
                posts: [],
                post: null,
                type: 1
            }
        },
        mounted() {
            this.getAll();
        },
        filters: {
            ago(date) {
                return moment(date).fromNow();
            }
        },
        methods: {
            getAll: function () {
                axios.get('/post')
                .then(response => {
                    console.log(response);
                    this.posts = response.data;
                });
            },
            publish: function () {
                axios.post('/post/store', {
                    post: this.post,
                    type: this.type
                })
                .then(response => {
                    this.posts.unshift(response.data);
                    this.post = null;
                    this.type = 1;
                });
            },
            toogle: function (type) {
                this.type = type;
            }
        }
    }
</script>
