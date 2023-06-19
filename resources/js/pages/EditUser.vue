<template>
    <div>
        <h1>Edit User</h1>
        <form @submit.prevent="handleEdit()">
            <div class="mb-3">
                <label for="inputNama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="inputNama" v-model="formInput.name"
                    v-bind:class="[errors.name ? 'is-invalid' : '']">
                <div style="color:red;" v-if="errors.name">
                    <span><small>{{ errors.name[0] }}</small></span>
                </div>
            </div>
            <div class="mb-3">
                <label for="inputEmail" class="form-label">Email</label>
                <input type="email" class="form-control" id="inputEmail" v-model="formInput.email"
                    v-bind:class="[errors.email ? 'is-invalid' : '']">
                <div style="color:red;" v-if="errors.email">
                    <span><small>{{ errors.email[0] }}</small></span>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</template>

<script>
export default {
    props: ['id'],
    data() {
        return {
            formInput: {
                name: '',
                email: ''
            },
            errors: {}
        }
    },
    mounted() {
        this.getUser()
    },
    methods: {
        getUser() {
            axios.get('/api/users/' + this.id).then((response) => {
                // console.log(response);
                this.formInput = {
                    name: response.data.name,
                    email: response.data.email
                }
            });
        },
        handleEdit() {
            // console.log(this.formInput);
            axios.put('/api/users/' + this.id, this.formInput).then((response) => {
                if (response.data.status) {
                    const Toast = this.$swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', this.$swal.stopTimer)
                            toast.addEventListener('mouseleave', this.$swal.resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: 'success',
                        title: response.data.message
                    })
                    this.$router.push('/user');
                }
            }).catch((error) => {
                if (error.response.status == 403) {
                    this.errors = error.response.data.message;
                }
            });
        }
    }
}
</script>
