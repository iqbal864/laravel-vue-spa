<template>
    <div>
        <h1>Register</h1>
        <form @submit.prevent="handleSubmit()">
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
            <div class="mb-3">
                <label for="inputPassword" class="form-label">Password</label>
                <input type="password" class="form-control" id="inputPassword" v-model="formInput.password"
                    v-bind:class="[errors.password ? 'is-invalid' : '']">
                <div style="color:red;" v-if="errors.password">
                    <span><small>{{ errors.password[0] }}</small></span>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            formInput: {
                name: '',
                email: '',
                password: ''
            },
            errors: {}
        }
    },
    methods: {
        handleSubmit() {
            // console.log(this.formInput);
            axios.post('/api/users', this.formInput).then((response) => {
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
