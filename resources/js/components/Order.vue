<template>
    <div class="card">

        <h4 class="card-header"> Заказать буквенное имя </h4>

        <div class="card-body">
            <form @submit.prevent="addNewSignature">
                <div class="form-group mb-2">

                    <input type="text" v-model="name"
                           class="form-control"
                           :class="{'is-invalid': $v.name.$error}"
                           placeholder="Введите название">

                    <div class="invalid-feedback" v-if="!$v.name.required">
                        Обязательное поле.
                    </div>
                    <div class="invalid-feedback" v-if="!$v.name.maxLength">
                        Макс. кол-во символов: {{ $v.name.$params.maxLength.max }}
                    </div>
                    <div class="invalid-feedback" v-if="!$v.name.minLength">
                        Мин. кол-во символов: {{ $v.name.$params.minLength.min }}
                    </div>
                </div>
                <button type="submit" class="btn btn-primary text-white mb-3"> Отправить </button>
            </form>

            <div class="alert alert-danger" role="alert" v-if="errored">
                Ошибка загрузки данных! <br>
                {{ errors[0] }}
            </div>
            <div class="spinner-border" v-if="loading" style="width: 2rem;height: 2rem">
                <span class="sr-only"> </span>
            </div>
        </div>
    </div>

</template>

<script>

import {required, maxLength, minLength} from 'vuelidate/lib/validators'

export default {

    props: ['user'],

    data() {
        return {
            errors: [],
            errored: false,
            loading: false,
            name: null
        }
    },

    mounted() {

    },

    methods: {

        addNewSignature() {

            this.$v.name.$touch()

            if (this.$v.name.$anyError) {
                return;
            }

            this.loading = true;

            axios.post('/api/signatures', {
                name: this.name,
                user_id: this.user.id
            })
                .then(response => {
                    this.name = '';
                })
                .catch(error => {
                    if (error.response.data.errors.name) {
                        this.errors = []
                        this.errors.push(error.response.data.errors.name[0])
                    }
                    this.errored = true;
                })
                .finally(() => {
                    this.$v.$reset()
                    this.loading = false;
                })
        }
    },

    validations: {
        name: {
            required,
            maxLength: maxLength(11),
            minLength: minLength(3)
        }
    }
}
</script>

<style scoped>

</style>
