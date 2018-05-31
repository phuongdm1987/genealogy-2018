<template>
    <div id="svg-container">
        <tree ref="tree" :identifier="getId" :zoomable="zoomable" :data="treeData" :node-text="nodeText"  :margin-x="Marginx" :margin-y="Marginy" :radius="radius" :type="type" :layout-type="layoutType" :duration="duration" class="tree" @clicked="onClick" @expand="onExpand" @retract="onRetract"/>

        <div class="modal fade" id="personInfoModal" tabindex="-1" role="dialog" aria-labelledby="personInfoModal" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content" v-if="currentNode">
                    <div class="modal-header">
                        <h5 class="modal-title" id="fullName">{{ currentNode.data.full_name }} <i :class="sex"></i></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <nav class="nav nav-pills flex-column flex-sm-row" id="myTab" role="tablist">
                            <a class="flex-sm-fill text-sm-center nav-link active"  id="detail-tab" data-toggle="tab" href="#detail" role="tab" aria-controls="detail" aria-selected="true">Detail</a>
                            <a class="flex-sm-fill text-sm-center nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact</a>
                            <a class="flex-sm-fill text-sm-center nav-link" id="profile-tab" data-toggle="tab" href="#biographical" role="tab" aria-controls="biographical" aria-selected="false">Biographical</a>
                        </nav>
                        <div class="tab-content mt-3" id="myTabContent">
                            <div class="tab-pane fade show active" id="detail" role="tabpanel" aria-labelledby="detail-tab">
                                <form>
                                    <div class="text-center">
                                        <img v-if="currentNode.data.avatar_path" :src="currentNode.data.avatar_path" :alt="currentNode.data.full_name" class="img-thumbnail">
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label text-right">Sex:</label>
                                        <div class="col-sm-9">
                                            <p class="form-control-plaintext"><i :class="sex"></i> {{ currentNode.data.sex_txt }}</p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label text-right">Birth of date:</label>
                                        <div class="col-sm-9">
                                            <p class="form-control-plaintext"><i class="fa fa-birthday-cake fa-lg"></i> {{ currentNode.data.bod }}</p>
                                        </div>
                                    </div>
                                    <div class="form-group row" v-if="currentNode.data.dod">
                                        <label class="col-sm-3 col-form-label text-right">Death of date:</label>
                                        <div class="col-sm-9">
                                            <p class="form-control-plaintext"><i class="fa fa-battery-slash fa-lg"></i> {{ currentNode.data.dod }}</p>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab" v-if="'contact' in currentNode.data">
                                <form>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label text-right">Email:</label>
                                        <div class="col-sm-9">
                                            <p class="form-control-plaintext" v-if="currentNode.data.contact.data.email"><i class="fa fa-at fa-lg"></i> {{ currentNode.data.contact.data.email }}</p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label text-right">Mobile:</label>
                                        <div class="col-sm-9">
                                            <p class="form-control-plaintext" v-if="currentNode.data.contact.data.mobile"><i class="fa fa-mobile fa-lg"></i> {{ currentNode.data.contact.data.mobile }}</p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label text-right">Skype:</label>
                                        <div class="col-sm-9">
                                            <p class="form-control-plaintext" v-if="currentNode.data.contact.data.skype"><i class="fa fa-skype fa-lg"></i> {{ currentNode.data.contact.data.skype }}</p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label text-right">Facebook:</label>
                                        <div class="col-sm-9">
                                            <p class="form-control-plaintext" v-if="currentNode.data.contact.data.facebook_url"><i class="fa fa-facebook-square fa-lg"></i> {{ currentNode.data.contact.data.facebook_url }}</p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label text-right">Address:</label>
                                        <div class="col-sm-9">
                                            <p class="form-control-plaintext" v-if="currentNode.data.contact.data.address"><i class="fa fa-map-signs fa-lg"></i> {{ currentNode.data.contact.data.address }}</p>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="biographical" role="tabpanel" aria-labelledby="biographical-tab" v-if="'biographical' in currentNode.data">
                                <form>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label text-right">Birth place:</label>
                                        <div class="col-sm-9">
                                            <p class="form-control-plaintext" v-if="currentNode.data.biographical.data.birth_place"><i class="fa fa-home fa-lg"></i> {{ currentNode.data.biographical.data.birth_place }}</p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label text-right">Company:</label>
                                        <div class="col-sm-9">
                                            <p class="form-control-plaintext" v-if="currentNode.data.biographical.data.company"><i class="fa fa-suitcase fa-lg"></i> {{ currentNode.data.biographical.data.company }}</p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label text-right">Career:</label>
                                        <div class="col-sm-9">
                                            <p class="form-control-plaintext" v-if="currentNode.data.biographical.data.career"><i class="fa fa-bullhorn fa-lg"></i> {{ currentNode.data.biographical.data.career }}</p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label text-right">School:</label>
                                        <div class="col-sm-9">
                                            <p class="form-control-plaintext" v-if="currentNode.data.biographical.data.school"><i class="fa fa-black-tie fa-lg"></i> {{ currentNode.data.biographical.data.school }}</p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label text-right">Subject:</label>
                                        <div class="col-sm-9">
                                            <p class="form-control-plaintext" v-if="currentNode.data.biographical.data.subject"><i class="fa fa-slideshare fa-lg"></i> {{ currentNode.data.biographical.data.subject }}</p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label text-right">Degree:</label>
                                        <div class="col-sm-9">
                                            <p class="form-control-plaintext" v-if="currentNode.data.biographical.data.degree"><i class="fa fa-graduation-cap fa-lg"></i> {{ currentNode.data.biographical.data.degree }}</p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label text-right">Hobbies:</label>
                                        <div class="col-sm-9">
                                            <p class="form-control-plaintext" v-if="currentNode.data.biographical.data.hobbies"><i class="fa fa-star fa-lg"></i> {{ currentNode.data.biographical.data.hobbies }}</p>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    import {tree} from 'vued3tree'
    import {treeData} from '../../api/tree'
    import {personDetail} from '../../api/person'

    export default {
        name: 'app',
        data () {
            return {
                type: 'tree',
                layoutType: 'euclidean',
                duration: 750,
                Marginx: 30,
                Marginy: 30,
                radius: 5,
                nodeText: 'full_name',
                currentNode: null,
                zoomable: true,
                isLoading: false,
                events: [],
                treeData: null
            }
        },
        components: {
            tree
        },
        mounted () {
            treeData().then(response => {
                this.treeData = response.data;
            });
        },
        watch: {
            currentNode: function() {
                $('#myTab a[href="#detail"]').tab('show');
            }
        },
        computed: {
            sex: function () {
                switch (this.currentNode.data.sex) {
                    case 0:
                        return 'fa fa-mars fa-lg';
                    case 1:
                        return 'fa fa-venus fa-lg';
                    case 2:
                        return 'fa fa-genderless fa-lg';
                }
            }
        },
        methods: {
            do (action) {
                if (this.currentNode) {
                    this.isLoading = true;
                    this.$refs['tree'][action](this.currentNode).then(() => { this.isLoading = false })
                }
            },
            getId (node) {
                return node.id
            },
            expandAll () {
                this.do('expandAll')
            },
            collapseAll () {
                this.do('collapseAll')
            },
            showOnly () {
                this.do('showOnly')
            },
            show () {
                this.do('show')
            },
            onClick (evt) {
                this.currentNode = evt.element;
                this.onEvent('onClick', evt);

                personDetail(this.currentNode.data.id).then(response => {
                    this.currentNode.data = response.data;
                });

                $('#personInfoModal').modal();
            },
            onExpand (evt) {
                this.onEvent('onExpand', evt)
            },
            onRetract (evt) {
                this.onEvent('onRetract', evt)
            },
            onEvent (eventName, data) {
                this.events.push({eventName, data: data.data});
                console.log({eventName, data: data})
            },
            resetZoom () {
                this.isLoading = true;
                this.$refs['tree'].resetZoom().then(() => { this.isLoading = false })
            }
        }
    }
</script>

<style>
    #app {
        font-family: 'Avenir', Helvetica, Arial, sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        /*text-align: center;*/
        color: #2c3e50;
        margin-top: 20px;
    }

    .tree {
        height: 600px;
        width: 100%;
    }

    .graph-root {
        height: 800px;
        width: 100%;
    }

    .log  {
        height: 500px;
        overflow-x: auto;
        overflow-y: auto;
        overflow: auto;
        text-align: left;
    }

</style>
