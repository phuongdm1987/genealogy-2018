<template>
    <div class="modal fade" id="personInfoModal" tabindex="-1" role="dialog" aria-labelledby="personInfoModal" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" v-if="person">
                <div class="modal-header">
                    <h5 class="modal-title" id="fullName">{{ person.full_name }} <i :class="sex"></i></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-3">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <a class="nav-link active" id="nav-me-tab" data-toggle="pill" href="#nav-me" role="tab" aria-controls="nav-me" aria-selected="true">Home</a>
                                <!--<a class="nav-link" id="nav-children-tab" data-toggle="pill" href="#nav-children" role="tab" aria-controls="nav-children" aria-selected="false">Children</a>-->
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="tab-content" id="v-pills-tabContent">
                                <!-- Me tab content -->
                                <div class="tab-pane fade show active" id="nav-me" role="tabpanel" aria-labelledby="nav-me-tab">

                                    <nav>
                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                            <a class="nav-item nav-link active" id="nav-detail-tab" data-toggle="tab" href="#nav-detail" role="tab" aria-controls="nav-detail" aria-selected="true">Detail</a>
                                            <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Contact</a>
                                            <a class="nav-item nav-link" id="nav-biographical-tab" data-toggle="tab" href="#nav-biographical" role="tab" aria-controls="nav-biographical" aria-selected="false">Biographical</a>
                                        </div>
                                    </nav>
                                    <div class="tab-content" id="nav-tabContent">

                                        <div v-if="response" class="alert alert-dismissible fade show mt-3" :class="'alert-' + response.status" role="alert">
                                            {{ response.message }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close" @click="resetResponse">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <div class="text-center mt-3 mb-3">
                                            <img v-if="person.avatar_path" :src="person.avatar_path" :alt="person.full_name" class="img-thumbnail">
                                        </div>

                                        <!-- Detail tab content -->
                                        <div class="tab-pane fade show active" id="nav-detail" role="tabpanel" aria-labelledby="nav-detail-tab">
                                            <form @submit.prevent="validateBeforeSubmit" name="person" enctype="multipart/form-data">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label text-right">Sex <i :class="sex"></i></label>
                                                    <div class="col-sm-9">
                                                        <p class="form-control-plaintext" v-if="!showForm">{{ person.sex_txt }}</p>
                                                        <div v-if="showForm">
                                                            <div class="custom-control custom-radio custom-control-inline" v-for="(value, index) in sexes">
                                                                <input type="radio" :id="value" name="sex" class="custom-control-input" :value="index" v-model="person.sex">
                                                                <label class="custom-control-label" :for="value">{{ value }}</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label text-right">Birth of date <i class="fa fa-birthday-cake fa-lg"></i></label>
                                                    <div class="col-sm-9">
                                                        <p class="form-control-plaintext" v-if="!showForm">{{ person.birth_of_date }}</p>
                                                        <div v-if="showForm">
                                                            <input type="date" v-validate="'date_format:YYYY-MM-DD'" :class="{'is-invalid' : errors.has('bod')}" placeholder="Birth of date" name="bod" v-model="person.birth_of_date" class="form-control">
                                                            <div v-show="errors.has('bod')" class="invalid-feedback">{{ errors.first('bod') }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row" v-if="showForm">
                                                    <div class="col-sm-9 offset-3">
                                                        <input type="time" v-validate="'date_format:HH:mm'" :class="{'is-invalid' : errors.has('bot')}" placeholder="Birth of time" name="bot" v-model="person.birth_of_time" class="form-control">
                                                        <div v-show="errors.has('bot')" class="invalid-feedback">{{ errors.first('bot') }}</div>
                                                    </div>
                                                </div>
                                                <div class="form-group row" v-if="showForm">
                                                    <div class="col-sm-9 offset-3">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" :class="{'is-invalid' : errors.has('is_living')}" name="is_living" v-model="person.is_living" class="custom-control-input" id="is_living">
                                                            <label class="custom-control-label" for="is_living">This person is living</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row" v-if="!person.is_living">
                                                    <label class="col-sm-3 col-form-label text-right">Death of date <i class="fa fa-battery-slash fa-lg"></i></label>
                                                    <div class="col-sm-9">
                                                        <p class="form-control-plaintext" v-if="!showForm">{{ person.death_of_date }}</p>
                                                        <div v-if="showForm">
                                                            <input type="date" v-validate="'date_format:YYYY-MM-DD'" :class="{'is-invalid' : errors.has('dod')}" placeholder="Death of date" name="dod" v-model="person.death_of_date" class="form-control">
                                                            <div v-show="errors.has('dod')" class="invalid-feedback">{{ errors.first('dod') }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row" v-if="!person.is_living && showForm">
                                                    <div class="col-sm-9 offset-3">
                                                        <input type="time" v-validate="'date_format:HH:mm'" :class="{'is-invalid' : errors.has('dot')}" placeholder="Death of time" name="dot" v-model="person.death_of_time" class="form-control">
                                                        <div v-show="errors.has('dot')" class="invalid-feedback">{{ errors.first('dot') }}</div>
                                                    </div>
                                                </div>
                                                <div class="form-group row" v-if="showForm">
                                                    <div class="col-sm-9 offset-3">
                                                        <button type="submit" class="btn btn-outline-primary">Update</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

                                        <!-- Contact tab content -->
                                        <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                                            <form @submit.prevent="validateBeforeSubmit" v-if="person.contact">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label text-right">Email <i class="fa fa-at fa-lg"></i></label>
                                                    <div class="col-sm-9">
                                                        <p class="form-control-plaintext" v-if="!showForm">{{ person.contact.data.email }}</p>
                                                        <div v-if="showForm">
                                                            <input type="email" v-validate="'email'" :class="{'is-invalid' : errors.has('email')}" placeholder="Email" name="email" v-model="person.contact.data.email" class="form-control">
                                                            <div v-show="errors.has('email')" class="invalid-feedback">{{ errors.first('email') }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label text-right">Mobile <i class="fa fa-mobile fa-lg"></i></label>
                                                    <div class="col-sm-9">
                                                        <p class="form-control-plaintext" v-if="!showForm">{{ person.contact.data.mobile }}</p>
                                                        <div v-if="showForm">
                                                            <input type="text" v-validate="'numeric|min:6|max:11'" :class="{'is-invalid' : errors.has('mobile')}" placeholder="Mobile" name="mobile" v-model="person.contact.data.mobile" class="form-control">
                                                            <div v-show="errors.has('mobile')" class="invalid-feedback">{{ errors.first('mobile') }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label text-right">Skype <i class="fa fa-skype fa-lg"></i></label>
                                                    <div class="col-sm-9">
                                                        <p class="form-control-plaintext" v-if="!showForm">{{ person.contact.data.skype }}</p>
                                                        <div v-if="showForm">
                                                            <input type="text" v-validate="'alpha_num'" :class="{'is-invalid' : errors.has('skype')}" placeholder="Skype" name="skype" v-model="person.contact.data.skype" class="form-control">
                                                            <div v-show="errors.has('skype')" class="invalid-feedback">{{ errors.first('skype') }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label text-right">Facebook <i class="fa fa-facebook-square fa-lg"></i></label>
                                                    <div class="col-sm-9">
                                                        <p class="form-control-plaintext" v-if="!showForm">{{ person.contact.data.facebook_url }}</p>
                                                        <div v-if="showForm">
                                                            <input type="text" v-validate="'url'" :class="{'is-invalid' : errors.has('facebook_url')}" placeholder="Facebook url" name="facebook_url" v-model="person.contact.data.facebook_url" class="form-control">
                                                            <div v-show="errors.has('facebook_url')" class="invalid-feedback">{{ errors.first('facebook_url') }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label text-right">Address <i class="fa fa-map-signs fa-lg"></i></label>
                                                    <div class="col-sm-9">
                                                        <p class="form-control-plaintext" v-if="!showForm">{{ person.contact.data.address }}</p>
                                                        <div v-if="showForm">
                                                            <input type="text" placeholder="Address" name="address" v-model="person.contact.data.address" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row" v-if="showForm">
                                                    <div class="col-sm-9 offset-3">
                                                        <button type="submit" class="btn btn-outline-primary">Update</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

                                        <!-- Biographical tab content -->
                                        <div class="tab-pane fade" id="nav-biographical" role="tabpanel" aria-labelledby="nav-biographical-tab">
                                            <form @submit.prevent="validateBeforeSubmit" v-if="person.biographical">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label text-right">Birth place <i class="fa fa-home fa-lg"></i></label>
                                                    <div class="col-sm-9">
                                                        <p class="form-control-plaintext" v-if="!showForm">{{ person.biographical.data.birth_place }}</p>
                                                        <div v-if="showForm">
                                                            <input type="text" placeholder="Birth place" name="birth_place" v-model="person.biographical.data.birth_place" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label text-right">Company <i class="fa fa-suitcase fa-lg"></i></label>
                                                    <div class="col-sm-9">
                                                        <p class="form-control-plaintext" v-if="!showForm"> {{ person.biographical.data.company }}</p>
                                                        <div v-if="showForm">
                                                            <input type="text" placeholder="Company" name="company" v-model="person.biographical.data.company" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label text-right">Career <i class="fa fa-bullhorn fa-lg"></i></label>
                                                    <div class="col-sm-9">
                                                        <p class="form-control-plaintext" v-if="!showForm">{{ person.biographical.data.career }}</p>
                                                        <div v-if="showForm">
                                                            <input type="text" placeholder="Career" name="career" v-model="person.biographical.data.career" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label text-right">School <i class="fa fa-black-tie fa-lg"></i></label>
                                                    <div class="col-sm-9">
                                                        <p class="form-control-plaintext" v-if="!showForm">{{ person.biographical.data.school }}</p>
                                                        <div v-if="showForm">
                                                            <input type="text" placeholder="School" name="school" v-model="person.biographical.data.school" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label text-right">Subject <i class="fa fa-slideshare fa-lg"></i></label>
                                                    <div class="col-sm-9">
                                                        <p class="form-control-plaintext" v-if="!showForm">{{ person.biographical.data.subject }}</p>
                                                        <div v-if="showForm">
                                                            <input type="text" placeholder="Subject" name="subject" v-model="person.biographical.data.subject" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label text-right">Degree <i class="fa fa-graduation-cap fa-lg"></i></label>
                                                    <div class="col-sm-9">
                                                        <p class="form-control-plaintext" v-if="!showForm">{{ person.biographical.data.degree }}</p>
                                                        <div v-if="showForm">
                                                            <input type="text" placeholder="Degree" name="degree" v-model="person.biographical.data.degree" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label text-right">Hobbies <i class="fa fa-star fa-lg"></i></label>
                                                    <div class="col-sm-9">
                                                        <p class="form-control-plaintext" v-if="!showForm">{{ person.biographical.data.hobbies }}</p>
                                                        <div v-if="showForm">
                                                            <textarea placeholder="Hobbies" name="hobbies" rows="3" v-model="person.biographical.data.hobbies" class="form-control"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row" v-if="showForm">
                                                    <div class="col-sm-9 offset-3">
                                                        <button type="submit" class="btn btn-outline-primary">Update</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                </div>

                                <!-- Wife tab content -->
                                <!--<div class="tab-pane fade" id="nav-children" role="tabpanel" aria-labelledby="nav-children-tab"></div>-->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-info" @click="toggleEditForm">{{ !showForm ? 'Edit' : 'Show' }}</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapState } from 'vuex'
    import sexApi from '../../api/sex'

    export default {
        name: "Person",
        data () {
            return {
                sexes: null,
                response: null,
            }
        },
        mounted () {
            let that = this;
            sexApi().then(response => {
                this.sexes = response.data.data;
            });
            $('#personInfoModal').on('hide.bs.modal', function (e) {
                that.$store.dispatch('tree/resetCurrentNode');
            });
        },
        watch: {
            showModal: function() {
                $('#personInfoModal').modal('toggle');
            }
        },
        computed: {
            ...mapState({
                person: state => state.person.detail,
                showModal: state => state.showModal,
                showForm: state => state.showForm
            }),
            sex: function () {
                switch (this.person.sex) {
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
                            that.$store.dispatch('person/update', that.person);
                            break;
                    }
                });
            },
            resetResponse () {
                this.response = null;
            },
            toggleEditForm () {
                this.$store.dispatch('toggleShowForm');
            },
        }
    }
</script>

<style scoped>

</style>
