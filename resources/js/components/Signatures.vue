<template>

    <div>

        <b-table
            :items="signatures"
            :per-page="perPage"
            :current-page="currentPage"
            :fields="fields"
            class="mb-3 mt-3"
            outlined
        >
            <template #cell(status)="data">
                <span v-if="data.value == 'denied'" class="text-danger"> отказано </span>
                <span v-if="data.value == 'processing'"> в процессе </span>
                <span v-if="data.value == 'approved'" class="text-success"> одобрено </span>
            </template>

            <template #cell(created_at)="data">
                {{ data.value | moment("DD.MM.YYYY h:mm") }}
            </template>

            <template #cell(control)="data">
                <b-button @click="showModal(data)" ref="btnShow"> Изменить</b-button>
            </template>

        </b-table>

        <b-pagination
            v-model="currentPage"
            :total-rows="rows"
            :per-page="perPage"
        ></b-pagination>

        <b-modal ref="signature-modal" id="signature-modal" title="Редактирование">
            <form @submit.prevent="updateSignature">

                <div class="mb-3">
                    <label for="name"> Название </label>
                    <input v-model="item.name" type="text" id="name" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="name"> Статус </label>
                    <select v-model="item.status" class="form-control">
                        <option value="denied"> отказ</option>
                        <option value="processing"> в процессе</option>
                        <option value="approved"> одобрено</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="name"> Описание </label>
                    <textarea v-model="item.description" class="form-control" cols="30" rows="4"></textarea>
                </div>

                <button type="submit" class="btn btn-primary text-white mb-3"> Отправить</button>
            </form>

        </b-modal>


    </div>

</template>

<script>

export default {

    data() {
        return {
            perPage: 5,
            currentPage: 1,
            signatures: [],
            errors: [],
            errored: false,
            loading: true,
            fields: [
                {
                    key: 'id',
                    label: 'ID'
                },
                {
                    key: 'name',
                    label: 'Название'
                },
                {
                    key: 'status',
                    label: 'Статус',
                },
                {
                    key: 'created_at',
                    label: 'Дата',
                },
                {
                    key: 'control',
                    label: '',
                }
            ],
            item: {
                id: '',
                name: '',
                status: '',
                description: '',
                user_id: '',
            }
        }
    },

    mounted() {
        this.getSignatures()
    },

    methods: {

        updateSignature() {

            axios.post(`/api/signatures/${this.item.id}`, {
                _method: 'PUT',
                name: this.item.name,
                status: this.item.status,
                description: this.item.description,
                user_id: this.item.user_id,
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
                    this.getSignatures()
                    this.$refs['signature-modal'].hide()
                    this.loading = false;
                })
        },


        getSignatures() {
            axios.get('/api/signatures')
                .then(response => {
                    this.signatures = response.data.data;
                })
                .catch(error => {
                    this.errored = true;
                })
                .finally(() => {
                    this.loading = false;
                })
        },

        showModal(data) {
            this.item.id = data.item.id
            this.item.name = data.item.name
            this.item.status = data.item.status
            this.item.description = data.item.description
            this.item.user_id = data.item.user_id
            this.$root.$emit('bv::show::modal', 'signature-modal', '#btnShow')
        }
    },

    computed: {
        rows() {
            return this.signatures.length
        }
    },

    validations: {}
}
</script>

<style scoped>

</style>
