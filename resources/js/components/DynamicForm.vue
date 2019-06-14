<template>
    <div class="modal" tabindex="-1" role="dialog" :id="id">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ formData.title }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form>
                    <div class="modal-body" v-for="page in formData.pages" v-show="currentPage === page.number">
                        <h6 class="text-muted" v-if="page.name">{{ page.name }}</h6>
                        <div class="form-group" v-for="question in page.questions">
                            <label>
                                {{ question.question }}
                                <span class="text-danger" v-if="question.required === 1">*</span>
                            </label>
                            <v-select v-if="question.selectable"
                                      :name="question.htmlId"
                                      :multiple="question.selectArgs.indexOf('multiple') > -1"
                                      :taggable="question.selectArgs.indexOf('taggable') > -1"
                                      :options="question.options"
                                      label="text"
                                      :required="question.required === 1"
                                      v-model="form[question.id]"
                                      :reduce="option => option.text"></v-select>
                            <textarea class="form-control" :name="question.htmlId" v-else-if="question.type === 'textarea'" rows="7" :required="question.required === 1" v-model="form[question.id]"></textarea>
                            <input :type="question.type" :name="question.htmlId" class="form-control" :required="question.required === 1" v-model="form[question.id]" v-else>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger mr-auto" data-dismiss="modal" @click="reset()">Cancel</button>
                        <button type="button" class="btn btn-outline-secondary" @click="currentPage--" v-show="currentPage > 1">Back</button>
                        <button type="button" class="btn btn-outline-primary" @click="currentPage++" v-show="currentPage < formData.pages.length">Next</button>
                        <button type="button" class="btn btn-outline-primary" v-show="currentPage === formData.pages.length" @click="submit()" :disabled="!isValid()">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    import swal from 'sweetalert2'
    import vSelect from 'vue-select'

    export default {
        props: [ 'id', 'formData', 'postRoute' ],

        data() {
            return {
                currentPage: 1,
                form: {},
            }
        },

        created() {
            this.reset();
        },

        methods: {
            submit() {
                if(this.isValid()) {
                    axios.post(this.postRoute, this.form).then(response => {
                        swal.fire({
                            text: response.data,
                            type: 'success',
                            timer: 1000,
                            showConfirmButton: false
                        }).then(() => {
                            this.reset();
                            $('#' + this.id).modal('hide');
                        })

                    }).catch(error => {
                        swal.fire({
                            text: error.response.data,
                            type: 'error',
                            timer: 1000,
                            showConfirmButton: false
                        })
                    });
                } else {
                    swal.fire({
                        text: 'Please fill out all required fields.',
                        type: 'error',
                        timer: 1000,
                        showConfirmButton: false
                    })
                }
            },

            isValid() {
                let valid = true;

                this.formData.pages.forEach(page => {
                    page.questions.forEach(question => {
                        if(question.required === 1) {
                            if(this.form[question.id] === null || this.form[question.id].length === 0) {
                                valid = false;
                            }
                        }
                    });
                });

                return valid;
            },

            reset() {
                this.currentPage = 1;
                this.form = {};

                this.formData.pages.forEach(page => {
                    page.questions.forEach(question => {
                        this.form[question.id] = '';
                    });
                });
            }
        },

        components: {
            vSelect
        },
    }
</script>

<style lang="sass">
    @import "~vue-select/src/scss/vue-select.scss"
</style>
