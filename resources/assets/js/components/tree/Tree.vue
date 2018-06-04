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

                        <!-- Tab nav -->
                        <nav class="nav nav-pills flex-column flex-sm-row" id="myTab" role="tablist">
                            <a class="flex-sm-fill text-sm-center nav-link active"  id="detail-tab" data-toggle="tab" href="#detail" role="tab" aria-controls="detail" aria-selected="true">Detail</a>
                            <a class="flex-sm-fill text-sm-center nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact</a>
                            <a class="flex-sm-fill text-sm-center nav-link" id="profile-tab" data-toggle="tab" href="#biographical" role="tab" aria-controls="biographical" aria-selected="false">Biographical</a>
                        </nav>

                        <!-- Tab content -->
                        <div class="tab-content" id="myTabContent">
                            <div v-if="response" class="alert alert-dismissible fade show mt-3" :class="'alert-' + response.status" role="alert">
                                {{ response.message }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close" @click="resetResponse">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="text-center mt-3 mb-3">
                                <img v-if="currentNode.data.avatar_path" :src="currentNode.data.avatar_path" :alt="currentNode.data.full_name" class="img-thumbnail">
                            </div>

                            <!-- Personal detail -->
                            <div class="tab-pane fade show active" id="detail" role="tabpanel" aria-labelledby="detail-tab">
                                <form @submit.prevent="validateBeforeSubmit" name="person" enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label text-right">Sex <i :class="sex"></i></label>
                                        <div class="col-sm-9">
                                            <p class="form-control-plaintext" v-if="view">{{ currentNode.data.sex_txt }}</p>
                                            <div v-if="!view">
                                                <div class="custom-control custom-radio custom-control-inline" v-for="(value, index) in sexes">
                                                    <input type="radio" :id="value" name="sex" class="custom-control-input" :value="index" v-model="currentNode.data.sex">
                                                    <label class="custom-control-label" :for="value">{{ value }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label text-right">Birth of date <i class="fa fa-birthday-cake fa-lg"></i></label>
                                        <div class="col-sm-9">
                                            <p class="form-control-plaintext" v-if="view">{{ currentNode.data.birth_of_date }}</p>
                                            <div v-if="!view">
                                                <input type="date" v-validate="'date_format:YYYY-MM-DD'" :class="{'is-invalid' : errors.has('bod')}" placeholder="Birth of date" name="bod" v-model="currentNode.data.birth_of_date" class="form-control">
                                                <div v-show="errors.has('bod')" class="invalid-feedback">{{ errors.first('bod') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row" v-if="!view">
                                        <div class="col-sm-9 offset-3">
                                            <input type="time" v-validate="'date_format:HH:mm'" :class="{'is-invalid' : errors.has('bot')}" placeholder="Birth of time" name="bot" v-model="currentNode.data.birth_of_time" class="form-control">
                                            <div v-show="errors.has('bot')" class="invalid-feedback">{{ errors.first('bot') }}</div>
                                        </div>
                                    </div>
                                    <div class="form-group row" v-if="!view">
                                        <div class="col-sm-9 offset-3">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" :class="{'is-invalid' : errors.has('is_living')}" name="is_living" v-model="currentNode.data.is_living" class="custom-control-input" id="is_living">
                                                <label class="custom-control-label" for="is_living">This person is living</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row" v-if="!currentNode.data.is_living">
                                        <label class="col-sm-3 col-form-label text-right">Death of date <i class="fa fa-battery-slash fa-lg"></i></label>
                                        <div class="col-sm-9">
                                            <p class="form-control-plaintext" v-if="view">{{ currentNode.data.death_of_date }}</p>
                                            <div v-if="!view">
                                                <input type="date" v-validate="'date_format:YYYY-MM-DD'" :class="{'is-invalid' : errors.has('dod')}" placeholder="Death of date" name="dod" v-model="currentNode.data.death_of_date" class="form-control">
                                                <div v-show="errors.has('dod')" class="invalid-feedback">{{ errors.first('dod') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row" v-if="!currentNode.data.is_living && !view">
                                        <div class="col-sm-9 offset-3">
                                            <input type="time" v-validate="'date_format:HH:mm'" :class="{'is-invalid' : errors.has('dot')}" placeholder="Death of time" name="dot" v-model="currentNode.data.death_of_time" class="form-control">
                                            <div v-show="errors.has('dot')" class="invalid-feedback">{{ errors.first('dot') }}</div>
                                        </div>
                                    </div>
                                    <div class="form-group row" v-if="!view">
                                        <div class="col-sm-9 offset-3">
                                            <button type="submit" class="btn btn-outline-primary">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Personal contact -->
                            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab" v-if="'contact' in currentNode.data">
                                <form @submit.prevent="validateBeforeSubmit">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label text-right">Email <i class="fa fa-at fa-lg"></i></label>
                                        <div class="col-sm-9">
                                            <p class="form-control-plaintext" v-if="view">{{ currentNode.data.contact.data.email }}</p>
                                            <div v-if="!view">
                                                <input type="email" v-validate="'email'" :class="{'is-invalid' : errors.has('email')}" placeholder="Email" name="email" v-model="currentNode.data.contact.data.email" class="form-control">
                                                <div v-show="errors.has('email')" class="invalid-feedback">{{ errors.first('email') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label text-right">Mobile <i class="fa fa-mobile fa-lg"></i></label>
                                        <div class="col-sm-9">
                                            <p class="form-control-plaintext" v-if="view">{{ currentNode.data.contact.data.mobile }}</p>
                                            <div v-if="!view">
                                                <input type="text" v-validate="'numeric|min:6|max:11'" :class="{'is-invalid' : errors.has('mobile')}" placeholder="Mobile" name="mobile" v-model="currentNode.data.contact.data.mobile" class="form-control">
                                                <div v-show="errors.has('mobile')" class="invalid-feedback">{{ errors.first('mobile') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label text-right">Skype <i class="fa fa-skype fa-lg"></i></label>
                                        <div class="col-sm-9">
                                            <p class="form-control-plaintext" v-if="view">{{ currentNode.data.contact.data.skype }}</p>
                                            <div v-if="!view">
                                                <input type="text" v-validate="'alpha_num'" :class="{'is-invalid' : errors.has('skype')}" placeholder="Skype" name="skype" v-model="currentNode.data.contact.data.skype" class="form-control">
                                                <div v-show="errors.has('skype')" class="invalid-feedback">{{ errors.first('skype') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label text-right">Facebook <i class="fa fa-facebook-square fa-lg"></i></label>
                                        <div class="col-sm-9">
                                            <p class="form-control-plaintext" v-if="view">{{ currentNode.data.contact.data.facebook_url }}</p>
                                            <div v-if="!view">
                                                <input type="text" v-validate="'url'" :class="{'is-invalid' : errors.has('facebook_url')}" placeholder="Facebook url" name="facebook_url" v-model="currentNode.data.contact.data.facebook_url" class="form-control">
                                                <div v-show="errors.has('facebook_url')" class="invalid-feedback">{{ errors.first('facebook_url') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label text-right">Address <i class="fa fa-map-signs fa-lg"></i></label>
                                        <div class="col-sm-9">
                                            <p class="form-control-plaintext" v-if="view">{{ currentNode.data.contact.data.address }}</p>
                                            <div v-if="!view">
                                                <input type="text" placeholder="Address" name="address" v-model="currentNode.data.contact.data.address" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row" v-if="!view">
                                        <div class="col-sm-9 offset-3">
                                            <button type="submit" class="btn btn-outline-primary">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Personal biographical -->
                            <div class="tab-pane fade" id="biographical" role="tabpanel" aria-labelledby="biographical-tab" v-if="'biographical' in currentNode.data">
                                <form @submit.prevent="validateBeforeSubmit">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label text-right">Birth place <i class="fa fa-home fa-lg"></i></label>
                                        <div class="col-sm-9">
                                            <p class="form-control-plaintext" v-if="view">{{ currentNode.data.biographical.data.birth_place }}</p>
                                            <div v-if="!view">
                                                <input type="text" placeholder="Birth place" name="birth_place" v-model="currentNode.data.biographical.data.birth_place" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label text-right">Company <i class="fa fa-suitcase fa-lg"></i></label>
                                        <div class="col-sm-9">
                                            <p class="form-control-plaintext" v-if="view"> {{ currentNode.data.biographical.data.company }}</p>
                                            <div v-if="!view">
                                                <input type="text" placeholder="Company" name="company" v-model="currentNode.data.biographical.data.company" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label text-right">Career <i class="fa fa-bullhorn fa-lg"></i></label>
                                        <div class="col-sm-9">
                                            <p class="form-control-plaintext" v-if="view">{{ currentNode.data.biographical.data.career }}</p>
                                            <div v-if="!view">
                                                <input type="text" placeholder="Career" name="career" v-model="currentNode.data.biographical.data.career" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label text-right">School <i class="fa fa-black-tie fa-lg"></i></label>
                                        <div class="col-sm-9">
                                            <p class="form-control-plaintext" v-if="view">{{ currentNode.data.biographical.data.school }}</p>
                                            <div v-if="!view">
                                                <input type="text" placeholder="School" name="school" v-model="currentNode.data.biographical.data.school" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label text-right">Subject <i class="fa fa-slideshare fa-lg"></i></label>
                                        <div class="col-sm-9">
                                            <p class="form-control-plaintext" v-if="view">{{ currentNode.data.biographical.data.subject }}</p>
                                            <div v-if="!view">
                                                <input type="text" placeholder="Subject" name="subject" v-model="currentNode.data.biographical.data.subject" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label text-right">Degree <i class="fa fa-graduation-cap fa-lg"></i></label>
                                        <div class="col-sm-9">
                                            <p class="form-control-plaintext" v-if="view">{{ currentNode.data.biographical.data.degree }}</p>
                                            <div v-if="!view">
                                                <input type="text" placeholder="Degree" name="degree" v-model="currentNode.data.biographical.data.degree" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label text-right">Hobbies <i class="fa fa-star fa-lg"></i></label>
                                        <div class="col-sm-9">
                                            <p class="form-control-plaintext" v-if="view">{{ currentNode.data.biographical.data.hobbies }}</p>
                                            <div v-if="!view">
                                                <textarea placeholder="Hobbies" name="hobbies" rows="3" v-model="currentNode.data.biographical.data.hobbies" class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row" v-if="!view">
                                        <div class="col-sm-9 offset-3">
                                            <button type="submit" class="btn btn-outline-primary">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-info" @click="toggleEditForm">{{ view ? 'Edit' : 'Show' }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    import {tree} from 'vued3tree'
    import {treeData} from '../../api/tree'
    import * as person from '../../api/person'
    import sexApi from '../../api/sex'

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
                treeData: null,
                view: true,
                sexes: null,
                response: null
            }
        },
        components: {
            tree
        },
        mounted () {
            treeData().then(response => {
                this.treeData = response.data.data;
            });
            sexApi().then(response => {
                this.sexes = response.data.data;
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
            toggleEditForm () {
                this.view = !this.view;
            },
            onClick (evt) {
                this.currentNode = evt.element;
                this.onEvent('onClick', evt);

                this.fetchPersonDetail();

                $('#personInfoModal').modal();
            },
            validateBeforeSubmit(e) {
                let that = this;
                let submitButton = $(e.target).find('[type=submit]');
                submitButton.attr('disabled', 'disabled');
                let apiModule = e.target.name;

                this.$validator.validateAll().then((result) => {
                    if (!result) {
                        submitButton.attr('disabled', false);
                        return;
                    }

                    switch (apiModule) {
                        case 'person':
                            person.update(this.currentNode.data.id, this.currentNode.data).then(response => {
                                if (response.data.status === 'success') {
                                    that.fetchPersonDetail();
                                }

                                this.response = response.data;

                                submitButton.attr('disabled', false);
                                this.toggleEditForm();
                            });
                            break;
                    }
                });
            },
            fetchPersonDetail () {
                person.detail(this.currentNode.data.id).then(response => {
                    this.currentNode.data = response.data.data;
                });
            },
            resetResponse () {
                this.response = null;
            },
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
            onExpand (evt) {
                this.onEvent('onExpand', evt)
            },
            onRetract (evt) {
                this.onEvent('onRetract', evt)
            },
            onEvent (eventName, data) {
                this.events.push({eventName, data: data.data});
            },
            resetZoom () {
                this.isLoading = true;
                this.$refs['tree'].resetZoom().then(() => { this.isLoading = false })
            }
        }
    }
</script>

<style scoped>
    .tree {
        height: 85vh;
        width: 100%;
    }
</style>
